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
												<button class="nav-link" id="nav-arquivos-tab" data-bs-toggle="tab" data-bs-target="#nav-arquivos" type="button" role="tab" aria-controls="nav-arquivos" aria-selected="false">Documentos / Arquivos</button>
											</div>
										</nav>
										<div class="tab-content border" id="nav-tabContent" style="padding: 2rem 1rem; border-radius: 8px !important; border-top-left-radius: 0px !important;">
											<div class="tab-pane fade active show" id="nav-principal" role="tabpanel" aria-labelledby="nav-principal-tab">

												<div class="row">
													<div class="col-12 col-md-12">
														<div class="form-group">
															<label class="form-label" for="clie_nome_razao">Nome / Razão Social</label>
															<input type="text" name="clie_nome_razao" id="clie_nome_razao" class="form-control" value="<?php echo((isset($rs_dados->clie_nome_razao) ? $rs_dados->clie_nome_razao : ""));?>" readonly="readonly" onfocus="this.blur();" />
														</div>
													</div>
												</div>

												<div class="row">
													<div class="col-12 col-md-7">
														<div class="form-group">
															<label class="form-label" for="clie_nome_fantasia">Nome Fantasia</label>
															<input type="text" name="clie_nome_fantasia" id="clie_nome_fantasia" class="form-control" value="<?php echo((isset($rs_dados->clie_nome_fantasia) ? $rs_dados->clie_nome_fantasia : ""));?>" readonly="readonly" onfocus="this.blur();" />
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
																	<input type="text" name="clie_dte_ini_contrato" id="clie_dte_ini_contrato" class="form-control" value="<?php echo($clie_dte_ini_contrato);?>" readonly="readonly" onfocus="this.blur();" />
																</div>
															</div>
															<div class="col-12 col-md-6">
																<?php 
																	$clie_dte_end_contrato = (isset($rs_dados->clie_dte_end_contrato) ? $rs_dados->clie_dte_end_contrato : ""); 
																	$clie_dte_end_contrato = fct_formatdate($clie_dte_end_contrato, 'd/m/Y');
																?>
																<div class="form-group">
																	<label class="form-label" for="clie_dte_end_contrato">Término Contrato</label>
																	<input type="text" name="clie_dte_end_contrato" id="clie_dte_end_contrato" class="form-control" value="<?php echo($clie_dte_end_contrato);?>" readonly="readonly" onfocus="this.blur();" />
																</div>
															</div>
														</div>

													</div>
												</div>

												<div class="row">
													<div class="col-12 col-md-6">
														<div class="form-group">
															<label class="form-label" for="clie_email">E-mail</label>
															<input type="text" name="clie_email" id="clie_email" class="form-control" value="<?php echo((isset($rs_dados->clie_email) ? $rs_dados->clie_email : ""));?>" readonly="readonly" onfocus="this.blur();" />
														</div>
													</div>
													<div class="col-12 col-md-6">
														<div class="form-group">
															<label class="form-label" for="clie_cnpj">CNPJ</label>
															<input type="text" name="clie_cnpj" id="clie_cnpj" class="form-control mask-cnpj" value="<?php echo((isset($rs_dados->clie_cnpj) ? $rs_dados->clie_cnpj : ""));?>" readonly="readonly" onfocus="this.blur();" />
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-12 col-md-2">
														<div class="form-group">
															<label class="form-label" for="clie_cep">CEP</label>
															<input type="text" name="clie_cep" id="clie_cep" class="form-control" value="<?php echo((isset($rs_dados->clie_cep) ? $rs_dados->clie_cep : ""));?>" readonly="readonly" onfocus="this.blur();" />
														</div>
													</div>
													<div class="col-12 col-md-6">
														<div class="form-group">
															<label class="form-label" for="clie_endereco">Endereço</label>
															<input type="text" name="clie_endereco" id="clie_endereco" class="form-control" value="<?php echo((isset($rs_dados->clie_endereco) ? $rs_dados->clie_endereco : ""));?>" readonly="readonly" onfocus="this.blur();" />
														</div>
													</div>
													<div class="col-12 col-md-4">
														<div class="form-group">
															<label class="form-label" for="clie_end_numero">Numero</label>
															<input type="text" name="clie_end_numero" id="clie_end_numero" class="form-control" value="<?php echo((isset($rs_dados->clie_end_numero) ? $rs_dados->clie_end_numero : ""));?>" readonly="readonly" onfocus="this.blur();" />
														</div>
													</div>
												</div>

												<div class="row">
													<div class="col-12 col-md-3">
														<div class="form-group">
															<label class="form-label" for="clie_end_compl">Complemento</label>
															<input type="text" name="clie_end_compl" id="clie_end_compl" class="form-control" value="<?php echo((isset($rs_dados->clie_end_compl) ? $rs_dados->clie_end_compl : ""));?>" readonly="readonly" onfocus="this.blur();" />
														</div>
													</div>
													<div class="col-12 col-md-3">
														<div class="form-group">
															<label class="form-label" for="clie_bairro">Bairro</label>
															<input type="text" name="clie_bairro" id="clie_bairro" class="form-control" value="<?php echo((isset($rs_dados->clie_bairro) ? $rs_dados->clie_bairro : ""));?>" readonly="readonly" onfocus="this.blur();" />
														</div>
													</div>
													<div class="col-12 col-md-4">
														<div class="form-group">
															<label class="form-label" for="clie_cidade">Cidade</label>
															<input type="text" name="clie_cidade" id="clie_cidade" class="form-control" value="<?php echo((isset($rs_dados->clie_cidade) ? $rs_dados->clie_cidade : ""));?>" readonly="readonly" onfocus="this.blur();" />
														</div>
													</div>
													<div class="col-12 col-md-2">
														<div class="form-group">
															<label class="form-label" for="clie_estado">Estado</label>
															<input type="text" name="clie_estado" id="clie_estado" class="form-control" value="<?php echo((isset($rs_dados->clie_estado) ? $rs_dados->clie_estado : ""));?>" readonly="readonly" onfocus="this.blur();" />
														</div>
													</div>
												</div>

												<div class="row">
													<div class="col-12 col-md-12">
														<div class="form-group">
															<label class="form-label" for="clie_observacoes">Observações</label>
															<textarea name="clie_observacoes" id="clie_observacoes" class="form-control" rows="6" readonly="readonly" onfocus="this.blur();"><?php echo((isset($rs_dados->clie_observacoes) ? $rs_dados->clie_observacoes : ""));?></textarea>
														</div>
													</div>
												</div>
												
											</div>
											<div class="tab-pane fade" id="nav-arquivos" role="tabpanel" aria-labelledby="nav-arquivos-tab">

												<div class="row gx-2">
													<div class="col-12 col-md-3">
														<div class="form-group">
															<label class="form-label" for="clie_observacoes">Nome do Documento</label>
														</div>
													</div>
													<div class="col-12 col-md">
														<div class="row gx-2">
															<div class="col-12 col-md-6">
																<div class="form-group">
																	<label class="form-label">Data</label>
																</div>
															</div>
															<div class="col-12 col-md-6">
																<div class="form-group">
																	<label class="form-label">Validade</label>
																</div>
															</div>
														</div>
													</div>

													<div class="col-12 col-md-3">
														<div class="form-group">
															<label class="form-label" for="clie_observacoes">Anexo</label>
														</div>
													</div>
													<div class="col-12 col-md-2">
														<div class="form-group">
															<label class="form-label" for="clie_observacoes">Status</label>
														</div>
													</div>
													<div class="col-12 col-md-auto" style="width: 50px;">
														<div class="form-group">
															&nbsp;
														</div>
													</div>
												</div>
												<div class="row gx-2">
													<div class="col-12 col-md-12">
														<hr class="m-0 mb-2" style="color: #ffbf00;">
													</div>
												</div>

												<div id="BOX-CONTENT-ITEM-ARQUIVO">
													<?php
													if(  isset($rs_list_arquivos) ){
														$count = 0;
														foreach ($rs_list_arquivos->getResult() as $row) {
															$count++;
															$arq_id = (int)($row->arq_id);
															$clie_id = (int)($row->clie_id);
															$arq_hashkey = ($row->arq_hashkey);
															$arq_hash_item = ($row->arq_hash_item);
															$arq_nome_doc = ($row->arq_nome_doc);
															$arq_anexo = ($row->arq_anexo);
															$arq_data = ($row->arq_data);
															$arq_data = fct_formatdate($arq_data, 'd/m/Y');
															$arq_validade = ($row->arq_validade);
															$arq_validade = fct_formatdate($arq_validade, 'd/m/Y');
															$arq_ativo = (int)($row->arq_ativo);

															$label_anexo = "Escolher Arquivo";
															$link_download = "javascript:;";
															if(!empty($arq_anexo) ){ 
																$label_anexo = $arq_anexo;
																$link_download = base_url($folder_upload .'documentos/'. $arq_anexo);
															}
													?>
														<div class="trRow mb-2">
															<div class="row gx-2 align-items-end">
																<div class="col-12 col-md-3">
																	<div class="form-group">
																		<input type="text" name="arq_nome_doc[<?php echo( $arq_hash_item ); ?>]" id="arq_nome_doc_<?php echo( $arq_hash_item ); ?>" class="form-control form-control-sm" value="<?php echo( $arq_nome_doc ); ?>" readonly="readonly" onfocus="this.blur();" />
																	</div>
																</div>
																<div class="col-12 col-md">
																	<div class="row gx-2 align-items-end">
																		<div class="col-12 col-md-6">
																			<div class="form-group">
																				<input type="text" name="arq_data[<?php echo( $arq_hash_item ); ?>]" id="arq_data_<?php echo( $arq_hash_item ); ?>" class="form-control form-control-sm mask-date" value="<?php echo( $arq_data ); ?>" readonly="readonly" onfocus="this.blur();" />
																			</div>
																		</div>
																		<div class="col-12 col-md-6">
																			<div class="form-group">
																				<input type="text" name="arq_validade[<?php echo( $arq_hash_item ); ?>]" id="arq_validade_<?php echo( $arq_hash_item ); ?>" class="form-control form-control-sm mask-date" value="<?php echo( $arq_validade ); ?>" readonly="readonly" onfocus="this.blur();" />
																			</div>
																		</div>
																	</div>
																</div>
																<div class="col-12 col-md-3">
																	<div class="form-group d-flex">
																		<label for="arq_anexo_<?php echo( $arq_hash_item ); ?>"><span><?php echo( $label_anexo ); ?></span></label>
																		<?php if(!empty($arq_anexo) ){ ?>
																		<div style="width: 50px;">
																			<a href="<?php echo( $link_download ); ?>" target="_blank" style="font-size: 1.5rem; color: #00af29; padding: 0 8px;"><i class="las la-file-download"></i></a>
																		</div>
																		<?php } ?>
																	</div>
																</div>
																<div class="col-12 col-md-2">
																	<div class="form-group">
																		<select class="form-select form-select-sm" disabled name="arq_status[<?php echo( $arq_hash_item ); ?>]" id="arq_status_<?php echo( $arq_hash_item ); ?>">
																			<option value="" translate="no">- selecione -</option>
																			<?php
																			if( isset($cfgStatus)){
																				foreach ($cfgStatus as $key => $val) {
																					$label = $val['label'];
																					$value = $val['value'];
																					$selected = (($value == $arq_ativo) ? ' selected ' : '');
																				?>
																					<option value="<?php echo($value); ?>" <?php echo($selected); ?> translate="no"><?php echo($label); ?></option>
																			<?php
																				}
																			}
																			?>
																		</select>
																	</div>
																</div>
																<div class="col-12 col-md-auto align-self-center" style="width: 50px;">
																	&nbsp;
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