<?php

try
{
    require strstr( getcwd(), '/bin/Views/', true ) . '/bin/autoload.php' ;
    $app = new Controllers\BackendController ;
    /*if( $app->config()->get('debug') )
    	\Models\Kernel\ExceptionHandler::Start();*/
    $app->http() ;
}
catch( Exception $e )
{
	$is_exception = true ;
	$exeption_output = $e->getMessage() ;
	require_once( 'layout.php' ) ;
}

?>