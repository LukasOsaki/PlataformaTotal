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
	<link rel="shortcut icon" href="assets/media/fav-icon.png" />

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

	<link href="assets/css/reset_painel.css" rel="stylesheet" type="text/css" />
	<link href="assets/css/style-painel-login.css" rel="stylesheet" type="text/css" />

	<style>
		.image-fix {
			position: fixed;
			left: 0;
			top: 0;
			height: 100vh;
			width: 50%;
			z-index: 0;

			background-image: url('assets/media/fundo-login.jpg');
			background-position: center right;
			background-size: cover;
			background-repeat: no-repeat;	
			background-color: rgb(222 222 222 / 50%);
			border-right: 4px solid #c6f551;
			/* background-color: rgb(255,255,255,0); */
			/* border: 3px solid red; */

			/* background-color: rgb(255,255,255,255,0);
			background-image: url('../images/logo-evento.jpeg');
			background-position: left top;
			background-size: contain;
			background-repeat: no-repeat;	 */

			/* background-image: url('../images/logo-evento.jpeg');
			background-position: top center;
			background-size: cover;
			background-repeat: no-repeat;

			background-position: left top;
			background-size: contain;
			background-repeat: no-repeat; */
			
			/* left: 50%;
			top: 50%;
			widows: 50% ;
			transform: translate(-50%, -50%);	 */
		}
		.image-fix img {
			box-shadow: 6px 8px 10px rgb(255 255 255 / 77%) !important;
			max-width: 100%;
			height: 100%;
			width: auto;
			max-height: 100vh;
		}
		.image-fix:before {
			display:none;
			content: '';
			position: absolute;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			background-color: rgb(83 12 133 / 80%);
		}
		.image-fix-blur{
			z-index: -1;
			position: fixed;
			left: 0;
			width: 100%;
			height: 100vh;
			filter: blur(12px);
			-webkit-filter: blur(12px);            
			background-image: url('assets/media/fundo-login.jpg');
			background-position: center center;
			background-size: cover;
			background-repeat: no-repeat;	
		}
	</style>

</head>
<body>
	<div class="image-fix">
		<div class="box-image">
			<!-- <div class="is_desktop"><img src="assets/images/fundo-login.jpg"></div> -->
			<!-- <div class="is_mobile"><img src="assets/images/fundo-login.jpg"></div> -->
		</div>
	</div>
	<div style="position: relative; height: 100vh; overflow: hidden;">
		<div class="container-fluid" style="min-height: 100vh; border: 0px dotted red; padding: 0;">
			<div class="d-flex justify-content-center align-items-center w-100" style="min-height: 100vh;">
				<div class="row justify-content-center align-items-center w-100" >
					<div class="col-12 col-md-6">

						<!-- IMAGEM DESTE LADO -->
						
					</div>
					<div class="col-12 col-md-6">

						<FORM method="POST" class="" action="<?php echo( current_url() ); ?>">

							<div class="card-login">
								<div class="row justify-content-center align-items-center" >
									<div class="col-12 col-md-8">

											<div class="d-flex justify-content-center mb-3" style="padding: 0rem 2.5rem;">
												<img src="assets/media/logo-white.png" class="img-fluid" style="max-width: 300px;" />
											</div>

											<div class="mb-3">
												<h1 class="text-center h1_titulo">Acesso ao sistema</h1>
											</div>

											<div class="row mt-2">
												<div class="col-12 col-md-12">
													<div class="form-group">
														<label class="form-label" for="insti_email">Login / E-mail:</label>
														<input type="text" name="user_email" id="user_email" class="form-control" value="" />
													</div>
												</div>
											</div>

											<div class="row pt-2">
												<div class="col-12 col-md-12">
													<div class="form-group">
														<label class="form-label" for="insti_senha">Senha:</label>
														<input type="password" name="user_senha" id="user_senha" class="form-control" value="" />
													</div>
												</div>
											</div>

											<div class="mb-2 mt-2">
												<div class="d-flex justify-content-between">
													<div>
														<div class="form-check">
															<input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
															<label class="form-check-label" for="flexCheckDefault">
																Manter-me Conectado
															</label>
														</div>
													</div>
													<div>
														<a href="">Esqueci minha senha</a>
													</div>
												</div>
											</div>

											<div class="row pt-2">
												<div class="col-12 col-md-12">
													<div class="d-grid">
														<button type="submit" class="btn btn-primary">Entrar</button>
													</div>
												</div>
											</div>

									</div>
								</div>
							</div>

						</FORM>

					</div>
				</div>
			</div>
		</div>
	</div>

	<div id="app" style="display:none !important;">
		<div class="bg-login"></div>
		<div class="content-wrapper d-flex justify-content-center align-items-center" style="position: relative; min-height: 90vh;">

			<div class="" style="width: 100%;">
				<FORM method="POST" action="<?php echo(current_url()); ?>">
					<div class="container-fluid">
						<div class="row justify-content-center align-items-center" >
							<div class="col-12 col-md-4">

							<div class="card card-default" style="width: 100%; box-shadow: 0px 6px 20px 2px rgba(0,0,0,0.75);">
								<div class="card-header" style="padding: 0;">
									<div class="p-3 text-center">
										<img src="assets/media/gblogo.png" class="img-fluid" />
									</div>
								</div>
								<div class="card-body" style="padding: 30px; padding-top: 10px;">

									<h1 class="text-center">Área Administrativa</h1>

									<?php //echo( md5('guardiao') ); ?>

									<div class="row pt-2">
										<div class="col-12 col-md-12">
											<div class="form-group">
												<label class="form-label" for="EMAIL">E-mail / login:</label>
												<input type="text" name="EMAIL" id="EMAIL" class="form-control" value="" />
											</div>
										</div>
									</div>

									<div class="row pt-2">
										<div class="col-12 col-md-12">
											<div class="form-group">
												<label class="form-label" for="SENHA">Senha:</label>
												<input type="password" name="SENHA" id="SENHA" class="form-control" value="" />
											</div>
										</div>
									</div>

									<div class="row pt-2">
										<div class="col-12 col-md-12">
											<div class="d-grid">
												<button type="submit" class="btn btn-sm btn-primary">Entrar</button>
											</div>
										</div>
									</div>

								</div>
							</div>

								
							</div>
						</div>
					</div>
				</FORM>
			</div>

		</div>
	</div>

</body>
</html>