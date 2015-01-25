<?php
    namespace Models\Kernel ;
    
    abstract class Record implements \ArrayAccess
    {
        protected   $errors,
                    $id,
                    $encryptedId,
                    $cDate,
                    $mDate,
                    $cUserId,
                    $mUserId,
                    $cUserName_,
                    $mUserName_;
        
        public function __construct( $datas = array() )
        {
            if ( !empty( $datas ) )
                $this->hydrate( $datas ) ;
        }
        
        public function isNew()
        {
            return empty( $this->id ) ;
        }
        
        public function errors()
        {
            return $this->errors ;
        }
        
        public function hydrate( array $datas )
        {
            foreach( $datas as $attribute => $value )
            {
                $method = 'set'.ucfirst( $attribute ) ;
                if ( is_callable( array( $this, $method ) ) )
                    $this->$method( $value ) ;
            }
        }
        
        public function offsetGet( $var )
        {
            if( isset( $this->$var ) && is_callable( array( $this, $var ) ) )
                return $this->$var() ;
        }
        
        public function offsetSet( $var, $value )
        {
            $method = 'set'.ucfirst( $var );
            
            if (isset( $this->$var ) && is_callable( array( $this, $method ) ) )
                $this->$method( $value ) ;
        }
        
        public function offsetExists( $var )
        {
            return isset( $this->$var ) && is_callable( array( $this, $var ) ) ;
        }
        
        public function offsetUnset($var)
        {
            throw new \Exception('Unable to remove the dataset');
        }

        // SETTERS //

        public function setId( $id )
        {
            $this->id = (int) $id ;
        }

        public function setCDate( $value )
        {
            //if ( is_string($value) && preg_match('`[0-9]{2}/[0-9]{2}/[0-9]{4} [0-9]{2}:[0-9]{2}`', $value ) )
                $this->cDate = $value ;
        }
                
        public function setCUserId( $value )
        {
            if ( is_numeric( $value ) )
                $this->cUserId = $value ;
        }

        public function setMDate( $value )
        {
            //if ( is_string($value) && preg_match('`[0-9]{2}/[0-9]{2}/[0-9]{4} [0-9]{2}:[0-9]{2}`', $value ) )
                $this->mDate = $value ;
        }

        public function setMUserId( $value )
        {
            if ( is_numeric( $value ) )
                $this->mUserId = $value ;
        }

        public function setCUserName_( $value )
        {
            if ( is_string( $value ) )
                $this->cUserName_ = $value ;
        }

        public function setMUserName_( $value )
        {
            if ( is_string( $value ) )
                $this->mUserName_ = $value ;
        }

        // GETTERS //

        public function id() { return $this->id ; }
        public function cDate() { return $this->cDate ; }
        public function cUserId() { return $this->cUserId ; }
        public function mDate() { return $this->mDate ; }
        public function mUserId() { return $this->mUserId ; }
        public function cUserName_() { return $this->cUserName_ ; }
        public function mUserName_() { return $this->mUserName_ ; }
    }
?>