<?php $time = time(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<base href="<?php echo(base_url()); ?>/" />
	<title>Total Serviços Prediais</title>
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
	<link rel="shortcut icon" href="assets/media/favicon.png" />


	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

	<!-- <link href="assets/bootstrap/css/bootstrap.css" rel="stylesheet"> -->
	<!-- <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script> -->
	<!-- <link href="assets/line-awesome/css/line-awesome.min.css" rel="stylesheet" type="text/css" /> -->

	<link href="assets/css/reset_painel.css" rel="stylesheet" type="text/css" />
	<link href="assets/css/style_painel.css" rel="stylesheet" type="text/css" />

	<!-- choose one -->
	<script src="https://unpkg.com/feather-icons"></script>
	<script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>

	<link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/font-awesome-line-awesome/css/all.min.css">
	<link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">

	<?php $this->renderSection('headers'); ?>
</head>
<body>

	<?php
		$sessionAdmin_id = (isset($sessionAdmin_id) ? $sessionAdmin_id : '');
		$sessionAdmin_user_id = (int)(isset($sessionAdmin_user_id) ? $sessionAdmin_user_id : ''); 
		$sessionAdmin_user_nome =(isset($sessionAdmin_user_nome) ? $sessionAdmin_user_nome : ''); 
		$sessionAdmin_user_email = (int)(isset($sessionAdmin_user_email) ? $sessionAdmin_user_email : ''); 
		$sessionAdmin_user_nivel = session()->get('admin_nivel'); 
	?>


	<div class="openMenuMobile">
		<i class="las la-bars closed"></i>
		<i class="las la-times opened"></i>
	</div>
	<div class="nftmax-smenu">
		<div class="admin-menu">
            <div> 
				<div class="d-flex" style="padding: 0rem 15px;">
					<img src="assets/media/logo-white.png" class="img-fluid" style="max-height: 100px;" />
				</div>
                <div class="nav_list" style="padding-top:20px !important;"> 

					
					<?php
						if( $sessionAdmin_user_nivel == "administrador"){
					?>
						<a href="<?php echo(site_url('clientes')); ?>" class="nav_link"> <i class='bx bx-grid-alt nav_icon'></i> <span class="nav_name">Clientes</span></a>
						<a href="<?php echo(site_url('equipamentos')); ?>" class="nav_link"> <i class='bx bx-grid-alt nav_icon'></i> <span class="nav_name">Equipamentos</span></a>
						<a href="<?php echo(site_url('categorias')); ?>" class="nav_link"> <i class='bx bx-grid-alt nav_icon'></i> <span class="nav_name">Categorias</span></a>
						
						<div class="mt-3">
							<a href="<?php echo(site_url('servicos')); ?>" class="nav_link"> <i class='bx bx-grid-alt nav_icon'></i> <span class="nav_name">Serviços</span></a>
							<a href="<?php echo(site_url('programacoes')); ?>" class="nav_link"> <i class='bx bx-grid-alt nav_icon'></i> <span class="nav_name">Programação</span></a>
							<a href="<?php echo(site_url('programacoes/diaria/'. date('Y-m-d'))); ?>" class="nav_link"> <i class='bx bx-grid-alt nav_icon'></i> <span class="nav_name">Programação Diária</span></a>
						</div>

						<div class="mt-3">
							<a href="<?php echo(site_url('usuarios')); ?>" class="nav_link"> <i class='bx bx-grid-alt nav_icon'></i> <span class="nav_name">Usuários</span></a>
						</div>
						<!-- <div> -->
						<!-- 	<a href="<?php echo(site_url('permissoes')); ?>" class="nav_link"> <i class='bx bx-grid-alt nav_icon'></i> <span class="nav_name">Permissões</span></a> -->
						<!-- </div> -->
					<?php
						}
					?>


					<?php
						if( $sessionAdmin_user_nivel == "cliente"){
					?>
						<a href="<?php echo(site_url('clientes')); ?>" class="nav_link"> <i class='bx bx-grid-alt nav_icon'></i> <span class="nav_name">Clientes</span></a>
						<div class="mt-3">
							<a href="<?php echo(site_url('servicos')); ?>" class="nav_link"> <i class='bx bx-grid-alt nav_icon'></i> <span class="nav_name">Serviços</span></a>
						</div>
					<?php
						}
					?>




				</div>
			</div> 
		</div>
	</div>

	<main>
		<div class="page-content" style="padding-top: 0; margin-top: 0;">
			<div class="container-fluid" style="border-bottom: 1px solid  #f2f2f2; padding-bottom: 8px; margin-bottom: 12px;">
				<div class="row justify-content-end align-items-start">
					<div class="col-3 col-md-9"></div>
					<div class="col-9 col-md-3">
						<div class="d-flex align-items-center">
							<div style="padding-right: 12px;">
								<img src="assets/media/icons/user.png" style="width: 32px;" />
							</div>
							<div>
								<?php
									echo('<h4>'. $sessionAdmin_user_nome .'</h4>');
								?>
								<div class="pt-1" style="line-height:1"><a href="<?php echo(site_url('logout')); ?>" style="line-height:1">Sair</a></div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<?php 
				$this->renderSection('content');
			?>

			</div>
		</div>
		
	</main>


	<style>
		/*======================================
			Theme Default
		========================================*/
		.l-navbar .nav{
			  -ms-overflow-style: none;  /* IE and Edge */
			  scrollbar-width: none;  /* Firefox */
		}

		.nftmax-smenu {
			position: fixed;
			left: 0;
			z-index: 6000;
			height: 100%;
			transition: all 0.3s ease;
			transition: all 0.4s;
			width: 250px;
			transform: translateX(0%);
			box-shadow: 0 9px 95px 0 #0000000d;
		}
		.admin-menu {
			background: #fff;
			height: 100%;
			scrollbar-width: none;
			overflow: scroll;
			padding-left: 12px;
			padding-top: 10px;
			padding-right: 12px;
			transition: all .3s ease;
		}

		@media screen and (max-width: 768px) {
			.nftmax-smenu { left: -1000px !important; }
			.nftmax-smenu.opened { left: 0px !important; }
		}
		.openMenuMobile{
			position: fixed;
			top: 5px;
			left: 5px;
			z-index: 550;
			font-size: 19px;
			background-color: #9c9c9c;
			padding: 5px 10px;
			border-radius: 8px;
			color: white;
			cursor: pointer;
		}
		.openMenuMobile.opened{
			right: 15px !important;
			left: inherit !important;
		}
		.openMenuMobile .las.closed{ display: block !important; }
		.openMenuMobile .las.opened{ display: none !important; }
		.openMenuMobile.opened .las.closed{ display: none !important; }
		.openMenuMobile.opened .las.opened{ display: block !important; }
	</style>

	<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
	<script src="assets/plugins/jQuery-Mask-Plugin/dist/jquery.mask.min.js" type="text/javascript"></script>
	<script src="assets/js/app_plugins.js"></script>

	<script src="assets/js/mustache.js"></script>

	<script>
		let site_url = '<?php echo(site_url()); ?>/';	
	</script>


	<script>
	feather.replace();

	$(document).ready(function () {
		$(document).on('click', '.cmdOpenMenu', function (e) {
			e.preventDefault();

			let $navBar = $('#nav-bar');
			//let $navBar = $('#nav-bar');

			if( $navBar.hasClass( "show" ) ){
				$navBar.removeClass('show');
			}else{
				$navBar.addClass('show');
			}
			return false;
		});
		$(document).on('click', '.openMenuMobile', function (e) {
			e.preventDefault();
			let $this = $(this);
			let $menu = $('.nftmax-smenu');
			if( $menu.hasClass( "opened" ) ){
				$this.removeClass("opened");
				$menu.removeClass("opened");
			}else{
				$this.addClass("opened");
				$menu.addClass("opened");
			}
			return false;
		});
	});
	</script>

	<?php $this->renderSection('scripts'); ?>

</body>
</html>