<?php
    namespace Models\Kernel ;
    
    class HTTPResponse
    {
        protected $page ;
        
        public function __construct()
        {
            $this->page = null ;
        }

        public function addHeader( $header )
        {
            header( $header ) ;
        }
        
        public function redirect( $location )
        {
            header( 'Location: '. $location ) ;
            exit ;
        }

        public function redirectReferer()
        {
            if( isset( $_SERVER['HTTP_REFERER'] ) )
                header( 'Location: '. $_SERVER['HTTP_REFERER'] ) ;
            else
                header( 'Location: /console' ) ;
            exit ;
        }

        public function redirect403()
        {
            $this->page->setContentFile(dirname(__FILE__).'/../Web/403.html') ;
            $this->addHeader('HTTP/1.0 403 Forbidden') ;
            
            $this->send();
        }
        
        public function redirect404()
        {
            $this->page->setContentFile(dirname(__FILE__).'/../Web/404.html') ;  
            $this->addHeader('HTTP/1.0 404 Not Found') ;
            
            $this->send();
        }

        public function redirectAjax403()
        {
            $this->page->setContentFile(dirname(__FILE__).'/../Web/404.html') ;
            $this->addHeader('HTTP/1.0 403 Forbidden') ;
            $this->sendAjax() ;
        }

        public function redirectAjax404()
        {
            $this->page->setContentFile(dirname(__FILE__).'/../Web/404.html') ; 
            $this->addHeader('HTTP/1.0 404 Not Found') ;
            $this->sendAjax() ;
        }
        
        public function send()
        {
            exit( $this->page->getGeneratedPage() ) ;
        }

        public function sendAjax()
        {
            exit( $this->page->getGeneratedAjax() ) ;
        }
        
        public function setPage( Page $page )
        {
            $this->page = $page ;
        }
        
        public function setCookie($name, $value='', $expire=0, $path=null, $domain=null, $secure=false, $httpOnly=true )
        {
            setcookie( $name, $value, $expire, $path, $domain, $secure, $httpOnly ) ;
        }
    }
?>