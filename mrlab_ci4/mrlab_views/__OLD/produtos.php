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
			<div class="row justify-content-center mb-2">
				<div class="col-12 col-md-12">
					<h2><strong>Produtos</strong></h2>
				</div>
			</div>
			<div class="row justify-content-start">
				<?php 
				if( isset($list_produtos) ){
					foreach ($list_produtos->getResult() as $row) {
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
	</div>



<?php
	$this->endSection('content'); 
?>

<?php $time = time(); ?>
<?php $this->section('headers'); ?>

	<style>
	</style>

<?php $this->endSection('headers'); ?>

<?php $this->section('scripts'); ?>

	<script>
	</script>

<?php $this->endSection('scripts'); ?>