<?php 
	/**
	 * @author Felipe Barth http://felipebarth.com.br/blog - 02/06/201 
	 * Exemplo de como gerar um PDF com PHP usando 
	 * a classe DOMPDF.
	 * 
	 * Referências 
	 * http://php.net/manual/pt_BR/function.ob-start.php
	 * http://br1.php.net/manual/pt_BR/function.ob-get-clean.php
	 * https://github.com/dompdf/dompdf
	 */
?>
<?php
	/**
	 * Armazena saída do HTML em buffer
	 * Referências
	 * http://php.net/manual/pt_BR/function.ob-start.ph
	 */ 
	ob_start('geraPDF'); 
?>
<!DOCTYPE html>
<html>
	<head>
		 <meta charset='utf-8'>
		 <title>Exemplo de geração de PDF com PHP usando classe DOMPDF</title>
	</head>
	<style>
		p{
			border:1px solid black;
			box-shadow:5px 5px 5px #ccc;
			width:90%;
			padding:5px;
		}
	</style>
	<body>
		<h1>Gerando PDF com DOMPDF</h1>
		<p>
			Exemplo de criaçaõ de PDF com PHP usando classe DOMPDF
		</p>			
	</body>
</html>
<?php
	// Importa arquivo de config da classe DOMPDF
	require_once 'lib/dompdf/dompdf_config.inc.php';

	/**
	 *  Função ob_get_clean obtém conteúdo que está no buffer
	 *  e exclui o buffer de saída atual.
	 *  http://br1.php.net/manual/pt_BR/function.ob-get-clean.php 
	 */
	$html = ob_get_clean(); 
	$pdf = new DOMPDF();
	$pdf->load_html($html);
	$pdf->render();
	$pdf->stream("sample.pdf");
?>