<?php 
	$this->extend('templates/template_painel');
	$this->section('content'); 
?>

	<div class="box-breadcrumb">
		<div class="row">
			<div class="col-12">
				<h2 class="page-title">Equipamentos</h2>
			</div>
		</div>
	</div>

	<div id="app">
		<div class="row align-items-start">
			<div class="col-12 col-md-12">

				<FORM action="<?php echo(current_url()); ?>" method="post" name="formFieldsRegistro" id="formFieldsRegistro" enctype="multipart/form-data">
				<input type="text" name="eqto_id" id="eqto_id" value="<?php echo((isset($rs_dados->eqto_id) ? $rs_dados->eqto_id : ""));?>" />

				<div class="row align-items-start">
					<div class="col-12 col-md-12">

						<div class="card card-default">
							<div class="card-header-box">
								<div class="row align-items-center">
									<div class="col-12 col-md-6">
										
									</div>
									<div class="col-12 col-md-6">

										<div class="d-flex justify-content-end">
											<div style="margin-left: 5px;"><a href="<?php echo(site_url('equipamentos')); ?>" class="btn btn-sm btn-warning">Voltar</a></div>
											<div style="margin-left: 5px;"><input type="submit" class="btn btn-sm btn-success" value="Salvar" id="btnSubmitForm"></div>
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
													$eqto_ativo = (int)((isset($rs_dados->eqto_ativo) ? $rs_dados->eqto_ativo : "1")); 
													$ativo_s = ($eqto_ativo == "1" ? ' checked ' : '');
													$ativo_n = ($eqto_ativo != "1" ? ' checked ' : '');
												?>
												<div class="form-group">
													<div><label class="form-label" for="EMAIL">Registro Ativo?</label></div>
													<div>
														<div class="form-check-inline my-1">
															<div class="custom-control custom-radio">
																<input type="radio" name="eqto_ativo" id="ativo_s" class="custom-control-input" value="1" <?php echo($ativo_s)?> />
																<label class="custom-control-label" for="ativo_s">Sim</label>
															</div>
														</div>
														<div class="form-check-inline my-1">
															<div class="custom-control custom-radio">
																<input type="radio" name="eqto_ativo" id="ativo_n" class="custom-control-input" value="0" <?php echo($ativo_n)?> />
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
											<div class="col-12 col-md-12">
												<div class="form-group">
													<label class="form-label" for="eqto_titulo">Título do equipamento</label>
													<input type="text" name="eqto_titulo" id="eqto_titulo" class="form-control" value="<?php echo((isset($rs_dados->eqto_titulo) ? $rs_dados->eqto_titulo : ""));?>" />
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-12 col-md-4">
												<div class="form-group">
													<label class="form-label" for="eqto_tag">Tag</label>
													<input type="text" name="eqto_tag" id="eqto_tag" class="form-control cmdCheckEquipamento" value="<?php echo((isset($rs_dados->eqto_tag) ? $rs_dados->eqto_tag : ""));?>" />
												</div>
											</div>
											<div class="col-12 col-md-4">
												<div class="form-group">
													<label class="form-label" for="eqto_setor">Setor</label>
													<input type="text" name="eqto_setor" id="eqto_setor" class="form-control" value="<?php echo((isset($rs_dados->eqto_setor) ? $rs_dados->eqto_setor : ""));?>" />
												</div>
											</div>
											<div class="col-12 col-md-4">
												<div class="form-group">
													<label class="form-label" for="eqto_local">Local</label>
													<input type="text" name="eqto_local" id="eqto_local" class="form-control" value="<?php echo((isset($rs_dados->eqto_local) ? $rs_dados->eqto_local : ""));?>" />
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-12 col-md-4">
												<div class="form-group">
													<label class="form-label" for="eqto_capacidade">Capacidade</label>
													<input type="text" name="eqto_capacidade" id="eqto_capacidade" class="form-control" value="<?php echo((isset($rs_dados->eqto_capacidade) ? $rs_dados->eqto_capacidade : ""));?>" />
												</div>
											</div>
											<div class="col-12 col-md-4">
												<div class="form-group">
													<label class="form-label" for="eqto_fluido_ref">Fluído refrig.</label>
													<input type="text" name="eqto_fluido_ref" id="eqto_fluido_ref" class="form-control" value="<?php echo((isset($rs_dados->eqto_fluido_ref) ? $rs_dados->eqto_fluido_ref : ""));?>" />
												</div>
											</div>
											<div class="col-12 col-md-4">
												<div class="form-group">
													<label class="form-label" for="eqto_fabricante">Fabricante</label>
													<input type="text" name="eqto_fabricante" id="eqto_fabricante" class="form-control" value="<?php echo((isset($rs_dados->eqto_fabricante) ? $rs_dados->eqto_fabricante : ""));?>" />
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-12 col-md-6">
												<div class="form-group">
													<label class="form-label" for="eqto_modelo_cond">Modelo cond.</label>
													<input type="text" name="eqto_modelo_cond" id="eqto_modelo_cond" class="form-control" value="<?php echo((isset($rs_dados->eqto_modelo_cond) ? $rs_dados->eqto_modelo_cond : ""));?>" />
												</div>
											</div>
											<div class="col-12 col-md-6">
												<div class="form-group">
													<label class="form-label" for="eqto_modelo_evap">Modelo evap.</label>
													<input type="text" name="eqto_modelo_evap" id="eqto_modelo_evap" class="form-control" value="<?php echo((isset($rs_dados->eqto_modelo_evap) ? $rs_dados->eqto_modelo_evap : ""));?>" />
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-12 col-md-12">
												<div class="form-group">
													<label class="form-label" for="eqto_observacoes">Observações</label>
													<textarea name="eqto_observacoes" id="eqto_observacoes" class="form-control" rows="6"><?php echo((isset($rs_dados->eqto_observacoes) ? $rs_dados->eqto_observacoes : ""));?></textarea>
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

	<!-- Sweet Alert -->
	<link href="assets/plugins/sweet-alert2/sweetalert2.min.css" rel="stylesheet" type="text/css">
	<script src="assets/plugins/sweet-alert2/sweetalert2.min.js"></script>

	<script>
		$(document).ready(function () {
			$(document).on('blur', '#eqto_tag', function (e) {
				e.preventDefault();
				fct_check_equipamento();
			});
			$(document).on('change', '#clie_id', function (e) {
				e.preventDefault();
				fct_check_equipamento();
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
		var fct_check_equipamento = function(){
			let $eqto_tag = $( "#eqto_tag" ).val();
			let $clie_id = $( "#clie_id" ).val();
			let $eqto_id = $( "#eqto_id" ).val();

			if( $eqto_tag.length == 0 ){ return false; }

			// ------------------------------------------------------
			if( $clie_id.length == 0 ){
				Swal.fire({
					title: 'Atenção!',
					icon: 'warning',
					html:
						'Selecione um cliente <br>' +
						'para validar o número da TAG',
					confirmButtonText: 'Fechar',
					confirmButtonColor: "#0b8e8e",
				});
				return false;
			}

			// ------------------------------------------------------
			let $formData = {
				eqto_tag: $eqto_tag,
				clie_id: $clie_id,
				eqto_id: $eqto_id,
			};
			$.ajax({
				url: site_url  +'equipamentos/ajaxform/CHECK-EQUIPAMENTO',
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
					if( response.error_num == 1 ){
						$( "#btnSubmitForm" ).prop( "disabled", true );
						Swal.fire({
							title: 'Atenção!',
							icon: 'warning',
							html: response.error_msg,
							confirmButtonText: 'Fechar',
							confirmButtonColor: "#0b8e8e",
						});
						return false;
					}else{
						$( "#btnSubmitForm" ).prop( "disabled", false );
					}
					console.log(response);
				},
				error: function (jqXHR, textStatus, errorThrown) {
				}
			});
			// ------------------------------------------------------
		}
	</script>

<?php $this->endSection('scripts'); ?>