<?php
$telefones = array(
			'(51)9-9999-9999',
        		'(51)9999-9999',
			'(51)9912-9923',
        		'(51)5-4545-4111',
        		'519999-9999',
        		'419911-9923',
        		'519911-9920'
    		   );
$pattern = '/(\([0-9]{2}\))([0-9]{1}-)?([0-9]{4})-([0-9]){4}/';

foreach( $telefones as $telefone ){
	if(preg_match($pattern, $telefone)){
		echo "{$telefone} => Válido<br />"; 
		continue;
	}
	echo "{$telefone} => Inválido<br />";  
}
?>
