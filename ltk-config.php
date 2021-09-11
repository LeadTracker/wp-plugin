<?php

require_once('lang/texts.php');

/**
 * Classe responsável por controlar o plugin
 */
class LtkWp{

	//private static $wpdb;
	private static $info;
	
	private static $ltkApiUrl = 'http://cluster.navegg.com/ws/';
	private static $ltkApiKey = '3b1eb550948434f6d049a04830188de4';
	
	
	/**
	 * Função de inicialização
	 */
	function inicializar(){
	  //Mapear objeto para manipular o banco 
	  // global $wpdb;
	  // LtkWp::$wpdb = $wpdb;
	  /** Com $wpdb você manipula o banco de dados agora ele esta referenciado em uma variavel estática da classe.
	   * Para utiliza-la agora não precisa declarar global $wpdb em todas funções, basta usar a estica da classe. 
	   * Ex.: LtkWp::$wpdb->
	   * Esta variavel não está sendo usado no momento, pois na v1.0 o id é amazenado na tablea options padrão do Wp. Para futuras versões basta descomentar a linhas que possuem $wpdb
	   */
	
	  //Mapear infos relevantes para plugin
	  LtkWp::$info['plugin_fpath']= dirname(__FILE__);
	
	
	  //Chama a função para imprimir a tag no head
	  add_action( 'wp_head', array('ltkWp','echoLeadtracker'));
	
	  //Chama a função para criar página de administração
	  add_action( 'admin_menu', array('ltkWp','createAdmLtk'));

	  //Colocar Mensagem de erro se não estiver cadastrado ID_NAVEGG
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
	}
	
	/**
	 * Função de desinstalação
	 */
	function desinstalar(){
	  //Deleta dados do banco
	   LtkWp::deleteIdLtk();  
	}
	
	
	
	//Páginas
	
	
	/**
	 * Cria página de adm
	 */
	function createAdmLtk(){
	
	 add_menu_page('Lead Tracker','Lead Tracker',10,'ltk-admin',array('LtkWp','admInit'),plugins_url( '/contents/ltklogo.svg', __FILE__ ));
	
	 /* Exmplo com submenu para outra funcionalidade...
	  add_submenu_page('ltk-admin','Leadtracker - Optimeze. Results. - Painel ','Painel','manage_options','ltk-adm-rel',array('LtkWp','admInit'));*/
	
	}
	
	/**
	 * Faz o include da pagina inicial do administrador, que é chamado quando
	 * o usuário clica no menu NAVEGG
	 */
	function admInit(){ 
	
	  //caso esteja trocando o ID
	  if( isset( $_POST['idLtk']) ){
	
		//verifica se é um numerico
		if(LtkWp::idIsNum($_POST['idLtk'])){            
	
			//verifica se id é diferente do que ja estava cadastrado ou default
			if(!LtkWp::idIsDiference($_POST['idLtk'])){
			     $msgPost['class'] = 'updtFail';    
			     $msgPost['msg'] = getTextLtk('ltkMsgAdmIdAlt_4');
			}
			else //atualiza o id navegg
			     try{
				     	$uptStatus =LtkWp::setIdLtk(str_replace(" ","",$_POST['idLtk']));           			     
			        	if($uptStatus){           
						//perdeu o retorno do WS (caso tinha cadastrado antes)
						LtkWp::deleteAutoInLtk();
			        		$msgPost['class'] = 'updtSucess';
				     	  	$msgPost['msg'] = getTextLtk('ltkMsgAdmIdAlt_1');
			       		}else
			     			throw new Exception($uptStatus);		
	
			     }catch (Exception $e) {
			     	$msgPost['class'] = 'updtFail';    
			       	$msgPost['msg'] = getTextLtk('ltkMsgAdmIdAlt_3');
			     }
	        }else{
	           $msgPost['class'] = 'updtFail';    
		   $msgPost['msg'] = getTextLtk('ltkMsgAdmIdAlt_2');
		}       
	
	  }else //caso esteja querendo buscar ID através do e-mail cadastrado
		if($_POST['emLtk']){
			try{
				$rep = LtkWp::apiGetId($_POST['emLtk']);				
				if($rep->{"accid"}){
					if(!LtkWp::idIsDiference(str_replace(" ","",$rep->{"accid"}))){
        	            $msgPost['class'] = 'updtFail';
	                    $msgPost['msg'] = getTextLtk('ltkMsgAdmIdAlt_4');
                	}else{
                        $rep->{"accid"} = array_unique($rep->{"accid"});
                        if(count($rep->{"accid"}) > 1){
        	                $msgPost['class'] = 'updtFail';
	                        $msgPost['msg'] = getTextLtk('ltkMsgAdmIdAlt_5');
                            foreach($rep->{"accid"} as $id){
	                            $msgPost['msg'] .= '<br>Account ID - <strong>'.$id.'</strong>';
                            }
                        }else{
                            if(LtkWp::setIdLtk($rep->{"accid"}[0])){
					            //perdeu o retorno do WS (caso tinha cadastrado antes)
					            LtkWp::deleteAutoInLtk();
                	            $msgPost['class'] = 'updtSucess';
                	            $msgPost['msg'] = getTextLtk('ltkMsgAdmIdAlt_1');
                	        }else{
                	            throw new Exception($uptStatus); 
                            }
                        }
                    }
				}else{
                    if(empty($rep))
                        	throw new Exception(getTextLtk('ltkMsgAdmInitError_6'));
                        else
					    	throw new Exception("err");
                }

			}catch (Exception $e) {
		 	   $msgPost['class'] = 'updtFail';
	                   $msgPost['msg'] = getTextLtk('ltkMsgAdmInitError_2');			
			}			
		//endIfGetIdByEmail
		}else
			if($_POST['newLtk']){
				try{
					$name     = addslashes($_POST['nmLtk']);
					$email    = addslashes($_POST['nemLtk']);
					$siteName = addslashes($_POST['stLtk']);
					$siteUrl  = addslashes($_POST['urLtk']);
					if(empty($name) || empty($email)) throw new Exception("empty");
					
					$rep = LtkWp::apiNewAcc($name,$email,$siteName,$siteUrl);

					if(!@$rep->{"error"}){

                        if(!LtkWp::idIsDiference(str_replace(" ","",$rep->{"acc_id"}))){

                        	throw new Exception('dupli');

                        }else if(LtkWp::setIdLtk(str_replace(" ","",$rep->{"acc_id"}),str_replace(" ","",$rep->{"usr_acess_key"}) )){

                               $msgPost['class'] = 'updtSucess';
                               $msgPost['msg'] = getTextLtk('ltkMsgAdmIdAlt_1');

                        }else{

                           throw new Exception('err');
                        }

					}else{
                        if(empty($rep))
                            throw new Exception("wsnull");
						else
    	                    throw new Exception("err");
					}

				}catch (Exception $e) {
                    $msgs['err']     = getTextLtk('ltkMsgAdmInitError_7');
                    $msgs['empty']   = getTextLtk('ltkMsgAdmInitError_8');
                    $msgs['dupli']	 = getTextLtk('ltkMsgAdmIdAlt_4');
                    $msgs['wsnull']  = getTextLtk('ltkMsgAdmInitError_6');

                    $msgPost['class'] = 'updtFail';
                    $msgPost['msg'] = $msgs[$e->getMessage()];
                }

			}//endIfNewLtk
			
		
		


	
	  require_once('contents/cssInit.php');
	  require_once('ltk-init.php');
	
	}
	
	
	/**
	 * Verifica se o ID digitado é um número e retirando os espaços em branco
	 **/
	function idIsNum($id){
	   if(is_numeric(str_replace(" ","",$id)))
	   	return true;
	   else
	   	return false;
	}
	
	
	/**
	 * Verifica se o ID que esta tentando salvar é diferente do que esta salvo
	 **/
	function idIsDiference($id){
	   if($id == LtkWp::getIdLtk())
	      return false;
	   else
	      return true;
	}
	
	
	/**
	 * Exemplo de como ficaria com submenu para outra funcionalidade
	 *
	 */
	/*
	function admPainel(){
	 echo 'Implementar um painel navegg para Wp';
	}
	*/
	
	
	
	
	
	//Manipular dados
	
	
	/**
	 * Cria ID Leadtracker
	 */
	function createIdLtk(){
	 //Cria na table Options do wordpress o campo ID_NAVEGG com valor vazio caso nao tenha ainda
	  if(LtkWp::getIdLtk() == '')
	     add_option('ID_NAVEGG');
	}
	
	/**
	 * Deleta ID Leadtracker
	 */
	function deleteIdLtk(){
	     delete_option('ID_NAVEGG');
	     LtkWp::deleteAutoInLtk();
	}
	
	/** 
	 * Pega ID Leadtracker
	 */
	function getIdLtk(){
	   return get_option('ID_NAVEGG'); 
	}
	
	/**
	 * Atualiza ID Naveg
	*/
	function setIdLtk($id, $autoIn = NULL){
	   if(!empty($autoIn)) LtkWp::setAutoInLtk($autoIn);

	   if(update_option('ID_NAVEGG',$id))
	      return true;
	   else
	      return false;
	}
	

	/**
	  * Manipular autologin
          */
	function createAutoInLtk(){
		if(LtkWp::getAutoInLtk() == '')
			add_option('AUTOIN_NAVEGG');
	}
	function deleteAutoInLtk(){
		if(LtkWp::getAutoInLtk() != '')
			delete_option('AUTOIN_NAVEGG');
	}
	function getAutoInLtk(){
		return get_option('AUTOIN_NAVEGG');
	} 
        function setAutoInLtk($key){
		LtkWp::createAutoInLtk();
           	update_option('AUTOIN_NAVEGG',$key);
        }

	
	//Impressões
	
	
	
	/**
	 * Imprime Tag Js Leadtracker
	 */
	function echoLeadtracker() { 
	    
	   if(LtkWp::getIdLtk() != '')
			echo '<!-- Lead Tracker -->'."\n".
			'<script>'."\n".
			'(function(l,d,t,r,c,k){'."\n".
			'if(!l.lt){l.lt=l.lt||{_c:[]};'."\n".
			'c=d.getElementsByTagName(\'head\')[0];'."\n".
			'k=d.createElement(\'script\');k.async=1;'."\n".
			'k.src=t;c.appendChild(k);}'."\n".
			'l.ltq = l.ltq || function(k,v){l.lt._c.push([k,v])};'."\n".
			''."\n".
			'ltq(\'init\', \'1-1\')'."\n".
			'})(window,document,\'//tag.ltrck.com.br/lt1.js\');'."\n".
			'</script>'."\n".
			'<!-- End Lead Tracker -->';

	        #echo '<script id="navegg" type="text/javascript" src="//tag.ltrck.com.br/lt'.LtkWp::getIdLtk().'.js"></script>'."\n";
	
	}
	
	/**
	 * Aviso que o site ainda não está sendo analisado, pois falta cadastrar o ID
	 */
	function echoMsgNotId(){	
	    echo '<div id="ltkMsgAdmNotId" class="updated fade">
	           <p>Falta pouco para completar a sua instalação! <a href="admin.php?page=ltk-admin">Conecte sua conta</a> para que as visitas de seu site comecem a ser analisadas.</p>
	          </div>';
	
	}
	
	

	// Webservice
	
	
	/**
	 * GET ID Leadtracker by e-mail
	 */
    function apiGetId($email){
        $url = LtkWp::$ltkApiUrl;
        $url .= '?action=partneruseremail';
        $url .= '&part_key='.LtkWp::$ltkApiKey;
        $url .= '&email='.urlencode($email);
        $content = file_get_contents( $url );
        return json_decode($content);

    }


    /**
     * New Account
     */
    function apiNewAcc($name,$email,$siteName,$siteUrl){

        $postdata = http_build_query(
        array(
            'action' => 'partneraccount',
            'usr_name' => $name,
            'usr_email' => $email,
            'usr_site_name' => $siteName,
            'usr_domain' => $siteUrl,
            'part_key' => LtkWp::$ltkApiKey
        )
        );

        $opts = array('http' =>array('method'  => 'POST','content' => $postdata));
        $context = stream_context_create($opts);
        $content = file_get_contents(LtkWp::$ltkApiUrl, 0, $context);

        return json_decode($content);
    }

//EndClass
}

?>
