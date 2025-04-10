<?php
$this->extend('templates/template_painel');
$this->section('content');

//$vendedores_count = (isset($vendedores_count) ? $vendedores_count : 0);
//$produtos_count = (isset($produtos_count) ? $produtos_count : 0);
//$pedidos_count = (isset($pedidos_count) ? $pedidos_count : 0);

//$session_id = (int)(isset($session_id) ? $session_id : ''); 
//$session_nome =(isset($session_nome) ? $session_nome : ''); 
//$session_permissao = (int)(isset($session_permissao) ? $session_permissao : ''); 
//$session_label_permissao = (isset($session_label_permissao) ? $session_label_permissao : '');
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
									<!-- <h4 class="card-title">Histórico</h4> -->
								</div>
								<div class="col-12 col-md-6">

									<div class="d-flex justify-content-end">
										<div style="margin-left: 5px;"><a href="<?php echo (site_url('servicos/form')); ?>" class="btn btn-sm btn-primary">Novo Registro</a></div>
										<div style="margin-left: 5px;">
											<a href="<?php echo site_url('servicos/exportar') . '?' . http_build_query($_GET); ?>" class="btn btn-sm btn-primary">Exportar</a>
										</div>
									</div>

								</div>
							</div>
						</div>
						<div class="card-header-box">
							<div class="row align-items-center">
								<div class="col-12 col-md-12">
									<div class="d-flex justify-content-end">
										<form action="<?php echo site_url('servicos'); ?>" method="GET">
											<div class="d-flex flex-wrap gap-2 align-items-end">

												<!-- Filtro Equipamento -->
												<div>
													<label class="form-label" for="equipamento">Equipamento</label>
													<input name="equipamento" id="equipamento" class="form-control" value="<?php echo $selected_equipamento ?? ''; ?>">
												</div>

												<!-- Filtro Classificação -->
												<div>
													<label class="form-label" for="cliente">Cliente</label>
													<select name="cliente" id="cliente" class="form-select">
														<option value="">Selecione</option>
														<?php foreach ($rs_clientes->getResult() as $row): ?>
															<option value="<?php echo htmlspecialchars($row->clie_id); ?>"
																<?php echo ($selected_cliente ?? '') == $row->clie_id ? 'selected' : ''; ?>>
																<?php echo htmlspecialchars($row->clie_nome_fantasia); ?>
															</option>
														<?php endforeach; ?>
													</select>
												</div>

												<!-- Filtro Periodicidade -->
												<!-- Filtro Data de Vencimento -->
												<div>
													<label class="form-label">Data de execução</label>
													<div class="d-flex gap-2">
														<input type="date" name="inicio" id="inicio" class="form-control" value="<?php echo $selected_inicio ?? ''; ?>">
														<input type="date" name="fim" id="fim" class="form-control" value="<?php echo $selected_fim ?? ''; ?>">
													</div>
												</div>

												<!-- Botão de Filtrar -->
												<div>
													<button type="submit" class="btn btn-primary">Filtrar</button>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
						<div class="card-body" style="padding: 1rem 0;">
							<div class="box-content">
								<div class="row">
									<div class="col-12">
										<?php
										if (isset($rs_list)) {
										?>
											<div class="table-box table-responsive">
												<table id="example2" class="display table table-striped table-bordered" style="width:100%">
													<thead>
														<tr>
															<th class="text-center" style="width:60px;">Ação</th>
															<th style="width:30px;">ID</th>
															<th style="max-width:180px;">Nome do Cliente</th>
															<!-- <th style="width:60px;">Abert. Chamado</th> -->
															<th style="width:60px;">Executado em</th>
															<th>Status/Tag</th>
															<th style="max-width:200px;">Descrição</th>
															<th>Visualização Cliente</th>
														</tr>
													</thead>
													<tbody>
														<?php foreach ($rs_list->getResult() as $row) { ?>
															<tr class="trRow">
																<td class="text-center">
																	<div class="d-flex justify-content-center">
																		<div style="margin: 0 3px;">
																			<a href="<?php echo site_url('servicos/form/' . $row->pend_id); ?>" class="btn btn-sm btn-ac btn-primary">
																				<i class="las la-file-alt"></i>
																			</a>
																		</div>
																	</div>
																</td>
																<td><?php echo $row->pend_id; ?></td>
																<td><?php echo $row->clie_nome_fantasia; ?></td>
																<td>
																	<div><?php echo fct_formatdate($row->pend_dte_instalacao, 'd/m/Y'); ?></div>
																</td>
																<td style="background-color: <?php echo $row->categ_color; ?>">
																	<div><strong><?php echo $row->categ_titulo; ?></strong></div>
																	<div><?php echo $row->pendtag_tags; ?></div>
																</td>
																<td><?php echo $row->pendtag_descricao; ?></td>
																<td><?php
																	if ($row->pend_status == 0) {
																		echo '<span class="badge bg-success">Liberado</span>';
																	} elseif ($row->pend_status == 1) {
																		echo '<span class="badge bg-warning">Pendente</span>';
																	}
																	?></td>
															</tr>
														<?php } ?>
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

<style>
	table.dataTable td {
		word-break: break-word !important;
	}
</style>

<link href="assets/plugins/DataTables/DataTables-1.13.4/css/jquery.dataTables.css" rel="stylesheet">
<link href="assets/plugins/DataTables/DataTables-1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">

<script src="assets/plugins/DataTables/DataTables-1.13.4/js/jquery.dataTables.js"></script>
<script src="assets/plugins/DataTables/DataTables-1.13.4/js/dataTables.bootstrap5.min.js"></script>

<!-- Sweet Alert -->
<link href="assets/plugins/sweet-alert2/sweetalert2.min.css" rel="stylesheet" type="text/css">
<script src="assets/plugins/sweet-alert2/sweetalert2.min.js"></script>

<script>
	$(document).ready(function() {
		var table = $('#example2').DataTable({
			"pageLength": 100,
			order: [
				[0, "desc"]
			],
			//responsive: true,
			searching: true,
			paging: true,
			pagingType: "full_numbers",
			fixedHeader: {
				header: true,
				footer: false
			},
			"language": {
				"search": "Procurar",
				"lengthMenu": "Mostrar _MENU_ registro por página",
				"zeroRecords": "Nothing found - sorry",
				"info": "Monstrando _PAGE_ de _PAGES_",
				"infoEmpty": "Sem registros disponíveis",
				"infoFiltered": "(filtered from _MAX_ total records)",
				"oPaginate": {
					"sNext": "Próximo",
					"sPrevious": "Anterior",
					"sFirst": "Primeiro",
					"sLast": "Último"
				},
			}
		});
		//new $.fn.dataTable.FixedHeader( table );
	});
</script>


<?php $this->endSection('scripts'); ?>