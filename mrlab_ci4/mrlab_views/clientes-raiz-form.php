<?php
$this->extend('templates/template_painel');
$this->section('content');
?>

<div class="box-breadcrumb">
	<div class="row">
		<div class="col-12">
			<h2 class="page-title">Clientes Matriz</h2>
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
											<div style="margin-left: 5px;"><a href="<?php echo (site_url('clientesRaiz')); ?>" class="btn btn-sm btn-warning">Voltar</a></div>
											<div style="margin-left: 5px;"><input type="submit" class="btn btn-sm btn-success" value="Salvar"></div>
										</div>

									</div>
								</div>
							</div>
							<div class="card-body">

								<div class="row ">
									<div class="col-12 col-md-3">

									</div>
									<div class="col-12 col-md-12">

										<nav>
											<div class="nav nav-tabs" id="nav-tab" style="border-bottom: 0px !important;" role="tablist">
												<button class="nav-link active" id="nav-principal-tab" data-bs-toggle="tab" data-bs-target="#nav-principal" type="button" role="tab" aria-controls="nav-principal" aria-selected="true">Principal</button>
											</div>
										</nav>
										<div class="tab-content border" id="nav-tabContent" style="padding: 2rem 1rem; border-radius: 8px !important; border-top-left-radius: 0px !important;">
											<div class="tab-pane fade active show" id="nav-principal" role="tabpanel" aria-labelledby="nav-principal-tab">

												<div class="row justify-content-end">
													<div class="col-auto">
														<?php
														$clie_raiz_ativo = (int)((isset($rs_dados->clie_raiz_ativo) ? $rs_dados->clie_raiz_ativo : "1"));
														$ativo_s = ($clie_raiz_ativo == "1" ? ' checked ' : '');
														$ativo_n = ($clie_raiz_ativo != "1" ? ' checked ' : '');
														?>
														<div class="form-group">
															<div><label class="form-label" for="EMAIL">Registro Ativo?</label></div>
															<div>
																<div class="form-check-inline my-1">
																	<div class="custom-control custom-radio">
																		<input type="radio" name="clie_raiz_ativo" id="ativo_s" class="custom-control-input" value="1" <?php echo ($ativo_s) ?> />
																		<label class="custom-control-label" for="ativo_s">Sim</label>
																	</div>
																</div>
																<div class="form-check-inline my-1">
																	<div class="custom-control custom-radio">
																		<input type="radio" name="clie_raiz_ativo" id="ativo_n" class="custom-control-input" value="0" <?php echo ($ativo_n) ?> />
																		<label class="custom-control-label" for="ativo_n">Não</label>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>

												<div class="row">
													<div class="col-12 col-md-6">
														<div class="form-group">
															<label class="form-label" for="clie_raiz_nome_razao">Nome / Razão Social <span style="margin-left: 15px; color: red; font-size: .65rem;">obrigatório</span></label>
															<input type="text" name="clie_raiz_nome_razao" id="clie_raiz_nome_razao" class="form-control" value="<?php echo ((isset($rs_dados->clie_raiz_nome_razao) ? $rs_dados->clie_raiz_nome_razao : "")); ?>" />
														</div>
													</div>
													<div class="col-12 col-md-6">
														<div class="form-group">
															<label class="form-label" for="clie_raiz_nome_fantasia">Nome Fantasia</label>
															<input type="text" name="clie_raiz_nome_fantasia" id="clie_raiz_nome_fantasia" class="form-control" value="<?php echo ((isset($rs_dados->clie_raiz_nome_fantasia) ? $rs_dados->clie_raiz_nome_fantasia : "")); ?>" />
														</div>
													</div>
												</div>

								

												<div class="row">
													<div class="col-12 col-md-6">
														<div class="form-group">
															<label class="form-label" for="clie_raiz_login">Login</label>
															<input type="text" name="clie_raiz_login" id="clie_raiz_login" class="form-control" value="<?php echo ((isset($rs_dados->clie_raiz_login) ? $rs_dados->clie_raiz_login : "")); ?>" />
														</div>
													</div>
													<div class="col-12 col-md-6">
														<div class="row">
															<div class="col-12 col-md-7">
																<div class="form-group">
																	<label class="form-label" for="clie_raiz_cnpj">CNPJ</label>
																	<input type="text" name="clie_raiz_cnpj" id="clie_raiz_cnpj" class="form-control mask-cnpj" value="<?php echo ((isset($rs_dados->clie_raiz_cnpj) ? $rs_dados->clie_raiz_cnpj : "")); ?>" />
																</div>
															</div>
															<div class="col-12 col-md-5">
																<div class="form-group">
																	<label class="form-label" for="clie_raiz_senha">Senha</label>
																	<input type="password" name="clie_raiz_senha" id="clie_raiz_senha" class="form-control" value="" />
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
	var fct_count_item_arquivos = function(p, callback) {
		let $box = $('#BOX-CONTENT-ITEM-ARQUIVO');
		let $qtdItem = $box.find('.trRow');
		if ($qtdItem.length == 0) {
			$(".cmdAddArquivo").trigger("click");
		}
	}
	$(document).ready(function() {
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
			let $clieid = $this.data("clieid");
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
						clie_raiz_id: $clieid,
						arq_hashkey: $hashkey,
					};

					$.ajax({
						url: site_url + 'clientes/ajaxform/EXCLUIR-ARQUIVO',
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