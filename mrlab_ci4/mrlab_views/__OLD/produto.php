<?php 
	$this->extend('templates/template_default');
	$this->section('content'); 

	$session_id = (isset($session_id) ? $session_id : '');
	$session_user_id = (int)(isset($session_user_id) ? $session_user_id : ''); 
	$session_user_nome = (isset($session_user_nome) ? $session_user_nome : ''); 
	$session_user_acesso = (isset($session_user_acesso) ? $session_user_acesso : ''); 
	$session_user_acesso_label = (isset($session_user_acesso_label) ? $session_user_acesso_label : '');

	$prod_id = (isset($rs_produto->prod_id) ? (int)$rs_produto->prod_id : ''); 
	$prod_urlpage = (isset($rs_produto->prod_urlpage) ? $rs_produto->prod_urlpage : ''); 
	$prod_titulo = (isset($rs_produto->prod_titulo) ? $rs_produto->prod_titulo : ''); 
	$prod_resumo = (isset($rs_produto->prod_resumo) ? $rs_produto->prod_resumo : '');
	$prod_descricao = (isset($rs_produto->prod_descricao) ? nl2br($rs_produto->prod_descricao) : '');
	$prod_info_adicional = (isset($rs_produto->prod_info_adicional) ? nl2br($rs_produto->prod_info_adicional) : '');
	$prod_valor = (isset($rs_produto->prod_valor) ? $rs_produto->prod_valor : '');
	$prod_arquivo = (isset($rs_produto->prod_arquivo) ? $rs_produto->prod_arquivo : '');
	$photo = $folder_upload .'produtos/'. $prod_arquivo;  

	$link_add_cart = site_url('carrinho/add/'. $prod_id .'/'. $prod_urlpage)
?>

	<div id="app">
		<section class="mt-4 mb-4">
			<div class="row justify-content-around">
				<div class="col-12 col-md-7">

					<div class="card card-produtos" style="height: 460px;">
						<div style="padding: 20px; height: 100%; background-image:url('<?php echo($photo); ?>'); background-size: cover; background-position: center;">
<!-- 							<div class="infos-fixed"> -->
<!-- 								<h2><?php echo($prod_titulo); ?></h2> -->
<!-- 								<h3>ESQUENTA</h3> -->
<!-- 							</div> -->
						</div>
					</div>

				</div>
				<div class="col-12 col-md-5">
					<div class="pb-0"><h2><?php echo($prod_titulo); ?></h2></div>
					<div class="pb-3"><h4>Marca: Adidas</h4></div>

					<div class="pt-3 pb-2"><h2>R$ <?php echo($prod_valor); ?></h2></div>

					<div class="product-single__short-desc pb-2">
						<p><?php echo($prod_resumo); ?></p>
					</div>

					<form name="addtocart-form" method="post" action="<?php echo($link_add_cart); ?>">
						<div class="product-single__addtocart mb-4">
							<div class="qty-control position-relative">
								<input type="number" name="quantidade" id="quantidade" value="1" min="1" class="qty-control__number text-center">
								<div class="qty-control__reduce">-</div>
								<div class="qty-control__increase">+</div>
							</div><!-- .qty-control -->
							<button type="submit" class="btn btn-primary btn-addtocart js-open-aside">Adicionar ao Carrinho</button>
						</div>
					</form>

					<div class="product-single__meta-info">
						<div class="meta-item">
							<label>SKU:</label>
							<span>N/A</span>
						</div>
						<div class="meta-item">
							<label>Categories:</label>
							<span>Casual &amp; Urban Wear, Jackets, Men</span>
						</div>
						<div class="meta-item">
							<label>Tags:</label>
							<span>biker, black, bomber, leather</span>
						</div>
					</div>

				</div>
			</div>
		</section>


		<section class="mt-5 mb-4">
			<div class="row justify-content-center">
				<div class="col-12 col-md-12">

					<!-- Nav tabs -->
					<ul class="nav nav-tabs justify-content-center" role="tablist">
						<li class="nav-item">
							<a class="nav-link nav-link_underscore active" data-bs-toggle="tab" href="#tb-descricao" role="tab" aria-selected="true">Descrição</a>
						</li>
						<li class="nav-item">
							<a class="nav-link nav-link_underscore" data-bs-toggle="tab" href="#tb-informacoes" role="tab" aria-selected="false">Informações Adicionais</a>
						</li>
					</ul>

					<!-- Tab panes -->
					<div class="tab-content">
						<div class="tab-pane pt-3 pb-3 active" id="tb-descricao" role="tabpanel">

							<div class="product-single__description">
								<p class="content"><?php echo($prod_descricao); ?></p>
							</div>

						</div>
						<div class="tab-pane pt-3 pb-3" id="tb-informacoes" role="tabpanel">

							<div class="product-single__description">
								<p class="content"><?php echo($prod_info_adicional); ?></p>
							</div>

						</div>
					</div>

				</div>
			</div>
		</section>


		<section class="mt-5 mb-4">
			<div class="row justify-content-center mb-2">
				<div class="col-12 col-md-12">
					<h2><strong>Produtos</strong> Relacionados</h2>
				</div>
			</div>
			<div class="row justify-content-start">
				<?php
				if( isset($rs_prod_relacionados) ){
					foreach ($rs_prod_relacionados->getResult() as $row) {
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

	$cliente_id = ( isset($cliente_id) ? $cliente_id : 0);
?>

<?php $time = time(); ?>
<?php $this->section('headers'); ?>

	<style>
	</style>

<?php $this->endSection('headers'); ?>

<?php $this->section('scripts'); ?>

	<script>
		function QtyControl () {
		  document.querySelectorAll('.qty-control').forEach(function($qty) {
			if ($qty.classList.contains('qty-initialized')) {
			  return;
			}

			$qty.classList.add('qty-initialized');
			const $reduce = $qty.querySelector('.qty-control__reduce');
			const $increase = $qty.querySelector('.qty-control__increase');
			const $number = $qty.querySelector('.qty-control__number');

			$reduce.addEventListener('click', function() {
			  $number.value = parseInt($number.value) > 1 ? parseInt($number.value) - 1 : parseInt($number.value);
			});

			$increase.addEventListener('click', function() {
			  $number.value = parseInt($number.value) + 1;
			});
		  });
		}
		QtyControl();
	</script>

<?php $this->endSection('scripts'); ?>