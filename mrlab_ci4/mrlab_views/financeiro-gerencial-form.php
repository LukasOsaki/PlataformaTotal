<?php
$this->extend('templates/template_painel');
$this->section('content');
?>

<div class="box-breadcrumb">
	<div class="row">
		<div class="col-12">
			<h2 class="page-title">Financeiro Gerencial</h2>
		</div>
	</div>
</div>

<div id="app">
	<div class="row align-items-start">
		<div class="col-12 col-md-12">
			<?php if (isset($rs_dados->finc_id)) : ?>
				<form action="<?php echo (current_url()); ?>" method="post" name="formFieldsRegistro" id="formFieldsRegistro" enctype="multipart/form-data">

					<div class="row align-items-start">
						<div class="col-12 col-md-12">

							<div class="card card-default">
								<div class="card-header-box">
									<div class="row align-items-center">
										<div class="col-12 col-md-6">

										</div>
										<div class="col-12 col-md-6">

											<div class="d-flex justify-content-end">
												<div style="margin-left: 5px;"><a href="<?php echo (site_url('financeiro')); ?>" class="btn btn-sm btn-warning">Voltar</a></div>
												<div style="margin-left: 5px;"><input type="submit" class="btn btn-sm btn-success" value="Salvar"></div>
											</div>

										</div>
									</div>
								</div>
								<div class="card-body">

									<div class="row" id="ativo">
										<div class="col-12 col-md-12">

											<div class="row">
												<div class="col-12">
													<?php
													$finc_ativo = (int)((isset($rs_dados->finc_ativo) ? $rs_dados->finc_ativo : "1"));
													$ativo_s = ($finc_ativo == "1" ? ' checked ' : '');
													$ativo_n = ($finc_ativo != "1" ? ' checked ' : '');
													?>
													<div class="form-group">
														<div><label class="form-label" for="EMAIL">Registro Ativo?</label></div>
														<div>
															<div class="form-check-inline my-1">
																<div class="custom-control custom-radio">
																	<input type="radio" name="finc_ativo" id="ativo_s" class="custom-control-input" value="1" <?php echo ($ativo_s) ?> />
																	<label class="custom-control-label" for="ativo_s">Sim</label>
																</div>
															</div>
															<div class="form-check-inline my-1">
																<div class="custom-control custom-radio">
																	<input type="radio" name="finc_ativo" id="ativo_n" class="custom-control-input" value="0" <?php echo ($ativo_n) ?> />
																	<label class="custom-control-label" for="ativo_n">Não</label>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>

										</div>
									</div>
									<div class="row" id="tpConta class perd">
										<div class="col-12 col-md-4">

											<div class="form-group">
												<label class="form-label" for="finc_tipo_id">Tipo de Conta</label>

												<select name="finc_tipo_id" id="finc_tipo_id" class="form-select">
													<option value="" translate="no">Selecione</option>
													<?php
													foreach ($rs_list_tipo->getResult() as $row) {
														// Verifica se a sigla atual é a mesma do valor armazenado
														$selectedTipo = (isset($rs_dados->finc_tipo_id) &&
															$rs_dados->finc_tipo_id === $row->finc_tipo_id) ? "selected" : "";
													?>
														<option value="<?php echo htmlspecialchars($row->finc_tipo_id); ?>"
															<?php echo $selectedTipo; ?>>
															<?php echo htmlspecialchars($row->finc_tipo_nome); ?>
														</option>
													<?php
													}
													?>
												</select>

											</div>

										</div>
										<div class="col-12 col-md-4">
											<div class="form-group">
												<label class="form-label" for="finc_class_id">Classificação</label>
												<select name="finc_class_id" id="finc_class_id" class="form-select">
													<option value="" translate="no">Selecione</option>
													<?php
													foreach ($rs_list_class->getResult() as $row) {
														// Verifica se a sigla atual é a mesma do valor armazenado
														$selectedClass = (isset($rs_dados->finc_class_id) && $rs_dados->finc_class_id === $row->finc_class_id) ? "selected" : "";
													?>
														<option value="<?php echo htmlspecialchars($row->finc_class_id); ?>" <?php echo $selectedClass; ?>>
															<?php echo htmlspecialchars($row->finc_class_nome); ?>
														</option>
													<?php
													}
													?>
												</select>
											</div>
										</div>
										<div class="col-12 col-md-4">
											<div class="form-group">
												<label class="form-label" for="finc_periodicidade">Periodicidade</label>
												<select name="finc_periodicidade" id="finc_periodicidade" class="form-select">
													<option value="" translate="no">Selecione</option>
													<?php
													foreach ($cfgPeriodos as $row) {
														// Verifica se a sigla atual é a mesma do valor armazenado
														$selectedPeriodo = (isset($rs_dados->finc_periodicidade) && $rs_dados->finc_periodicidade === $row['value']) ? "selected" : "";
													?>
														<option value="<?php echo htmlspecialchars($row['value']); ?>" <?php echo $selectedPeriodo; ?>>
															<?php echo htmlspecialchars($row['value']); ?>
														</option>
													<?php
													}
													?>
												</select>
											</div>
										</div>
									</div>
									<div class="row" id="tp e nm">
										<div class="col-12 col-md-6">
											<div class="form-group">
												<label class="form-label" for="finc_tipo">Tipo</label>
												<input type="text" name="finc_tipo" id="finc_tipo" class="form-control"
													value="<?php echo ((isset($rs_dados->finc_tipo) ? $rs_dados->finc_tipo : "")); ?>" />
											</div>
										</div>
										<div class="col-12 col-md-6">
											<div class="form-group">
												<label class="form-label" for="finc_nome">Nome</label>
												<input type="text" name="finc_nome" id="finc_nome" class="form-control"
													value="<?php echo ((isset($rs_dados->finc_nome) ? $rs_dados->finc_nome : "")); ?>" />
											</div>
										</div>
									</div>
									<div class="row" id="tp e nm">
										<div class="col-12 col-md-3">
											<div class="form-group">
												<label class="form-label" for="finc_centro_custo">Centro de Custo</label>
												<input type="text" name="finc_centro_custo" id="finc_centro_custo" class="form-control"
													value="<?php echo ((isset($rs_dados->finc_centro_custo) ? $rs_dados->finc_centro_custo : "")); ?>" />
											</div>
										</div>
										<div class="col-12 col-md-3">
											<div class="form-group">
												<label class="form-label" for="finc_nr_parcela">N° Parcela</label>
												<input type="number" name="finc_nr_parcela" id="finc_nr_parcela" class="form-control"
													value="<?php echo ((isset($rs_dados->finc_nr_parcela) ? $rs_dados->finc_nr_parcela : "")); ?>" />
											</div>
										</div>
										<div class="col-12 col-md-3">
											<div class="form-group">
												<label class="form-label" for="finc_nr_parcela_total">N° Total de Parcelas</label>
												<input type="number" name="finc_nr_parcela_total" id="finc_nr_parcela_total" class="form-control"
													value="<?php echo ((isset($rs_dados->finc_nr_parcela_total) ? $rs_dados->finc_nr_parcela_total : "")); ?>" />
											</div>
										</div>

										<div class="col-12 col-md-3">
											<?php
											$finc_dte_vencimento = (isset($rs_dados->finc_dte_vencimento) ? $rs_dados->finc_dte_vencimento : "");
											$finc_dte_vencimento = fct_formatdate($finc_dte_vencimento, 'd/m/Y');
											?>
											<div class="form-group">
												<label class="form-label" for="finc_dte_vencimento">Data de Vencimento </label>
												<input type="text" name="finc_dte_vencimento" id="finc_dte_vencimento" class="form-control mask-date flatpickr_date" value="<?php echo ($finc_dte_vencimento); ?>" />
											</div>
										</div>
										<div class="col-12 col-md-4">
											<div class="form-group">
												<label class="form-label" for="finc_valor">Valor</label>
												<input type="text" name="finc_valor" id="finc_valor" class="form-control mask-money"
													value="<?php echo ((isset($rs_dados->finc_valor) ? $rs_dados->finc_valor : "")); ?>" />
											</div>
										</div>
										<div class="col-12 col-md-4">
											<div class="form-group">
												<label class="form-label" for="finc_juros">Juros</label>
												<input type="text" name="finc_juros" id="finc_juros" class="form-control mask-money"
													value="<?php echo ((isset($rs_dados->finc_juros) ? $rs_dados->finc_juros : "")); ?>" />
											</div>
										</div>
										<div class="col-12 col-md-4">
											<div class="form-group">
												<label class="form-label" for="finc_multa">Multa</label>
												<input type="text" name="finc_multa" id="finc_multa" class="form-control mask-money"
													value="<?php echo ((isset($rs_dados->finc_multa) ? $rs_dados->finc_multa : "")); ?>" />
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-12 col-md-3">
											<div class="form-group">
												<label class="form-label" for="finc_efetuado">Efetuado</label>
												<select
													name="finc_efetuado" id="finc_efetuado" class="form-control">
													<option value="">Selecione</option>
													<option value="1" <?php echo (isset($rs_dados->finc_efetuado) && $rs_dados->finc_efetuado == "1") ? 'selected' : ''; ?>>Sim</option>
													<option value="0" <?php echo (isset($rs_dados->finc_efetuado) && $rs_dados->finc_efetuado == "0") ? 'selected' : ''; ?>>Não</option>
												</select>
											</div>
										</div>
										<div class="col-12 col-md-3">
											<?php
											$finc_dte_efetuado = (isset($rs_dados->finc_dte_efetuado) ? $rs_dados->finc_dte_efetuado : "");
											$finc_dte_efetuado = fct_formatdate($finc_dte_efetuado, 'd/m/Y');
											?>
											<div class="form-group">
												<label class="form-label" for="finc_dte_efetuado">Data efetuado </label>
												<input type="text" name="finc_dte_efetuado" id="finc_dte_efetuado" class="form-control mask-date flatpickr_date" value="<?php echo ($finc_dte_efetuado); ?>" />
											</div>
										</div>
										<div class="col-12 col-md-3">
											<div class="form-group">
												<label class="form-label" for="finc_competencia">Competencia</label>
												<input type="text" name="finc_competencia" id="finc_competencia" class="form-control"
													value="<?php echo ((isset($rs_dados->finc_competencia) ? $rs_dados->finc_competencia : "")); ?>" />
											</div>
										</div>
										<div class="col-12 col-md-3">
											<div class="form-group">
												<label class="form-label" for="finc_nr_doc">N° documento</label>
												<input type="text" name="finc_nr_doc" id="finc_nr_doc" class="form-control"
													value="<?php echo ((isset($rs_dados->finc_nr_doc) ? $rs_dados->finc_nr_doc : "")); ?>" />
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-12 col-md-3">
											<?php
											$finc_dte_pagamento = (isset($rs_dados->finc_dte_pagamento) ? $rs_dados->finc_dte_pagamento : "");
											$finc_dte_pagamento = fct_formatdate($finc_dte_pagamento, 'd/m/Y');
											?>
											<div class="form-group">
												<label class="form-label" for="finc_dte_pagamento">Data de pagamento </label>
												<input type="text" name="finc_dte_pagamento" id="finc_dte_pagamento" class="form-control mask-date flatpickr_date" value="<?php echo ($finc_dte_pagamento); ?>" />
											</div>
										</div>
										<div class="col-12 col-md-3">
											<div class="form-group">
												<label class="form-label" for="finc_conta">Conta</label>
												<input type="text" name="finc_conta" id="finc_conta" class="form-control"
													value="<?php echo ((isset($rs_dados->finc_conta) ? $rs_dados->finc_conta : "")); ?>" />
											</div>
										</div>
										<div class="col-12 col-md-3">
											<div class="form-group">
												<label class="form-label" for="finc_forma_pagamento">Forma de pagamento</label>
												<input type="text" name="finc_forma_pagamento" id="finc_forma_pagamento" class="form-control"
													value="<?php echo ((isset($rs_dados->finc_forma_pagamento) ? $rs_dados->finc_forma_pagamento : "")); ?>" />
											</div>
										</div>
										<div class="col-12 col-md-3">
											<div class="form-group">
												<label class="form-label" for="finc_status">Status</label>
												<select
													name="finc_status" id="finc_status" class="form-control">
													<option value="">Selecione</option>
													<option value="Pendente" <?php echo (isset($rs_dados->finc_status) && $rs_dados->finc_status == "Pendente") ? 'selected' : ''; ?>>Pendente</option>
													<option value="Pago" <?php echo (isset($rs_dados->finc_status) && $rs_dados->finc_status == "Pago") ? 'selected' : ''; ?>>Pago</option>
													<option value="Aguardando" <?php echo (isset($rs_dados->finc_status) && $rs_dados->finc_status == "Aguardando") ? 'selected' : ''; ?>>Aguardando</option>
												</select>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-12 col-md-12">
											<div class="form-group">
												<label class="form-label" for="finc_observacoes">Observações</label>
												<textarea name="finc_observacoes" id="finc_observacoes" class="form-control" rows="6"><?php echo ((isset($rs_dados->finc_observacoes) ? $rs_dados->finc_observacoes : "")); ?></textarea>
											</div>
										</div>
									</div>

								</div>
							</div>
						</div>

					</div>
				</form>
			<?php else : ?>
				<form action="<?= site_url('financeiro/salvarGerencial') ?>" method="post" id="formFinanceiro">
					<div class="row align-items-start">
						<div class="card card-default">

							<div class="card-body">

								<div id="lancamentosContainer">

									<div class="lancamento-item" data-index="0">
										<div class="card-header-box">
											<div class="row align-items-center">
												<div class="col-6">
													<strong>N° Lançamento <span class="lancamento-index">1</span></strong>
												</div>
												<div class="col-6 text-right">
													<button type="button" name="lancamento[0][btn]" class="btn btn-danger btn-sm removeLancamento">
														Remover
													</button>
												</div>
											</div>
										</div>

										<div class="row" id="tpConta class perd">
											<div class="col-12 col-md-4">

												<div class="form-group">
													<label class="form-label" for="lancamento[0][finc_tipo_id]">Tipo de Conta</label>
													<select name="lancamento[0][finc_tipo_id]" class="form-select">
														<option value="">Selecione</option>
														<?php foreach ($rs_list_tipo->getResult() as $row) : ?>
															<option value="<?= htmlspecialchars($row->finc_tipo_id) ?>">
																<?= htmlspecialchars($row->finc_tipo_nome) ?>
															</option>
														<?php endforeach; ?>
													</select>
												</div>

											</div>
											<div class="col-12 col-md-4">
												<div class="form-group">
													<label class="form-label" for="lancamento[0][finc_class_id]">Classificação</label>
													<select name="lancamento[0][finc_class_id]" id="lancamento[0][finc_class_id]" class="form-select">
														<option value="" translate="no">Selecione</option>
														<?php
														foreach ($rs_list_class->getResult() as $row) {
														?>
															<option value="<?php echo htmlspecialchars($row->finc_class_id); ?>" >
																<?php echo htmlspecialchars($row->finc_class_nome); ?>
															</option>
														<?php
														}
														?>
													</select>
												</div>
											</div>
											<div class="col-12 col-md-4">
												<div class="form-group">
													<label class="form-label" for="lancamento[0][finc_periodicidade]">Periodicidade</label>
													<select name="lancamento[0][finc_periodicidade]" id="lancamento[0][finc_periodicidade]" class="form-select">
														<option value="" translate="no">Selecione</option>
														<?php
														foreach ($cfgPeriodos as $row) {
														?>
															<option value="<?php echo htmlspecialchars($row['value']); ?>" >
																<?php echo htmlspecialchars($row['value']); ?>
															</option>
														<?php
														}
														?>
													</select>
												</div>
											</div>
										</div>
										<div class="row" id="tp e nm">
											<div class="col-12 col-md-6">
												<div class="form-group">
													<label class="form-label" for="lancamento[0][finc_tipo]">Tipo</label>
													<input type="text" name="lancamento[0][finc_tipo]" id="lancamento[0][finc_tipo]" class="form-control" />
												</div>
											</div>
											<div class="col-12 col-md-6">
												<div class="form-group">
													<label class="form-label" for="lancamento[0][finc_nome]">Nome</label>
													<input type="text" name="lancamento[0][finc_nome]" id="lancamento[0][finc_nome]" class="form-control" />
												</div>
											</div>
										</div>
										<div class="row" id="tp e nm">
											<div class="col-12 col-md-3">
												<div class="form-group">
													<label class="form-label" for="lancamento[0][finc_centro_custo]">Centro de Custo</label>
													<input type="text" name="lancamento[0][finc_centro_custo]" id="lancamento[0][finc_centro_custo]" class="form-control" />
												</div>
											</div>
											<div class="col-12 col-md-3">
												<div class="form-group">
													<label class="form-label" for="lancamento[0][finc_nr_parcela]">N° Parcela</label>
													<input type="number" name="lancamento[0][finc_nr_parcela]" id="lancamento[0][finc_nr_parcela]" class="form-control" />
												</div>
											</div>
											<div class="col-12 col-md-3">
												<div class="form-group">
													<label class="form-label" for="lancamento[0][finc_nr_parcela_total]">N° Total de Parcelas</label>
													<input type="number" name="lancamento[0][finc_nr_parcela_total]" id="lancamento[0][finc_nr_parcela_total]" class="form-control" />
												</div>
											</div>
											<div class="col-12 col-md-3">

												<div class="form-group">
													<label class="form-label" for="lancamento[0][finc_dte_vencimento]">Data de Vencimento </label>
													<input type="date" name="lancamento[0][finc_dte_vencimento]" id="lancamento[0][finc_dte_vencimento]" class="form-control" value="" />
												</div>
											</div>
											<div class="col-12 col-md-4">
												<div class="form-group">
													<label class="form-label" for="lancamento[0][finc_valor]">Valor</label>
													<input type="text" name="lancamento[0][finc_valor]" id="lancamento[0][finc_valor]" class="form-control mask-money"
														value="<?php echo ((isset($rs_dados->finc_valor) ? $rs_dados->finc_valor : "")); ?>" />
												</div>
											</div>
											<div class="col-12 col-md-4">
												<div class="form-group">
													<label class="form-label" for="lancamento[0][finc_juros]">Juros</label>
													<input type="text" name="lancamento[0][finc_juros]" id="lancamento[0][finc_juros]" class="form-control mask-money"
														value="<?php echo ((isset($rs_dados->finc_juros) ? $rs_dados->finc_juros : "")); ?>" />
												</div>
											</div>
											<div class="col-12 col-md-4">
												<div class="form-group">
													<label class="form-label" for="lancamento[0][finc_multa]">Multa</label>
													<input type="text" name="lancamento[0][finc_multa]" id="lancamento[0][finc_multa]" class="form-control mask-money"
														value="<?php echo ((isset($rs_dados->finc_multa) ? $rs_dados->finc_multa : "")); ?>" />
												</div>
											</div>

										</div>
										<div class="row">
											<div class="col-12 col-md-3">
												<div class="form-group">
													<label class="form-label" for="lancamento[0][finc_efetuado]">Efetuado</label>
													<select
														name="lancamento[0][finc_efetuado]" id="lancamento[0][finc_efetuado]" class="form-control">
														<option value="">Selecione</option>
														<option value="1">Sim</option>
														<option value="0">Não</option>
													</select>
												</div>
											</div>
											<div class="col-12 col-md-3">

												<div class="form-group">
													<label class="form-label" for="lancamento[0][finc_dte_efetuado]">Data efetuado </label>
													<input type="date" name="lancamento[0][finc_dte_efetuado]" id="lancamento[0][finc_dte_efetuado]" class="form-control" value="" />
												</div>
											</div>
											<div class="col-12 col-md-3">
												<div class="form-group">
													<label class="form-label" for="lancamento[0][finc_competencia]">Competencia</label>
													<input type="text" name="lancamento[0][finc_competencia]" id="lancamento[0][finc_competencia]" class="form-control" />
												</div>
											</div>
											<div class="col-12 col-md-3">
												<div class="form-group">
													<label class="form-label" for="lancamento[0][finc_nr_doc]">N° documento</label>
													<input type="text" name="lancamento[0][finc_nr_doc]" id="lancamento[0][finc_nr_doc]" class="form-control" />
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-12 col-md-3">

												<div class="form-group">
													<label class="form-label" for="lancamento[0][finc_dte_pagamento]">Data de pagamento </label>
													<input type="date" name="lancamento[0][finc_dte_pagamento]" id="lancamento[0][finc_dte_pagamento]" class="form-control" value="" />
												</div>
											</div>
											<div class="col-12 col-md-3">
												<div class="form-group">
													<label class="form-label" for="lancamento[0][finc_conta]">Conta</label>
													<input type="text" name="lancamento[0][finc_conta]" id="lancamento[0][finc_conta]" class="form-control" />
												</div>
											</div>
											<div class="col-12 col-md-3">
												<div class="form-group">
													<label class="form-label" for="lancamento[0][finc_forma_pagamento]">Forma de pagamento</label>
													<input type="text" name="lancamento[0][finc_forma_pagamento]" id="lancamento[0][finc_forma_pagamento]" class="form-control" />
												</div>
											</div>
											<div class="col-12 col-md-3">
												<div class="form-group">
													<label class="form-label" for="lancamento[0][finc_status]">Status</label>
													<select
														name="lancamento[0][finc_status]" id="lancamento[0][finc_status]" class="form-control">
														<option value="">Selecione</option>
														<option value="Pendente">Pendente</option>
														<option value="Pago">Pago</option>
														<option value="Aguardando">Aguardando</option>
													</select>
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-12 col-md-12">
												<div class="form-group">
													<label class="form-label" for="lancamento[0][finc_observacoes]">Observações</label>
													<textarea name="lancamento[0][finc_observacoes]" id="lancamento[0][finc_observacoes]" class="form-control" rows="6"></textarea>
												</div>
											</div>
										</div>



									</div>
									<hr>

								</div>
							</div>
							<div class="card-footer-box">
								<div class="row align-items-center">
									<div class="col-12 col-md-6">
										<div class="d-flex">
											<div style="margin-left: 5px;">
												<button type="button" id="addLancamento" class="btn btn-sm btn-primary">Adicionar Lançamento</button>
											</div>
										</div>
									</div>
									<div class="col-12 col-md-6">
										<div class="d-flex justify-content-end">
											<div style="margin-left: 5px;"><a href="<?php echo (site_url('financeiro')); ?>" class="btn btn-sm btn-warning">Voltar</a></div>
											<div style="margin-left: 5px;"><input type="submit" class="btn btn-sm btn-success" value="Salvar"></div>
										</div>
									</div>


								</div>
							</div>
						</div>

				</form>
			<?php endif; ?>

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
	.nav-tabs .nav-link {
		background-color: #e0e0e0 !important;
	}

	.nav-tabs .nav-link.active {
		color: #ffffff !important;
		background-color: #9ac52e !important;
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
</style>
<style>
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
</style>

<?php $this->endSection('headers'); ?>

<?php $this->section('scripts'); ?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="assets/plugins/flatpickr/flatpickr-locale-br.js"></script>

<!-- Sweet Alert -->
<link href="assets/plugins/sweet-alert2/sweetalert2.min.css" rel="stylesheet" type="text/css">
<script src="assets/plugins/sweet-alert2/sweetalert2.min.js"></script>


<!-- Sweet Alert -->
<link href="assets/plugins/custom-file-input/custom-file-input.css" rel="stylesheet" type="text/css">
<script src="assets/plugins/custom-file-input/custom-file-input.js"></script>
<script>
	$(document).ready(function() {
		let count = 1; // Começa em 1 porque o primeiro lançamento já existe (índice 0)

		$("#addLancamento").click(function() {
			let newIndex = count;
			let newLancamento = $(".lancamento-item").first().clone(); // Clona o primeiro lançamento

			// Atualiza os atributos do novo elemento
			newLancamento.attr("data-index", newIndex);
			newLancamento.find("select, input, textarea").each(function() {
				let name = $(this).attr("name");
				if (name) {
					name = name.replace(/\[\d+\]/, "[" + newIndex + "]");
					$(this).attr("name", name);
				}
				$(this).val(""); // Limpa os valores dos campos clonados
			});

			// Atualiza o número do lançamento
			newLancamento.find(".lancamento-index").text(newIndex + 1);

			// Mostra o botão de remover no novo lançamento
			newLancamento.find(".removeLancamento").show();

			$("#lancamentosContainer").append(newLancamento);
			count++; // Incrementa o contador
			atualizarNumeracao(); // Atualiza os números dos lançamentos
		});

		// Evento para remover um lançamento
		$(document).on("click", ".removeLancamento", function() {
			if ($(".lancamento-item").length > 1) {
				$(this).closest(".lancamento-item").remove();
				atualizarNumeracao(); // Atualiza a numeração dos lançamentos restantes
			}
		});

		// Oculta o botão de remover no primeiro lançamento ao carregar a página
		$(".lancamento-item").first().find(".removeLancamento").hide();

		// Função para atualizar a numeração dos lançamentos após remoção
		function atualizarNumeracao() {
			$(".lancamento-item").each(function(index) {
				$(this).attr("data-index", index);
				$(this).find(".lancamento-index").text(index + 1);

				// Atualiza os nomes dos inputs
				$(this).find("select, input").each(function() {
					let name = $(this).attr("name");
					if (name) {
						name = name.replace(/\[\d+\]/, "[" + index + "]");
						$(this).attr("name", name);
					}
				});
			});

			// Garante que o primeiro lançamento nunca tenha o botão de remover visível
			$(".lancamento-item").first().find(".removeLancamento").hide();
		}
	});
</script>

<script id="mstcItemArquivo" type="text/x-jquery-tmpl">
	<div class="{{trRow}} mb-2">
			<div class="row gx-2 align-items-end">
				<div class="col-12 col-md-3">
					<div class="form-group">
					<select
																					name="func_arq_nome_doc[{{hashitem}}]" id="func_arq_nome_doc[{{hashitem}}]" class="form-select form-select-sm">
																					<option  value="">Selecione</option>
																					<option value="Certidão de Nascimento">Certidão de Nascimento</option>
																					<option value="Certidão de casamento">Certidão de casamento</option>
																					<option value="Comprovante de Residência">Comprovante de Residência</option>
																					<option value="RG">RG</option>
																					<option value="CPF">CPF</option>
																					<option value="Titulo">Titulo</option>
																				</select>
					</div>
				</div>
				<div class="col-12 col-md">
					<div class="row gx-2 align-items-end">
						<div class="col-12 col-md-6" style="display: none">
							<div class="form-group">
								<input type="text" name="func_arq_tipo[{{hashitem}}]" id="func_arq_tipo_{{hashitem}}" class="form-control form-control-sm" value="Documento" />
							</div>
						</div>
						<div class="col-12 col-md-6">
							<div class="form-group">
								<input type="text" name="func_arq_data[{{hashitem}}]" id="func_arq_data_{{hashitem}}" class="form-control form-control-sm mask-date flatpickr_date" value="" />
							</div>
						</div>
						<div class="col-12 col-md-6">
							<div class="form-group">
								<input type="text" name="func_arq_validade[{{hashitem}}]" id="func_arq_validade_{{hashitem}}" class="form-control form-control-sm mask-date flatpickr_date" value="" />
							</div>
						</div>
					</div>
				</div>
				<div class="col-12 col-md-3">
					<div class="form-group d-flex">
						<input type="file" name="func_arq_anexo_{{hashitem}}" id="func_arq_anexo_{{hashitem}}" class="form-control form-control-sm inputfile inputfile-1" data-multiple-caption="{count} files selected" />
						<label for="func_arq_anexo_{{hashitem}}"><span>Escolher Arquivo</span></label>
					</div>
				</div>
				<div class="col-12 col-md-2">
					<div class="form-group d-flex">
						<select class="form-select form-select-sm" name="func_arq_status[{{hashitem}}]" id="func_arq_status_{{hashitem}}">
							<option value="" translate="no">- selecione -</option>
							<?php
							if (isset($cfgStatus)) {
								foreach ($cfgStatus as $key => $val) {
									$label = $val['label'];
									$value = $val['value'];
							?>
									<option value="<?php echo ($value); ?>" translate="no"><?php echo ($label); ?></option>
							<?php
								}
							}
							?>
						</select>
					</div>
				</div>
				<div class="col-12 col-md-auto align-self-center" style="width: 50px;">
					<a href="javascript:;" class="cmdREMOVEITEMARQ" style="font-size: 1.5rem; color: red; padding: 0 8px;"><i class="las la-times-circle"></i></a>
				</div>
			</div>
		</div>
</script>



<script>
	var fct_random_string = function(qtdChar) {
		//function fctRandomString(qtdChar) {
		var result = '';
		var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
		var charactersLength = characters.length;
		for (var i = 0; i < qtdChar; i++) {
			result += characters.charAt(Math.floor(Math.random() * charactersLength));
		}
		return result;
	}
	var fct_count_item_arquivos = function(p, callback) {
		let $box = $('#BOX-CONTENT-ITEM-ARQUIVO');
		let $qtdItem = $box.find('.trRow');
		if ($qtdItem.length == 0) {
			$(".cmdAddArquivo").trigger("click");
		}
	}
	$(document).ready(function() {
		//add arquivo
		$(document).on('click', '.cmdAddArquivo', function(e) {
			let templateData = {
				item: 1,
				trRow: 'trRow',
				hashitem: fct_random_string(8)
			};
			let template = $("#mstcItemArquivo").html();
			$('#BOX-CONTENT-ITEM-ARQUIVO').append(Mustache.render(template, templateData));

			let $el = $('#BOX-CONTENT-ITEM-ARQUIVO');
			$el.find(".mask-date").mask('00/00/0000', {
				placeholder: "dd/mm/yyyy",
				clearIfNotMatch: true
			});

			$el.find('.flatpickr_date').flatpickr({
				"allowInput": true,
				"locale": "pt",
				dateFormat: "d/m/Y",
			});
			//$el.find('.mask-hours').mask('00:00:00', {placeholder: "00:00:00", clearIfNotMatch: true});

			var inputs = document.querySelectorAll('.inputfile');
			Array.prototype.forEach.call(inputs, function(input) {
				var label = input.nextElementSibling,
					labelVal = label.innerHTML;
				input.addEventListener('change', function(e) {
					var fileName = '';
					if (this.files && this.files.length > 1)
						fileName = (this.getAttribute('data-multiple-caption') || '').replace('{count}', this.files.length);
					else
						fileName = e.target.value.split('\\').pop();

					if (fileName)
						label.querySelector('span').innerHTML = fileName;
					else
						label.innerHTML = labelVal;
				});
				// Firefox bug fix
				input.addEventListener('focus', function() {
					input.classList.add('has-focus');
				});
				input.addEventListener('blur', function() {
					input.classList.remove('has-focus');
				});
			});
		});
		$(document).on('click', '.cmdDELETARARQ', function(e) {
			let $this = $(this);
			let $hashkey = $this.data("hashkey");
			let $fincid = $this.data("fincid");
			let $row = $this.closest(".trRow");

			Swal.fire({
				title: 'Atenção!',
				icon: 'warning',
				html: 'Você está prestes a excluir este registro. <br />' +
					'Esta ação não poderá ser revertida.',
				type: 'warning',
				showCancelButton: true,
				cancelButtonColor: "#AAAAAA",
				confirmButtonColor: "#E96565",
				//confirmButtonColor: '$danger',
				//cancelButtonColor: '$success',
				confirmButtonText: 'Excluir',
				cancelButtonText: 'Cancelar',
				reverseButtons: true
			}).then(function(result) {
				if (result.value) {
					// ------------------------------------------------------
					let $formData = {
						func_id: $funcid,
						func_arq_hashkey: $hashkey,
					};

					$.ajax({
						url: site_url + 'financeiro/ajaxform/EXCLUIR-ARQUIVO',
						method: "POST",
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
						success: function(response) {
							console.log('2 success');
							console.log(response);

							$row.remove();
							fct_count_item_arquivos();
						},
						error: function(jqXHR, textStatus, errorThrown) {}
					});
					// ------------------------------------------------------
				}
			});
		});
		$(document).on('click', '.cmdREMOVEITEMARQ', function(e) {
			let $this = $(this);
			let $row = $this.closest(".trRow");

			Swal.fire({
				title: 'Atenção!',
				icon: 'warning',
				html: 'Você está prestes a excluir este registro. <br />' +
					'Esta ação não poderá ser revertida.',
				type: 'warning',
				showCancelButton: true,
				cancelButtonColor: "#AAAAAA",
				confirmButtonColor: "#E96565",
				//confirmButtonColor: '$danger',
				//cancelButtonColor: '$success',
				confirmButtonText: 'Excluir',
				cancelButtonText: 'Cancelar',
				reverseButtons: true
			}).then(function(result) {
				if (result.value) {
					$row.remove();
					fct_count_item_arquivos();
				}
			});
		});

		fct_count_item_arquivos();


		$('.flatpickr_date').flatpickr({
			"allowInput": true,
			"locale": "pt",
			dateFormat: "d/m/Y",
		});

		$(document).on('click', '.cmdFiltrar', function(e) {
			e.preventDefault();

			let $bsc_vendedor = $("#bsc_vendedor").val();
			let $bsc_cliente = $("#bsc_cliente").val();
			let $bsc_data_inicial = $("#bsc_data_inicial").val();
			let $bsc_data_final = $("#bsc_data_final").val();
			let $bsc_status = $("#bsc_status").val();

			let $url = '';
			if ($bsc_vendedor.length > 0) {
				$url = $url + '/vendedor:' + $bsc_vendedor;
			}
			if ($bsc_cliente.length > 0) {
				$url = $url + '/cliente:' + $bsc_cliente;
			}
			if ($bsc_data_inicial.length > 0) {
				$url = $url + '/data_inicial:' + ($bsc_data_inicial);
			}
			if ($bsc_data_final.length > 0) {
				$url = $url + '/data_final:' + ($bsc_data_final);
			}
			if ($bsc_status.length > 0) {
				$url = $url + '/status:' + $bsc_status;
			}

			//console.log( site_url  +'historico/filtrar'+ $url );
			window.location.href = site_url + 'historico/filtrar' + $url;
			return false;
		});
		$(document).on('click', '.cmdUpdateStatus', function(e) {
			e.preventDefault();

			let $this = $(this);
			let $codigo = $this.data("codigo");
			let $msg = $(".msg-email");

			Swal.fire({
				title: 'Atenção!',
				icon: 'warning',
				html: 'Confirme a alteração de status deste pedido.',
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
						url: site_url + 'pedidos/ajaxform/ALTERAR-STATUS',
						method: "POST",
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
						success: function(response) {
							console.log('2 success');
							console.log(response);
							$msg.html(response.error_msg).show();
						},
						error: function(jqXHR, textStatus, errorThrown) {}
					});
					// ------------------------------------------------------
				}
			});
		});
		$(document).on('click', '.cmdArquivarRegistro', function(e) {
			e.preventDefault();
			let $this = $(this);
			let $codigo = $this.data("codigo");
			let $row = $this.closest(".trRow");

			Swal.fire({
				title: 'Atenção!',
				icon: 'warning',
				html: 'Confirme o arquivamento deste pedido.',
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
						url: site_url + 'historico/ajaxform/ARQUIVAR-REGISTRO',
						method: "POST",
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
						success: function(response) {
							console.log('2 success');
							console.log(response);
							$row.remove();
						},
						error: function(jqXHR, textStatus, errorThrown) {
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