<?php

namespace Models\Kernel ;

class PDOFactory
{
    public static function getMysqlConnexion( $dsn, $username, $password, $settings )
    {
        $options = array(
            \PDO::ATTR_ERRMODE                  => \PDO::ERRMODE_EXCEPTION,
            \PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
            \PDO::ATTR_STATEMENT_CLASS          => array( '\Models\Kernel\PDOStatement', array() )
        );
        $db = new \PDO( $dsn, $username, $password, $options ) ;
        $db->exec( "SET CHARACTER SET utf8" ) ;
        // Unlimited GROUPCONCAT operations size
        // http://dev.mysql.com/doc/refman/5.1/en/server-system-variables.html#sysvar_group_concat_max_len
        $db->exec( "SET SESSION group_concat_max_len = 18446744073709547520;" ) ;
        /*$dbVersion = $db->exec( "SELECT version FROM versioning ORDER BY 'date' DESC" ) ;*/
        /*if( $dbVersion != $version )
            throw new Exception("DB: Required version : '$version' - Database version : '$dbVersion'", 1 ) ;*/

        return $db ;
    }
}

// Custom class implementation in order to get debug on failing queries
class PDOStatement extends \PDOStatement
{
    protected $_debugValues = null;
    protected function __construct() { }

    public function execute( $values=array() )
    {
        $this->_debugValues = $values ;
        try {
            $t = parent::execute( $values ) ;
        } catch( PDOException $e ) {
            throw $e ;
        }

        echo _debugQuery() ;
        die() ;

        return $t ;
    }

    public function _debugQuery( $replaced=true )
    {
        $q = $this->queryString ;

        if( !$replaced )
            return $q ;

        return preg_replace_callback( '/:([0-9a-z_]+)/i', array( $this, '_debugReplace' ), $q ) ;
    }

    protected function _debugReplace( $m )
    {
        $v = $this->_debugValues[$m[1]] ;
        if( $v === null )
            return "NULL" ;
        if( !is_numeric( $v ) )
            $v = str_replace( "'", "''", $v ) ;
        return "'$v'" ;
    }
}

?>