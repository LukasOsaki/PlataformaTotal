<?php
$this->extend('templates/template_painel');
$this->section('content');
?>

<div class="box-breadcrumb">
	<div class="row">
		<div class="col-12">
			<h2 class="page-title">Lancamento Agendado</h2>
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
											<div style="margin-left: 5px;"><a href="<?php echo (site_url('financeiroLancamentos')); ?>" class="btn btn-sm btn-warning">Voltar</a></div>
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
												$finc_lanc_ativo = (int)((isset($rs_dados->finc_lanc_ativo) ? $rs_dados->finc_lanc_ativo : "1"));
												$ativo_s = ($finc_lanc_ativo == "1" ? ' checked ' : '');
												$ativo_n = ($finc_lanc_ativo != "1" ? ' checked ' : '');
												?>
												<div class="form-group">
													<div><label class="form-label" for="EMAIL">Registro Ativo?</label></div>
													<div>
														<div class="form-check-inline my-1">
															<div class="custom-control custom-radio">
																<input type="radio" name="finc_lanc_ativo" id="ativo_s" class="custom-control-input" value="1" <?php echo ($ativo_s) ?> />
																<label class="custom-control-label" for="ativo_s">Sim</label>
															</div>
														</div>
														<div class="form-check-inline my-1">
															<div class="custom-control custom-radio">
																<input type="radio" name="finc_lanc_ativo" id="ativo_n" class="custom-control-input" value="0" <?php echo ($ativo_n) ?> />
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
											<label class="form-label" for="finc_lanc_periodicidade">Periodicidade</label>
											<select name="finc_lanc_periodicidade" id="finc_lanc_periodicidade" class="form-select">
												<option value="" translate="no">Selecione</option>
												<?php
												foreach ($cfgPeriodos as $row) {
													// Verifica se a sigla atual é a mesma do valor armazenado
													$selectedPeriodo = (isset($rs_dados->finc_lanc_periodicidade) && $rs_dados->finc_lanc_periodicidade === $row['value']) ? "selected" : "";
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
								<div class="row" id="row_ie_porcentagem" style="display: none;">
									<div class="col-12 col-md-12">
										<div class="form-group">
											<label class="form-label" for="finc_lanc_ie_porcentagem">Valor fixo ou porcentagem</label>
											<div class="form-group">
												<select
													name="finc_lanc_ie_porcentagem"
													id="finc_lanc_ie_porcentagem"
													class="form-control">
													<option value="">Selecione</option>
													<option value="0" <?php echo (isset($rs_dados->finc_lanc_ie_porcentagem) && $rs_dados->finc_lanc_ie_porcentagem == "0") ? 'selected' : ''; ?>>Fixo</option>
													<option value="1" <?php echo (isset($rs_dados->finc_lanc_ie_porcentagem) && $rs_dados->finc_lanc_ie_porcentagem == "1") ? 'selected' : ''; ?>>Porcentagem</option>
												</select>
											</div>
										</div>
									</div>
								</div>

								<div class="row" id="tp e nm">
									<div class="col-12 col-md-6">
										<div class="form-group">
											<label class="form-label" for="finc_lanc_tipo">Tipo</label>
											<input type="text" name="finc_lanc_tipo" id="finc_lanc_tipo" class="form-control"
												value="<?php echo ((isset($rs_dados->finc_lanc_tipo) ? $rs_dados->finc_lanc_tipo : "")); ?>" />
										</div>
									</div>
									<div class="col-12 col-md-6">
										<div class="form-group">
											<label class="form-label" for="finc_lanc_custo">Centro de Custo</label>
											<input type="text" name="finc_lanc_custo" id="finc_lanc_custo" class="form-control"
												value="<?php echo ((isset($rs_dados->finc_lanc_custo) ? $rs_dados->finc_lanc_custo : "")); ?>" />
										</div>
									</div>
								</div>

								<div class="row" id="row_valor">
									<div class="col-12 col-md-6" id="div_valor" style="display: none;">
										<div class="form-group">
											<label class="form-label" for="finc_lanc_valor">Valor</label>
											<input type="text"
												name="finc_lanc_valor"
												id="finc_lanc_valor"
												class="form-control mask-money"
												value="<?php echo isset($rs_dados->finc_lanc_valor) && $rs_dados->finc_lanc_valor !== '' ? $rs_dados->finc_lanc_valor : '0.00'; ?>" />
										</div>
									</div>
									<div class="col-12 col-md-6" id="div_porcentagem" style="display: none;">
										<div class="form-group">
											<label class="form-label" for="finc_lanc_porcentagem">Porcentagem</label>
											<input type="text"
												name="finc_lanc_porcentagem"
												id="finc_lanc_porcentagem"
												class="form-control mask-money"
												value="<?php echo isset($rs_dados->finc_lanc_porcentagem) && $rs_dados->finc_lanc_porcentagem !== '' ? $rs_dados->finc_lanc_porcentagem : '0'; ?>" />
										</div>
									</div>
									<div class="col-12 col-md-6">
										<?php
										$finc_lanc_dte_lancamento = (isset($rs_dados->finc_lanc_dte_lancamento) ? $rs_dados->finc_lanc_dte_lancamento : "");
										$finc_lanc_dte_lancamento = fct_formatdate($finc_lanc_dte_lancamento, 'd/m/Y');
										?>
										<div class="form-group">
											<label class="form-label" for="finc_lanc_dte_lancamento">Data de Vencimento </label>
											<input type="text" name="finc_lanc_dte_lancamento" id="finc_lanc_dte_lancamento" class="form-control mask-date flatpickr_date" value="<?php echo ($finc_lanc_dte_lancamento); ?>" />
										</div>
									</div>
								</div>


								<?php if (!isset($rs_dados->finc_lanc_id) || empty($rs_dados->finc_lanc_id)) : ?>
									<div class="row" id="tableFunc" style="display: none">
										<div class="col-12">
											<h4>Selecione os Funcionários</h4>
											<?php
											if (isset($rs_list_func)) {
											?>
												<div class="table-box table-responsive">
													<table id="example2" class="display table table-striped table-bordered" style="width:100%">
														<thead>
															<tr>
																<th class="text-center" style="width:110px;">Ação</th>
																<th style="width:50px;">ID</th>
																<th>Nome</th>
															</tr>
														</thead>
														<tbody>
															<?php
															$count = 0;
															foreach ($rs_list_func->getResult() as $row) {
																$count++;
																$func_id = ($row->func_id);
																$func_hashkey = ($row->func_hashkey);
																$func_nome = ($row->func_nome);


																$link_form = site_url('financeiroLancamentos/form/' . $func_id);
																$linkGerarPDF = site_url();
															?>
																<tr class="trRow">
																	<td class="text-center">
																		<input type="checkbox" name="selected_func_ids[]" value="<?php echo $func_id; ?>">
																	</td>
																	<td><?php echo ($func_id); ?></td>
																	<td><?php echo ($func_nome); ?></td>

																</tr>
															<?php
															}
															?>
														</tbody>
													</table>
												</div>
											<?php
											} else {
											?>
												<div class="table-box text-center" style="padding: 16px 8px;">
													<?php echo ('Nenhum registro encontrado'); ?>
												</div>
											<?php
											}
											?>

										</div>
									</div>

									<div class="row" id="tableClie" style="display: none">
										<div class="col-12">
											<h4>Selecione os Clientes</h4>
											<?php
											if (isset($rs_list_clie)) {
											?>
												<div class="table-box table-responsive">
													<table id="example2" class="display table table-striped table-bordered" style="width:100%">
														<thead>
															<tr>
																<th class="text-center" style="width:110px;">Ação</th>
																<th style="width:50px;">ID</th>
																<th>Nome</th>
															</tr>
														</thead>
														<tbody>
															<?php
															$count = 0;
															foreach ($rs_list_clie->getResult() as $row) {
																$count++;
																$clie_id = ($row->clie_id);
																$clie_hashkey = ($row->clie_hashkey);
																$clie_nome_razao = ($row->clie_nome_razao);


																$link_form = site_url('financeiroLancamentos/form/' . $clie_id);
																$linkGerarPDF = site_url();
															?>
																<tr class="trRow">
																	<td class="text-center">
																		<input type="checkbox" name="selected_clie_ids[]" value="<?php echo $clie_id; ?>">
																	</td>
																	<td><?php echo ($clie_id); ?></td>
																	<td><?php echo ($clie_nome_razao); ?></td>

																</tr>
															<?php
															}
															?>
														</tbody>
													</table>
												</div>
											<?php
											} else {
											?>
												<div class="table-box text-center" style="padding: 16px 8px;">
													<?php echo ('Nenhum registro encontrado'); ?>
												</div>
											<?php
											}
											?>

										</div>
									</div>
								<?php endif; ?>
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

	$(document).ready(function() {


		$('.flatpickr_date').flatpickr({
			"allowInput": true,
			"locale": "pt",
			dateFormat: "d/m/Y",
		});

	});
</script>
<script>
	document.addEventListener('DOMContentLoaded', function() {
		const selectTipo = document.getElementById('finc_lanc_ie_porcentagem');
		const divValor = document.getElementById('div_valor');
		const divPorcentagem = document.getElementById('div_porcentagem');

		// Função para alternar visibilidade
		function toggleFields() {
			const selectedValue = selectTipo.value;

			// Exibe ou oculta os campos com base na seleção
			if (selectedValue === "0") { // Fixo
				divValor.style.display = 'block';
				divPorcentagem.style.display = 'none';
			} else if (selectedValue === "1") { // Porcentagem
				divValor.style.display = 'none';
				divPorcentagem.style.display = 'block';
			} else { // Nenhum selecionado
				divValor.style.display = 'none';
				divPorcentagem.style.display = 'none';
			}
		}

		// Evento para detectar mudança no select
		selectTipo.addEventListener('change', toggleFields);

		// Chamada inicial para ajustar a exibição
		toggleFields();
	});
</script>

<script>
	document.addEventListener('DOMContentLoaded', function() {
    const selectClassificacao = document.getElementById('finc_class_id');
    const tableClie = document.getElementById('tableClie');
    const tableFunc = document.getElementById('tableFunc');
    const row_ie_porcentagem = document.getElementById('row_ie_porcentagem');
    const div_valor = document.getElementById('div_valor');
    const div_porcentagem = document.getElementById('div_porcentagem');

    // Dados PHP serializados em JSON
    const classificacoes = <?php echo json_encode($rs_list_class->getResult()); ?>;

    // Função para resetar os checkboxes
    function resetCheckboxes(tableId) {
        const table = document.getElementById(tableId);
        if (table) {
            const checkboxes = table.querySelectorAll('input[type="checkbox"]');
            checkboxes.forEach(checkbox => {
                checkbox.checked = false;
            });
        }
    }

    // Evento para monitorar mudanças no select
    selectClassificacao.addEventListener('change', function() {
        const selectedValue = selectClassificacao.value;

        // Encontra a classificação correspondente
        const selectedClass = classificacoes.find(item => item.finc_class_id == selectedValue);

        // Define a visibilidade com base nos valores
        if (selectedClass) {
            tableClie.style.display = selectedClass.finc_class_cliente == 1 ? 'block' : 'none';
            tableFunc.style.display = selectedClass.finc_class_func == 1 ? 'block' : 'none';
            row_ie_porcentagem.style.display = selectedClass.finc_class_func == 1 ? 'block' : 'none';
        } else {
            tableClie.style.display = 'none';
            tableFunc.style.display = 'none';
            row_ie_porcentagem.style.display = 'none';
        }

        // Resetar os checkboxes ao alterar a visibilidade
        resetCheckboxes('tableClie');
        resetCheckboxes('tableFunc');
    });
});
</script>



<?php $this->endSection('scripts'); ?>