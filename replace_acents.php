<?php
 
function replace_accents($str) {
$str = htmlentities($str, ENT_COMPAT, 'UTF-8');
$str = preg_replace('/&([a-zA-Z])(uml|acute|grave|circ|tilde);/', '$1', $str);
 
return html_entity_decode($str);
}
