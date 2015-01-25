<?php
    namespace Models\Kernel ;
    
    abstract class Core
    {
        protected $httpRequest ;
        protected $httpResponse ;
        protected $name ;
        
        public function __construct()
        {
            $this->httpRequest = new HTTPRequest ;
            $this->httpResponse = new HTTPResponse ;
            $this->name = '' ;
        }
        
        abstract public function http() ;
        abstract public function ajax() ;
        abstract public function cli() ;
        
        public function httpRequest()
        {
            return $this->httpRequest ;
        }
        
        public function httpResponse()
        {
            return $this->httpResponse ;
        }
        
        public function name()
        {
            return $this->name ;
        }

        public function auth()
        {
            return new Auth ;
        }

        public function lang()
        {
            return new Lang( $this->name, $this->auth()->lang() ) ;
        }

        public function config()
        {
            return new Config( $this->name ) ;
        }

        public function crypt()
        {
            return new Crypt( $this->config()->get('hashKey') ) ;
        }
    }
?>