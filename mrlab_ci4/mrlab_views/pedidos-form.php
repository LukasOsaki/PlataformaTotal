<?php 
	$this->extend('templates/template_painel');
	$this->section('content'); 
?>

	<div class="box-breadcrumb">
		<div class="row">
			<div class="col-12">
				<h2 class="page-title">Pedidos</h2>
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
											<div style="margin-left: 5px;"><a href="<?php echo(site_url('clientes')); ?>" class="btn btn-sm btn-warning">Voltar</a></div>
										</div>

									</div>
								</div>
							</div>
							<div class="card-body">

								<div class="row ">
									<div class="col-12 col-md-5">

										<?php 
											$ped_nome = ((isset($rs_pedido->ped_nome) ? $rs_pedido->ped_nome : ""));
											$ped_sobrenome = ((isset($rs_pedido->ped_sobrenome) ? $rs_pedido->ped_sobrenome : ""));
										?>
										<div class="row">
											<div class="col-12 col-md-12">
												<div class="form-group">
													<label class="form-label" for="cad_nome">Nome</label>
													<input type="text" name="cad_nome" id="cad_nome" class="form-control" readonly="readonly" onfocus="this.blur();" value="<?php echo( $ped_nome ." ". $ped_sobrenome ); ?>" />
												</div>
											</div>
										</div>

										<?php 
											$ped_endereco = ((isset($rs_pedido->ped_endereco) ? $rs_pedido->ped_endereco : ""));
										?>
										<div class="row">
											<div class="col-12 col-md-12">
												<div class="form-group">
													<label class="form-label" for="ped_endereco">Endereço</label>
													<input type="text" name="ped_endereco" id="ped_endereco" class="form-control" readonly="readonly" onfocus="this.blur();" value="<?php echo( $ped_endereco ); ?>" />
												</div>
											</div>
										</div>

										<?php 
											$ped_bairro = ((isset($rs_pedido->ped_bairro) ? $rs_pedido->ped_bairro : ""));
											$ped_cidade = ((isset($rs_pedido->ped_cidade) ? $rs_pedido->ped_cidade : ""));
										?>
										<div class="row">
											<div class="col-12 col-md-6">
												<div class="form-group">
													<label class="form-label" for="ped_bairro">Bairro</label>
													<input type="text" name="ped_bairro" id="ped_bairro" class="form-control" readonly="readonly" onfocus="this.blur();" value="<?php echo( $ped_bairro ); ?>" />
												</div>
											</div>
											<div class="col-12 col-md-6">
												<div class="form-group">
													<label class="form-label" for="ped_cidade">Cidade</label>
													<input type="text" name="ped_cidade" id="ped_cidade" class="form-control" readonly="readonly" onfocus="this.blur();" value="<?php echo( $ped_cidade ); ?>" />
												</div>
											</div>
										</div>

										<?php 
											$ped_cep = ((isset($rs_pedido->ped_cep) ? $rs_pedido->ped_cep : ""));
											$ped_estado = ((isset($rs_pedido->ped_estado) ? $rs_pedido->ped_estado : ""));
										?>
										<div class="row">
											<div class="col-12 col-md-6">
												<div class="form-group">
													<label class="form-label" for="ped_cep">Bairro</label>
													<input type="text" name="ped_cep" id="ped_cep" class="form-control" readonly="readonly" onfocus="this.blur();" value="<?php echo( $ped_cep ); ?>" />
												</div>
											</div>
											<div class="col-12 col-md-6">
												<div class="form-group">
													<label class="form-label" for="ped_estado">Estado</label>
													<input type="text" name="ped_estado" id="ped_estado" class="form-control" readonly="readonly" onfocus="this.blur();" value="<?php echo( $ped_estado ); ?>" />
												</div>
											</div>
										</div>

										<?php 
											$ped_observacoes = ((isset($rs_pedido->ped_observacoes) ? $rs_pedido->ped_observacoes : ""));
										?>
										<div class="row">
											<div class="col-12 col-md-12">
												<div class="form-group">
													<label class="form-label" for="ped_observacoes">Observações</label>
													<textarea name="ped_observacoes" id="ped_observacoes" class="form-control" rows="10" readonly="readonly" onfocus="this.blur();" /><?php echo( $ped_observacoes ); ?></textarea>
												</div>
											</div>
										</div>

									</div>
									<div class="col-12 col-md-7">

										<?php 
											$ped_envio_tipo = ((isset($rs_pedido->ped_envio_tipo) ? $rs_pedido->ped_envio_tipo : ""));
											$ped_pagto_tipo = ((isset($rs_pedido->ped_pagto_tipo) ? $rs_pedido->ped_pagto_tipo : ""));

											$label_envio = (isset($arrMethodEnvio[$ped_envio_tipo]) ? $arrMethodEnvio[$ped_envio_tipo]['label'] .' - R$ '. $arrMethodEnvio[$ped_envio_tipo]['value']  : '');
											$label_pagto = (isset($arrMethodPagto[$ped_pagto_tipo]) ? $arrMethodPagto[$ped_pagto_tipo]['label'] : '');
										?>
										<div class="row">
											<div class="col-12 col-md-6">
												<div class="form-group">
													<label class="form-label" for="ped_envio_tipo">Método de Envio</label>
													<input type="text" name="ped_envio_tipo" id="ped_envio_tipo" class="form-control" readonly="readonly" onfocus="this.blur();" value="<?php echo( $label_envio ); ?>" />
												</div>
											</div>
											<div class="col-12 col-md-6">
												<div class="form-group">
													<label class="form-label" for="ped_pagto_tipo">Método de Pagamento</label>
													<input type="text" name="ped_pagto_tipo" id="ped_pagto_tipo" class="form-control" readonly="readonly" onfocus="this.blur();" value="<?php echo( $label_pagto ); ?>" />
												</div>
											</div>
										</div>

										<?php
										if( isset($rs_itens) ){
										?>
										<h3 class="mt-4">Itens relacionados a este pedido</h3>
										<div class="table-box table-responsive">
											<table id="example2" class="display nowrap table table-striped table-bordered" style="width:100%">
												<thead>
													<tr>
														<th style="width:50px;">ID</th>
														<th>Produto</th>
														<th class="text-center" style="width:120px;">Valor / Quant</th>
														<th class="text-center" style="width:135px;">Subtotal</th>
													</tr>
												</thead>
												<tbody>
												<?php
													$count = 0;
													foreach ($rs_itens->getResult() as $row) {
														$count++;
														$item_id = ($row->item_id);
														$item_produto = ($row->item_produto);
														$item_valor = ($row->item_valor);
														$item_quant = ($row->item_quant);

														$subtotal = ($item_valor * $item_quant);
													?>
														<tr class="trRow">
															<td><?php echo($item_id); ?></td>
															<td >
																<div><?php echo($item_produto); ?></div>
															</td>
															<td class="text-center">
																<div><?php echo($item_valor .' x '. $item_quant); ?></div>
															</td>
															<td class="text-end">
																<div><?php echo($subtotal); ?></div>
															</td>
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

	<!-- Sweet Alert -->
	<link href="assets/plugins/sweet-alert2/sweetalert2.min.css" rel="stylesheet" type="text/css">
	<script src="assets/plugins/sweet-alert2/sweetalert2.min.js"></script>

	<script>
		$(document).ready(function () {
			
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