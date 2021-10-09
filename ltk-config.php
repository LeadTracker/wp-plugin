<?php

/**
 * Classe responsável por controlar o plugin
 * Agradecimentos a Frank Vieiro e Navegg
 */
class LtkWp{

	private static $info;
	
	private static $oauthUrl = 'https://painel.leadtracker.com.br/api/v1/cf-oauth/';
	private static $oauthInfoUrl = 'https://painel.leadtracker.com.br/api/v1/cf-oauth-info/';

	
	
	/**
	 * Função de inicialização
	 */
	function inicializar(){
	
	  //Mapear infos relevantes para plugin
	  LtkWp::$info['plugin_fpath']= dirname(__FILE__);
	
	
	  //Chama a função para imprimir a tag no head
	  add_action( 'wp_head', array('ltkWp','echoLeadtracker'));
	
	  //Chama a função para criar página de administração
	  add_action( 'admin_menu', array('ltkWp','createAdmLtk'));

	  //Colocar Mensagem de erro se não estiver cadastrado LTK_ID
	  if(LtkWp::getIdLtk() == ''&& $_GET['page'] != 'ltk-admin' )//Verifica se não é post! E imprimie
	     add_action( 'admin_notices', array('ltkWp','echoMsgNotId' ));
	}
	
	/**
	 * Função de instalação
	 */
	function instalar(){
	    //Verifica se esta inicializado se não estiver, inicializa;
	    if ( is_null(LtkWp::$info) ) LtkWp::inicializar();
	    
	    //Criar dados do banco
	    LtkWp::createIdLtk();
		LtkWp::createLtkToken();
	}
	
	/**
	 * Função de desinstalação
	 */
	function desinstalar(){
	  //Deleta dados do banco
	   LtkWp::deleteIdLtk();
	   LtkWp::deleteLtkToken();
	}
	
	
	
	//Páginas
	
	
	/**
	 * Cria página de adm
	 */
	function createAdmLtk(){
		add_menu_page('Lead Tracker','Lead Tracker',10,'ltk-admin',array('LtkWp','admInit'),plugins_url( '/contents/ltklogo.svg', __FILE__ ));
	}
	
	/**
	 * Faz o include da pagina inicial do administrador, que é chamado quando
	 * o usuário clica no menu Lead Tracker
	 */
	function admInit(){ 

		// Oauth return from panel
		if($_GET['check'] && $_GET['code']){

			if($_SESSION['LTK_OAUTH_CODE'] == $_GET['check']){
				LtkWp::setLtkToken(filter_var($_GET['code'], FILTER_SANITIZE_STRING));
			}
			echo "<script>window.close()</script>";
		}

		// Logout = remove Token
		if($_GET['check'] && $_GET['logout']){

			if($_SESSION['LTK_OAUTH_CODE'] == $_GET['check']){
				LtkWp::deleteLtkToken();
				LtkWp::deleteIdLtk();
			}

			$url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]".$_SERVER['REQUEST_URI'];
			$url = preg_replace('~(\?|&)logout=[^&]*~', '$1', $url);
			$url = preg_replace('~(\?|&)check=[^&]*~', '$1', $url);
			echo "<script>window.location.replace('".esc_url($url)."')</script>";	
		}


		// Set LtkId
		// Logout = remove Token
		if($_POST['check'] && $_POST['ltkId']){
			if($_SESSION['LTK_OAUTH_CODE'] == $_POST['check']){
					LtkWp::setIdLtk(filter_var($_POST['ltkId'], FILTER_SANITIZE_NUMBER_INT));
			}
		}

		LtkWp::genOauthCheck();
		require_once('contents/cssInit.php');
		require_once('ltk-init.php');
		
	}


	/**
	 * Oauth
	 */
	function getOauthUrl(){
		
		$redir = urlencode((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]".'&check='.LtkWp::getOauthCheck());
		$url = LTKWp::$oauthUrl.'?redir='.$redir;
		return $url;
	}

	function getLogoutUrl(){
		return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]".'&logout=1&check='.LtkWp::getOauthCheck();
	}


	/**
	 * Oauth checksum
	 */
	function genOauthCheck(){
		$_SESSION['LTK_OAUTH_CODE'] = uniqid();
	}
	function getOauthCheck(){
		return $_SESSION['LTK_OAUTH_CODE'];
	}
	/**
	 * Oauth Token
	 */
	function createLtkToken(){
		//Cria na table Options do wordpress o campo LTK_ID com valor vazio caso nao tenha ainda
		if(LtkWp::getLtkToken() == '')
			add_option('LTK_OAUTH_TOKEN');
	}
	function setLtkToken($token){
		update_option('LTK_OAUTH_TOKEN', $token);
	}
	function deleteLtkToken(){
			delete_option('LTK_OAUTH_TOKEN');
	}
	function getLtkToken(){
		return get_option('LTK_OAUTH_TOKEN'); 
	}


	function isLogged(){
		return true ? LtkWp::getLtkToken()!='' : false;
	}

	/**
	 * Get Account list with Oauth TOken
	 */
	function getAccList(){
		$token = LtkWp::getLtkToken();
		if(!$token) return Array();

		$options = array(
			'http' => array(
				'header'  => "Authorization: bearer $token\r\n".
					"Content-type: application/json\r\n",
				'method'  => 'POST'
			)
		);
		$context  = stream_context_create($options);
		$result = file_get_contents(LtkWp::$oauthInfoUrl, false, $context);
		if ($result === FALSE) { /* Handle error */ }

		$data = json_decode($result, true);
		return $data['accs']['enumNames'];


	}
	
	
	
	
	//Manipular dados

	function base62($num, $b=62) {
		$base='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$r = $num  % $b ;
		$res = $base[$r];
		$q = floor($num/$b);
		while ($q) {
		  $r = $q % $b;
		  $q =floor($q/$b);
		  $res = $base[$r].$res;
		}
		return $res;
	}
	
	
	/**
	 * Cria ID Leadtracker
	 */
	function createIdLtk(){
	 //Cria na table Options do wordpress o campo LTK_ID com valor vazio caso nao tenha ainda
	  if(LtkWp::getIdLtk() == '')
	     add_option('LTK_ID');
	}
	function deleteIdLtk(){
		delete_option('LTK_ID');

	}
	function getIdLtk(){
		return get_option('LTK_ID'); 
	 }
	function setIdLtk($id){
	   return update_option('LTK_ID',$id);
	}
	


	
	//Impressões
	
	
	
	/**
	 * Imprime Tag Js Leadtracker
	 */
	function echoLeadtracker() { 
	    
	   if(LtkWp::getIdLtk() != '')
			echo '<!-- Lead Tracker - Wordpress Plugin -->'."\n".
			'<script>'."\n".
			'(function(l,d,t,r,c,k){'."\n".
			'if(!l.lt){l.lt=l.lt||{_c:[]};'."\n".
			'c=d.getElementsByTagName(\'head\')[0];'."\n".
			'k=d.createElement(\'script\');k.async=1;'."\n".
			'k.src=t;c.appendChild(k);}'."\n".
			'l.ltq = l.ltq || function(k,v){l.lt._c.push([k,v])};'."\n".
			''."\n".
			'ltq(\'init\', \''.esc_html(LtkWp::base62(LtkWp::getIdLtk())).'-0\')'."\n".
			'})(window,document,\'//tag.ltrck.com.br/lt'.esc_html(LtkWp::getIdLtk()).'.js?wp=1\');'."\n".
			'</script>'."\n".
			'<!-- End Lead Tracker -->';
	
	}
	
	/**
	 * Aviso que o site ainda não está sendo analisado, pois falta cadastrar o ID
	 */
	function echoMsgNotId(){	
	    echo '<div id="ltkMsgAdmNotId" class="updated fade">
	           <p>Falta pouco para completar a sua instalação! <a href="admin.php?page=ltk-admin">Conecte sua conta</a> para que as visitas de seu site comecem a ser analisadas.</p>
	          </div>';
	
	}

//EndClass
}

?>
