<?php
$this->extend('templates/template_painel');
$this->section('content');
?>

<div class="box-breadcrumb">
	<div class="row">
		<div class="col-12">
			<h2 class="page-title">Funcionário</h2>
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
											<div style="margin-left: 5px;"><a href="<?php echo (site_url('funcionarios')); ?>" class="btn btn-sm btn-warning">Voltar</a></div>
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
												<button class="nav-link" id="nav-documentos-tab" data-bs-toggle="tab" data-bs-target="#nav-documentos" type="button" role="tab" aria-controls="nav-documentos" aria-selected="false">Documentos</button>
												<button class="nav-link" id="nav-exames-tab" data-bs-toggle="tab" data-bs-target="#nav-exames" type="button" role="tab" aria-controls="nav-exames" aria-selected="false">Exames Médicos</button>
												<button class="nav-link" id="nav-cursos-tab" data-bs-toggle="tab" data-bs-target="#nav-cursos" type="button" role="tab" aria-controls="nav-cursos" aria-selected="false">Cursos e Treinamentos</button>
											</div>
										</nav>
										<div class="tab-content border" id="nav-tabContent" style="padding: 2rem 1rem; border-radius: 8px !important; border-top-left-radius: 0px !important;">
											<div class="tab-pane fade active show" id="nav-principal" role="tabpanel" aria-labelledby="nav-principal-tab">

												<div class="row justify-content-end">
													<div class="col-auto">
														<?php
														$func_ativo = (int)((isset($rs_dados->func_ativo) ? $rs_dados->func_ativo : "1"));
														$ativo_s = ($func_ativo == "1" ? ' checked ' : '');
														$ativo_n = ($func_ativo != "1" ? ' checked ' : '');
														?>
														<div class="form-group">
															<div><label class="form-label" for="EMAIL">Registro Ativo?</label></div>
															<div>
																<div class="form-check-inline my-1">
																	<div class="custom-control custom-radio">
																		<input type="radio" name="func_ativo" id="ativo_s" class="custom-control-input" value="1" <?php echo ($ativo_s) ?> />
																		<label class="custom-control-label" for="ativo_s">Sim</label>
																	</div>
																</div>
																<div class="form-check-inline my-1">
																	<div class="custom-control custom-radio">
																		<input type="radio" name="func_ativo" id="ativo_n" class="custom-control-input" value="0" <?php echo ($ativo_n) ?> />
																		<label class="custom-control-label" for="ativo_n">Não</label>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>

												<div class="row">
													<div class="col-12 col-md-12">
														<div class="form-group">
															<label class="form-label" for="func_nome">Nome <span style="margin-left: 15px; color: red; font-size: .65rem;">obrigatório</span></label>
															<input type="text" name="func_nome" id="func_nome" class="form-control" value="<?php echo ((isset($rs_dados->func_nome) ? $rs_dados->func_nome : "")); ?>" />
														</div>
													</div>
												</div>

												<div class="row">
													<div class="col-12 col-md-6">
														<div class="form-group">
															<label class="form-label" for="func_nome_mae">Nome Mãe</label>
															<input type="text" name="func_nome_mae" id="func_nome_mae" class="form-control" value="<?php echo ((isset($rs_dados->func_nome_mae) ? $rs_dados->func_nome_mae : "")); ?>" />
														</div>
													</div>
													<div class="col-12 col-md-6">
														<div class="form-group">
															<label class="form-label" for="func_nome_pai">Nome Pai</label>
															<input type="text" name="func_nome_pai" id="func_nome_pai" class="form-control" value="<?php echo ((isset($rs_dados->func_nome_pai) ? $rs_dados->func_nome_pai : "")); ?>" />
														</div>
													</div>

												</div>

												<div class="row">
													<div class="col-12 col-md-6">
														<div class="form-group">
															<label class="form-label" for="func_email">E-mail</label>
															<input type="text" name="func_email" id="func_email" class="form-control" value="<?php echo ((isset($rs_dados->func_email) ? $rs_dados->func_email : "")); ?>" />
														</div>
													</div>
													<div class="col-12 col-md-3">
														<div class="form-group">
															<label class="form-label" for="func_telefone">Telefone</label>
															<input type="text" name="func_telefone" id="func_telefone" class="form-control mask-phone-fixo" value="<?php echo ((isset($rs_dados->func_telefone) ? $rs_dados->func_telefone : "")); ?>" />
														</div>
													</div>
													<div class="col-12 col-md-3">
														<div class="form-group">
															<label class="form-label" for="func_celular">Celular</label>
															<input type="text" name="func_celular" id="func_celular" class="form-control mask-phone-cel" value="<?php echo ((isset($rs_dados->func_celular) ? $rs_dados->func_celular : "")); ?>" />
														</div>
													</div>

												</div>
												<div class="row">
													<div class="col-12 col-md-4">
														<div class="form-group">
															<label class="form-label" for="func_cpf">CPF</label>
															<input type="text" name="func_cpf" id="func_cpf" class="form-control mask-cpf" value="<?php echo ((isset($rs_dados->func_cpf) ? $rs_dados->func_cpf : "")); ?>" />
														</div>
													</div>
													<div class="col-12 col-md-4">

														<div class="form-group">
															<label class="form-label" for="func_uf_rg">Estado RG
															</label>
															<select name="func_uf_rg" id="func_uf_rg" class="form-select">
																<option value="" translate="no">Selecione</option>
																<?php
																// Array com os estados e suas siglas
																$estados = [
																	"AC" => "Acre",
																	"AL" => "Alagoas",
																	"AP" => "Amapá",
																	"AM" => "Amazonas",
																	"BA" => "Bahia",
																	"CE" => "Ceará",
																	"DF" => "Distrito Federal",
																	"ES" => "Espírito Santo",
																	"GO" => "Goiás",
																	"MA" => "Maranhão",
																	"MT" => "Mato Grosso",
																	"MS" => "Mato Grosso do Sul",
																	"MG" => "Minas Gerais",
																	"PA" => "Pará",
																	"PB" => "Paraíba",
																	"PR" => "Paraná",
																	"PE" => "Pernambuco",
																	"PI" => "Piauí",
																	"RJ" => "Rio de Janeiro",
																	"RN" => "Rio Grande do Norte",
																	"RS" => "Rio Grande do Sul",
																	"RO" => "Rondônia",
																	"RR" => "Roraima",
																	"SC" => "Santa Catarina",
																	"SP" => "São Paulo",
																	"SE" => "Sergipe",
																	"TO" => "Tocantins"
																];

																// Geração dinâmica das opções
																foreach ($estados as $sigla => $nome) {
																	// Verifica se a sigla atual é a mesma do valor armazenado
																	$selectedEstadoRg = (isset($rs_dados->func_uf_rg) && $rs_dados->func_uf_rg === $sigla) ? "selected" : "";
																?>
																	<option value="<?php echo htmlspecialchars($sigla); ?>" <?php echo $selectedEstadoRg; ?>>
																		<?php echo htmlspecialchars($nome); ?>
																	</option>
																<?php
																}
																?>
															</select>

														</div>

													</div>
													<div class="col-12 col-md-4">

														<div class="form-group">
															<label class="form-label" for="func_rg">RG</label>
															<input type="text" name="func_rg" id="func_rg" class="form-control" value="<?php echo ((isset($rs_dados->func_rg) ? $rs_dados->func_rg : "")); ?>" />
														</div>

													</div>
													<div class="col-12 col-md-4">
														<div class="form-group">
															<label class="form-label" for="func_titulo">Titulo</label>
															<input type="text" name="func_titulo" id="func_titulo" class="form-control" value="<?php echo ((isset($rs_dados->func_titulo) ? $rs_dados->func_titulo : "")); ?>" />
														</div>
													</div>

													<div class="col-12 col-md-4">

														<div class="form-group">
															<label class="form-label" for="func_estado_civil">Estado Cívil</label>
															<select class="form-select" name="func_estado_civil" id="func_estado_civil">
																<option value="" translate="no">- Selecione -</option>
																<?php
																$estadosCivis = [
																	"solteiro" => "Solteiro(a)",
																	"casado" => "Casado(a)",
																	"separado" => "Separado(a)",
																	"divorciado" => "Divorciado(a)",
																	"viuvo" => "Viúvo(a)"
																];

																foreach ($estadosCivis as $valor => $label) {
																	// Verifica se o valor atual é igual ao valor de func_estado_civil
																	$selected = (isset($rs_dados->func_estado_civil) && $rs_dados->func_estado_civil == $valor) ? "selected" : "";
																?>
																	<option value="<?php echo htmlspecialchars($valor); ?>" <?php echo $selected; ?> translate="no">
																		<?php echo htmlspecialchars($label); ?>
																	</option>
																<?php
																}
																?>
															</select>

														</div>

													</div>
													<div class="col-12 col-md-4">
														<?php
														$func_dt_nasc = (isset($rs_dados->func_dt_nasc) ? $rs_dados->func_dt_nasc : "");
														$func_dt_nasc = fct_formatdate($func_dt_nasc, 'd/m/Y');
														?>
														<div class="form-group">
															<label class="form-label" for="func_dt_nasc">Data de Nascimento </label>
															<input type="text" name="func_dt_nasc" id="func_dt_nasc" class="form-control mask-date flatpickr_date" value="<?php echo ($func_dt_nasc); ?>" />
														</div>
													</div>

												</div>
												<div class="row">
													<div class="col-12 col-md-2">
														<div class="form-group">
															<label class="form-label" for="func_cep">CEP</label>
															<input type="text" name="func_cep" id="func_cep" class="form-control" value="<?php echo ((isset($rs_dados->func_cep) ? $rs_dados->func_cep : "")); ?>" />
														</div>
													</div>
													<div class="col-12 col-md-6">
														<div class="form-group">
															<label class="form-label" for="func_endereco">Endereço</label>
															<input type="text" name="func_endereco" id="func_endereco" class="form-control" value="<?php echo ((isset($rs_dados->func_endereco) ? $rs_dados->func_endereco : "")); ?>" />
														</div>
													</div>
													<div class="col-12 col-md-4">
														<div class="form-group">
															<label class="form-label" for="func_end_numero">Numero</label>
															<input type="text" name="func_end_numero" id="func_end_numero" class="form-control" value="<?php echo ((isset($rs_dados->func_end_numero) ? $rs_dados->func_end_numero : "")); ?>" />
														</div>
													</div>
												</div>

												<div class="row">
													<div class="col-12 col-md-3">
														<div class="form-group">
															<label class="form-label" for="func_end_compl">Complemento</label>
															<input type="text" name="func_end_compl" id="func_end_compl" class="form-control" value="<?php echo ((isset($rs_dados->func_end_compl) ? $rs_dados->func_end_compl : "")); ?>" />
														</div>
													</div>
													<div class="col-12 col-md-3">
														<div class="form-group">
															<label class="form-label" for="func_bairro">Bairro</label>
															<input type="text" name="func_bairro" id="func_bairro" class="form-control" value="<?php echo ((isset($rs_dados->func_bairro) ? $rs_dados->func_bairro : "")); ?>" />
														</div>
													</div>
													<div class="col-12 col-md-4">
														<div class="form-group">
															<label class="form-label" for="func_cidade">Cidade</label>
															<input type="text" name="func_cidade" id="func_cidade" class="form-control" value="<?php echo ((isset($rs_dados->func_cidade) ? $rs_dados->func_cidade : "")); ?>" />
														</div>
													</div>
													<div class="col-12 col-md-2">
														<div class="form-group">
															<label class="form-label" for="func_estado">Estado</label>
															<select name="func_estado" id="func_estado" class="form-select">
																<option value="" translate="no">Selecione</option>
																<?php

																// Geração dinâmica das opções
																foreach ($estados as $sigla => $nome) {
																	// Verifica se a sigla atual é a mesma do valor armazenado
																	$selectedEstado = (isset($rs_dados->func_estado) && $rs_dados->func_estado === $sigla) ? "selected" : "";
																?>
																	<option value="<?php echo htmlspecialchars($sigla); ?>" <?php echo $selectedEstado; ?>>
																		<?php echo htmlspecialchars($nome); ?>
																	</option>
																<?php
																}
																?>
															</select>

															<!-- <input type="text" name="func_estado" id="func_estado" class="form-control" value="<?php echo ((isset($rs_dados->func_estado) ? $rs_dados->func_estado : "")); ?>" /> -->
														</div>
													</div>
												</div>

												<div class="row">
													<div class="col-12 col-md-6">
														<div class="form-group">
															<label class="form-label" for="func_salario">Salário</label>
															<?php
															$session = session();
															if ($session->get('admin_nivel') == "Admin Master") {
															?>
																<input type="text" name="func_salario" id="func_salario" class="form-control mask-money"
																	value="<?php echo isset($rs_dados->func_salario) ? $rs_dados->func_salario : ""; ?>" />
															<?php
															}
															?>

														</div>
													</div>
													<div class="col-12 col-md-6">
														<div class="form-group">
															<label class="form-label" for="func_observacoes">Utiliza VT</label>
															<div class="form-group">
																<select
																	name="func_sn_vt" id="func_sn_vt" class="form-control">
																	<option value="">Selecione</option>
																	<option value="S" <?php echo (isset($rs_dados->func_sn_vt) && $rs_dados->func_sn_vt == "S") ? 'selected' : ''; ?>>Sim</option>
																	<option value="N" <?php echo (isset($rs_dados->func_sn_vt) && $rs_dados->func_sn_vt == "N") ? 'selected' : ''; ?>>Não</option>
																</select>
															</div>
														</div>
													</div>
												</div>

												<div class="row">
													<div class="col-12 col-md-12">
														<div class="form-group">
															<label class="form-label" for="func_observacoes">Observações</label>
															<textarea name="func_observacoes" id="func_observacoes" class="form-control" rows="6"><?php echo ((isset($rs_dados->func_observacoes) ? $rs_dados->func_observacoes : "")); ?></textarea>
														</div>
													</div>
												</div>

											</div>

											<!-- <div class="tab-pane fade" id="nav-dependentes" role="tabpanel" aria-labelledby="nav-dependentes-tab">

												<div class="row gx-2">
													<div class="col-12 col-md-3">
														<div class="form-group">
															<label class="form-label" for="func_dep_nome">Nome</label>
														</div>
													</div>
													<div class="col-12 col-md">
														<div class="row gx-2">
															<div class="col-12 col-md-6">
																<div class="form-group">
																	<label class="form-label" for="func_dep_dt_nasc">Nascimento</label>
																</div>
															</div>
															<div class="col-12 col-md-6">
																<div class="form-group">
																	<label class="form-label" for="func_dep_sexo">Sexo</label>
																</div>
															</div>
														</div>
													</div>

													<div class="col-12 col-md-3">
														<div class="form-group">
															<label class="form-label" for="func_dep_tipo">Tipo</label>
														</div>
													</div>
													<div class="col-12 col-md-1">
														<div class="form-group">
															<label class="form-label" for="func_observacoes">IR</label>
														</div>
													</div>
													<div class="col-12 col-md-1">
														<div class="form-group">
															<label class="form-label" for="func_observacoes">SF</label>
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

												<div id="BOX-CONTENT-ITEM-DEPENDENTE">
													<?php
													if (isset($rs_list_dependentes)) {
														$count = 0;
														foreach ($rs_list_dependentes->getResult() as $row) {
															$count++;
															$func_dep_id = (int)($row->func_dep_id);
															$func_id = (int)($row->func_id);
															$func_dep_hashkey = ($row->func_dep_hashkey);
															$func_dep_hash_item = ($row->func_dep_hash_item);
															$func_dep_nome_doc = ($row->func_dep_nome_doc);
															$func_dep_anexo = ($row->func_dep_anexo);
															$func_dep_data = ($row->func_dep_data);
															$func_dep_data = fct_formatdate($func_dep_data, 'd/m/Y');
															$func_dep_validade = ($row->func_dep_validade);
															$func_dep_validade = fct_formatdate($func_dep_validade, 'd/m/Y');
															$func_dep_ativo = (int)($row->func_dep_ativo);
															$func_dep_tipo = ($row->func_dep_tipo);


													?>
															<div class="trRow mb-2">
																<div class="row gx-2 align-items-end">
																	<div class="col-12 col-md-3">
																		<div class="form-group">
																			<div class="form-group">
																				<select
																					name="func_arq_nome_doc[<?php echo ($func_arq_hash_item); ?>]" id="func_arq_nome_doc[<?php echo ($func_arq_hash_item); ?>]" class="form-select form-select-sm">
																					<option disabled value="">Selecione</option>
																					<option value="Certidão de Nascimento" <?php echo (isset($func_arq_nome_doc) && $func_arq_nome_doc == "Certidão de Nascimento") ? 'selected' : ''; ?>>Certidão de Nascimento</option>
																					<option value="Certidão de casamento" <?php echo (isset($func_arq_nome_doc) && $func_arq_nome_doc == "Certidão de casamento") ? 'selected' : ''; ?>>Certidão de casamento</option>
																					<option value="Comprovante de Residência" <?php echo (isset($func_arq_nome_doc) && $func_arq_nome_doc == "Comprovante de Residência") ? 'selected' : ''; ?>>Comprovante de Residência</option>
																					<option value="RG" <?php echo (isset($func_arq_nome_doc) && $func_arq_nome_doc == "RG") ? 'selected' : ''; ?>>RG</option>
																					<option value="CPF" <?php echo (isset($func_arq_nome_doc) && $func_arq_nome_doc == "CPF") ? 'selected' : ''; ?>>CPF</option>
																					<option value="Titulo" <?php echo (isset($func_arq_nome_doc) && $func_arq_nome_doc == "Titulo") ? 'selected' : ''; ?>>Titulo</option>
																				</select>
																			</div>
																		</div>
																	</div>
																	<div class="col-12 col-md">
																		<div class="row gx-2 align-items-end">
																			<div class="col-12 col-md-6" style="display: none">
																				<div class="form-group">
																					<input type="text" name="func_arq_tipo[<?php echo ($func_arq_hash_item); ?>]" id="func_arq_tipo_[<?php echo ($func_arq_hash_item); ?>]" class="form-control form-control-sm" value="Documento" />
																				</div>
																			</div>
																			<div class="col-12 col-md-6">
																				<div class="form-group">
																					<input type="text" name="func_arq_data[<?php echo ($func_arq_hash_item); ?>]" id="func_arq_data_<?php echo ($func_arq_hash_item); ?>" class="form-control form-control-sm mask-date flatpickr_date" value="<?php echo ($func_arq_data); ?>" />
																				</div>
																			</div>
																			<div class="col-12 col-md-6">
																				<div class="form-group">
																					<input type="text" name="func_arq_validade[<?php echo ($func_arq_hash_item); ?>]" id="func_arq_validade_<?php echo ($func_arq_hash_item); ?>" class="form-control form-control-sm mask-date flatpickr_date" value="<?php echo ($func_arq_validade); ?>" />
																				</div>
																			</div>
																		</div>
																	</div>
																	<div class="col-12 col-md-3">
																		<div class="form-group d-flex">
																			<input type="file" name="func_arq_anexo_<?php echo ($func_arq_hash_item); ?>" id="func_arq_anexo_<?php echo ($func_arq_hash_item); ?>" class="form-control form-control-sm inputfile inputfile-1" data-multiple-caption="{count} files selected" />
																			<label for="func_arq_anexo_<?php echo ($func_arq_hash_item); ?>"><span><?php echo ($label_anexo); ?></span></label>
																			<?php if (!empty($func_arq_anexo)) { ?>
																				<div style="width: 50px;">
																					<a href="<?php echo ($link_download); ?>" target="_blank" style="font-size: 1.5rem; color: #00af29; padding: 0 8px;"><i class="las la-file-download"></i></a>
																				</div>
																			<?php } ?>
																		</div>
																	</div>
																	<div class="col-12 col-md-2">
																		<div class="form-group">
																			<select class="form-select form-select-sm" name="func_arq_status[<?php echo ($func_arq_hash_item); ?>]" id="func_arq_status_<?php echo ($func_arq_hash_item); ?>">
																				<option value="" translate="no">- selecione -</option>
																				<?php
																				if (isset($cfgStatus)) {
																					foreach ($cfgStatus as $key => $val) {
																						$label = $val['label'];
																						$value = $val['value'];
																						$selected = (($value == $func_arq_ativo) ? ' selected ' : '');
																				?>
																						<option value="<?php echo ($value); ?>" <?php echo ($selected); ?> translate="no"><?php echo ($label); ?></option>
																				<?php
																					}
																				}
																				?>
																			</select>
																		</div>
																	</div>
																	<div class="col-12 col-md-auto align-self-center" style="width: 50px;">
																		<a href="javascript:;" class="cmdDELETARARQ" data-hashkey="<?php echo ($func_arq_hashkey); ?>" data-funcid="<?php echo ($func_id); ?>" style="font-size: 1.5rem; color: red; padding: 0 8px;"><i class="las la-times-circle"></i></a>
																	</div>
																</div>
															</div>
													<?php
														}
													}
													?>
												</div>

												<div class="pt-3">
													<div class="row justify-content-end">
														<div class="col-12 col-md-2">
															<div class="form-group">
																<button type="button" class="btn btn-sm btn-warning cmdAddArquivo" value="">Add Novo Arquivo</button>
															</div>
														</div>
													</div>
												</div>

											</div> -->
											<div class="tab-pane fade" id="nav-documentos" role="tabpanel" aria-labelledby="nav-documentos-tab">

												<div class="row gx-2">
													<div class="col-12 col-md-3">
														<div class="form-group">
															<label class="form-label" for="func_observacoes">Nome do Documento</label>
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
															<label class="form-label" for="func_observacoes">Anexo</label>
														</div>
													</div>
													<div class="col-12 col-md-2">
														<div class="form-group">
															<label class="form-label" for="func_observacoes">Status</label>
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
													if (isset($rs_list_arquivos)) {
														$count = 0;
														foreach ($rs_list_arquivos->getResult() as $row) {
															$count++;
															$func_arq_id = (int)($row->func_arq_id);
															$func_id = (int)($row->func_id);
															$func_arq_hashkey = ($row->func_arq_hashkey);
															$func_arq_hash_item = ($row->func_arq_hash_item);
															$func_arq_nome_doc = ($row->func_arq_nome_doc);
															$func_arq_anexo = ($row->func_arq_anexo);
															$func_arq_data = ($row->func_arq_data);
															$func_arq_data = fct_formatdate($func_arq_data, 'd/m/Y');
															$func_arq_validade = ($row->func_arq_validade);
															$func_arq_validade = fct_formatdate($func_arq_validade, 'd/m/Y');
															$func_arq_ativo = (int)($row->func_arq_ativo);
															$func_arq_tipo = ($row->func_arq_tipo);

															$label_anexo = "Escolher Arquivo";
															$link_download = "javascript:;";
															if (!empty($func_arq_anexo)) {
																$label_anexo = $func_arq_anexo;
																$link_download = base_url($folder_upload . 'funcionarios/' . $func_arq_anexo);
															}
													?>
															<div class="trRow mb-2">
																<div class="row gx-2 align-items-end">
																	<div class="col-12 col-md-3">
																		<div class="form-group">
																			<div class="form-group">
																				<select
																					name="func_arq_nome_doc[<?php echo ($func_arq_hash_item); ?>]" id="func_arq_nome_doc[<?php echo ($func_arq_hash_item); ?>]" class="form-select form-select-sm">
																					<option disabled value="">Selecione</option>
																					<option value="Certidão de Nascimento" <?php echo (isset($func_arq_nome_doc) && $func_arq_nome_doc == "Certidão de Nascimento") ? 'selected' : ''; ?>>Certidão de Nascimento</option>
																					<option value="Certidão de casamento" <?php echo (isset($func_arq_nome_doc) && $func_arq_nome_doc == "Certidão de casamento") ? 'selected' : ''; ?>>Certidão de casamento</option>
																					<option value="Comprovante de Residência" <?php echo (isset($func_arq_nome_doc) && $func_arq_nome_doc == "Comprovante de Residência") ? 'selected' : ''; ?>>Comprovante de Residência</option>
																					<option value="RG" <?php echo (isset($func_arq_nome_doc) && $func_arq_nome_doc == "RG") ? 'selected' : ''; ?>>RG</option>
																					<option value="CPF" <?php echo (isset($func_arq_nome_doc) && $func_arq_nome_doc == "CPF") ? 'selected' : ''; ?>>CPF</option>
																					<option value="Titulo" <?php echo (isset($func_arq_nome_doc) && $func_arq_nome_doc == "Titulo") ? 'selected' : ''; ?>>Titulo</option>
																				</select>
																			</div>
																		</div>
																	</div>
																	<div class="col-12 col-md">
																		<div class="row gx-2 align-items-end">
																			<div class="col-12 col-md-6" style="display: none">
																				<div class="form-group">
																					<input type="text" name="func_arq_tipo[<?php echo ($func_arq_hash_item); ?>]" id="func_arq_tipo_[<?php echo ($func_arq_hash_item); ?>]" class="form-control form-control-sm" value="Documento" />
																				</div>
																			</div>
																			<div class="col-12 col-md-6">
																				<div class="form-group">
																					<input type="text" name="func_arq_data[<?php echo ($func_arq_hash_item); ?>]" id="func_arq_data_<?php echo ($func_arq_hash_item); ?>" class="form-control form-control-sm mask-date flatpickr_date" value="<?php echo ($func_arq_data); ?>" />
																				</div>
																			</div>
																			<div class="col-12 col-md-6">
																				<div class="form-group">
																					<input type="text" name="func_arq_validade[<?php echo ($func_arq_hash_item); ?>]" id="func_arq_validade_<?php echo ($func_arq_hash_item); ?>" class="form-control form-control-sm mask-date flatpickr_date" value="<?php echo ($func_arq_validade); ?>" />
																				</div>
																			</div>
																		</div>
																	</div>
																	<div class="col-12 col-md-3">
																		<div class="form-group d-flex">
																			<input type="file" name="func_arq_anexo_<?php echo ($func_arq_hash_item); ?>" id="func_arq_anexo_<?php echo ($func_arq_hash_item); ?>" class="form-control form-control-sm inputfile inputfile-1" data-multiple-caption="{count} files selected" />
																			<label for="func_arq_anexo_<?php echo ($func_arq_hash_item); ?>"><span><?php echo ($label_anexo); ?></span></label>
																			<?php if (!empty($func_arq_anexo)) { ?>
																				<div style="width: 50px;">
																					<a href="<?php echo ($link_download); ?>" target="_blank" style="font-size: 1.5rem; color: #00af29; padding: 0 8px;"><i class="las la-file-download"></i></a>
																				</div>
																			<?php } ?>
																		</div>
																	</div>
																	<div class="col-12 col-md-2">
																		<div class="form-group">
																			<select class="form-select form-select-sm" name="func_arq_status[<?php echo ($func_arq_hash_item); ?>]" id="func_arq_status_<?php echo ($func_arq_hash_item); ?>">
																				<option value="" translate="no">- selecione -</option>
																				<?php
																				if (isset($cfgStatus)) {
																					foreach ($cfgStatus as $key => $val) {
																						$label = $val['label'];
																						$value = $val['value'];
																						$selected = (($value == $func_arq_ativo) ? ' selected ' : '');
																				?>
																						<option value="<?php echo ($value); ?>" <?php echo ($selected); ?> translate="no"><?php echo ($label); ?></option>
																				<?php
																					}
																				}
																				?>
																			</select>
																		</div>
																	</div>
																	<div class="col-12 col-md-auto align-self-center" style="width: 50px;">
																		<a href="javascript:;" class="cmdDELETARARQ" data-hashkey="<?php echo ($func_arq_hashkey); ?>" data-funcid="<?php echo ($func_id); ?>" style="font-size: 1.5rem; color: red; padding: 0 8px;"><i class="las la-times-circle"></i></a>
																	</div>
																</div>
															</div>
													<?php
														}
													}
													?>
												</div>

												<div class="pt-3">
													<div class="row justify-content-end">
														<div class="col-12 col-md-2">
															<div class="form-group">
																<button type="button" class="btn btn-sm btn-warning cmdAddArquivo" value="">Add Novo Arquivo</button>
															</div>
														</div>
													</div>
												</div>

											</div>
											<div class="tab-pane fade" id="nav-exames" role="tabpanel" aria-labelledby="nav-exames-tab">

												<div class="row gx-2">
													<div class="col-12 col-md-3">
														<div class="form-group">
															<label class="form-label" for="func_observacoes">Nome do Documento</label>
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
															<label class="form-label" for="func_observacoes">Anexo</label>
														</div>
													</div>
													<div class="col-12 col-md-2">
														<div class="form-group">
															<label class="form-label" for="func_observacoes">Status</label>
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

												<div id="BOX-CONTENT-ITEM-EXAME">
													<?php
													if (isset($rs_list_exames)) {
														$count = 0;
														foreach ($rs_list_exames->getResult() as $row) {
															$count++;
															$func_arq_id = (int)($row->func_arq_id);
															$func_id = (int)($row->func_id);
															$func_arq_hashkey = ($row->func_arq_hashkey);
															$func_arq_hash_item = ($row->func_arq_hash_item);
															$func_arq_nome_doc = ($row->func_arq_nome_doc);
															$func_arq_anexo = ($row->func_arq_anexo);
															$func_arq_data = ($row->func_arq_data);
															$func_arq_data = fct_formatdate($func_arq_data, 'd/m/Y');
															$func_arq_validade = ($row->func_arq_validade);
															$func_arq_validade = fct_formatdate($func_arq_validade, 'd/m/Y');
															$func_arq_ativo = (int)($row->func_arq_ativo);
															$func_arq_tipo = ($row->func_arq_tipo);

															$label_anexo = "Escolher Arquivo";
															$link_download = "javascript:;";
															if (!empty($func_arq_anexo)) {
																$label_anexo = $func_arq_anexo;
																$link_download = base_url($folder_upload . 'funcionarios/' . $func_arq_anexo);
															}
													?>
															<div class="trRow mb-2">
																<div class="row gx-2 align-items-end">
																	<div class="col-12 col-md-3">
																		<div class="form-group">
																			<div class="form-group">
																				<input type="text" name="func_arq_nome_doc[<?php echo ($func_arq_hash_item); ?>]" id="func_arq_nome_doc_<?php echo ($func_arq_hash_item); ?>" class="form-control form-control-sm" value="<?php echo ($func_arq_nome_doc); ?>" />

																			</div>
																		</div>
																	</div>
																	<div class="col-12 col-md">
																		<div class="row gx-2 align-items-end">
																			<div class="col-12 col-md-6" style="display: none">
																				<div class="form-group">
																					<input type="text" name="func_arq_tipo[<?php echo ($func_arq_hash_item); ?>]" id="func_arq_tipo_[<?php echo ($func_arq_hash_item); ?>]" class="form-control form-control-sm" value="Exame" />
																				</div>
																			</div>
																			<div class="col-12 col-md-6">
																				<div class="form-group">
																					<input type="text" name="func_arq_data[<?php echo ($func_arq_hash_item); ?>]" id="func_arq_data_<?php echo ($func_arq_hash_item); ?>" class="form-control form-control-sm mask-date flatpickr_date" value="<?php echo ($func_arq_data); ?>" />
																				</div>
																			</div>
																			<div class="col-12 col-md-6">
																				<div class="form-group">
																					<input type="text" name="func_arq_validade[<?php echo ($func_arq_hash_item); ?>]" id="func_arq_validade_<?php echo ($func_arq_hash_item); ?>" class="form-control form-control-sm mask-date flatpickr_date" value="<?php echo ($func_arq_validade); ?>" />
																				</div>
																			</div>
																		</div>
																	</div>
																	<div class="col-12 col-md-3">
																		<div class="form-group d-flex">
																			<input type="file" name="func_arq_anexo_<?php echo ($func_arq_hash_item); ?>" id="func_arq_anexo_<?php echo ($func_arq_hash_item); ?>" class="form-control form-control-sm inputfile inputfile-1" data-multiple-caption="{count} files selected" />
																			<label for="func_arq_anexo_<?php echo ($func_arq_hash_item); ?>"><span><?php echo ($label_anexo); ?></span></label>
																			<?php if (!empty($func_arq_anexo)) { ?>
																				<div style="width: 50px;">
																					<a href="<?php echo ($link_download); ?>" target="_blank" style="font-size: 1.5rem; color: #00af29; padding: 0 8px;"><i class="las la-file-download"></i></a>
																				</div>
																			<?php } ?>
																		</div>
																	</div>
																	<div class="col-12 col-md-2">
																		<div class="form-group">
																			<select class="form-select form-select-sm" name="func_arq_status[<?php echo ($func_arq_hash_item); ?>]" id="func_arq_status_<?php echo ($func_arq_hash_item); ?>">
																				<option value="" translate="no">- selecione -</option>
																				<?php
																				if (isset($cfgStatus)) {
																					foreach ($cfgStatus as $key => $val) {
																						$label = $val['label'];
																						$value = $val['value'];
																						$selected = (($value == $func_arq_ativo) ? ' selected ' : '');
																				?>
																						<option value="<?php echo ($value); ?>" <?php echo ($selected); ?> translate="no"><?php echo ($label); ?></option>
																				<?php
																					}
																				}
																				?>
																			</select>
																		</div>
																	</div>
																	<div class="col-12 col-md-auto align-self-center" style="width: 50px;">
																		<a href="javascript:;" class="cmdDELETARARQ" data-hashkey="<?php echo ($func_arq_hashkey); ?>" data-funcid="<?php echo ($func_id); ?>" style="font-size: 1.5rem; color: red; padding: 0 8px;"><i class="las la-times-circle"></i></a>
																	</div>
																</div>
															</div>
													<?php
														}
													}
													?>
												</div>

												<div class="pt-3">
													<div class="row justify-content-end">
														<div class="col-12 col-md-2">
															<div class="form-group">
																<button type="button" class="btn btn-sm btn-warning cmdAddExame" value="">Add Novo Arquivo</button>
															</div>
														</div>
													</div>
												</div>

											</div>
											<div class="tab-pane fade" id="nav-cursos" role="tabpanel" aria-labelledby="nav-cursos-tab">

												<div class="row gx-2">
													<div class="col-12 col-md-3">
														<div class="form-group">
															<label class="form-label" for="func_observacoes">Nome do Documento</label>
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
															<label class="form-label" for="func_observacoes">Anexo</label>
														</div>
													</div>
													<div class="col-12 col-md-2">
														<div class="form-group">
															<label class="form-label" for="func_observacoes">Status</label>
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

												<div id="BOX-CONTENT-ITEM-CURSO">
													<?php
													if (isset($rs_list_cursos)) {
														$count = 0;
														foreach ($rs_list_cursos->getResult() as $row) {
															$count++;
															$func_arq_id = (int)($row->func_arq_id);
															$func_id = (int)($row->func_id);
															$func_arq_hashkey = ($row->func_arq_hashkey);
															$func_arq_hash_item = ($row->func_arq_hash_item);
															$func_arq_nome_doc = ($row->func_arq_nome_doc);
															$func_arq_anexo = ($row->func_arq_anexo);
															$func_arq_data = ($row->func_arq_data);
															$func_arq_data = fct_formatdate($func_arq_data, 'd/m/Y');
															$func_arq_validade = ($row->func_arq_validade);
															$func_arq_validade = fct_formatdate($func_arq_validade, 'd/m/Y');
															$func_arq_ativo = (int)($row->func_arq_ativo);
															$func_arq_tipo = ($row->func_arq_tipo);

															$label_anexo = "Escolher Arquivo";
															$link_download = "javascript:;";
															if (!empty($func_arq_anexo)) {
																$label_anexo = $func_arq_anexo;
																$link_download = base_url($folder_upload . 'funcionarios/' . $func_arq_anexo);
															}
													?>
															<div class="trRow mb-2">
																<div class="row gx-2 align-items-end">
																	<div class="col-12 col-md-3">
																		<div class="form-group">
																			<div class="form-group">
																				<input type="text" name="func_arq_nome_doc[<?php echo ($func_arq_hash_item); ?>]" id="func_arq_nome_doc_<?php echo ($func_arq_hash_item); ?>" class="form-control form-control-sm" value="<?php echo ($func_arq_nome_doc); ?>" />

																			</div>
																		</div>
																	</div>
																	<div class="col-12 col-md">
																		<div class="row gx-2 align-items-end">
																			<div class="col-12 col-md-6" style="display: none">
																				<div class="form-group">
																					<input type="text" name="func_arq_tipo[<?php echo ($func_arq_hash_item); ?>]" id="func_arq_tipo_[<?php echo ($func_arq_hash_item); ?>]" class="form-control form-control-sm" value="Curso" />
																				</div>
																			</div>
																			<div class="col-12 col-md-6">
																				<div class="form-group">
																					<input type="text" name="func_arq_data[<?php echo ($func_arq_hash_item); ?>]" id="func_arq_data_<?php echo ($func_arq_hash_item); ?>" class="form-control form-control-sm mask-date flatpickr_date" value="<?php echo ($func_arq_data); ?>" />
																				</div>
																			</div>
																			<div class="col-12 col-md-6">
																				<div class="form-group">
																					<input type="text" name="func_arq_validade[<?php echo ($func_arq_hash_item); ?>]" id="func_arq_validade_<?php echo ($func_arq_hash_item); ?>" class="form-control form-control-sm mask-date flatpickr_date" value="<?php echo ($func_arq_validade); ?>" />
																				</div>
																			</div>
																		</div>
																	</div>
																	<div class="col-12 col-md-3">
																		<div class="form-group d-flex">
																			<input type="file" name="func_arq_anexo_<?php echo ($func_arq_hash_item); ?>" id="func_arq_anexo_<?php echo ($func_arq_hash_item); ?>" class="form-control form-control-sm inputfile inputfile-1" data-multiple-caption="{count} files selected" />
																			<label for="func_arq_anexo_<?php echo ($func_arq_hash_item); ?>"><span><?php echo ($label_anexo); ?></span></label>
																			<?php if (!empty($func_arq_anexo)) { ?>
																				<div style="width: 50px;">
																					<a href="<?php echo ($link_download); ?>" target="_blank" style="font-size: 1.5rem; color: #00af29; padding: 0 8px;"><i class="las la-file-download"></i></a>
																				</div>
																			<?php } ?>
																		</div>
																	</div>
																	<div class="col-12 col-md-2">
																		<div class="form-group">
																			<select class="form-select form-select-sm" name="func_arq_status[<?php echo ($func_arq_hash_item); ?>]" id="func_arq_status_<?php echo ($func_arq_hash_item); ?>">
																				<option value="" translate="no">- selecione -</option>
																				<?php
																				if (isset($cfgStatus)) {
																					foreach ($cfgStatus as $key => $val) {
																						$label = $val['label'];
																						$value = $val['value'];
																						$selected = (($value == $func_arq_ativo) ? ' selected ' : '');
																				?>
																						<option value="<?php echo ($value); ?>" <?php echo ($selected); ?> translate="no"><?php echo ($label); ?></option>
																				<?php
																					}
																				}
																				?>
																			</select>
																		</div>
																	</div>
																	<div class="col-12 col-md-auto align-self-center" style="width: 50px;">
																		<a href="javascript:;" class="cmdDELETARARQ" data-hashkey="<?php echo ($func_arq_hashkey); ?>" data-funcid="<?php echo ($func_id); ?>" style="font-size: 1.5rem; color: red; padding: 0 8px;"><i class="las la-times-circle"></i></a>
																	</div>
																</div>
															</div>
													<?php
														}
													}
													?>
												</div>

												<div class="pt-3">
													<div class="row justify-content-end">
														<div class="col-12 col-md-2">
															<div class="form-group">
																<button type="button" class="btn btn-sm btn-warning cmdAddCurso" value="">Add Novo Arquivo</button>
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


<script id="mstcItemExame" type="text/x-jquery-tmpl">
	<div class="{{trRow}} mb-2">
			<div class="row gx-2 align-items-end">
				<div class="col-12 col-md-3">
					<div class="form-group">
					<input type="text" name="func_arq_nome_doc[{{hashitem}}]" id="func_arq_nome_doc{{hashitem}}" class="form-control form-control-sm" value="" />

					</div>
				</div>
				<div class="col-12 col-md">
					<div class="row gx-2 align-items-end">
						<div class="col-12 col-md-6" style="display: none">
							<div class="form-group">
								<input type="text" name="func_arq_tipo[{{hashitem}}]" id="func_arq_tipo_{{hashitem}}" class="form-control form-control-sm" value="Exame" />
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


<script id="mstcItemCurso" type="text/x-jquery-tmpl">
	<div class="{{trRow}} mb-2">
			<div class="row gx-2 align-items-end">
				<div class="col-12 col-md-3">
					<div class="form-group">
					<input type="text" name="func_arq_nome_doc[{{hashitem}}]" id="func_arq_nome_doc{{hashitem}}" class="form-control form-control-sm" value="" />

					</div>
				</div>
				<div class="col-12 col-md">
					<div class="row gx-2 align-items-end">
						<div class="col-12 col-md-6" style="display: none">
							<div class="form-group">
								<input type="text" name="func_arq_tipo[{{hashitem}}]" id="func_arq_tipo_{{hashitem}}" class="form-control form-control-sm" value="Curso" />
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
	var fct_count_item_exames = function(p, callback) {
		let $box = $('#BOX-CONTENT-ITEM-EXAME');
		let $qtdItem = $box.find('.trRow');
		if ($qtdItem.length == 0) {
			$(".cmdAddExame").trigger("click");
		}
	}
	var fct_count_item_cursos = function(p, callback) {
		let $box = $('#BOX-CONTENT-ITEM-CURSO');
		let $qtdItem = $box.find('.trRow');
		if ($qtdItem.length == 0) {
			$(".cmdAddCurso").trigger("click");
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
		//Adiciona exame
		$(document).on('click', '.cmdAddExame', function(e) {
			let templateData = {
				item: 1,
				trRow: 'trRow',
				hashitem: fct_random_string(8)
			};
			let template = $("#mstcItemExame").html();
			$('#BOX-CONTENT-ITEM-EXAME').append(Mustache.render(template, templateData));

			let $el = $('#BOX-CONTENT-ITEM-EXAME');
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
		//Adiciona Curso
		$(document).on('click', '.cmdAddCurso', function(e) {
			let templateData = {
				item: 1,
				trRow: 'trRow',
				hashitem: fct_random_string(8)
			};
			let template = $("#mstcItemCurso").html();
			$('#BOX-CONTENT-ITEM-CURSO').append(Mustache.render(template, templateData));

			let $el = $('#BOX-CONTENT-ITEM-CURSO');
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
			let $funcid = $this.data("funcid");
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
							fct_count_item_exames();
							fct_count_item_cursos();
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
					fct_count_item_exames();
					fct_count_item_cursos();
				}
			});
		});

		fct_count_item_arquivos();
		fct_count_item_exames();
		fct_count_item_cursos();


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