<?php $time = time(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<base href="<?php echo(base_url()); ?>/" />
	<title>Amancio Agasalhos</title>
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta charset="utf-8" />

	<meta property="og:locale" content="en_US" />
	<meta property="og:type" content="article" />
	<meta property="og:title" content="" />
	<meta property="og:url" content="" />
	<meta property="og:site_name" content="" />

	<link rel="canonical" href="<?php echo(current_url()); ?>" />
	<link rel="shortcut icon" href="assets/media/fav-icon.png" />
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

	<link href="assets/css/style_front.css" rel="stylesheet" type="text/css" />

	<?php $this->renderSection('headers'); ?>
</head>
<body>
	<?php
		$session_id = (isset($session_id) ? $session_id : '');
		$session_user_id = (int)(isset($session_user_id) ? $session_user_id : ''); 
		$session_user_nome =(isset($session_user_nome) ? $session_user_nome : ''); 
		$session_user_acesso = (isset($session_user_acesso) ? $session_user_acesso : '');
		$session_user_avatar = (isset($session_user_avatar) ? $session_user_avatar : '');
		$session_user_acesso_label = (isset($session_user_acesso_label) ? $session_user_acesso_label : '');
	?>
	<header>
		<div class="container-fluid">

			<div class="row justify-content-center align-items-center">
				<div class="col-9 col-md-3 text-center text-md-start">
					<a href="<?php echo(site_url()); ?>"><img src="assets/media/logotipo.png" class="img-fluid mb-2 mb-md-0" style="height: 60px;" /></a>
				</div>
				<div class="col-3 col-md-auto text-center text-md-start">
					<nav class="navbar navbar-expand-lg navbar-light justify-content-end justify-content-md-center">
						<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
							<span class="navbar-toggler-icon"></span>
						</button>
					</nav>
				</div>
				<div class="col-12 col-md-8">
					<div class="row justify-content-center align-items-center">
						<div class="col-12 col-md-4">
							<div class="">
								<input type="text" class="form-control" id="exampleFormControlInput1" placeholder="O que você procura?">
							</div>
						</div>
						<div class="col-12 col-md-8">
							<div class="d-flex justify-content-end mt-3 mt-md-0 option-header">
								<div class="d-flex align-items-center opt-item">
									
									<div style="font-size: 1rem; font-weight: bold; line-height: 1; text-align: end;">
										<?php if( session()->get('isLoggedIn') === TRUE ){ ?>
											<div><?php print( session()->get('cad_nome') ); ?></div>
											<div><a href="<?php echo(site_url('perfil/logout')); ?>">Sair</a></div>
										<?php }else{ ?>
											<div><a href="<?php echo(site_url('perfil')); ?>">Entrar</a></div>
										<?php } ?>
									</div>
									<div>
										<a style="margin-left: 10px;" href="<?php echo(site_url('perfil')); ?>"><img src="assets/media/icons/user.png" class="img-fluid" style="height: 32px;" /></a>
									</div>
								</div>
								<div class="opt-item"><a href="<?php echo(site_url()); ?>"><img src="assets/media/icons/favorito.png" class="img-fluid" style="height: 32px;" /></a></div>
								<div class="opt-item" style="position: relative;">
									<a href="<?php echo(site_url('carrinho')); ?>">
									<img src="assets/media/icons/shopping-cart.png" class="img-fluid" style="height: 32px;" />
									<div class="cart_qtd_itens">
										<?php echo($rs_count_cart); ?>
									</div></a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row justify-content-center">
				<div class="col-12">
					<hr style="margin: 8px; color: #48c4cc;">
				</div>
			</div>
			<div class="row justify-content-center">
				<div class="col-12 text-center">
					<div style="padding:3px 0;">
						<nav class="navbar navbar-expand-lg navbar-light justify-content-end justify-content-md-center">
							<div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
								<ul class="navbar-nav justify-content-center">
									<?php 
									if( isset($rs_categ) ){
										foreach ($rs_categ->getResult() as $row) {
											$categ_id = ($row->categ_id);
											$categ_titulo = ($row->categ_titulo);
											$link_categ = site_url('produtos/categ/'. $categ_id);
									?>
									<li class="nav-item">
										<a class="nav-link" href="<?php echo($link_categ); ?>"><?php echo($categ_titulo); ?></a>
									</li>
									<?php 
										}
									}
									?>
								</ul>
							</div>
						</nav>
					</div>
				</div>
			</div>

		</div>
	</header>
	<main>
		<?php
			//print_r( session()->get('cad_id') );
			//print_r( session()->get('cad_nome') );
			//print_r( session()->get('cad_email') );
			//print_r( session()->get('session_type') );
			//print_r( '['. $rs_count_cart .']' );
		?>
		<div class="page-content">
			<div class="container-fluid">
				<?php 
					// conteúdo principal
					$this->renderSection('content');
				?>
			</div>
		</div>
	</main>
	<footer class="pt-4 pb-4">
		<div class="container-fluid">

			<div class="row justify-content-center align-items-center">
				<div class="col-12 col-md-4 text-center">
					<div class="pb-3">
						<a href="<?php echo(site_url()); ?>"><img src="assets/media/logotipo-fig.png" class="img-fluid" style="height: 60px;" /></a>
					</div>
					<div><strong>lucas999949860@gmail.com</strong></div>
					<div><strong>+55 54 99149-7203</strong></div>
					<div>todos os direitos reservados</div>
				</div>
			</div>

		</div>
	</footer>

	<script src="assets/js/app_plugins.js"></script>

	<script>
	let SITE_URL = '<?php echo(site_url()); ?>/';	

	$(document).ready(function () {
	});
	</script>

	<?php $this->renderSection('scripts'); ?>

</body>
</html>