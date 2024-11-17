<?php 
	$this->extend('templates/template_default');
	$this->section('content'); 

	$session_id = (isset($session_id) ? $session_id : '');
	$session_user_id = (int)(isset($session_user_id) ? $session_user_id : ''); 
	$session_user_nome =(isset($session_user_nome) ? $session_user_nome : ''); 
	$session_user_acesso = (isset($session_user_acesso) ? $session_user_acesso : ''); 
	$session_user_acesso_label = (isset($session_user_acesso_label) ? $session_user_acesso_label : '');
?>

	<div id="app">
		<section class="mt-4 mb-4">
			<div class="row justify-content-around">
				<div class="col-12 col-md-8">
					<?php
					if( isset($rs_destaque) ){
						$prod_id = ($rs_destaque->prod_id);
						$prod_urlpage = ($rs_destaque->prod_urlpage);
						$prod_titulo = ($rs_destaque->prod_titulo);
						$prod_valor = ($rs_destaque->prod_valor);
						$prod_arquivo = ($rs_destaque->prod_arquivo);

						$photo = $folder_upload .'produtos/'. $prod_arquivo;  
						$link_produto = site_url('produto/'. $prod_id .'/'. $prod_urlpage);
					?>
					<a href="<?php echo($link_produto); ?>"><div class="card card-produtos" style="height: 550px;">
						<div style="padding: 40px; height: 100%; background-image:url('<?php echo($photo); ?>'); background-size: cover;">
							<div class="row align-items-end h-100">
								<div class="col-12 col-md-9">
									<h2 style="font-size: 3rem; font-weight: bold;"><?php echo($prod_titulo); ?></h2>
									<h3>DESTAQUE</h3>
								</div>
							</div>
						</div>
					</div></a>
					<?php 
					}
					?>
				</div>
				<div class="col-12 col-md-4">
					
					<div class="d-flex flex-column h-100 justify-content-between">
						<?php
						if( isset($rs_destaque_lateral) ){
							foreach ($rs_destaque_lateral->getResult() as $row) {
								$prod_id = ($row->prod_id);
								$prod_urlpage = ($row->prod_urlpage);
								$prod_titulo = ($row->prod_titulo);
								$prod_valor = ($row->prod_valor);
								$prod_arquivo = ($row->prod_arquivo);

								$photo = $folder_upload .'produtos/'. $prod_arquivo;  
								$link_produto = site_url('produto/'. $prod_id .'/'. $prod_urlpage);
						?>
						<a href="<?php echo($link_produto); ?>"><div class="card card-produtos" style="height: 260px;">
							<div style="padding: 20px; height: 100%; background-image:url('<?php echo($photo); ?>'); background-size: cover;">
								<div class="infos-fixed">
									<h2><?php echo($prod_titulo); ?></h2>
									<h3>ESQUENTA</h3>
								</div>
							</div>
						</div></a>
						<?php 
							}
						}
						?>
					</div>

				</div>
			</div>
		</section>


		<section class="mt-5 mb-4">
			<div class="row justify-content-around">
				<div class="col-12 col-md-12">
					<h2>Acabou de chegar</h2>
				</div>
			</div>
			<div class="row justify-content-around">
				<?php
				if( isset($list_acabou_chegar) ){
					foreach ($list_acabou_chegar->getResult() as $row) {
						$prod_id = ($row->prod_id);
						$prod_urlpage = ($row->prod_urlpage);
						$prod_titulo = ($row->prod_titulo);
						$prod_valor = ($row->prod_valor);
						$prod_arquivo = ($row->prod_arquivo);

						$photo = $folder_upload .'produtos/'. $prod_arquivo;  
						$link_produto = site_url('produto/'. $prod_id .'/'. $prod_urlpage);
				?>
				<div class="col-12 col-md-3 pb-4">
					<div class="card card-prod-list mb-4">
						<a href="<?php echo($link_produto); ?>"><div class="card-body" style="position: relative; height:225px; background-image: url('<?php echo($photo); ?>'); background-size: cover; background-position: center;">
							<button class="pc__atc btn anim_appear-bottom btn position-absolute border-0 text-uppercase fw-medium js-add-cart js-open-aside" data-aside="cartDrawer" title="Add To Cart">Add To Cart</button>
						</div></a>
						<div class="card-footer">
							<h4 class="title"><?php echo($prod_titulo); ?></h4>
							<h4 class="price"><?php echo($prod_valor); ?></h4>
						</div>
					</div>
				</div>
				<?php 
					}
				}
				?>
			</div>
		</section>


		<section class="mt-5 mb-4">
			<div class="row justify-content-around">
				<div class="col-12 col-md-12">
					<div class="card card-produtos" style="height: 550px;">
						<div style="padding: 40px; height: 100%; background-image:url('assets/media/banners/banner-02.jpg');">
							<div class="row align-items-center h-100">
								<div class="col-12 col-md-9">
									<h2 style="font-size: 4rem; font-weight: bold;">LIQUIDAÇÃO ESTILO</h2>
									<h3>COM ÓTIMOS DESCONTOS</h3>
								</div>
							</div>
						</div><!-- <a href="<?php echo(site_url('produto')); ?>"><img src="assets/media/banners/banner-02.jpg" class="img-fluid" /></a> -->
					</div>
				</div>
			</div>
		</section>


		<section class="mt-5 mb-4">
			<div class="row justify-content-around">
				<div class="col-12 col-md-12">
					<h2>Parceiros</h2>
				</div>
			</div>
			<div class="row">
				<div class="col-12 col-md-12">
					
					<div class="card card-marcas pt-4 pb-4">
						<div class="d-flex justify-content-center">
							<div style="margin: 0 20px;"><a href="<?php echo(site_url('dashboard')); ?>"><img src="assets/media/logos/adidas.jpg" class="img-fluid" style="height: 60px;" /></a></div>
							<div style="margin: 0 20px;"><a href="<?php echo(site_url('dashboard')); ?>"><img src="assets/media/logos/nike.png" class="img-fluid" style="height: 60px;" /></a></div>
							<div style="margin: 0 20px;"><a href="<?php echo(site_url('dashboard')); ?>"><img src="assets/media/logos/puma.png" class="img-fluid" style="height: 60px;" /></a></div>
							<div style="margin: 0 20px;"><a href="<?php echo(site_url('dashboard')); ?>"><img src="assets/media/logos/kappa.png" class="img-fluid" style="height: 60px;" /></a></div>
							<div style="margin: 0 20px;"><a href="<?php echo(site_url('dashboard')); ?>"><img src="assets/media/logos/speedo.png" class="img-fluid" style="height: 60px;" /></a></div>
						</div>
					</div>

				</div>
			</div>
		</section>


		<section class="mt-5 mb-4">
			<div class="row justify-content-around">
				<div class="col-12 col-md-12">
					<h2>Conheça mais</h2>
				</div>
			</div>
			<div class="row justify-content-center">
				<?php
				if( isset($rs_conheca_mais) ){
					foreach ($rs_conheca_mais->getResult() as $row) {
						$prod_id = ($row->prod_id);
						$prod_urlpage = ($row->prod_urlpage);
						$prod_titulo = ($row->prod_titulo);
						$prod_valor = ($row->prod_valor);
						$prod_arquivo = ($row->prod_arquivo);

						$photo = $folder_upload .'produtos/'. $prod_arquivo;  
						$link_produto = site_url('produto/'. $prod_id .'/'. $prod_urlpage);
				?>
				<div class="col-12 col-md-6">
					<a href="<?php echo($link_produto); ?>"><div class="card card-produtos" style="height: 380px;">
						<div style="padding: 20px; height: 100%; background-image:url('<?php echo($photo); ?>'); background-size: cover;">
							<div class="infos-fixed">
								<h2><?php echo($prod_titulo); ?></h2>
								<h3>ESQUENTA</h3>
							</div>
						</div>
					</div></a>
				</div>
				<?php 
					}
				}
				?>
			</div>
		</section>

	</div>



<?php
	$this->endSection('content'); 

	$cliente_id = ( isset($cliente_id) ? $cliente_id : 0);
?>

<?php $time = time(); ?>
<?php $this->section('headers'); ?>

	<style>
		.list_cart{
			margin: 3px 0;
		}
		.list_cart a{
			border: 1px solid #ebeced;
			padding: 8px;
			display: block;
			border-radius: 0.25rem;
			color: #000;
		}
		.list_cart a:hover{
			background-color: #edeeef;
			color: #000;
		}
	</style>

<?php $this->endSection('headers'); ?>

<?php $this->section('scripts'); ?>

	<script>
		let LIST_PRODUTOS = [];
		let LIST_STATUS = [];
		let CLIENTE_ID = '<?php echo( $cliente_id ); ?>';
	</script>

	<!-- VueJs -->
	<script src="assets/vue/vue.min.js"></script>
	<script src="assets/vue/axios.min.js"></script>

	<script src="assets/vue/carrinho.js"></script>

<?php $this->endSection('scripts'); ?>