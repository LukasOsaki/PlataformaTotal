<?php 
	$this->extend('templates/template_painel');
	$this->section('content'); 
?>

	<div class="box-breadcrumb">
		<div class="row">
			<div class="col-12">
				<h2 class="page-title">Pendências</h2>
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
											<div style="margin-left: 5px;"><a href="<?php echo(site_url('pendencias')); ?>" class="btn btn-sm btn-warning">Voltar</a></div>
											<div style="margin-left: 5px;"><input type="submit" class="btn btn-sm btn-success" value="Salvar"></div>
										</div>

									</div>
								</div>
							</div>
							<div class="card-body">

								<div class="row ">
									<div class="col-12 col-md-8">

										<div class="row">
											<div class="col-12 col-md-3">
												<?php 
													$pend_dte_registro = (isset($rs_dados->pend_dte_registro) ? $rs_dados->pend_dte_registro : ""); 
													$pend_dte_registro = fct_formatdate($pend_dte_registro, 'd/m/Y');
												?>
												<div class="form-group">
													<label class="form-label" for="pend_dte_registro">Abertura do Chamado</label>
													<input type="text" name="pend_dte_registro" id="pend_dte_registro" class="form-control mask-date flatpickr_date" value="<?php echo($pend_dte_registro);?>" />
												</div>
											</div>
											<div class="col-12 col-md-3">
												<div class="row d-none">
													<!-- NAO ESTA SENDO UTILIZADO -->
													<div class="col-12 col-md-12">
														<?php 
															$pend_dte_compra = (isset($rs_dados->pend_dte_compra) ? $rs_dados->pend_dte_compra : ""); 
															$pend_dte_compra = fct_formatdate($pend_dte_compra, 'd/m/Y');
														?>
														<div class="form-group">
															<label class="form-label" for="pend_dte_compra">Comprado em</label>
															<input type="text" name="pend_dte_compra" id="pend_dte_compra" class="form-control mask-date flatpickr_date" value="<?php echo($pend_dte_compra);?>" />
														</div>
													</div>
												</div>
												<?php 
													$pend_dte_instalacao = (isset($rs_dados->pend_dte_instalacao) ? $rs_dados->pend_dte_instalacao : ""); 
													$pend_dte_instalacao = fct_formatdate($pend_dte_instalacao, 'd/m/Y');
												?>
												<div class="form-group">
													<label class="form-label" for="pend_dte_instalacao">Executado em</label>
													<input type="text" name="pend_dte_instalacao" id="pend_dte_instalacao" class="form-control mask-date flatpickr_date " value="<?php echo($pend_dte_instalacao);?>" />
												</div>
											</div>
											<div class="col-12 col-md-3">
												<?php 
													$_pend_tipo_serv = (isset($rs_dados->pend_tipo_serv) ? $rs_dados->pend_tipo_serv : "");
												?>
												<div class="form-group">
													<!-- Obs.: Tirar os itens: Atrasado e Pendente dessa coluna e colocar na coluna da “OS” (Substituir nome para “Status”) e incluir “Realizado” -->
													<label class="form-label" for="pend_tipo_serv">Tipo</label>
													<select class="form-select" name="pend_tipo_serv" id="pend_tipo_serv">
														<option value="" translate="no">- selecione -</option>
														<?php
														if( isset($rs_tipo_serv)){
															foreach ($rs_tipo_serv->getResult() as $row) {
																$categ_id = ($row->categ_id);
																$categ_titulo = ($row->categ_titulo);
																$selected = (($categ_id == $_pend_tipo_serv) ? "selected" : "");
														?>
															<option value="<?php echo($categ_id); ?>" <?php echo($selected); ?> translate="no"><?php echo($categ_titulo); ?></option>
														<?php
															}
														}
														?>
													</select>
												</div>
											</div>
											<div class="col-12 col-md-3">
												<?php 
													$_pend_status = (isset($rs_dados->pend_status) ? $rs_dados->pend_status : "");
												?>
												<div class="form-group">
													<!-- 
													Obs.: Tirar os itens: Atrasado e Pendente dessa coluna e colocar na coluna da “OS” (Substituir nome para “Status”) e incluir “Realizado”
														Atrasado | Pendente | Realizado
													-->
													<label class="form-label" for="pend_status">Status</label>
													<select class="form-select" name="pend_status" id="pend_status">
														<option value="" translate="no">- selecione -</option>
														<?php
														if( isset($rs_status)){
															foreach ($rs_status->getResult() as $row) {
																$categ_id = ($row->categ_id);
																$categ_titulo = ($row->categ_titulo);
																$selected = (($categ_id == $_pend_status) ? "selected" : "");
														?>
															<option value="<?php echo($categ_id); ?>" <?php echo($selected); ?> translate="no"><?php echo($categ_titulo); ?></option>
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

										<div class="row mt-3 mb-3">
											<div class="col-12 col-md-12">
												<div class="card" style="background-color: #d8ffec;">
													<div class="card-body" style="padding: 15px !important;">
														<div id="BOX-CONTENT-ITEM-TAG">
														<?php
														if( isset($rs_tags) ){
														$countItem = 0;
														foreach ($rs_tags->getResult() as $row) {
															$countItem++;
															$pendtag_id = (int)($row->pendtag_id);
															$pendtag_hashkey = ($row->pendtag_hashkey);
															$pendtag_tag = ($row->pendtag_tag);
															$pendtag_descricao = ($row->pendtag_descricao);
															$pendtag_anexos = '';
															$pendtag_observacoes = ($row->pendtag_observacoes);
														?>
															<div class="carBoxRow trRow">
																<div class="row">
																	<div class="col-12 col-md-3">
																		<div class="form-group">
																			<label class="form-label" for="pendtag_tag_<?php echo($countItem);?>">Tag</label>
																			<input type="text" name="pendtag_tag[]" id="pendtag_tag_<?php echo($countItem);?>" class="form-control" value="<?php echo($pendtag_tag);?>" />
																		</div>
																	</div>
																	<div class="col-12 col-md-9">
																		<div class="form-group">
																			<label class="form-label" for="pendtag_descricao_<?php echo($countItem);?>">Descrição</label>
																			<input type="text" name="pendtag_descricao[]" id="pendtag_descricao_<?php echo($countItem);?>" class="form-control" value="<?php echo($pendtag_descricao);?>" />
																		</div>
																	</div>
																	<div class="col-12 col-md-3">
																		<div class="form-group">
																			<label class="form-label" for="pendtag_anexos_<?php echo($countItem);?>">Arquivo Anexo <span style="color:red;">(disabled)</span></label>
																			<input type="file" name="pendtag_anexos[]" id="pendtag_anexos_<?php echo($countItem);?>" class="form-control" value="<?php echo($pendtag_anexos);?>" disabled />
																		</div>
																	</div>
																	<div class="col-12 col-md-9">
																		<div class="form-group">
																			<label class="form-label" for="pendtag_observacoes_<?php echo($countItem);?>">Observação</label>
																			<input type="text" name="pendtag_observacoes[]" id="pendtag_observacoes_<?php echo($countItem);?>" class="form-control" value="<?php echo($pendtag_observacoes);?>" />
																		</div>
																	</div>
																</div>
																<div class="row justify-content-start">
																	<div class="col-12 col-md-4">
																		<a href="javascript:;" style="padding: 3px 8px;" class="cmdDELETARIDTAG icon-delete" data-hashkey="<?php echo($pendtag_hashkey);?>"><i class="far fa-trash-alt"></i> Excluir Este Registro</a>
																		<input type="hidden" name="pendtag_id[]" id="pendtag_id_<?php echo($countItem);?>" value="<?php echo($pendtag_id);?>" />
																	</div>
																</div>
															</div>
														<?php
															}
														}
														?>
														</div>
														<a href="javascript:;" class="btn btn-sm btn-warning cmdAddNovaTAG">Adicionar Novo Equipamento </a>
													</div>
												</div>
											</div>
										</div>

									</div>
									<div class="col-12 col-md-4">

										<div class="row ">
											<div class="col-12">
												<div class="form-group">
													<label class="form-label" for="pend_coment_interno">Comentário Interno</label>
													<textarea name="pend_coment_interno" id="pend_coment_interno" class="form-control" rows="6"><?php echo((isset($rs_dados->pend_coment_interno) ? $rs_dados->pend_coment_interno : ""));?></textarea>
												</div>
											</div>
										</div>

										<div class="row ">
											<div class="col-12">
												<div class="form-group">
													<label class="form-label" for="pend_observacoes">Observações</label>
													<textarea name="pend_observacoes" id="pend_observacoes" class="form-control" rows="6"><?php echo((isset($rs_dados->pend_observacoes) ? $rs_dados->pend_observacoes : ""));?></textarea>
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

		.carBoxRow{
			border-bottom: 1px dashed #000000;
			margin-bottom: 20px;
			padding-bottom: 20px;
		}

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
	<!-- <script src="assets/painel/js/custom/documentation/forms/flatpickr-locale-br.js"></script> -->


	<!-- Sweet Alert -->
	<link href="assets/plugins/sweet-alert2/sweetalert2.min.css" rel="stylesheet" type="text/css">
	<script src="assets/plugins/sweet-alert2/sweetalert2.min.js"></script>


	<script id="mstcRowItemTag" type="text/x-jquery-tmpl">
		<div class="carBoxRow {{trRow}}">
			<div class="row">
				<div class="col-12 col-md-3">
					<div class="form-group">
						<label class="form-label" for="pendtag_tag_{{item}}">Tag</label>
						<input type="text" name="pendtag_tag[]" id="pendtag_tag_{{item}}" class="form-control" value="" />
					</div>
				</div>
				<div class="col-12 col-md-9">
					<div class="form-group">
						<label class="form-label" for="pendtag_descricao_{{item}}">Descrição</label>
						<input type="text" name="pendtag_descricao[]" id="pendtag_descricao_{{item}}" class="form-control" value="" />
					</div>
				</div>
				<div class="col-12 col-md-3">
					<div class="form-group">
						<label class="form-label" for="pendtag_anexos_{{item}}">Arquivo Anexo <span style="color:red;">(disabled)</span></label>
						<input type="file" name="pendtag_anexos[]" id="pendtag_anexos_{{item}}" class="form-control" value="" disabled />
					</div>
				</div>
				<div class="col-12 col-md-9">
					<div class="form-group">
						<label class="form-label" for="pendtag_observacoes_{{item}}">Observação</label>
						<input type="text" name="pendtag_observacoes[]" id="pendtag_observacoes_{{item}}" class="form-control" value="" />
					</div>
				</div>
			</div>
			<div class="row justify-content-start">
				<div class="col-12 col-md-4">
					<a href="javascript:;" style="padding: 3px 8px;" class="cmdREMOVEITEMTAG icon-delete"><i class="far fa-trash-alt"></i> Remover Este Box</a>
					<input type="hidden" name="pendtag_id[]" id="pendtag_id_{{item}}" value="" />
				</div>
			</div>
		</div>
	</script>

	<script>
	$(document).ready(function(){
		$.ajaxSetup({cache: false});

		$(document).on('click', '.cmdAddNovaTAG', function (e) {
			let templateData = {
				item: 1,
				trRow: 'trRow'
			};
			let template = $("#mstcRowItemTag").html();
			$('#BOX-CONTENT-ITEM-TAG').append(Mustache.render(template, templateData));

			let $el = $('#BOX-CONTENT-ITEM-TAG'); 	
			//$el.find(".mask-date-place").mask('00/00/0000', {placeholder: "dd/mm/yyyy", clearIfNotMatch: true});
			//$el.find('.mask-hours').mask('00:00:00', {placeholder: "00:00:00", clearIfNotMatch: true});
		});
		$(document).on('click', '.cmdREMOVEITEMTAG', function (e) {
			let $this = $(this);
			let $row = $this.closest( ".trRow" );

			Swal.fire({
				title: 'Atenção!',
				icon: 'warning',
				html:
					'Você está prestes a excluir este registro. <br />' +
					'Esta ação não poderá ser revertida.',
				type: 'warning',
				showCancelButton: true,
				cancelButtonColor: "#AAAAAA",
				confirmButtonColor: "#E96565",
				//confirmButtonColor: '$danger',
				//cancelButtonColor: '$success',
				confirmButtonText: 'Apagar',
				cancelButtonText: 'Cancelar',
				reverseButtons: true
			}).then(function(result) {
				if (result.value) {
					$row.remove();
					fct_count_item_tags();
				}
			});
		});
		$(document).on('click', '.cmdDELETARIDTAG', function (e) {
			let $this = $(this);
			let $hashkey = $this.data( "hashkey" );
			let $row = $this.closest( ".trRow" );

			Swal.fire({
				title: 'Atenção!',
				icon: 'warning',
				html:
					'Você está prestes a excluir este registro. '+ $hashkey +'<br />' +
					'Esta ação não poderá ser revertida.',
				type: 'warning',
				showCancelButton: true,
				cancelButtonColor: "#AAAAAA",
				confirmButtonColor: "#E96565",
				//confirmButtonColor: '$danger',
				//cancelButtonColor: '$success',
				confirmButtonText: 'Apagar',
				cancelButtonText: 'Cancelar',
				reverseButtons: true
			}).then(function(result) {
				if (result.value) {
					// ------------------------------------------------------
					let $formData = {
						hashkey: $hashkey,
					};
					$.ajax({
						url: site_url +'pendencias/ajaxform/EXCLUIR-PENDENCIA-TAG',
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
							fct_count_item_tags();
						},
						error: function (jqXHR, textStatus, errorThrown) {
						}
					});
					// ------------------------------------------------------
				}
			});
		}); 

		fct_count_item_tags();
	});
	var fct_count_item_tags = function(p, callback){
		let $box = $('#BOX-CONTENT-ITEM-TAG');
		let $qtdItem = $box.find('.trRow');
		if( $qtdItem.length == 0 ){
			$( ".cmdAddNovaTAG" ).trigger( "click" );	
		}
	}
	</script>


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