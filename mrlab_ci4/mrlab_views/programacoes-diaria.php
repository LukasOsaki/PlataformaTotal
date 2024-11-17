<?php 
	$this->extend('templates/template_painel');
	$this->section('content'); 
?>

	<div class="box-breadcrumb">
		<div class="row">
			<div class="col-12">
				<h2 class="page-title">Programação Diária</h2>
			</div>
		</div>
	</div>

	<div id="app">
		<div class="row align-items-start">
			<div class="col-12 col-md-12">

				<div class="row align-items-start">
					<div class="col-12 col-md-12">

						<div class="card card-default">
							<div class="card-body" style="padding: 1rem 0;">
								
								<div class="row mb-4 align-items-end">
									<div class="col-12 col-md-3">
										<div class="">
											<label class="form-label" for="prog_dte_visita">Selecione uma data para consulta</label>
											<input type="text" name="prog_dte_visita" id="prog_dte_visita" class="form-control mask-date flatpickr_date " value="<?php echo($prog_dte_visita);?>" />
										</div>
									</div>
								</div>

								<?php
								if( isset($rs_list_periodo)){
									foreach ($rs_list_periodo as $key => $val) {
										//$label = $val['label'];
										//$selected = (($key == $prog_periodo) ? "selected" : "");
										$label_prog_periodo = (isset($cfgProgPeriodo[$key]['label']) ? $cfgProgPeriodo[$key]['label'] : "");
										$css_grid = 'grid_'. $key;
								?>
									<div class="box-content mb-4 <?php print( $css_grid ); ?>">
										<div class="row">
											<div class="col-12">
												<?php
												if( isset($rs_list) ){
												?>
												<div class="table-box table-responsive">
													<h3><?php print( $label_prog_periodo ); ?></h3>
													
													<table id="example2" class="display nowrap table table-striped table-bordered" style="width:100%">
														<thead>
															<tr>
																<th style="width:70px;">Seq.</th>
																<th style="width:25%;">Cliente</th>
																<th style="width:25%;">Ténico</th>
																<th>Atividade</th>
															</tr>
														</thead>
														<tbody>
														<?php
															$count = 0;
															foreach ($val as $row) {
																$count++;
																$prog_id = ($row->prog_id);
																$prog_hashkey = ($row->prog_hashkey);
																$prog_dte_visita = ($row->prog_dte_visita);
																$prog_dte_visita = fct_formatdate($prog_dte_visita, 'd/m/Y');
																$prog_periodo = ($row->prog_periodo);
																$label_prog_periodo = (isset($cfgProgPeriodo[$prog_periodo]['label']) ? $cfgProgPeriodo[$prog_periodo]['label'] : "");

																$prog_sequencia = ($row->prog_sequencia);
																$prog_tecnico = ($row->prog_tecnico);
																$prog_realizada = (int)($row->prog_realizada);
																$prog_atividades = ($row->prog_atividades);
																$clie_nome_razao = ($row->clie_nome_razao);

																$colorRed = '#ff9494';
																$colorGreen = '#d0ffb8';
																$colorRealizado = (($prog_realizada==1) ? $colorGreen : $colorRed);   
															?>
																<tr class="trRow" style="background-color: <?php echo($colorRealizado); ?>">
																	<td><?php echo($prog_sequencia); ?></td>
																	<td><?php echo($clie_nome_razao); ?></td>
																	<td><?php echo($prog_tecnico); ?></td>
																	<td><?php echo($prog_atividades); ?></td>
																</tr>
															<?php
															}
														?>
														</tbody>
													</table>
												</div>
												<?php
												}else{
												?>
												<div class="table-box text-center" style="padding: 16px 8px;">
													<?php echo('Nenhum registro encontrado'); ?>
												</div>	
												<?php 
												} 
												?>


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
		.grid_manha{
			background-color: #fffcf8;
			border: 2px solid orange;
			border-radius: .5rem;		
		}
		.grid_tarde{
			background-color: #ecfafb;
			border: 2px solid #81cbe4;
			border-radius: .5rem;
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

	<script>
	$(document).ready(function () {
		$('.flatpickr_date').flatpickr({
			"allowInput" : true,
			"locale": "pt",
			dateFormat:"d/m/Y",	
			mode: "range",
			onChange: function(selectedDates, dateStr, instance) {
				let $url = '';
				if( dateStr.length > 0 ){ 
					//$url = converterData(dateStr);
					$url = converterData(dateStr);
					window.location.href = site_url  +'programacoes/diaria/'+ $url;
				}
			}
		});

		//$(document).on('click', '.cmdExibirDate', function (e) {
		//	e.preventDefault();
		//	let $prog_dte_visita = $("#prog_dte_visita").val();
		//	let $url = '';
		//	if( $prog_dte_visita.length > 0 )	{ 
		//		$url = converterData($prog_dte_visita); 
		//	}
		//	window.location.href = site_url  +'programacoes/diaria/'+ $url;
		//	return false;
		//});
	});

	function converterData(d) {
		// Dividir a string da data nos componentes dia, mês e ano
		var partes = d.split("/");
		
		// Criar uma nova data no formato mês/dia/ano
		var data = new Date(partes[2], partes[1] - 1, partes[0]);
		
		// Obter os componentes da data no formato Y-m-d
		var ano = data.getFullYear();
		var mes = data.getMonth() + 1;
		var dia = data.getDate();
		
		// Formatar a data no formato Y-m-d
		var dataFormatada = ano + "-" + (mes < 10 ? "0" : "") + mes + "-" + (dia < 10 ? "0" : "") + dia;
		
		return dataFormatada;
	}

	// Exemplo de uso
	//var dataOriginal = "01/03/2024";
	//var dataConvertida = converterData(dataOriginal);
	//console.log(dataConvertida); // Saída: 2024-01-03

	</script>


<?php $this->endSection('scripts'); ?>