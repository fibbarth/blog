<?php 
	/**
	 * @author Felipe Barth http://felipebarth.com.br/blog - 01/06/2013
	 * Exemplo de uso da função preg_replace.
	 */
	$nomes = array(	'Fulano da Silva Inscrito',
					'Fulano da Silva *** inscrito***',
					'Fulano da Silva ** inscrito',
					'Fulano da Silva (INSCRITO)',
					'Fulano da Silva *(inscrito)**',
					'Fulano da Silva * inscrito*',	
					'Fulano da Silva * inscritos *****',
					'Fulano da Silva ( inscritos *****',
				   );
	
	foreach( $nomes as $nome ){
		$nArrumado[] = preg_replace('/[*([:blank:]]*(inscrito)s?[[:blank:]*)]*/i','',$nome);
	}
	
	var_dump('<pre>',$nArrumado,'</pre>');
?>