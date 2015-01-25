<?php
    namespace Models\Kernel ;
    
    class Router extends CoreApp
    {
        public function getController( $type )
        {
            if( $this->app->httpRequest()->requestURI() != "/api/users" )
                return new \Controllers\Backend\UserController( $this->app, 'User', 'index' ) ;
            else
                return new \Controllers\Backend\UserController( $this->app, 'User', 'api' ) ;

            if( $type != 'job' )
            {
                $dom = new \DOMDocument ;
                $dom->load( dirname(__FILE__) .'/../Applications/'. $this->app->name() .'/Config/routes.xml' ) ;

                foreach ( $dom->getElementsByTagName('route') as $route )
                {
                    if ( preg_match( '`^'. $route->getAttribute('url').'$`', $this->app->httpRequest()->requestURI(), $matches ) )
                    {
                        $module = $route->getAttribute('module') ;
                        $action = $route->getAttribute('action') ;
                        
                        $classname = $module .'Controller' ;
                        if ( !file_exists( dirname(__FILE__) .'/../Applications/'. $this->app->name() .'/Modules/'. $module .'/'. $classname .'.class.php' ) )
                           throw new \RuntimeException( 'Le module où pointe la route n\'existe pas' ) ;

                        $class = '\\Applications\\'.$this->app->name().'\\Modules\\'.$module.'\\'.$classname ;
                        $controller = new $class( $this->app, $type, $module, $action ) ;
                        
                        if ( $route->hasAttribute( 'vars' ) )
                        {
                            $vars = explode( ',', $route->getAttribute('vars') ) ;
                            
                            foreach ( $matches as $key => $match )
                            {
                                if ( $key !== 0 )
                                    $this->app->httpRequest()->addGetVar( $vars[$key - 1], $match ) ;
                            }
                        }
                        break;
                    }
                }
            }
            else
            {
                $args = getopt( 'm:a:' ) ;
                if( isset( $args['m'] ) && isset( $args['a'] ) )
                {
                    $module = $args['m'] ;
                    $action = $args['a'] ;
                    $classname = $module .'Controller' ;
                    $class = '\\Applications\\'.$this->app->name().'\\Modules\\'.$module.'\\'.$classname ;
                    $controller = new $class( $this->app, $type, $module, $action ) ;
                }
                else
                    throw new \RuntimeException( 'Nothing to do -- Usage : -m Module -a Action' ) ;
            }
            
            if ( !isset( $controller ) )
            {
                $this->app->httpResponse()->setPage( new Page( $this->app ) ) ; 
                if ( $type == 'ajax' )
                    $this->app->httpResponse()->redirectAjax404() ;
                else if( $type == 'job' )
                {
                    echo "Controller not found\n";
                    exit;
                }
                else if( $this->app->name() == "Frontend" )
                    $this->app->httpResponse()->redirect( "/fr/404" ) ;
                else
                    $this->app->httpResponse()->redirect404() ;
            }
            
            return $controller ;
        }
    }
?>