<?php 
/**
 * @author Felipe Barth http://felipebarth.com.br/blog 31/05/2013
 * Exemplo de uso do spl_autoload_register, spl_autoload_extension
 * Criando uma alternativa para o autoload usando funções anonimas
 * 
 * Referências:
 * http://br1.php.net/manual/en/functions.anonymous.php
 * http://www.php.net/manual/en/function.spl-autoload-register.php
 */

  
  //Registra função autoload como uma função anônima
  spl_autoload_register(function($className){
  	// Alterado caminho para realizar o include.
  	set_include_path('classes/');
  	require_once($className.'.class.php');
  });
  
  $hello = new Hello();
  $world = new World();
  $hello->text();
  echo 	' ';
  $world->text();
?>