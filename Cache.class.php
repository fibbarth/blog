<?php
/**
 * @author Felipe Barth
 * Classe responsável por fazer cache tanto de HTML 
 * quanto de informações em geral.
 * 
 * Formas de uso:
 * - Para HTML 
 *   	$cache = new Cache('nome de id do cache', [ timelife em segundos ]);
 *		if( $cache->initCache() ){
 *			Usando valores do cache
 *			echo $cache->content();
 *		}else{
 *			html gerado sem cache...
 *			$cache->store();
 *		}
 * - Para outros formatos
 * 	 $cache = new Cache( '', [timelife em segundos ]);
 * 	 $cache->initCache('formato') // Por exemplo 'json'
 * 	 if( $cache->checkTimeLife() ){
 * 		echo $cache->content();
 *   }else{
 *   	$cache->store( $dadosJaFormatados );
 *   }
 *
 */
class Cache{
	
	private $cache;
	private $type;
	private $timelife;
	private $pdo;

	/**
	 * @author Felipe Barth
	 * Método construtor deve-se obrigatoriamente passar o nome do cache 
	 * que será o indentificador e caso o cache não existir é assumido o timelife
	 * passado como parâmetro;
	 * @param string $nameCache
	 * @param int $timelife Valor em segundos
	 */
	public function __construct( $nameCache, $timelife = '600' ){
		//Conexao com o banco
		$dsn = 'mysql:dbname=def;charset=utf8;host='.MYSQL_HOST;
		$this->pdo = new PDO( $dsn, MYSQL_USER, MYSQL_PASS );
		$this->timelife = $timelife;
		$this->initdata( $nameCache );
	}
	
	/**
	 * @author Felipe Barth
	 * Inicializa os atributos da classe
	 * visibilidade é private pois é para apenas uso
	 * interno da classe.
	 * @param string $nameCache
	 */
	private function initData( $nameCache ){
		// inicializa dados
		$sql = "SELECT name,
					   type,
					   content,
				       created,
				       timelife
				         FROM cache WHERE name = :name";
		$sth = $this->pdo->prepare( $sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY) );
		$sth->execute( array( ':name' => $nameCache ) );
		if( !$sth->rowCount() ){
			$this->insertCache( $nameCache );
		}else{
			$this->cache = $sth->fetchObject();
		}
	}
	
	/**
	 * @author Felipe Barth
	 * Método responsável para inicar o cache e passo o tipo do cache que será salvo
	 * caso for tipo HTML o tipo  é default e não necessário passar o content. 
	 * @param string $type  Tipo dos valores que vão ser passados caso seja HTML 
	 * não é necessário passar o content no store
	 */
	public function initCache( $type = 'html' ){
		$this->type = $type;
		if( $this->type == 'html' ){
			ob_start();
		}
	}
	
	/**
	 * @author Felipe Barth
	 * Método que armazena o cache no banco de dados.
	 * 
	 * @param string $content
	 * @param boolean $show default true onde mostra a saida, senão apenas armazena no contents
	 * @return boolean
	 */
	public function store( $contentCache = false, $show = true ){
		
		// Para tipos html
		if( !$contentCache ){
			if( $show ){
				$contentCache = ob_get_contents();
			}else{
				$contentCache = ob_get_clean();
			}
		}
		if( $this->checkTimeLife() ){
			return false;
		}
		$date = date ("Y-m-d H:i:s");
		$params = array(
						 ':name' 	 => $this->cache->name,
						 ':type' 	 => $this->type,
						 ':content'  => $contentCache,
						 ':created'  => $date,
						 ':timelife' => $this->cache->timelife 	
					   );
		return $this->updateCache( $params );
	}
	
	/**
	 * @author Felipe Barth
	 * Método que atualiza cache
	 * @param array $params
	 * @return boolean
	 */
	private function updateCache( $params ){
		$sql = "UPDATE cache 
					SET type=:type, 
						content=:content, 
						created=:created, 
						timelife=:timelife 
							WHERE name=:name";
	
		$sth = $this->pdo->prepare( $sql );
		$this->bind( $params );
		$return = $sth->execute( $params );

		return $return; 				
	}
	
	/**
	 * @author Felipe Barth
	 * Retorna o cache salvo em banco.
	 */
	public function content(){
		// Adicionado 
		if( $_SERVER['HTTPS'] && $this->cache->type == 'html' ){
			$de  	= 'http://';
			$para   = 'https://';
		}else{
			$de  	= 'https://';
			$para   = 'http://';
		}
		return str_replace($de, $para, $this->cache->content);
	}
	
	/**
	 * @author Felipe Barth
	 * Método responsável por inserir novo cache no banco
	 * visibilidade private pois apenas será usado dentro da classe.
	 * @param string $nameCache
	 */
	private function insertCache( $nameCache ){
		$sql = "INSERT INTO 
					cache( name, created, timelife ) 
					VALUES(:name, :created, :timelife )";
		$sth = $this->pdo->prepare( $sql );
		$params = array(
						 ':name'    => $nameCache,
						 ':created' => '0000-00-00 00:00:00',
						 ':timelife' => $this->timelife	
						);
		$this->bind( $params );
		$sth->execute( $params );
	}
	
	/**
	 * @author Felipe Barth
	 * Realiza o bind para atualizar os atributos da classe 
	 * com os valores atuais.
	 * @param array $params
	 * @return boolean
	 */
	private function bind( $params ){
		if( is_array( $params ) ){
			foreach( $params as $param => $value ){
				$param = ltrim( $param, ':' );
				$this->cache->$param = $value;
			} 
			return true;
		}
		return false;
	}
	
	/**
	 * @author Felipe Barth
	 * Verifica se o cache está com o período válido.
	 * @return boolean
	 */
	public function checkTimeLife(){
		// Data do cache do banco de dados
		$dateCache = new DateTime($this->cache->created);
		// Cria objeto de intervalo
		$intervalo = new DateInterval( 'PT'.$this->cache->timelife.'S' );
		// Adiciona a data do cache para comparação com a data atual.
		$dateCache->add( $intervalo );
		// Data atual
		$dataAtual = new DateTime('NOW');
		
		return ($dataAtual->format('U') <= $dateCache->format('U'));  
	}
	
	/**
	 * @author Felipe Barth
	 * Limpa o cache que foi passado como parâmetro 
	 * no construtor da classe.
	 */
	public function clearCache(){
		$sql = "DELETE FROM cache WHERE name=:name";
		$params = array( ':name' => $this->cache->name );
		$sth = $this->pdo->prepare( $sql );
		$sth->execute( $params );
	}
	
	/**
	 * @author Felipe Barth
	 * Caso seja inicializado a classe porém nada foi armazenado 
	 * será excluido do banco ao finalizar o objeto.
	 */
	public function __destruct(){
		if( $this->cache->created == '0000-00-00 00:00:00' && empty($this->cache->content) && empty($this->cache->type) ){
			$this->clearCache();		
		}
	}
}
