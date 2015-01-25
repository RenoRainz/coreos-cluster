<?php
    namespace Models\Kernel ;
    
    class CoreApp
    {
        protected $app ;
        
        public function __construct( Core $app )
        {
            $this->app = $app ;
        }
        
        public function app()
        {
            return $this->app ;
        }
    }
?>