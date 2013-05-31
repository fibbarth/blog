<?php 
/**
 * @author Felipe Barth http://felipebarth.com.br/blog
 * @date 2013-05-31
 * 
 * Aqui vamos demostrar como realizar operações de adição 
 * subtração e diferenças de datas usando a Classe nativa do PHP
 * e a classe DateInterval.
 * 
 * Referências
 * http://www.php.net/manual/en/class.datetime.php
 * http://www.php.net/manual/en/class.dateinterval.php
 */

	//Primeiro criamos um objeto DateTime com a data de hoje ( 31/05/2013 )
	$hoje = new DateTime('now');

	/**
	 * Usamos o método format apenas para confirmar que está com a data de hoje
	 * http://php.net/manual/en/datetime.format.php
	 */  
	echo $hoje->format('d/m/Y H:i:s');
	
	// Criado intervalo de dois dias http://www.php.net/manual/en/dateinterval.createfromdatestring.php
	// Pode ser criado desta forma
	$intervalo  = new DateInterval('P2D');
	
	// Ou desta forma 
	$itervalo2  = DateInterval::createFromDateString('2 days');
	
	// Para confirmar que ambos são iguais
	var_dump('<pre>',$intervalo, $itervalo2,'</pre>');
	
	
?>