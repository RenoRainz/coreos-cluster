<?php
    namespace Models\Kernel ;
    
    class HTTPRequest
    {
        protected $session ;

        public function __construct() { 
            $this->session = new Auth() ;
        }

        public function session() { 
            return $this->session ;
        }

        public function cookieData( $key )
        {
            return isset( $_COOKIE[$key] ) ? $_COOKIE[$key] : null ;
        }
        
        public function cookieExists( $key )
        {
            return isset( $_COOKIE[$key] ) ;
        }
        
        public function getData( $key )
        {
            return isset( $_GET[$key] ) ? $_GET[$key] : null ;
        }

        public function getDatas()
        {
            return $_GET ;
        }
        
        public function getExists( $key = null )
        {
            if( !is_null( $key ) )
                return isset( $_GET[$key] ) ;
            else if( count( $_GET ) > 0 )
                return true ;
            else
                return false ;
        }
        
        public function postData( $key )
        {
            return isset( $_POST[$key] ) ? $_POST[$key] : null ;
        }

        public function postDatas()
        {
            return $_POST ;
        }
        
        public function postExists( $key = null )
        {
            if( !is_null( $key ) )
                return isset( $_POST[$key] ) ;
            else if( count( $_POST ) > 0 )
                return true ;
            else
                return false ;
        }

        public function addGetVar( $key, $value )
        {
            if( isset( $key ) && isset( $value ) )
                $_GET[$key] = $value ;
            return true ;
        }
        
        public function requestURI()
        {
            return $_SERVER['REQUEST_URI'] ;
        }
    }
?>