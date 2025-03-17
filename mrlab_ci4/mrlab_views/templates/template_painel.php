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

    <link rel="stylesheet" href="assets/css/reset_painel.css">
    <link rel="stylesheet" href="assets/css/style_painel.css">

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
    $sessionAdmin_user_nivel = session()->get('admin_nivel');
    $sessionAdmin_user_nome = (isset($sessionAdmin_user_nome) ? $sessionAdmin_user_nome : '');
    $permissoes = session()->get('permissoes');
    ?>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="assets/media/logo-white.png" alt="Logo" style="height: 50px;">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <?php if ($sessionAdmin_user_nivel != "cliente" && !empty($permissoes)): ?>
                        <?php foreach ($permissoes as $permissao): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= site_url($permissao['urlpage']) ?>">
                                    <i class="bx bx-grid-alt nav_icon"></i> <?= $permissao['titulo'] ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>

                    <?php if ($sessionAdmin_user_nivel == "cliente"): ?>
                        <li class="nav-item"><a class="nav-link" href="<?= site_url('clientes') ?>">Perfil</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= site_url('servicos') ?>">Serviços</a></li>
                    <?php endif; ?>
                    <?php if ($sessionAdmin_user_nivel == "cliente_raiz"): ?>
                        <li class="nav-item"><a class="nav-link" href="<?= site_url('clientesRaiz') ?>">Perfil</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= site_url('servicos') ?>">Serviços</a></li>
                    <?php endif; ?>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item d-flex align-items-center">
                        <img src="assets/media/icons/user.png" alt="User Icon" style="width: 32px; margin-right: 10px;">
                        <div>
                            <strong><?= $sessionAdmin_user_nome ?></strong>
                            <br>
                            <a href="<?= site_url('logout') ?>">Sair</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main >
        <div class="container-fluid">
            <?php $this->renderSection('content'); ?>
        </div>
    </main>

    <!-- Scripts -->
    <script>
        feather.replace();
        let site_url = '<?= site_url(); ?>/';
    </script>


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
