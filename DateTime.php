<?php 
/**
 * @author Felipe Barth http://felipebarth.com.br/blog - 31/05/2013
 * Teste 
 * 
 * Exemplo de como realizar operações de adição 
 * subtração e diferenças de datas usando a Classe nativa do PHP DateTime
 * e a classe DateInterval.
 * Dúvidas: fibbarth@gmail.com
 * 
 * Referências
 * http://www.php.net/manual/en/class.datetime.php
 * http://www.php.net/manual/en/class.dateinterval.php
 */
	
	//Primeiro criamos um objeto DateTime com a data de hoje ( 31/05/2013 )
	$hoje = new DateTime( 'now', new DateTimeZone( 'America/Sao_Paulo') );

	/**
	 * Usamos o método format apenas para confirmar que está com a data de hoje
	 * http://php.net/manual/en/datetime.format.php
	 */  
	echo $hoje->format('d/m/Y');
	
	// Criado intervalo de dois dias http://www.php.net/manual/en/dateinterval.createfromdatestring.php
	// Pode ser criado desta forma
	$intervalo  = new DateInterval('P2D');
	
	// Ou desta forma 
	$itervalo2  = DateInterval::createFromDateString('2 days');
	
	// Para confirmar que ambos são iguais
	var_dump('<pre>',$intervalo, $itervalo2,'</pre>');
	
	//Substraindo dois dias do objeto hoje
	$hoje->sub($intervalo);
	echo $hoje->format('d/m/Y');

	// Apenas para dar uma quebra na exibição
	echo '<br />';
	$hoje->add($intervalo);
	echo $hoje->format('d/m/Y');
	
	/*
	 *  Cria uma objeto DateTime, estou usando como exemplo minha data de
	 *  nascimento
	 */ 
	$dataNascimento = new DateTime('1984-06-02');

	// Data futura
	$futuro 	    = new DateTime('2034-01-01');
	
	// A diferença entre as datas 
	$anos = $dataNascimento->diff( $futuro );
	echo '<br />';

	// Imprime na tela a diferença entre as datas
	echo <<<STRING
	Em {$futuro->format('d/m/Y')}
	eu terei {$anos->y} anos, {$anos->m} meses, {$anos->d} dias
STRING;
?>
