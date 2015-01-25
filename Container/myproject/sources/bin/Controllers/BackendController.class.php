<?php
    namespace Controllers ;
    
    class BackendController extends \Models\Kernel\Core
    {
        public function __construct()
        {
            parent::__construct() ;
            
            $this->name = 'Backend' ;
        }
        
        public function http()
        {

            /*if ( $this->auth()->isAuthenticated() )
            {
                $router = new \Models\Kernel\Router($this) ;
                $controller = $router->getController('app') ;
            }
            else
                $controller = new Backend\UserController( $this, 'User', 'auth' ) ;*/
            
            $router = new \Models\Kernel\Router($this) ;
            $controller = $router->getController('app') ;
            $controller->execute() ;
            
            $this->httpResponse->setPage( $controller->page() ) ;
            $this->httpResponse->send() ;
        }

        public function ajax()
        {
            $router = new \Models\Kernel\Router($this) ;
            $controller = $router->getController('ajax') ;
            $this->httpResponse->setPage( $controller->page() ) ;

            if ( $this->auth()->isAuthenticated() && isset( $_SERVER['HTTP_REFERER'] ) && strpos( $_SERVER['HTTP_REFERER'], $this->config()->get('url') ) !== false )
            {
                $controller->execute() ;
                $this->httpResponse->sendAjax() ;
            }
            else 
                $this->httpResponse->redirectAjax403() ;
        }

        public function cli()
        {
            $router = new \Models\Kernel\Router( $this ) ;
            $controller = $router->getController('cli') ;
            $controller->execute() ;
        }
    }
?>