<?php
    namespace Models\Kernel ;

    class Lang
    {
        protected $vars ;
        private $app_name ;
    	private $lang ;    	
        
        public function __construct( $app_name, $lang )
        {
        	$this->app_name = $app_name ;
        	$this->lang = $lang ;
        }

        public function appLang( $upCase=true)
        {
            if( !$upCase )
                return strtolower( $this->lang ) ;
            else
                return $this->lang ;
        }

        public function txt( $var, $arr=null )
        {
            if ( !$this->vars )
            {
                $xml = new \DOMDocument ;
                @$xml->load(dirname(__FILE__).'/../Applications/'. $this->app_name .'/Lang/'. strtoupper( $this->lang ) .'.xml') ;
                
                $elements = $xml->getElementsByTagName('define') ;
                
                foreach ($elements as $element)
                {
                    $this->vars[$element->getAttribute('var')] = $element->getAttribute('value') ;
                }
            }
            
            if ( isset( $this->vars[$var] ) )
            {
                if ( isset( $arr ) )
                {
                    $output = $this->vars[$var] ;
                    foreach( $arr as $key => $val )
                    {
                        $output = str_replace( '{'.$key.'}', $val, $output ) ;
                        if( strstr( $output, '{'.$key.'-s}' ) )
                        {
                            if( is_numeric( $val ) && $val > 1 )
                                $output = str_replace( '{'.$key.'-s}', 's', $output ) ;
                            else
                                $output = str_replace( '{'.$key.'-s}', '', $output ) ;
                        }
                    }
                    return $output ;
                }
                else
                    return $this->vars[$var] ;
            }
            
            return '{'.$var.'}' ;
        }

        public function img( $var )
        {
            if( $this->app_name == 'Backend' )
                return dirname(__FILE__) . '/../Web/console/images/'. strtoupper( $this->lang ) .'/' . $var ;
            else
                return dirname(__FILE__) . '/../Web/images/'. strtoupper( $this->lang ) .'/' . $var ;
        }
    }
?>