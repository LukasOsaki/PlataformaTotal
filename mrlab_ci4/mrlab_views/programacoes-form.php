<?php 
	$this->extend('templates/template_painel');
	$this->section('content'); 
?>

	<div class="box-breadcrumb">
		<div class="row">
			<div class="col-12">
				<h2 class="page-title">Programações</h2>
			</div>
		</div>
	</div>

	<div id="app">
		<div class="row align-items-start">
			<div class="col-12 col-md-12">

				<FORM action="<?php echo(current_url()); ?>" method="post" name="formFieldsRegistro" id="formFieldsRegistro" enctype="multipart/form-data">

				<div class="row align-items-start">
					<div class="col-12 col-md-12">

						<div class="card card-default">
							<div class="card-header-box">
								<div class="row align-items-center">
									<div class="col-12 col-md-6">
										
									</div>
									<div class="col-12 col-md-6">

										<div class="d-flex justify-content-end">
											<div style="margin-left: 5px;"><a href="<?php echo(site_url('programacoes')); ?>" class="btn btn-sm btn-warning">Voltar</a></div>
											<div style="margin-left: 5px;"><input type="submit" class="btn btn-sm btn-success" value="Salvar"></div>
										</div>

									</div>
								</div>
							</div>
							<div class="card-body">

								<div class="row ">
									<div class="col-12 col-md-3">

										<div class="row mb-4">
											<div class="col-12">
												<?php 
													$prog_ativo = (int)((isset($rs_dados->prog_ativo) ? $rs_dados->prog_ativo : "1")); 
													$ativo_s = ($prog_ativo == "1" ? ' checked ' : '');
													$ativo_n = ($prog_ativo != "1" ? ' checked ' : '');
												?>
												<div class="form-group">
													<div><label class="form-label">Registro Ativo?</label></div>
													<div>
														<div class="form-check-inline my-1">
															<div class="custom-control custom-radio">
																<input type="radio" name="prog_ativo" id="ativo_s" class="custom-control-input" value="1" <?php echo($ativo_s)?> />
																<label class="custom-control-label" for="ativo_s">Sim</label>
															</div>
														</div>
														<div class="form-check-inline my-1">
															<div class="custom-control custom-radio">
																<input type="radio" name="prog_ativo" id="ativo_n" class="custom-control-input" value="0" <?php echo($ativo_n)?> />
																<label class="custom-control-label" for="ativo_n">Não</label>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>

										<div class="row mb-4">
											<div class="col-12">
												<?php 
													$prog_realizada = (int)((isset($rs_dados->prog_realizada) ? $rs_dados->prog_realizada : "0")); 
													$realizado_s = ($prog_realizada == "1" ? ' checked ' : '');
													$realizado_n = ($prog_realizada != "1" ? ' checked ' : '');
												?>
												<div class="form-group">
													<div><label class="form-label">Serviço Realizado?</label></div>
													<div>
														<div class="form-check-inline my-1">
															<div class="custom-control custom-radio">
																<input type="radio" name="prog_realizada" id="realizado_s" class="custom-control-input" value="1" <?php echo($realizado_s)?> />
																<label class="custom-control-label" for="realizado_s">Sim</label>
															</div>
														</div>
														<div class="form-check-inline my-1">
															<div class="custom-control custom-radio">
																<input type="radio" name="prog_realizada" id="realizado_n" class="custom-control-input" value="0" <?php echo($realizado_n)?> />
																<label class="custom-control-label" for="realizado_n">Não</label>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>

									</div>
									<div class="col-12 col-md-9">

										<div class="row">
											<div class="col-12 col-md-3">
												<?php 
													$prog_dte_visita = (isset($rs_dados->prog_dte_visita) ? $rs_dados->prog_dte_visita : ""); 
													$prog_dte_visita = fct_formatdate($prog_dte_visita, 'd/m/Y');
												?>
												<div class="form-group">
													<label class="form-label" for="prog_dte_visita">Data de Visita</label>
													<input type="text" name="prog_dte_visita" id="prog_dte_visita" class="form-control mask-date flatpickr_date" value="<?php echo($prog_dte_visita);?>" />
												</div>
											</div>
											<div class="col-12 col-md-9">
												<?php 
													$_clie_id = (isset($rs_dados->clie_id) ? $rs_dados->clie_id : "");
												?>
												<div class="form-group">
													<label class="form-label" for="clie_id">Cliente</label>
													<select class="form-select" name="clie_id" id="clie_id">
														<option value="" translate="no">- selecione -</option>
														<?php
														if( isset($rs_clientes)){
															foreach ($rs_clientes->getResult() as $row) {
																$clie_id = ($row->clie_id);
																$clie_nome_razao = ($row->clie_nome_razao);
																$selected = (($clie_id == $_clie_id) ? "selected" : "");
														?>
															<option value="<?php echo($clie_id); ?>" <?php echo($selected); ?> translate="no"><?php echo($clie_nome_razao); ?></option>
														<?php
															}
														}
														?>
													</select>
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-12 col-md-3">
												<?php 
													$prog_periodo = (isset($rs_dados->prog_periodo) ? $rs_dados->prog_periodo : "");
												?>
												<div class="form-group">
													<label class="form-label" for="prog_periodo">Período</label>
													<select class="form-select" name="prog_periodo" id="prog_periodo">
														<option value="" translate="no">- selecione -</option>
														<?php
														if( isset($cfgProgPeriodo)){
															foreach ($cfgProgPeriodo as $key => $val) {
																$label = $val['label'];
																$selected = (($key == $prog_periodo) ? "selected" : "");
															?>
																<option value="<?php echo($key); ?>" <?php echo($selected); ?> translate="no"><?php echo($label); ?></option>
														<?php
															}
														}
														?>
													</select>
												</div>
											</div>
											<div class="col-12 col-md-2">
												<div class="form-group">
													<label class="form-label" for="prog_sequencia">Sequência</label>
													<input type="text" name="prog_sequencia" id="prog_sequencia" class="form-control" value="<?php echo((isset($rs_dados->prog_sequencia) ? $rs_dados->prog_sequencia : ""));?>" />
												</div>
											</div>
											<div class="col-12 col-md-7">
												<div class="form-group">
													<label class="form-label" for="prog_tecnico">Técnico</label>
													<input type="text" name="prog_tecnico" id="prog_tecnico" class="form-control" value="<?php echo((isset($rs_dados->prog_tecnico) ? $rs_dados->prog_tecnico : ""));?>" />
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-12 col-md-12">
												<div class="form-group">
													<label class="form-label" for="prog_atividades">Atividades</label>
													<textarea name="prog_atividades" id="prog_atividades" class="form-control" rows="6"><?php echo((isset($rs_dados->prog_atividades) ? $rs_dados->prog_atividades : ""));?></textarea>
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