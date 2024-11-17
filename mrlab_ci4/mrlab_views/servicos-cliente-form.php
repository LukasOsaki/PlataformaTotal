<?php 
	$this->extend('templates/template_painel');
	$this->section('content'); 
?>

	<div class="box-breadcrumb">
		<div class="row">
			<div class="col-12">
				<h2 class="page-title">Serviços</h2>
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

										<div class="d-flex justify-content-end">
											<div style="margin-left: 5px;"><a href="<?php echo(site_url('servicos')); ?>" class="btn btn-sm btn-warning">Voltar</a></div>
										</div>

									</div>
								</div>
							</div>
							<div class="card-body">

								<div class="row ">
									<div class="col-12 col-md-12">

										<div class="row d-none">
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

										<div class="row ">
											<div class="col-12">
												<div class="form-group">
													<label class="form-label" for="pend_coment_interno">Comentário Interno</label>
													<textarea name="pend_coment_interno" id="pend_coment_interno" class="form-control" rows="4" readonly="readonly" onfocus="this.blur();"><?php echo((isset($rs_dados->pend_coment_interno) ? $rs_dados->pend_coment_interno : ""));?></textarea>
												</div>
											</div>
										</div>

										<div class="row mt-2 mb-3">
											<div class="col-12 col-md-12">
												<div id="BOX-CONTENT-ITEM-TAG">
												<?php
												if( isset($rs_tags) ){
												$countItem = 0;

												//print '<pre>';
												//print_r( $rs_tags->getResult() );
												//print '</pre>';
												foreach ($rs_tags->getResult() as $row) {
													$countItem++;
													$pendtag_id = (int)($row->pendtag_id);
													$pendtag_hashkey = ($row->pendtag_hashkey);
													
													$pendtag_dte_registro = fct_formatdate($row->pendtag_dte_registro, 'd/m/Y');
													$pendtag_dte_instalacao = fct_formatdate($row->pendtag_dte_instalacao, 'd/m/Y');
													$pendtag_tipo_serv = ($row->pendtag_tipo_serv);
													$pendtag_status = ($row->pendtag_status);

													$eqto_id = (int)($row->eqto_id);
													$eqto_tag = ($row->eqto_tag);
													$pendtag_equipamento = ($row->eqto_titulo);

													$pendtag_tag = ($row->pendtag_tag);
													$pendtag_descricao = ($row->pendtag_descricao);
													$pendtag_anexos = '';
													$pendtag_observacoes = ($row->pendtag_observacoes);
												?>
												<div class="card cardboxtag mb-3 trRow">
													<div class="card-body" style="padding: 15px !important;">
														<div class="carBoxRow">
															<div class="row">
																<div class="col-12 col-md-3">
																	<div class="form-group">
																		<label class="form-label" for="pendtag_dte_registro_<?php echo($countItem);?>">Abertura do Chamado</label>
																		<input type="text" name="pendtag_dte_registro[]" id="pendtag_dte_registro_<?php echo($countItem);?>" class="form-control" value="<?php echo($pendtag_dte_registro);?>" readonly="readonly" onfocus="this.blur();" />
																	</div>
																</div>
																<div class="col-12 col-md-3">
																	<div class="form-group">
																		<label class="form-label" for="pendtag_dte_instalacao_<?php echo($countItem);?>">Executado em</label>
																		<input type="text" name="pendtag_dte_instalacao[]" id="pendtag_dte_instalacao_<?php echo($countItem);?>" class="form-control" value="<?php echo($pendtag_dte_instalacao);?>" readonly="readonly" onfocus="this.blur();" />
																	</div>
																</div>
																<div class="col-12 col-md-3">
																	<div class="form-group">
																		<label class="form-label" for="pendtag_tipo_serv_<?php echo($countItem);?>">Tipo</label>
																		<select class="form-select" name="pendtag_tipo_serv[]" id="pendtag_tipo_serv_<?php echo($countItem);?>" disabled >
																			<option value="" translate="no">- selecione -</option>
																			<?php
																			if( isset($rs_tipo_serv)){
																				foreach ($rs_tipo_serv->getResult() as $row) {
																					$categ_id = ($row->categ_id);
																					$categ_titulo = ($row->categ_titulo);
																					$selected = (($categ_id == $pendtag_tipo_serv) ? "selected" : "");
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
																	<div class="form-group">
																		<label class="form-label" for="pendtag_status_<?php echo($countItem);?>">Status</label>
																		<select class="form-select" name="pendtag_status[]" id="pendtag_status_<?php echo($countItem);?>" disabled >
																			<option value="" translate="no">- selecione -</option>
																			<?php
																			if( isset($rs_status)){
																				foreach ($rs_status->getResult() as $row) {
																					$categ_id = ($row->categ_id);
																					$categ_titulo = ($row->categ_titulo);
																					$selected = (($categ_id == $pendtag_status) ? "selected" : "");
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
																<div class="col-12 col-md-3">
																	<div class="form-group">
																		<label class="form-label" for="pendtag_tag_<?php echo($countItem);?>">Tag</label>
																		<input type="text" name="pendtag_tag[]" id="pendtag_tag_<?php echo($countItem);?>" class="form-control cmdBuscaEquipamento" value="<?php echo($eqto_tag);?>" readonly="readonly" onfocus="this.blur();" />
																		<input type="hidden" name="pendtag_eqto_id[]" id="pendtag_eqto_id_<?php echo($countItem);?>" class="form-control eqto_id" value="<?php echo($eqto_id);?>" readonly="readonly" onfocus="this.blur();" />
																	</div>
																</div>
																<div class="col-12 col-md-9">
																	<div class="form-group">
																		<div>
																			<label class="form-label" for="pendtag_equipamento_<?php echo($countItem);?>">Equipamento</label>
																			<input type="text" name="pendtag_equipamento[]" id="pendtag_equipamento_<?php echo($countItem);?>" class="form-control eqto_titulo" value="<?php echo($pendtag_equipamento);?>" readonly="readonly" onfocus="this.blur();" readonly="readonly" onfocus="this.blur();" />
																		</div>
																		<div class="eqto_error"></div>
																	</div>
																</div>
																<div class="col-12 col-md-4 d-none">
																	<div class="form-group">
																		<label class="form-label" for="pendtag_anexos_<?php echo($countItem);?>">Arquivo Anexo <span style="color:red;">(disabled)</span></label>
																		<input type="file" name="pendtag_anexos[]" id="pendtag_anexos_<?php echo($countItem);?>" class="form-control" value="<?php echo($pendtag_anexos);?>" disabled />
																	</div>
																</div>
															</div>
															<div class="row">
																<div class="col-12 col-md-6">
																	<div class="form-group">
																		<label class="form-label" for="pendtag_descricao_<?php echo($countItem);?>">Descrição</label>
																		<input type="text" name="pendtag_descricao[]" id="pendtag_descricao_<?php echo($countItem);?>" class="form-control" value="<?php echo($pendtag_descricao);?>" readonly="readonly" onfocus="this.blur();" />
																	</div>
																</div>
																<div class="col-12 col-md-6">
																	<div class="form-group">
																		<label class="form-label" for="pendtag_observacoes_<?php echo($countItem);?>">Observação</label>
																		<input type="text" name="pendtag_observacoes[]" id="pendtag_observacoes_<?php echo($countItem);?>" class="form-control" value="<?php echo($pendtag_observacoes);?> " readonly="readonly" onfocus="this.blur();" />
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
												<?php
													}
												}
												?>
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
		.tag-delete{
			padding: 4px 12px;
			background-color: #ff4343;
			border-radius: .25rem;
			color: white;
			font-size: .7rem;
			font-weight: 400;		
		}
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
		.card.cardboxtag{
			background-color: #d8ffec;
			border: 4px solid #cccccc;
		}
		.card.cardboxtag:hover{
			background-color: #ebebeb;
		}
		.carBoxRow{
			/*border-bottom: 1px dashed #000000;*/
			/*margin-bottom: 20px;*/
			/*padding-bottom: 20px;*/
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