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

	<link href="assets/css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>

	<div id="app">
		<div class="bg-login"></div>
		<div class="content-wrapper d-flex justify-content-center align-items-center" style="position: relative; min-height: 90vh;">

			<div class="" style="width: 100%;">
				<FORM method="POST" action="<?php echo(current_url()); ?>">
					<div class="container-fluid">
						<div class="row justify-content-center align-items-center" >
							<div class="col-12 col-md-6">

							<div class="card card-default" style="width: 100%; box-shadow: 0px 6px 20px 2px rgba(0,0,0,0.75); background-color: #011634; border: 1px solid rgb(93 222 230) !important;">
								<div class="card-header" style="padding: 12px 0;">
									<h1 class="text-center p-0 m-0" style="font-size: 2rem; font-weight: bold;">Área Administrativa</h1>
								</div>
								<div class="card-body" style="padding: 30px; padding-top: 10px;">

									<div class="row justify-content-between align-items-center" >
										<div class="col-12 col-md-5">
											<div class="p-3 text-center">
												<img src="assets/media/logotipo.png" class="img-fluid" />
											</div>
										</div>
										<div class="col-12 col-md-6">
											
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
						</div>
					</div>
				</FORM>
			</div>

		</div>
	</div>

</body>
</html>