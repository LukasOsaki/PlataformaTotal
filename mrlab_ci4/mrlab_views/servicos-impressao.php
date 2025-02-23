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

			<FORM action="<?php echo (current_url()); ?>" method="post" name="formFieldsRegistro" id="formFieldsRegistro" enctype="multipart/form-data">

				<div class="row align-items-start">
					<div class="col-12 col-md-12">

						<div class="card card-default">
							<div class="card-header-box">
								<div class="row align-items-center">
									<div class="col-12 col-md-6">

									</div>
									<div class="col-12 col-md-6">

										<div class="d-flex justify-content-end">
											<div style="margin-left: 5px;"><a href="<?php echo (site_url('servicos')); ?>" class="btn btn-sm btn-warning">Voltar</a></div>
											<div style="margin-left: 5px;"><a href="javascript:;" onclick="printDIV('IMPRESSAO')" class="btn btn-sm btn-info">Imprimir</a></div>
										</div>

									</div>
								</div>
							</div>
							<div class="card-body">

								<div id="IMPRESSAO">
									<div>

										<div class="row justify-content-center">
											<div class="col-6">
												<div style="margin:0 auto;" class="text-center">
													<img src="<?php echo (base_url('assets/media/logo-white.png')); ?>" class="img-fluid" style="margin:0 auto; max-height: 100px;" />
												</div>
											</div>
										</div>
										<div class="row justify-content-center mt-4 mb-3">
											<div class="col-12">
												<div style="margin:0 auto;" class="text-center">
													<h2>ORDEM DE SERVIÇO</h2>
												</div>
											</div>
										</div>

										<div class="row ">
											<div class="col-12 col-md-12">

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
																if (isset($rs_clientes)) {
																	foreach ($rs_clientes->getResult() as $row) {
																		$clie_id = ($row->clie_id);
																		$clie_nome_razao = ($row->clie_nome_razao);
																		$clie_nome_fantasia = ($row->clie_nome_fantasia);
																		$selected = (($clie_id == $_clie_id) ? "selected" : "");
																?>
																		<option value="<?php echo ($clie_id); ?>" <?php echo ($selected); ?> translate="no"><?php echo ($clie_nome_fantasia); ?></option>
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
															<div><?php echo ((isset($rs_dados->pend_coment_interno) ? $rs_dados->pend_coment_interno : "")); ?></div>
														</div>
													</div>
												</div>

												<div class="row mt-2 mb-3">
													<div class="col-12 col-md-12">
														<div id="BOX-CONTENT-ITEM-TAG">
															<?php
															if (isset($rs_tags)) {
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
																					<div class="col-6 col-md-3">
																						<div class="form-group">
																							<label class="form-label" for="pendtag_dte_registro_<?php echo ($countItem); ?>">Abertura do Chamado</label>
																							<div><?php echo ($pendtag_dte_registro); ?></div>
																						</div>
																					</div>
																					<div class="col-6 col-md-3">
																						<div class="form-group">
																							<label class="form-label" for="pendtag_dte_instalacao_<?php echo ($countItem); ?>">Executado em</label>
																							<div><?php echo ($pendtag_dte_instalacao); ?></div>
																						</div>
																					</div>
																					<div class="col-6 col-md-3">
																						<div class="form-group">
																							<label class="form-label" for="pendtag_tipo_serv_<?php echo ($countItem); ?>">Tipo</label>
																							<select class="form-select" name="pendtag_tipo_serv[]" id="pendtag_tipo_serv_<?php echo ($countItem); ?>">
																								<option value="" translate="no">- selecione -</option>
																								<?php
																								if (isset($rs_tipo_serv)) {
																									foreach ($rs_tipo_serv->getResult() as $row) {
																										$categ_id = ($row->categ_id);
																										$categ_titulo = ($row->categ_titulo);
																										$selected = (($categ_id == $pendtag_tipo_serv) ? "selected" : "");
																								?>
																										<option value="<?php echo ($categ_id); ?>" <?php echo ($selected); ?> translate="no"><?php echo ($categ_titulo); ?></option>
																								<?php
																									}
																								}
																								?>
																							</select>
																						</div>
																					</div>
																					<div class="col-6 col-md-3">
																						<div class="form-group">
																							<label class="form-label" for="pendtag_status_<?php echo ($countItem); ?>">Status</label>
																							<select class="form-select" name="pendtag_status[]" id="pendtag_status_<?php echo ($countItem); ?>">
																								<option value="" translate="no">- selecione -</option>
																								<?php
																								if (isset($rs_status)) {
																									foreach ($rs_status->getResult() as $row) {
																										$categ_id = ($row->categ_id);
																										$categ_titulo = ($row->categ_titulo);
																										$selected = (($categ_id == $pendtag_status) ? "selected" : "");
																								?>
																										<option value="<?php echo ($categ_id); ?>" <?php echo ($selected); ?> translate="no"><?php echo ($categ_titulo); ?></option>
																								<?php
																									}
																								}
																								?>
																							</select>
																						</div>
																					</div>
																				</div>
																				<div class="row">
																					<div class="col-3 col-md-3">
																						<div class="form-group">
																							<label class="form-label" for="pendtag_tag_<?php echo ($countItem); ?>">Tag</label>
																							<div><?php echo ($eqto_tag); ?></div>
																						</div>
																					</div>
																					<div class="col-9 col-md-9">
																						<div class="form-group">
																							<div>
																								<label class="form-label" for="pendtag_equipamento_<?php echo ($countItem); ?>">Equipamento</label>
																								<div><?php echo ($pendtag_equipamento); ?></div>
																							</div>
																						</div>
																					</div>
																				</div>
																				<div class="row">
																					<div class="col-12 col-md-6">
																						<div class="form-group">
																							<label class="form-label" for="pendtag_descricao_<?php echo ($countItem); ?>">Descrição</label>
																							<div><?php echo ($pendtag_descricao); ?></div>
																						</div>
																					</div>
																					<div class="col-12 col-md-6">
																						<div class="form-group">
																							<label class="form-label" for="pendtag_observacoes_<?php echo ($countItem); ?>">Observação</label>
																							<div><?php echo ($pendtag_observacoes); ?></div>
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
													<div class="col-12 col-md-12 mt-3">
														<div id="BOX-CONTENT-MAT-UTILIZADO">
															<div class="card">
																<div class="card-header">
																	<h3>Materiais Utilizados</h3>
																</div>
																<div class="card-body">
																	<table class="table table-bordered table-striped">
																		<thead>
																			<tr>
																				<th>Qtd</th>
																				<th>Eqto</th>
																				<th>Tipo</th>
																				<th>Comentário</th>
																			</tr>
																		</thead>
																		<tbody id="table-content-mat-utilizado">
																			<?php
																			if (isset($rs_mats_utilizados)) {
																				$countItem = 0;
																				foreach ($rs_mats_utilizados->getResult() as $row) {
																					$countItem++;
																					$pend_mat_id = (int)($row->pend_mat_id);
																					$pend_mat_material = ($row->pend_mat_material);
																					$pend_mat_hashkey = ($row->pend_mat_hashkey);
																					$pend_mat_eqto = ($row->pend_mat_eqto);
																					$pend_mat_observacoes = ($row->pend_mat_observacoes);
																					$pend_mat_tipo = ($row->pend_mat_tipo);
																					$pend_mat_dte_compra = ($row->pend_mat_dte_compra);
																					$pend_mat_dte_disponivel = ($row->pend_mat_dte_disponivel);
																					$pend_mat_dte_utilizado = ($row->pend_mat_dte_utilizado);
																					$pend_mat_qtd = (int)($row->pend_mat_qtd);
																			?>
																					<tr class="trRow">
																						<td>
																							<input type="number" name="pend_mat_qtd[]" id="pend_mat_qtd_<?php echo ($countItem); ?>" class="form-control" value="<?php echo ($pend_mat_qtd); ?>" />
																						</td>
																						<td>
																							<input type="text" name="pend_mat_eqto[]" id="pend_mat_eqto_<?php echo ($countItem); ?>" class="form-control" value="<?php echo ($pend_mat_eqto); ?>" />
																						</td>
																						<td>
																							<input type="text" name="pend_mat_material[]" id="pend_mat_material_<?php echo ($countItem); ?>" class="form-control" value="<?php echo ($pend_mat_material); ?>" />
																						</td>
																						<td>
																							<input type="text" name="pend_mat_observacoes[]" id="pend_mat_observacoes<?php echo ($countItem); ?>" class="form-control" value="<?php echo ($pend_mat_observacoes); ?>" />
																							<input type="hidden" name="pend_mat_tipo[]" id="pend_mat_tipo<?php echo ($countItem); ?>" class="form-control" value="<?php echo ($pend_mat_tipo); ?>" />
																							<input type="hidden" name="pend_mat_dte_compra[]" id="pend_mat_dte_compra_<?php echo ($countItem); ?>" class="form-control" value="<?php echo ($pend_mat_dte_compra); ?>" />
																							<input type="hidden" name="pend_mat_dte_disponivel[]" id="pend_mat_dte_disponivel_<?php echo ($countItem); ?>" class="form-control" value="<?php echo ($pend_mat_dte_disponivel); ?>" />
																							<input type="hidden" name="pend_mat_dte_utilizado[]" id="pend_mat_dte_utilizado_<?php echo ($countItem); ?>" class="form-control" value="<?php echo ($pend_mat_dte_utilizado); ?>" />
																						</td>

																					</tr>
																			<?php
																				}
																			}
																			?>
																		</tbody>
																	</table>

																</div>

															</div>

														</div>
													</div>
													<div class="col-12 col-md-12 mt-3">
														<div id="BOX-CONTENT-MAT-SOLICITADO">
															<div class="card">
																<div class="card-header">
																	<h3>Materiais Solicitados</h3>
																</div>
																<div class="card-body">
																	<table class="table table-bordered table-striped">
																		<thead>
																			<tr>
																				<th>Qtd</th>
																				<th>Eqto</th>
																				<th>Tipo</th>
																				<th>Comentário</th>
																				<th>Dt Compra</th>
																				<th>Dt Disponível</th>
																				<th>Dt Utilizado</th>
																			</tr>
																		</thead>
																		<tbody id="table-content-mat-solicitado">
																			<?php
																			if (isset($rs_mats_solicitados)) {
																				$countItem = 0;
																				foreach ($rs_mats_solicitados->getResult() as $row) {
																					$countItem++;
																					$pend_mat_id = (int)($row->pend_mat_id);
																					$pend_mat_material = ($row->pend_mat_material);
																					$pend_mat_hashkey = ($row->pend_mat_hashkey);
																					$pend_mat_eqto = ($row->pend_mat_eqto);
																					$pend_mat_observacoes = ($row->pend_mat_observacoes);
																					$pend_mat_tipo = ($row->pend_mat_tipo);
																					$pend_mat_dte_compra = fct_formatdate($row->pend_mat_dte_compra, 'd/m/Y');
																					$pend_mat_dte_disponivel = fct_formatdate($row->pend_mat_dte_disponivel, 'd/m/Y');
																					$pend_mat_dte_utilizado = fct_formatdate($row->pend_mat_dte_utilizado, 'd/m/Y');
																					$pend_mat_qtd = (int)($row->pend_mat_qtd);
																			?>
																					<tr class="trRow">
																						<td>
																							<input type="number" name="pend_mat_qtd[]" id="pend_mat_qtd_<?php echo ($countItem); ?>" class="form-control" value="<?php echo ($pend_mat_qtd); ?>" />
																						</td>
																						<td>
																							<input type="text" name="pend_mat_eqto[]" id="pend_mat_eqto_<?php echo ($countItem); ?>" class="form-control" value="<?php echo ($pend_mat_eqto); ?>" />
																						</td>
																						<td>
																							<input type="text" name="pend_mat_material[]" id="pend_mat_material_<?php echo ($countItem); ?>" class="form-control" value="<?php echo ($pend_mat_material); ?>" />
																						</td>
																						<td>

																							<textarea name="pend_mat_observacoes[]" id="pend_mat_observacoes<?php echo ($countItem); ?>" class="form-control" rows="1" ><?php echo ($pend_mat_observacoes); ?></textarea>
																							<!-- <input type="text" name="pend_mat_observacoes[]" id="pend_mat_observacoes<?php echo ($countItem); ?>" class="form-control" value="<?php echo ($pend_mat_observacoes); ?>" /> -->
																							<input type="hidden" name="pend_mat_tipo[]" id="pend_mat_tipo<?php echo ($countItem); ?>" class="form-control" value="<?php echo ($pend_mat_tipo); ?>" />
																						</td>
																						<td>
																							<input type="text" name="pend_mat_dte_compra[]" id="pend_mat_dte_compra_<?php echo ($countItem); ?>" class="form-control mask-date flatpickr_date" value="<?php echo ($pend_mat_dte_compra); ?>" />
																						</td>
																						<td>
																							<input type="text" name="pend_mat_dte_disponivel[]" id="pend_mat_dte_disponivel_<?php echo ($countItem); ?>" class="form-control mask-date flatpickr_date" value="<?php echo ($pend_mat_dte_disponivel); ?>" />
																						</td>
																						<td>
																							<input type="text" name="pend_mat_dte_utilizado[]" id="pend_mat_dte_utilizado_<?php echo ($countItem); ?>" class="form-control mask-date flatpickr_date" value="<?php echo ($pend_mat_dte_utilizado); ?>" />
																						</td>

																					</tr>
																			<?php
																				}
																			}
																			?>
																		</tbody>
																	</table>
																</div>
																<div class="card-footer">
																	<a href="javascript:;" class="btn btn-sm btn-warning cmdAddNovoMatSolicitado">Adicionar Material Solicitado</a>
																</div>

															</div>

														</div>
													</div>
												</div>

											</div>
										</div>

										<div>
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
			.eqto_error {
				display: none;
				background-color: #ed3838;

				border-radius: .25rem;
				font-size: .65rem;
				padding: 1px 8px;
				margin-top: 2px;
				color: white;
			}

			.eqto_error.active {
				display: table;
			}

			.tag-delete {
				padding: 4px 12px;
				background-color: #ff4343;
				border-radius: .25rem;
				color: white;
				font-size: .7rem;
				font-weight: 400;
			}

			.list_cart {
				margin: 3px 0;
			}

			.list_cart a {
				border: 1px solid #ebeced;
				padding: 8px;
				display: block;
				border-radius: 0.25rem;
				color: #000;
			}

			.list_cart a:hover {
				background-color: #edeeef;
				color: #000;
			}

			.card.cardboxtag {
				background-color: #d8ffec;
				border: 4px solid #cccccc;
			}

			.card.cardboxtag:hover {
				background-color: #ebebeb;
			}

			.carBoxRow {
				/*border-bottom: 1px dashed #000000;*/
				/*margin-bottom: 20px;*/
				/*padding-bottom: 20px;*/
			}

			.table-box {
				width: 100%;
				border: 1px solid #f2f2f2;
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

			.trRowError {
				background-color: #ffcfcf !important;
				border: 4px solid #ff0000 !important;
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
			function printDIV(i) {
				var cssEstilos = '';
				var imp = window.open('', 'div', 'width=' + window.innerWidth + ',height=' + window.innerWidth);

				var cSs = document.querySelectorAll("link[rel='stylesheet']");
				for (x = 0; x < cSs.length; x++) {
					cssEstilos += '<link rel="stylesheet" href="' + cSs[x].href + '">';
				}

				imp.document.write('<html><head><title>' + document.title + '</title>');
				imp.document.write(cssEstilos + '</head><body>');
				imp.document.write(document.getElementById(i).innerHTML);
				imp.document.write('</body></html>');

				setTimeout(function() {
					imp.print();
					imp.close();
				}, 500);
			}
			printDIV('IMPRESSAO');
		</script>

		<?php $this->endSection('scripts'); ?>