<?php
  function checkStringEncoding( $string ){
		$string = ( mb_detect_encoding($string.'x', 'UTF-8, ISO-8859-1') != 'UTF-8' ) ? utf8_encode($string) : $string;
		return $string;
	}
