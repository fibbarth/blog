<?php
$string = 'TesteDeCamelCase';
$source = CamelCaseToHumanCase($string);
function CamelCaseToHumanCase($source) {
  return preg_replace('/(?<!^)([A-Z][a-z]|(?<=[a-z])[^a-z]|(?<=[A-Z])[0-9_])/', ' $1', $source);
}
echo $source;
?>
