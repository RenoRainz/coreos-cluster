<?php
    namespace Models\Kernel ;
    use Symfony\Component\Yaml\Yaml ;

    class Config
    {
        private $app_name ;
        protected $vars ;

        public function __construct( $app_name )
        {
            $this->app_name = $app_name ;

            $path = strstr( getcwd(), '/bin/Views/', true ) . '/conf' ;
            $common_config_file = $path . '/common.yml' ;
            $app_config_file = $path . '/' . strtolower($this->app_name) .'.yml' ;

            if( !file_exists( $common_config_file ) )
                throw new \Exception( "CONFIG: Common configuration file : $common_config_file not found", 1 ) ;
            
            if( !$common_vars = Yaml::parse( file_get_contents( $common_config_file ) ) )
                    throw new \Exception( "CONFIG: Invalid yaml file format : $common_config_file", 1 ) ;

            if( file_exists( $app_config_file ) )
            {
                if( !$app_vars = Yaml::parse( file_get_contents( $app_config_file ) ) )
                    throw new \Exception( "CONFIG: Invalid yaml file format : $app_config_file", 1 ) ;
                $this->vars = $this->array_merge_recursive_replace( $common_vars, $app_vars ) ;
            }
            else
                $this->vars = $common_vars ;
        }
        
        public function get( $var )
        {
            if( strpos( $var, ':' ) )
            {
                $vars = explode( ':', $var ) ;
                $var = $this->vars ;
                foreach( $vars as $node )
                    $var = $var[$node] ;
                return $var ;
            }
            else if ( isset( $this->vars[$var] ) )
                return $this->vars[$var] ;
            else
                throw new \Exception( "CONFIG: Undefined variable '$var'" ) ;

            return null ;
        }

        public function getVars()
        {
            return $this->vars ;
        }

        private function array_merge_recursive_replace() {
            $arrays = func_get_args() ;
            $base = array_shift( $arrays ) ;
            foreach( $arrays as $array ) {
                reset( $base ) ;
                while( list( $key, $value ) = @each( $array ) )
                {
                    if( is_array( $value ) && @is_array( $base[$key] ) )
                        $base[$key] = array_merge_recursive_replace($base[$key], $value) ;
                    else
                        $base[$key] = $value ;
                }
            }

            return $base ;
        }
    }
?>