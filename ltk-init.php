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
				<p></p><p></p><p></p>
				
		
				
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
				   	<span>Configurações</span>
				   	<div class="status <?php  echo LtkWp::getIdLtk() != ''?'on':'off'; ?>">
				   	   <span></span>
					   <?php  echo LtkWp::getIdLtk() != '' ? 'ativo' : 'inativo' ; ?>
					   (Acc: <?php  echo LtkWp::getIdLtk(); ?>)
		        </div>
				   </h2>
           
	   <div class="inside">
					
				<?php 
				//getInfo User
				global 	$current_user; 
				wp_get_current_user();

				if(!LtkWp::isLogged()) {
				?>
				<div class="login">
					<h4>
						<b>Logue com a sua conta:</b>
					</h4>
					<div class="btn" onCLick="LtkWpOpenLoginPopup()">
						<img src="<?php echo plugins_url( 'contents/ltk-login.png', __FILE__ ); ?>" />
						<span>Entrar</span>
					</div>

					<a class="know" target="_blank" href="https://leadtracker.com.br?utm_content=plugin_wordpress">Não possui uma conta? Conheça o Lead Tracker</a>
				</div>
				<?php
				} else {
				?>

				<form method="post" action=""> 
					<input type="hidden" name="check" value="<?php echo  esc_attr(LtkWp::getOauthCheck());?>" />
					<h4><b>Logue com a sua conta:</b></h4>
					<p>Selecione qual pixel você deseja instalar.</p>
					<?php
						$accs = LtkWp::getAccList();
						$ltkId =  LtkWp::getIdLtk();
						
							
					?>
					<select name="ltkId">
						<?php
						foreach($accs as $k=>$v){ ?>
						<option <?php if($k==$ltkId) echo 'selected'; ?>  value="<?php echo  esc_attr($k);?>"><?php echo $v;?></option>
						<?php } ?>
					</select>

					<button class="button" title="Salvar">Salvar</button>
			        	
				</form>
				<a class="logout" href="<?php echo  esc_url( LtkWp::getLogoutUrl());?>">Deslogar</a>

				<?php } ?>

				
				


		<div class="clearme"></div>

            </div>
          </div>
        </div>
      </div>

      <div class="postbox-container" style="width:99%;">
        <div class="meta-box-sortables ui-sortable">
          <div class="postbox pn_ltk">
           <h2 class="hndle"><span>Relatórios</span></h2>

	   		<div class="inside analytics-dash clearfix">
					<a href="https://painel.leadtracker.com.br/" target="_blank" class="dash">
		   			<img src="<?php echo plugins_url( 'contents/dashboard.png', __FILE__ ); ?>">
		   		</a>

					<div class="texto">						
						<h3>Leadtracker </h3>
						<p>
							<a href="<?php echo esc_url($pnUrl); ?>" target="_blank">
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

function LtkWpOpenLoginPopup(){
	let url = '<?php echo esc_url( LtkWp::getOauthUrl());?>';

	let popup = window.open(url, 'popup', "width=410, height=610, resizable=false, scrollbars=no")

	var popupTimer = setInterval(function() { 
		if(popup.closed) {
			clearInterval(popupTimer);
			window.location.reload(true);
		}
	}, 1000);
}

</script>

