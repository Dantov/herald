<?php

/**
* 
* @param {object} $arr
* @param {object} $str
* @param {object} false
* @param {object} $die
* 
* @return
*/
function debug( $arr, $str = false , $die = false)
{
	echo '<pre>';
	if ( $str )
		echo $str . ' = ';
	print_r( $arr );
	echo '</pre>';

	if ( $die )
		die("\n\t Script stopped by debug function");
}