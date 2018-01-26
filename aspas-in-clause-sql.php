<?php
  $values  = array('string1','string2','string3','string4');
  $inQuery = sprintf( "'%s'", implode( "','", $values ) );
  $query = "SELECT * FROM TABLE WHERE IN ( {$inQuery} )";
