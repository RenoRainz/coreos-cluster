<?php

namespace Models\Kernel ;

class Crypt {
	private $hashKey ;

	public function __construct( $hashKey )
    {   
        $this->hashKey = $hashKey ;
    }

	public function decrypt( $value ) {
	    $data = $this->base64url_decode( $value ) ;
	    $salt = substr( $data, 8, 8 ) ;
	    $ct = substr( $data, 16 ) ;
	    // 3 rounds for 256, 2 rounds for 128, 3 rounds for 192 since it's not evenly divided by 128 bits
	    $rounds = 3 ;
	    $data00 = $this->hashKey . $salt ;
	    $md5_hash = array() ;
	    $md5_hash[0] = md5( $data00, true ) ;
	    $result = $md5_hash[0];
	    for( $i=1; $i<$rounds; $i++ )
	    {
	      	$md5_hash[$i] = md5( $md5_hash[$i-1].$data00, true ) ;
	        $result .= $md5_hash[$i] ;
	    }
	    $key = substr( $result, 0, 32 ) ;
	    $iv  = substr( $result, 32, 16 ) ;

	    return openssl_decrypt( $ct, 'aes-256-cbc', $key, true, $iv ) ;
	}

	public function encrypt( $value )
	{
	    // Set a random salt
	    $salt = openssl_random_pseudo_bytes( 8 ) ;

	    $salted = '' ;
	    $dx = '' ;
	    // Salt the key(32) and iv(16) = 48
	    while( strlen( $salted ) < 48 )
	    {
	      $dx = md5( $dx. $this->hashKey .$salt, true ) ;
	      $salted .= $dx ;
	    }

	    $key = substr( $salted, 0, 32 ) ;
	    $iv  = substr( $salted, 32, 16 ) ;

	    $encrypted_data = openssl_encrypt( $value, 'aes-256-cbc', $key, true, $iv ) ;
	    return $this->base64url_encode( 'Salted__' . $salt . $encrypted_data ) ;
	}

	private function base64url_encode( $data )
	{ 
		return rtrim( strtr( base64_encode( $data ), '+/', '-_' ), '=' ) ; 
	} 

	private function base64url_decode( $data )
	{ 
		return base64_decode( str_pad( strtr( $data, '-_', '+/' ), strlen( $data ) % 4, '=', STR_PAD_RIGHT ) ) ; 
	}
}

?>