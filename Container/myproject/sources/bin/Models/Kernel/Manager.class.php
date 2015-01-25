<?php

namespace Models\Kernel ;

abstract class Manager
{
    protected $dao ;
    protected $mapping ;
    protected $attributes ;
    protected $tables ;
    
    public function __construct( $dao )
    {
        $this->dao = $dao ;
        $this->mapping = array() ;
        $this->attributes = array() ;
        $this->tables = array() ;
    }

    // Setters for inheritance in PDO
    public function mapping() { return $this->mapping ; }
    public function attributes() { return $this->attributes ; }
    public function tables() { return $this->tables ; }

    // Functions providing the computing of the MySQL Requests. Should not be placed here but lazy to create Manager_PDO.php..
    private function computeRequestAttributes( $displayedAttributes=array(), $countFoundRows=false )
    {
        $requestAttributes = "SELECT " . ( $countFoundRows ? "SQL_CALC_FOUND_ROWS " : "" ) ;
        foreach( $displayedAttributes as $displayedAttribute )
            $requestAttributes .= $this->attributes[$displayedAttribute] .", " ;
        return substr_replace( $requestAttributes, "", -2 ) ;
    }

    private function computeRequestTables( $requestAttributes=null )
    {
        $requestTables = null ;
        foreach( $this->tables as $key => $table )
        {
            if( strpos( $requestAttributes, $key ."." ) !== false )
            {
                if( $table['mapWith'] == null )
                    $requestTables .= "FROM `". $table['name'] ."` ". $key ." " ;
                else if( strpos( $requestTables, $key ."." ) === false )
                    $requestTables .= $this->computeRequestTablesLegacy( $requestTables, $key ) ;
            }
            $keys[$key] = true ;
        }
        return $requestTables ;
    }

    private function computeRequestTablesLegacy( $requestTables, $key )
    {
        if( strpos( $requestTables, $this->tables[$key]['name'] ) == true )
            return null ;
        else
        {
            if( isset( $this->tables[$key]['mapType'] ) && ! empty( $this->tables[$key]['mapType'] ) )
                $mapType = $this->tables[$key]['mapType'] ;
            else
                $mapType = "LEFT" ;

            $requestTables = $this->computeRequestTablesLegacy( $requestTables, $this->tables[$key]['mapWith'] ) ;
            $requestTables .= $mapType. " JOIN ". $this->tables[$key]['name'] ." ". $key ." ON ". $key .".". $this->tables[$key]['mapLeft'] ."=". $this->tables[$key]['mapWith'] .".". $this->tables[$key]['mapRight'] ." " ;
            return $requestTables ;
        }
    }

    private function computeRequestGroup()
    {
        return "GROUP BY " . $this->attributes['id'] ;
    }

    protected function computeRequest( $where=null, $order=null, $limit=null, $displayedAttributes=array(), $countFoundRows=false, $specificAttributes=array() )
    {
        // Display all attributes
        if( count( $displayedAttributes ) == 0 )
        {
            foreach( $this->attributes as $attribute => $notrequired )
                $displayedAttributes[] = $attribute ;
        }

        $requestAttributes = $this->computeRequestAttributes( $displayedAttributes, $countFoundRows ) ;
        $requestTables = $this->computeRequestTables( $requestAttributes . $where . $order . $limit ) ; // Concat everything to get all required tables
        $request = $requestAttributes . " " ;
        
        if( count( $specificAttributes ) > 0 )      // In case we have dynamically defined attributes such as distance computing by lat/long
        {
            foreach( $specificAttributes as $specificAttribute )
                $request .= "," . $specificAttribute ;
        }
        
        $request .= " ". $requestTables ." ". $where ." ". $this->computeRequestGroup() ." ". $order ." ". $limit ;
        return $request ;
    }

    // Should not be here since we execute MySQL Requests in here but it is always better rather than having it in the CoreController.
    public function getDataTables( $displayedAttributes, $params, $crypt, $pageRestrictions, $globalRestrictions, $actionList )
    {
        // PAGING
        if ( isset( $params['displayStart'] ) && $params['displayLength'] != '-1' )
            $limit = "LIMIT ". $params['displayStart'] .", ". $params['displayLength'] ;

        // SORTING
        if( count( $params['sortedColumns'] ) > 0 )
        {
            $order = "ORDER BY " ;
            foreach( $params['sortedColumns'] as $columnId => $sortType )
            {
                $mappedAttribute = $this->mapping[$displayedAttributes[intval( $columnId )]] ;
                if( is_array( $mappedAttribute ) )
                    $order .= implode( $mappedAttribute, ' '. $sortType .', ' ) .' '. $sortType .', ' ;
                else
                    $order .= $mappedAttribute." ". $sortType .", " ;
            }
            $order = substr_replace( $order, "", -2 ) ;
        }
        else
            $order = null ;
        
        // GLOBAL FILTERING
        if( count( $params['globalSearch'] ) > 0 )
        {
            $where = "WHERE ( " ;
            foreach( $params['globalSearch'] as $search )
            {
                for ( $i=0 ; $i<count($displayedAttributes) ; $i++ )
                {
                    if( substr_count( $search, "/" ) == 2 )
                    {
                        // WARNING DECOMPOSITION FOR FRENCH DATE FORMATTING ONLY
                        $dateVals = explode( "/", $search ) ;
                        $search = $dateVals[2] . '-' . $dateVals[1] .'-' . $dateVals[0] ;
                    }

                    $mappedAttribute = $this->mapping[$displayedAttributes[$i]] ;
                    if( is_array( $mappedAttribute ) )
                    {
                        foreach( $mappedAttribute as $attr )
                            $where .= $attr." LIKE '%". $search ."%' OR " ;
                    }
                    else
                        $where .= $mappedAttribute." LIKE '%". $search ."%' OR " ;
                }
            }
            $where = substr_replace( $where, "", -3 ) ;
            $where .= ')';
        }
        else
            $where = null ;

        // COLUMN FILTERING
        if( count( $params['columnSearch'] ) > 0 )
        {
            foreach( $params['columnSearch'] as $columnId => $search )
            {
                if( !empty( $where ) )
                    $where = "AND ( " ;
                else
                    $where = "WHERE ( " ;

                $mappedAttribute = $this->mapping[$displayedAttributes[$columnId]] ;
                if( is_array( $mappedAttribute ) )
                {
                    foreach( $mappedAttribute as $attr )
                    {
                        foreach( $search as $value )
                            $where .= $attr." LIKE '%". $value ."%' OR " ;
                    }
                }
                else if( substr_count( $search[0], " - " ) > 0 )
                {
                    $rangeVal = explode( ' - ', $search[0] ) ;
                    if( substr_count( $rangeVal[0], "/" ) == 2 && substr_count( $rangeVal[1], "/" ) == 2 )
                    {
                        // WARNING DECOMPOSITION FOR FRENCH DATE FORMATTING
                        $dateVals0 = explode( "/", $rangeVal[0] ) ;
                        $dateVals1 = explode( "/", $rangeVal[1] ) ;
                        $rangeVal[0] = $dateVals0[2] ."-". $dateVals0[1] ."-". $dateVals0[0] ;
                        $rangeVal[1] = $dateVals1[2] ."-". $dateVals1[1] ."-". $dateVals1[0] ;
                    }

                    $where .= $mappedAttribute ." >= '". $rangeVal[0] ."' AND ". $mappedAttribute ." <= '". $rangeVal[1] ."' OR " ;
                }
                else
                    $where .= $mappedAttribute." LIKE '%". $search ."%' OR ";
                
                $where = substr_replace( $where, "", -3 ) ; 
                $where .= ')';
            }
        }

        if( count( $pageRestrictions['object'] ) > 0 || count( $pageRestrictions['field'] ) > 0 )
        {
            if( !empty( $where ) )
                $where .= "AND ( " ;
            else
                $where = "WHERE ( " ;

            foreach( $pageRestrictions['object'] as $var => $value )
                $where .= " " . $this->mapping[$var] . " NOT REGEXP '" . $value . "' OR " ;

            $where = substr( $where, 0, -4 ) . " )" ;
        }

        $sql = $this->computeRequest( $where, $order, $limit, $displayedAttributes, true ) ;
        //print_r( $params ) ;
        //echo $sql ; die();
        $req = $this->dao->prepare( $sql ) ;
        $req->execute() ;
        
        $objectType = "\Models\Modules\\".$params['object'] ;
        $output = array() ;
        $output['aaData'] = array() ;

        // Compute restrictions on Buttons
        $restrictedObjects = array() ;
        foreach( $globalRestrictions as $restriction )
        {
            if( $restriction['module'] == $params['object'] && !isset( $restrictedObjects[$restriction['action']] ) )
                $restrictedObjects[$restriction['action']] = $restriction['object'] ;
        }

        while ( $datas = $req->fetch( \PDO::FETCH_ASSOC ) )
        {
            $object = new $objectType( $datas ) ;
            $row = array();
            for ( $i=0 ; $i<count($displayedAttributes) ; $i++ )
            {
                $attribute = $displayedAttributes[$i] ;
                if ( isset( $object ) )
                {
                    $value = $object[$attribute] ;

                    if( isset( $attribute ) && $attribute === 'id' )
                        $row[$attribute] = $crypt->encrypt( $value ) ;
                    else if( !is_array( $value ) )
                        $row[$attribute] = $value ;
                    else
                    {
                        if( isset( $value[0] ) && is_array( $value[0] ) )
                        {
                            foreach( $value as $key => $v )
                            {
                                if( array_key_exists( 'id', $v ) )
                                    $value[$key]['id'] = $crypt->encrypt( $v['id'] ) ;
                            }
                        }
                        else if( array_key_exists( 'id', $value ) )
                            $value['id'] = $crypt->encrypt( $value['id'] ) ;
                        $row[$attribute] = json_encode( $value ) ;
                    }
                }
                else
                    $row[$attribute] = null ;
            }

            // Check if we enable the button or not
            foreach( $actionList as $action )
            {
                if( isset( $restrictedObjects[$action] ) )
                {
                    if( $restrictedObjects[$action] != "*" )
                    {
                        list( $var, $pattern ) = explode( '=', $restrictedObjects[$action] ) ;
                        if( isset( $object[$var] ) )
                        {
                            if( preg_match( $pattern, $object[$var] ) )
                                $row[$action] = 0 ;
                            else
                                $row[$action] = 1 ;
                        }
                        else
                            throw new \RuntimeException("Couldnt check the restriction on objects") ;
                    }
                    else
                        $row[$action] = 0 ;
                }
                else
                    $row[$action] = 1 ;
            }

            $output['aaData'][] = $row ;
        }

        $output['iTotalDisplayRecords'] = $this->dao->query('SELECT FOUND_ROWS()')->fetchColumn() ;
        $output['iTotalRecords'] = $this->count() ;
        
        return $output ;
    }

    public function getSelect2( $search,  $searchFields, $nameFields, $where, $order, $limit )
    {
        if( is_string( $search ) )
        {   
            $filter = null ;
            $values = explode( ' ', $search ) ;
            for( $i=0; $i<count( $values ); $i++ )
            {
                $filter .= "( " ;
                foreach( $searchFields as $field )
                    $filter .= $this->mapping[$field] ." LIKE :search$i OR " ;
                $filter = substr( $filter, 0, -4 ) . " ) AND " ;
            }
            $filter = substr( $filter, 0, -5 ) ;

            $sql = $this->computeRequest( "WHERE ( $filter ) ".$where, $order, $limit, array_merge( array( 'id' ), $nameFields ) ) ;
            $req = $this->dao->prepare( $sql ) ;
            //echo $sql ; die();
            for( $i=0; $i<count( $values ); $i++ )
                $req->bindValue( ':search'.$i, '%'.$values[$i].'%', \PDO::PARAM_STR ) ;
            $req->execute() ;
            

            $objects = array() ;
            while ( $object = $req->fetch( \PDO::FETCH_ASSOC ) )
            {
                $name = null ;
                foreach( $nameFields as $nameField )
                    $name .= $object[$nameField]." " ;
                $objects[] = array( "id"=>$object['id'], "name"=> substr( $name, 0, -1 ) ) ;
            }

            if( count( $objects ) > 0 )
                return array( "total"=>count($objects), "datas"=>$objects, "more"=>false ) ;
        }
        return array( "total"=>0, "datas"=>"", "more"=>false ) ;
    }

    // System Usage
    public function getMySQLUsage( $database=null )
    {
        if( !empty( $database ) )
        {
            $size = 0 ;
            $req = $this->dao->prepare( "SHOW TABLE STATUS FROM " . $database ) ;
            $req->execute() ;
            while ( $data = $req->fetch( \PDO::FETCH_ASSOC ) )
                $size += $data['Data_length'] + $data['Index_length'] ; 
            return $size ;
        }
        else
            throw new \RuntimeException("Unspecified database") ;
    }
}

?>