<?php
    function autoload( $class )
    {
        $path = strstr( getcwd(), '/bin/Views/', true ) ;
        require_once( $path . '/vendor/autoload.php' ) ;
        
        $class = str_replace( '\\', '/', $class ) ;

    	if( file_exists( $file = $path . '/' . $class .'.class.php' ) )
        	require( $file ) ;
        else if( file_exists( $file = $path . '/bin/'. $class .'.class.php' ) )
            require( $file ) ;
    }

    spl_autoload_register( 'autoload' ) ;
?>