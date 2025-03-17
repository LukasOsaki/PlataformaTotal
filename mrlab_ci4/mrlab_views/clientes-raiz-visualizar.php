<?php 
	$this->extend('templates/template_painel');
	$this->section('content'); 
?>

	<div class="box-breadcrumb">
		<div class="row">
			<div class="col-12">
				<h2 class="page-title">Cliente Matriz</h2>
			</div>
		</div>
	</div>

	<div id="app">
		<div class="row align-items-start">
			<div class="col-12 col-md-12">

				<div class="row align-items-start">
					<div class="col-12 col-md-12">

						<div class="card card-default">
							<div class="card-header-box">
								<div class="row align-items-center">
									<div class="col-12 col-md-6">
										
									</div>
									<div class="col-12 col-md-6">

									</div>
								</div>
							</div>
							<div class="card-body">

								<div class="row ">
									<div class="col-12 col-md-12">

										<nav>
											<div class="nav nav-tabs" id="nav-tab" style="border-bottom: 0px !important;" role="tablist">
												<button class="nav-link active" id="nav-principal-tab" data-bs-toggle="tab" data-bs-target="#nav-principal" type="button" role="tab" aria-controls="nav-principal" aria-selected="true">Principal</button>
											</div>
										</nav>
										<div class="tab-content border" id="nav-tabContent" style="padding: 2rem 1rem; border-radius: 8px !important; border-top-left-radius: 0px !important;">
											<div class="tab-pane fade active show" id="nav-principal" role="tabpanel" aria-labelledby="nav-principal-tab">

												<div class="row">
													<div class="col-12 col-md-6">
														<div class="form-group">
															<label class="form-label" for="clie_raiz_nome_razao">Nome / Razão Social</label>
															<input type="text" name="clie_raiz_nome_razao" id="clie_raiz_nome_razao" class="form-control" value="<?php echo((isset($rs_dados->clie_raiz_nome_razao) ? $rs_dados->clie_raiz_nome_razao : ""));?>" readonly="readonly" onfocus="this.blur();" />
														</div>
													</div>
													<div class="col-12 col-md-6">
														<div class="form-group">
															<label class="form-label" for="clie_raiz_nome_fantasia">Nome Fantasia</label>
															<input type="text" name="clie_raiz_nome_fantasia" id="clie_raiz_nome_fantasia" class="form-control" value="<?php echo((isset($rs_dados->clie_raiz_nome_fantasia) ? $rs_dados->clie_raiz_nome_fantasia : ""));?>" readonly="readonly" onfocus="this.blur();" />
														</div>
													</div>
												</div>

											

												<div class="row">
													<div class="col-12 col-md-6">
														<div class="form-group">
															<label class="form-label" for="clie_raiz_login">Login</label>
															<input type="text" name="clie_raiz_login" id="clie_raiz_login" class="form-control" value="<?php echo((isset($rs_dados->clie_raiz_login) ? $rs_dados->clie_raiz_login : ""));?>" readonly="readonly" onfocus="this.blur();" />
														</div>
													</div>
													<div class="col-12 col-md-6">
														<div class="form-group">
															<label class="form-label" for="clie_raiz_cnpj">CNPJ</label>
															<input type="text" name="clie_raiz_cnpj" id="clie_raiz_cnpj" class="form-control mask-cnpj" value="<?php echo((isset($rs_dados->clie_raiz_cnpj) ? $rs_dados->clie_raiz_cnpj : ""));?>" readonly="readonly" onfocus="this.blur();" />
														</div>
													</div>

													<div class="col-12 col-md-12">
														<div class="form-group">
															<label class="form-label" for="clie_raiz_hashkey">Chave API</label>
															<input type="text" name="clie_raiz_hashkey" id="clie_raiz_hashkey" class="form-control" value="<?php echo((isset($rs_dados->clie_raiz_hashkey) ? $rs_dados->clie_raiz_hashkey : ""));?>" readonly="readonly" onfocus="this.blur();" />
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
				</div>

			</div>
		</div>
	</div>



<?php
	$this->endSection('content'); 
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
	<style>
		.table-box {
			width: 100%;
			border: 1px solid  #f2f2f2;
			border-radius: 0.35rem !important;
			padding: 8px;
		}
		.table td {
			border-color: #dee2e6 !important;
			/*border-width: 1px !important;*/
			vertical-align: top;
		}

		div.dataTables_wrapper div.dataTables_length select {
			width: auto;
			display: inline-block;
			padding-top: 0.25rem !important;
			padding-bottom: 0.25rem !important;
			padding-left: 0.5rem !important;
			padding: 0.375rem 2.25rem 0.375rem 0.75rem !important;
		}
		.dataTables_wrapper .dataTables_paginate .paginate_button {
			padding: 0 !important;
			margin-left: 2px !important;
			border: 0px solid transparent !important;
		}
		.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
			border: 0px solid #fff !important;
			background-color: #585858 !important;
			background-color: #ffffff !important;
			background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #ffffff), color-stop(100%, #ffffff));
			background: -webkit-linear-gradient(top, #ffffff 0%, #ffffff 100%);
			background: -moz-linear-gradient(top, #ffffff 0%, #ffffff 100%);
			background: -ms-linear-gradient(top, #ffffff 0%, #ffffff 100%);
			background: -o-linear-gradient(top, #ffffff 0%, #ffffff 100%);
			background: linear-gradient(to bottom, #ffffff 0%, #ffffff 100%);
			box-shadow: inset 0 0 3px #ffffff;
		}
		.dataTables_wrapper .dataTables_paginate .paginate_button:active {
			outline: none;
			background-color: #ffffff !important;
			background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #ffffff), color-stop(100%, #ffffff)) !important;
			background: -webkit-linear-gradient(top, #ffffff 0%, #ffffff 100%) !important;
			background: -moz-linear-gradient(top, #ffffff 0%, #ffffff 100%) !important;
			background: -ms-linear-gradient(top, #ffffff 0%, #ffffff 100%) !important;
			background: -o-linear-gradient(top, #ffffff 0%, #ffffff 100%) !important;
			background: linear-gradient(to bottom, #ffffff 0%, #ffffff 100%) !important;
			box-shadow: inset 0 0 3px #ffffff !important;
		}
	</style>

<?php $this->endSection('headers'); ?>

<?php $this->section('scripts'); ?>

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
	<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
	<script src="assets/plugins/flatpickr/flatpickr-locale-br.js"></script>

	<!-- Sweet Alert -->
	<link href="assets/plugins/sweet-alert2/sweetalert2.min.css" rel="stylesheet" type="text/css">
	<script src="assets/plugins/sweet-alert2/sweetalert2.min.js"></script>

	<script>
	$(document).ready(function () {

		$('.flatpickr_date').flatpickr({
			"allowInput" : true,
			"locale": "pt",
			dateFormat:"d/m/Y",	
		});
	});
	</script>

<?php $this->endSection('scripts'); ?>