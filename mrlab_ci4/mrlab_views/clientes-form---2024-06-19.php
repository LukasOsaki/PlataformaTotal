<?php 
	$this->extend('templates/template_painel');
	$this->section('content'); 
?>

	<div class="box-breadcrumb">
		<div class="row">
			<div class="col-12">
				<h2 class="page-title">Clientes</h2>
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
											<div style="margin-left: 5px;"><a href="<?php echo(site_url('clientes')); ?>" class="btn btn-sm btn-warning">Voltar</a></div>
											<div style="margin-left: 5px;"><input type="submit" class="btn btn-sm btn-success" value="Salvar"></div>
										</div>

									</div>
								</div>
							</div>
							<div class="card-body">

								<div class="row ">
									<div class="col-12 col-md-3">

										<div class="row">
											<div class="col-12">
												<?php 
													$clie_ativo = (int)((isset($rs_dados->clie_ativo) ? $rs_dados->clie_ativo : "1")); 
													$ativo_s = ($clie_ativo == "1" ? ' checked ' : '');
													$ativo_n = ($clie_ativo != "1" ? ' checked ' : '');
												?>
												<div class="form-group">
													<div><label class="form-label" for="EMAIL">Registro Ativo?</label></div>
													<div>
														<div class="form-check-inline my-1">
															<div class="custom-control custom-radio">
																<input type="radio" name="clie_ativo" id="ativo_s" class="custom-control-input" value="1" <?php echo($ativo_s)?> />
																<label class="custom-control-label" for="ativo_s">Sim</label>
															</div>
														</div>
														<div class="form-check-inline my-1">
															<div class="custom-control custom-radio">
																<input type="radio" name="clie_ativo" id="ativo_n" class="custom-control-input" value="0" <?php echo($ativo_n)?> />
																<label class="custom-control-label" for="ativo_n">Não</label>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>

									</div>
									<div class="col-12 col-md-9">

										<div class="row">
											<div class="col-12 col-md-12">
												<div class="form-group">
													<label class="form-label" for="clie_nome_razao">Nome / Razão Social <span style="margin-left: 15px; color: red; font-size: .65rem;">obrigatório</span></label>
													<input type="text" name="clie_nome_razao" id="clie_nome_razao" class="form-control" value="<?php echo((isset($rs_dados->clie_nome_razao) ? $rs_dados->clie_nome_razao : ""));?>" />
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-12 col-md-7">
												<div class="form-group">
													<label class="form-label" for="clie_nome_fantasia">Nome Fantasia</label>
													<input type="text" name="clie_nome_fantasia" id="clie_nome_fantasia" class="form-control" value="<?php echo((isset($rs_dados->clie_nome_fantasia) ? $rs_dados->clie_nome_fantasia : ""));?>" />
												</div>
											</div>
											<div class="col-12 col-md-5">
												<div class="row">
													<div class="col-12 col-md-6">
														<?php 
															$clie_dte_ini_contrato = (isset($rs_dados->clie_dte_ini_contrato) ? $rs_dados->clie_dte_ini_contrato : ""); 
															$clie_dte_ini_contrato = fct_formatdate($clie_dte_ini_contrato, 'd/m/Y');
														?>
														<div class="form-group">
															<label class="form-label" for="clie_dte_ini_contrato">Início Contrato</label>
															<input type="text" name="clie_dte_ini_contrato" id="clie_dte_ini_contrato" class="form-control mask-date flatpickr_date" value="<?php echo($clie_dte_ini_contrato);?>" />
														</div>
													</div>
													<div class="col-12 col-md-6">
														<?php 
															$clie_dte_end_contrato = (isset($rs_dados->clie_dte_end_contrato) ? $rs_dados->clie_dte_end_contrato : ""); 
															$clie_dte_end_contrato = fct_formatdate($clie_dte_end_contrato, 'd/m/Y');
														?>
														<div class="form-group">
															<label class="form-label" for="clie_dte_end_contrato">Término Contrato</label>
															<input type="text" name="clie_dte_end_contrato" id="clie_dte_end_contrato" class="form-control mask-date flatpickr_date" value="<?php echo($clie_dte_end_contrato);?>" />
														</div>
													</div>
												</div>

											</div>
										</div>

										<div class="row">
											<div class="col-12 col-md-6">
												<div class="form-group">
													<label class="form-label" for="clie_email">E-mail</label>
													<input type="text" name="clie_email" id="clie_email" class="form-control" value="<?php echo((isset($rs_dados->clie_email) ? $rs_dados->clie_email : ""));?>" />
												</div>
											</div>
											<div class="col-12 col-md-6">
												<div class="row">
													<div class="col-12 col-md-7">
														<div class="form-group">
															<label class="form-label" for="clie_cnpj">CNPJ</label>
															<input type="text" name="clie_cnpj" id="clie_cnpj" class="form-control mask-cnpj" value="<?php echo((isset($rs_dados->clie_cnpj) ? $rs_dados->clie_cnpj : ""));?>" />
														</div>														
													</div>
													<div class="col-12 col-md-5">
														<div class="form-group">
															<label class="form-label" for="clie_senha">Senha</label>
															<input type="password" name="clie_senha" id="clie_senha" class="form-control" value="" />
														</div>	
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-12 col-md-2">
												<div class="form-group">
													<label class="form-label" for="clie_cep">CEP</label>
													<input type="text" name="clie_cep" id="clie_cep" class="form-control" value="<?php echo((isset($rs_dados->clie_cep) ? $rs_dados->clie_cep : ""));?>" />
												</div>
											</div>
											<div class="col-12 col-md-6">
												<div class="form-group">
													<label class="form-label" for="clie_endereco">Endereço</label>
													<input type="text" name="clie_endereco" id="clie_endereco" class="form-control" value="<?php echo((isset($rs_dados->clie_endereco) ? $rs_dados->clie_endereco : ""));?>" />
												</div>
											</div>
											<div class="col-12 col-md-4">
												<div class="form-group">
													<label class="form-label" for="clie_end_numero">Numero</label>
													<input type="text" name="clie_end_numero" id="clie_end_numero" class="form-control" value="<?php echo((isset($rs_dados->clie_end_numero) ? $rs_dados->clie_end_numero : ""));?>" />
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-12 col-md-3">
												<div class="form-group">
													<label class="form-label" for="clie_end_compl">Complemento</label>
													<input type="text" name="clie_end_compl" id="clie_end_compl" class="form-control" value="<?php echo((isset($rs_dados->clie_end_compl) ? $rs_dados->clie_end_compl : ""));?>" />
												</div>
											</div>
											<div class="col-12 col-md-3">
												<div class="form-group">
													<label class="form-label" for="clie_bairro">Bairro</label>
													<input type="text" name="clie_bairro" id="clie_bairro" class="form-control" value="<?php echo((isset($rs_dados->clie_bairro) ? $rs_dados->clie_bairro : ""));?>" />
												</div>
											</div>
											<div class="col-12 col-md-4">
												<div class="form-group">
													<label class="form-label" for="clie_cidade">Cidade</label>
													<input type="text" name="clie_cidade" id="clie_cidade" class="form-control" value="<?php echo((isset($rs_dados->clie_cidade) ? $rs_dados->clie_cidade : ""));?>" />
												</div>
											</div>
											<div class="col-12 col-md-2">
												<div class="form-group">
													<label class="form-label" for="clie_estado">Estado</label>
													<input type="text" name="clie_estado" id="clie_estado" class="form-control" value="<?php echo((isset($rs_dados->clie_estado) ? $rs_dados->clie_estado : ""));?>" />
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-12 col-md-12">
												<div class="form-group">
													<label class="form-label" for="clie_observacoes">Observações</label>
													<textarea name="clie_observacoes" id="clie_observacoes" class="form-control" rows="6"><?php echo((isset($rs_dados->clie_observacoes) ? $rs_dados->clie_observacoes : ""));?></textarea>
												</div>
											</div>
										</div>


										<!--
										<div class="row">
											<div class="col-12 col-md-2">
												<div class="form-group">
													<label class="form-label" for="clie_observacoes">Nome do Documento</label>
													<input type="text" name="clie_estado" id="clie_estado" class="form-control" value="" />
												</div>
											</div>
											<div class="col-12 col-md-2">
												<div class="form-group">
													<label class="form-label" for="clie_observacoes">Data</label>
													<input type="text" name="clie_estado" id="clie_estado" class="form-control" value="" />
												</div>
											</div>
											<div class="col-12 col-md-2">
												<div class="form-group">
													<label class="form-label" for="clie_observacoes">Validade</label>
													<input type="text" name="clie_estado" id="clie_estado" class="form-control" value="" />
												</div>
											</div>
											<div class="col-12 col-md-2">
												<div class="form-group">
													<label class="form-label" for="clie_observacoes">Anexo</label>
													<input type="file" name="clie_estado" id="clie_estado" class="form-control" value="" />
												</div>
											</div>
											<div class="col-12 col-md-2">
												<div class="form-group">
													<label class="form-label" for="clie_observacoes">Status</label>
													<input type="text" name="clie_estado" id="clie_estado" class="form-control" value="" />
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-12 col-md-2">
												<div class="form-group">
													<label class="form-label" for="clie_observacoes">Nome do Documento</label>
													<input type="text" name="clie_estado" id="clie_estado" class="form-control" value="" />
												</div>
											</div>
											<div class="col-12 col-md-2">
												<div class="form-group">
													<label class="form-label" for="clie_observacoes">Data</label>
													<input type="text" name="clie_estado" id="clie_estado" class="form-control" value="" />
												</div>
											</div>
											<div class="col-12 col-md-2">
												<div class="form-group">
													<label class="form-label" for="clie_observacoes">Validade</label>
													<input type="text" name="clie_estado" id="clie_estado" class="form-control" value="" />
												</div>
											</div>
											<div class="col-12 col-md-2">
												<div class="form-group">
													<label class="form-label" for="clie_observacoes">Anexo</label>
													<input type="file" name="clie_estado" id="clie_estado" class="form-control" value="" />
												</div>
											</div>
											<div class="col-12 col-md-2">
												<div class="form-group">
													<label class="form-label" for="clie_observacoes">Status</label>
													<input type="text" name="clie_estado" id="clie_estado" class="form-control" value="" />
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-12 col-md-2">
												<div class="form-group">
													<label class="form-label" for="clie_observacoes">Nome do Documento</label>
													<input type="text" name="clie_estado" id="clie_estado" class="form-control" value="" />
												</div>
											</div>
											<div class="col-12 col-md-2">
												<div class="form-group">
													<label class="form-label" for="clie_observacoes">Data</label>
													<input type="text" name="clie_estado" id="clie_estado" class="form-control" value="" />
												</div>
											</div>
											<div class="col-12 col-md-2">
												<div class="form-group">
													<label class="form-label" for="clie_observacoes">Validade</label>
													<input type="text" name="clie_estado" id="clie_estado" class="form-control" value="" />
												</div>
											</div>
											<div class="col-12 col-md-2">
												<div class="form-group">
													<label class="form-label" for="clie_observacoes">Anexo</label>
													<input type="file" name="clie_estado" id="clie_estado" class="form-control" value="" />
												</div>
											</div>
											<div class="col-12 col-md-2">
												<div class="form-group">
													<label class="form-label" for="clie_observacoes">Status</label>
													<input type="text" name="clie_estado" id="clie_estado" class="form-control" value="" />
												</div>
											</div>
										</div>
										<div class="row justify-content-end">
											<div class="col-12 col-md-2">
												<div class="form-group">
													<button type="button" name="clie_estado" id="clie_estado" class="form-control" value="">Add novo Arquivo</button>
												</div>
											</div>
										</div>
										-->


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
		
		$(document).on('click', '.cmdFiltrar', function (e) {
			e.preventDefault();

			let $bsc_vendedor = $("#bsc_vendedor").val();
			let $bsc_cliente = $("#bsc_cliente").val();
			let $bsc_data_inicial = $("#bsc_data_inicial").val();
			let $bsc_data_final = $("#bsc_data_final").val();
			let $bsc_status = $("#bsc_status").val();

			let $url = '';
			if( $bsc_vendedor.length > 0 )	{ $url = $url +'/vendedor:'+ $bsc_vendedor; }
			if( $bsc_cliente.length > 0 )	{ $url = $url +'/cliente:'+ $bsc_cliente; }
			if( $bsc_data_inicial.length > 0 )	{ $url = $url +'/data_inicial:'+ ($bsc_data_inicial); }
			if( $bsc_data_final.length > 0 )	{ $url = $url +'/data_final:'+ ($bsc_data_final); }
			if( $bsc_status.length > 0 )	{ $url = $url +'/status:'+ $bsc_status; }

			//console.log( site_url  +'historico/filtrar'+ $url );
			window.location.href = site_url  +'historico/filtrar'+ $url;
			return false;
		});
		$(document).on('click', '.cmdUpdateStatus', function (e) {
			e.preventDefault();

			let $this = $(this);
			let $codigo = $this.data( "codigo" );
			let $msg = $( ".msg-email" );

			Swal.fire({
				title: 'Atenção!',
				icon: 'warning',
				html:
					'Confirme a alteração de status deste pedido.',
				type: 'warning',
				showCancelButton: true,
				cancelButtonColor: "#AAAAAA",
				confirmButtonColor: "#3c973e",
				//confirmButtonColor: '$danger',
				//cancelButtonColor: '$success',
				confirmButtonText: 'Sim! Confirmo.',
				cancelButtonText: 'Cancelar',
				reverseButtons: true
			}).then(function(result) {
				if (result.value) {
					// ------------------------------------------------------
					let $formData = {
						venda_id: $codigo
					};

					$msg.html('Aguarde. Estamos processando').show();
					$.ajax({
						url: site_url  +'pedidos/ajaxform/ALTERAR-STATUS',
						method:"POST",
						type: "POST",
						dataType: "json",
						data: $formData,
						crossDomain: true,
						beforeSend: function(response) {
							console.log('1 beforeSend');
							console.log(response);
						},
						complete: function(response) { 
							//console.log('3 complete');
							//console.log(response);
						},
						success:function(response){
							console.log('2 success');
							console.log(response);
							$msg.html(response.error_msg).show();
						},
						error: function (jqXHR, textStatus, errorThrown) {
						}
					});
					// ------------------------------------------------------
				}
			});
		});
		$(document).on('click', '.cmdArquivarRegistro', function (e) {
			e.preventDefault();
			let $this = $(this);
			let $codigo = $this.data( "codigo" );
			let $row = $this.closest( ".trRow" );

			Swal.fire({
				title: 'Atenção!',
				icon: 'warning',
				html:
					'Confirme o arquivamento deste pedido.',
				type: 'warning',
				showCancelButton: true,
				cancelButtonColor: "#AAAAAA",
				confirmButtonColor: "#3c973e",
				//confirmButtonColor: '$danger',
				//cancelButtonColor: '$success',
				confirmButtonText: 'Sim! Confirmo.',
				cancelButtonText: 'Cancelar',
				reverseButtons: true
			}).then(function(result) {
				if (result.value) {
					// ------------------------------------------------------
					let $formData = {
						codigo: $codigo
					};

					$.ajax({
						url: site_url  +'historico/ajaxform/ARQUIVAR-REGISTRO',
						method:"POST",
						type: "POST",
						dataType: "json",
						data: $formData,
						crossDomain: true,
						beforeSend: function(response) {
							console.log('1 beforeSend');
							console.log(response);
						},
						complete: function(response) { 
							console.log('3 complete');
							console.log(response);
						},
						success:function(response){
							console.log('2 success');
							console.log(response);
							$row.remove();
						},
						error: function (jqXHR, textStatus, errorThrown) {
							console.log('4 error');
							console.log(errorThrown);
						}
					});
					// ------------------------------------------------------
				}
			});
		});
	});
	</script>

<?php $this->endSection('scripts'); ?>