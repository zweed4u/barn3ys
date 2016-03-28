<?php

$keywords = 'SNEAKER_NAME_HERE';
$from     = 504306160;
$to       = 504999999;

set_time_limit( 0 );

$curl = curl_init();
curl_setopt( $curl, CURLOPT_AUTOREFERER, true );
curl_setopt( $curl, CURLOPT_FOLLOWLOCATION, false );
curl_setopt( $curl, CURLOPT_HEADER, false );
curl_setopt( $curl, CURLOPT_NOBODY, true );
curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
curl_setopt( $curl, CURLOPT_USERAGENT, 'Opera/9.80 (Windows NT 6.0; U; en) Presto/2.2.15 Version/10.10' );
$keywords = explode( ' ', strtolower( $keywords ) );
$links = 0;
$log = fopen( dirname( __FILE__ ) . '/barneys.log', 'w' );
for ( $i = $from ; $i <= $to ; $i ++ ) {
	curl_setopt( $curl, CURLOPT_URL, 'http://www.barneys.com/' . $i . '.html' );
	echo $i;
 	//   if ( $i % 25 == 0 ) {
        fwrite( $log, 'position=' . $i . ', found=' . $links . "\n" );
        fflush( $log );
   	// }
    	$response = curl_exec( $curl );
    	$info = curl_getinfo( $curl );
 	if ( $info[ 'http_code' ] == 403) {
		echo 'banned';
		break;	
	}
	if ( $info[ 'http_code' ] == 301 && ( $pos = strrpos( $info[ 'redirect_url' ], '/' ) ) !== false ) {
        	$found = true;
        	foreach ( $keywords as $keyword ) {
            		if ( strpos( substr( $info[ 'redirect_url' ], $pos ), $keyword ) === false ) {
                		$found = false;
                		break;
            		}
        	}
        	if ( $found ) {
			echo ' :: ';
            		echo $info[ 'redirect_url' ] ;
            		$links ++;
        	}
    	}
	echo "\n";
    	sleep(rand(.5,1.5));
}
fclose( $log );
curl_close( $curl );
