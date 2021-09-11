<div class="wrap">
  <div id="icon-leadtracker" class="icon32"><br>
  </div>

  <h2>Leadtracker</h2>

  <div id="dashboard-widgets-wrap">
    <div id="dashboard-widgets" class="metabox-holder">
	

<div class="col">

      <div class="postbox-container" style="width:99%;">
        <div id="normal-sortables" class="meta-box-sortables ui-sortable">
          <div id="dashboard_right_now" class="postbox sobre">

            <h2 class="hndle"><span>Sobre o Lead Tracker</span></h2>

            <div class="inside">
		
						<img src="<?php echo plugins_url( 'contents/leadtracker.png', __FILE__ ); ?>" id="logo" />

            	<h4><strong>Mensure, analise e acompanhe seus lançamentos</strong></h4><br />
				
				
               	<p>Um lead quente que compra hoje é um lead frio de outro lançamento. Chega de usar diversas páginas diferentes pra tentar mapear de onde suas vendas acontecem.</p>

				<p>Com 1 página de captura você será capaz de saber quem são as pessoas que estão se cadastrando (qual lançamento, qual origem, qual criativo e qual público) e guardar essas informações para quando acontecerem as vendas você ter acesso ao que importa:</p>
				<ul class="ul-cnt">
					<li>Consultar a jornada e o histórico de cada comprador para identificar padrões de compra;</li>
					<li>Tempo médio de compra;</li>
					<li>Qual criativo converteu mais nesse lançamento;</li>
					<li>Públicos que mais converteram; e</li>
					<li>Como cada lançamento anterior contribuiu nas vendas do lançamento atual.</li>
				</ul>
				<p></p>
				<p></p>
				
		
				
      <ul class="links ltk_lst">              
	      <h4 class="tlt">Links:</h4>           


				<li><a href="https://leadtracker.com.br/#servi%C3%A7os" target="_blank">	
					<span class="dashicons dashicons-admin-tools"></span>
					Recursos
				</a></li>
				  
				<li><a href="https://blog.leadtracker.com.br/" target="_blank">
					<span class="dashicons dashicons-laptop"></span>
					Blog
				</a></li>


				<li><a href="https://leadtracker.com.br/#planos" target="_blank">
					<span class="dashicons dashicons-admin-users"></span>
				  Planos
				</a></li>
				  
				<li><a href="https://leadtracker.com.br/contato-2/" target="_blank">
					<span class="dashicons dashicons-email-alt"></span>
					Contato
				</a></li>
      </ul>

               <div class="clearme"></div>
            </div>
          </div>
        </div>
      </div>
	
	
	<div class="clearme"></div>
</div>

<div class="col">

      <div class="postbox-container" style="width:99%;">
        <div class="meta-box-sortables ui-sortable">
          <div class="postbox id_ltk" style="max-height: 315px;">
           <h2 class="hndle">
				   	<span><?php echo getTextLtk('ltkMsgAdmInitYourId'); ?></span>
				   	<div class="status <?php  echo LtkWp::getIdLtk() != ''?'on':'off'; ?>">
				   	   <span></span>
					   <?php  echo LtkWp::getIdLtk() != '' ? getTextLtk('ltkMsgAdmInitYourId_1') : getTextLtk('ltkMsgAdmInitYourId_2') ; ?>
		        </div>
				   </h2>
           
	   <div class="inside">
					
			<?php /* <p>Verifique sua conta do Leadtracker Analytics:</p> */ ?>


				<?php 
					//getInfo User
					global 	$current_user; 
					get_currentuserinfo();
				 ?>

				<?php /* <label for="idLtk" style="display: block; float: left; width: 70px; margin-right: 8px; padding-top: 7px; text-align: right;">ID Leadtracker:</label>*/ ?>
				<form method="post" action="" onSubmit ="return validaFormId()" > 
					<h4><b>Logue com a sua conta:</b></h4>
					<p>Selecione qual pixel você deseja instalar.</p>
					<?php
						if( isset( $_POST['idLtk']) )
							$ltkId = $_POST['idLtk'];
						else if(LtkWp::getIdLtk() != ''){
							$ltkId =  LtkWp::getIdLtk();
						}
							
					?>
					<!-- <input type="text" name="idLtk" id="idLtk" value="<?php echo $ltkId; ?>" placeholder="<?php echo getTextLtk('ltkMsgAdmInitYourId_5');?>"/> -->
					<select>
						<option value="6">(6) Lead Tracker</option>
					</select>

					<button class="button" title="Salvar">Salvar</button>

			        	<?php if( isset( $_POST['idLtk']) ||  $msgPost['class'] == 'updtSucess'){ ?>
				        	<p class="<?php echo $msgPost['class']; ?>"><?php echo $msgPost['msg'];?></p>
					<?php } ?>					
				</form>

				
				<?php
					//verifição para saber se precisa opcao de criar conta ou buscar id
					 if( (!isset($msgPost['class']) &&  LtkWp::getIdLtk() == '')  || (isset($msgPost['class']) && $msgPost['class'] != 'updtSucess') ){ 
				?>

				<!-- <form method="post" action="" onSubmit ="return validaFormSearch()" <?php echo $msgPost['class'] == 'updtSucess' ? 'styledisplay:none' : ''; ?> > 

					<p>Oi</p>

					<input type="text" name="emLtk" id="emLtk" value="<?php echo isset($_POST['emLtk']) ? $_POST['emLtk'] : '';?>" style="width: 100%; max-width: 200px; background-image: none; font-size: 13px;" />
					<button class="button" title="<?php echo getTextLtk('ltkMsgAdmInitYourId_12'); ?>" >
						<?php echo getTextLtk('ltkMsgAdmInitYourId_12'); ?>
					</button>

				                    <?php if( isset( $_POST['emLtk']) ){ ?>
				                            <p style="clear:both;" class="<?php echo $msgPost['class']; ?>"><?php echo $msgPost['msg'];?></p>
						<br/>
				                    <?php } ?>


					<div class="sing-up ltk_lst" style="clear: both;">
						<?php 
							/* <li class="h">
						   		<a href="<?php echo getTextLtk('ltkMsgAdmInitYourId_8_link'); ?>"  target="_blank">
							     		<?php echo getTextLtk('ltkMsgAdmInitYourId_8'); ?>
						   		</a>
					        	</li> */ 
						?>

						<a href="javascript:void(0)" onClick="document.getElementById('containerNewAccount').style.display = 'block'" >
							<?php echo getTextLtk('ltkMsgAdmInitYourId_9'); ?> 
							<span><?php echo getTextLtk('ltkMsgAdmInitYourId_10'); ?></span>
						</a>
					</div>	

				</form>    -->

				<?php } ?>


		<div class="clearme"></div>

            </div>
          </div>
        </div>
      </div>
	 
 
  


  
	  
      <div class="postbox-container" style="width:99%;">
        <div class="meta-box-sortables ui-sortable">
          <div class="postbox pn_ltk">
           <h2 class="hndle"><span><?php echo getTextLtk('ltkMsgAdmInitPainel_3'); ?></span></h2>

	   		<div class="inside analytics-dash clearfix">
					<a href="https://painel.leadtracker.com.br/" target="_blank" class="dash">
		   			<img src="<?php echo plugins_url( 'contents/dashboard.png', __FILE__ ); ?>">
		   		</a>

					<div class="texto">						
						<h3>Leadtracker </h3>
						<p>
							<a href="<?php echo $pnUrl; ?>" target="_blank">
								Clique aqui
							</a> 
							 para acessar seus relatórios completos sobre seus lançamentos.
						</p>
					</div>

	        </div>

          </div>
        </div>
      </div>

<div class="clearme"></div>
</div>

   <div class="clear"></div>

  </div>
  
</div>
<script type="text/javascript">

function validaFormId(){

  if(document.getElementById('idLtk').value == '' ||  document.getElementById('idLtk').value == '<?php echo getTextLtk('ltkMsgAdmInitYourId_5');?>'){
	alert("<?php echo getTextLtk('ltkMsgAdmInitYourIdAlert_1'); ?>");
	return false;
  }
   return true;
}

function validaFormNew(){

	if(document.getElementById('nmLtk').value == '' ){
        	alert("<?php echo getTextLtk('ltkMsgAdmInitError_3');?>");
		document.getElementById('nmLtk').focus();		
        	return false;
	}		

	if(!validaEmail('nemLtk'))
		return false;

	return true;
}
function validaFormSearch(){
   return validaEmail('emLtk');
}

function validaEmail(id){
  if(document.getElementById(id).value == '' ){
        alert("<?php echo getTextLtk('ltkMsgAdmInitError_4');?>");
	document.getElementById(id).focus();		
        return false;
  }else
        if(!checkMail(document.getElementById(id).value)){
                alert("<?php echo getTextLtk('ltkMsgAdmInitError_5');?>");
		document.getElementById(id).focus();		
                return false;
        }
        
   return true;
}
function checkMail(mail){
	var er = new RegExp(/^[A-Za-z0-9_\-\.]+@[A-Za-z0-9_\-\.]{2,}\.[A-Za-z0-9]{2,}(\.[A-Za-z0-9])?/);
	if(typeof(mail) == "string")
		if(er.test(mail)) return true; 
	else if(typeof(mail) == "object"){
		if(er.test(mail.value))	return true;
	}else	return false;
}

</script>

