<?php

    namespace Models\Kernel ;

    session_start() ;

    class Auth
    {
        public function __construct() {}

        public function getAttribute( $attr )
        {
            return isset( $_SESSION[$attr] ) ? $_SESSION[$attr] : null ;
        }

        public function getFlash()
        {
            $flash = $_SESSION['flash'] ;
            unset( $_SESSION['flash'] ) ;
            return $flash ;
        }
        
        public function hasFlash()
        {
            return isset( $_SESSION['flash'] ) ;
        }
        
        public function setAttribute( $attr, $value )
        {
            $_SESSION[$attr] = $value ;
        }
        
        public function disconnect()
        {
            $this->setAuthenticated( false ) ;
            $this->unsetCookie() ;
            @session_start() ;
            session_unset() ;
            session_destroy() ;
        }
        
        /* SETTERS */

        public function setAuthenticated( $authenticated = true )
        {
            if ( !is_bool( $authenticated ) )
                throw new \InvalidArgumentException('AUTH: Incorrect value, method User::setAuthenticated() must get a boolean') ;
            
            $_SESSION['auth'] = $authenticated ;
        }

        public function setFlash( $message, $type )
        {
            $_SESSION['flash'] = array( 'message'=>$message,
                                        'type'=>$type
                                      ) ;
        }

        public function setCookie( $email, $token )
        {
            if ( is_string( $email ) && !empty( $email ) && is_string( $token ) && !empty( $token ) )
            {
                setcookie( 'email', $email, time() + 365*24*3600, NULL, FALSE ) ;
                setcookie( 'token', $token, time() + 365*24*3600, NULL, FALSE ) ;
            }
            else
                throw new InvalidArgumentException( "AUTH: Unable to create cookie, incorrect informations", 1 ) ;
        }

        public function unsetCookie()
        {
            setcookie( 'email', '', time()-3600 ) ;
            setcookie( 'token', '', time()-3600 ) ;
            
            // Deletion of cookies for the entire domain name
            if (isset($_SERVER['HTTP_COOKIE'])) {
                $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
                foreach( $cookies as $cookie ) {
                    $parts = explode( '=', $cookie ) ;
                    $name = trim( $parts[0] ) ;
                    setcookie( $name, '', time()-1000 ) ;
                    setcookie( $name, '', time()-1000, '/' ) ;
                }
            }
        }

        public function setCryptId( $value )
        {
            if ( is_string( $value ) && !empty( $value ) )
                $_SESSION['cryptId'] = $value ;
        }

        public function setTitle( $value )
        {
            if ( is_string( $value ) && !empty( $value ) )
                $_SESSION['firstName'] = $value ;
        }

        public function setFirstName( $value )
        {
            if ( is_string( $value ) && !empty( $value ) )
                $_SESSION['firstName'] = $value ;
        }

        public function setLastName( $value )
        {
            if ( is_string( $value ) && !empty( $value ) )
                $_SESSION['lastName'] = $value ;
        }

        public function setLang( $value )
        {
            if ( is_string( $value ) && !empty( $value ) )
                $_SESSION['lang'] = $value ;
        }

        public function setRoles( $value )
        {
            if ( is_array( $value ) && count( $value ) > 0 )
                $_SESSION['roles'] = $value ;
        }

        /* GETTERS */

        public function isAuthenticated() { return isset( $_SESSION['auth'] ) && $_SESSION['auth'] === true ; }
        public function cryptId() { return $_SESSION['cryptId'] ; }
        public function title() { return $_SESSION['title'] ; }
        public function firstName() { return $_SESSION['firstName'] ; }
        public function lastName() { return $_SESSION['lastName'] ; }
        public function lang() { return ( isset( $_SESSION['lang'] ) ? $_SESSION['lang'] : 'FR' ) ; }
        public function roles() { return ( isset( $_SESSION['roles'] ) ? $_SESSION['roles'] : array( array( 'id'=>1, "name"=>"Visitors" ) ) ) ; }
    }
?>