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
					<h2><strong>Carrinho</strong></h2>
				</div>
			</div>

			<?php 
			if( isset($rs_carrinho) ){ 
			?>
			<div class="shopping-cart mt-5">
				<div class="row justify-content-start">
					<div class="col-12 col-md-8">

						<table class="cart-table">
							<thead>
								<tr>
									<th>Produto</th>
									<th class="text-center">Valor</th>
									<th class="text-center">Quantidade</th>
									<th>Subtotal</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$subTotalResumo = 0;
								foreach ($rs_carrinho->getResult() as $row) {
									$prod_id = (int)$row->prod_id;
									$prod_urlpage = $row->prod_urlpage;
									$prod_titulo = $row->prod_titulo;
									$prod_valor = $row->prod_valor;
									$prod_arquivo = $row->prod_arquivo;
									$cart_hashkey = $row->cart_hashkey;
									$cart_quant = (int)$row->cart_quant;

									$subtotal = ($prod_valor * $cart_quant);

									$subTotalResumo = $subTotalResumo + $subtotal;

									$photo = $folder_upload .'produtos/'. $prod_arquivo;  
									$link_produto = site_url('produto/'. $prod_id .'/'. $prod_urlpage);

									$link_delete = site_url('carrinho/delete/'. $cart_hashkey);
								?>
								<tr>
									<td>
										<div class="d-flex align-items-center">
											<div>
												<div class="card-body" style="position: relative; height: 80px; width: 80px; background-image: url('<?php echo($photo); ?>'); background-size: cover; background-position: center;">
												</div>
											</div>
											<div style="margin-left: 30px;">
												<h4><?php echo($prod_titulo); ?></h4>
											</div>
										</div>
									</td>
									<td class="text-center">
										<span class="shopping-cart__product-price">R$ <?php echo($prod_valor); ?></span>
									</td>
									<td class="text-center">
										<span class="shopping-cart__product-price"><?php echo($cart_quant); ?></span>
										<div class="product-single__addtocart cart d-none">
											<div class="qty-control position-relative">
												<input type="number" name="quantity" value="<?php echo($cart_quant); ?>" min="1" class="qty-control__number text-center">
												<div class="qty-control__reduce">-</div>
												<div class="qty-control__increase">+</div>
											</div><!-- .qty-control -->
										</div>
									</td>
									<td>
										<span class="shopping-cart__subtotal">R$ <?php echo($subtotal); ?></span>
									</td>
									<td>
										<a href="<?php echo($link_delete); ?>" class="remove-cart">
											<svg width="10" height="10" viewBox="0 0 10 10" fill="#767676" xmlns="http://www.w3.org/2000/svg">
											<path d="M0.259435 8.85506L9.11449 0L10 0.885506L1.14494 9.74056L0.259435 8.85506Z"></path>
											<path d="M0.885506 0.0889838L9.74057 8.94404L8.85506 9.82955L0 0.97449L0.885506 0.0889838Z"></path>
											</svg>
										</a>
									</td>
								</tr>
								<?php 
								}
								?>
							</tbody>
						</table>
					</div>
					<div class="col-12 col-md-4">
						
						<?php 
						$attr_form = ['class' => '', 'id' => 'formCartCheckout', 'name' => 'formCartCheckout', 'csrf_id' => 'secucity' ];
						echo form_open( current_url(), $attr_form ); ?>
						<?php echo( csrf_field() ) ?>
							<div class="cart-resumo">
								<h3>Resumo do carrinho</h3>
								<div class="shopping-cart__totals">
									<table class="cart-totals">
										<tbody>
											<tr>
												<th>Subtotal</th>
												<td>R$ <?php echo($subTotalResumo); ?></td>
											</tr>
											<tr>
												<th>Forma de Envio</th>
												<td>
													<div class="form-check">
														<input class="form-check-input form-check-input_fill" type="radio" name="tipo_envio" value="frete_gratis" id="frete_gratis">
														<label class="form-check-label" for="frete_gratis">Frete Grátis</label>
													</div>
													<div class="form-check">
														<input class="form-check-input form-check-input_fill" type="radio" name="tipo_envio" value="frete_fixo" id="frete_fixo">
														<label class="form-check-label" for="frete_fixo">Frete Fixo: R$ 49,00</label>
													</div>
													<div class="form-check">
														<input class="form-check-input form-check-input_fill" type="radio" name="tipo_envio" value="retirada_local" id="retirada_local">
														<label class="form-check-label" for="retirada_local">Retirada no Local: R$ 8,00</label>
													</div>
												</td>
											</tr>
											<tr>
												<th>Total</th>
												<td>R$ <?php echo($subTotalResumo); ?></td>
											</tr>
										</tbody>
									</table>

									<div class="d-grid mt-4">
										<button class="btn btn-primary">PROSSEGUIR PARA CHECKOUT</button>
									</div>	
								</div>
							</div>
						<?php echo form_close(); ?>

					</div>
				</div>
			</div>
			<?php 
			}else{
			?>
				<div class="row justify-content-center">
					<div class="col-12 col-md-12">
						<h3>Não há produtos no carrinho</h3>
					</div>
				</div>
			<?php 
			} 
			?>

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