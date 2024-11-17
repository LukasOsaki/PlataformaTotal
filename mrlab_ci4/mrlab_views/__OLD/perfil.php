<?php 
	$this->extend('templates/template_default');
	$this->section('content'); 

	$session_id = (isset($session_id) ? $session_id : '');
	$session_user_id = (int)(isset($session_user_id) ? $session_user_id : ''); 
	$session_user_nome =(isset($session_user_nome) ? $session_user_nome : ''); 
	$session_user_acesso = (isset($session_user_acesso) ? $session_user_acesso : ''); 
	$session_user_acesso_label = (isset($session_user_acesso_label) ? $session_user_acesso_label : '');


?>

	<div id="app">
		<section class="mt-4 mb-4">

			<div class="row justify-content-evenly mt-5 mb-2">
				<div class="col-12 col-md-5">

					<!-- Nav tabs -->
					<ul class="nav nav-tabs justify-content-center" role="tablist">
						<li class="nav-item">
							<a class="nav-link nav-link_underscore active" data-bs-toggle="tab" href="#tb-login" role="tab" aria-selected="true">LOGIN</a>
						</li>
						<li class="nav-item">
							<a class="nav-link nav-link_underscore" data-bs-toggle="tab" href="#tb-account" role="tab" aria-selected="false">CRIAR CONTA</a>
						</li>
					</ul>

					<!-- Tab panes -->
					<div class="tab-content">
						<div class="tab-pane pt-3 pb-3 active" id="tb-login" role="tabpanel">

							<?php 
							$attr_form = ['class' => '', 'id' => 'formPerfilLogin', 'name' => 'formPerfilLogin', 'csrf_id' => 'secucity' ];
							echo form_open( site_url('perfil/login'), $attr_form ); ?>
							<div class="card card-login">
								<div class="card-body">

									<div class="form-group">
										<label>E-mail</label>
										<input type="text" class="form-control" id="lg_cad_email" name="lg_cad_email" placeholder="">
									</div>

									<div class="form-group">
										<label>Senha</label>
										<input type="text" class="form-control" id="lg_cad_senha" name="lg_cad_senha" placeholder="">
									</div>

								</div>
								<div class="card-footer">
									<div class="d-grid">
										<button class="btn btn-primary">Acessar</button>
									</div>	
								</div>
							</div>
							<?php echo form_close(); ?>

						</div>
						<div class="tab-pane pt-3 pb-3" id="tb-account" role="tabpanel">

							<?php 
							$attr_form = ['class' => '', 'id' => 'formPerfilConta', 'name' => 'formPerfilConta', 'csrf_id' => 'secucity' ];
							echo form_open( site_url('perfil/criar-conta'), $attr_form ); ?>
							<?php echo( csrf_field() ) ?>
							<div class="card card-login">
								<div class="card-body">

									<div class="form-group">
										<label class="form-label">Nome</label>
										<input type="text" class="form-control" id="cad_nome" name="cad_nome" placeholder="">
									</div>

									<div class="form-group">
										<label class="form-label">E-mail</label>
										<input type="text" class="form-control" id="cad_email" name="cad_email" placeholder="">
									</div>

									<div class="form-group">
										<label class="form-label">Senha</label>
										<input type="passowrd" class="form-control" id="cad_senha" name="cad_senha" placeholder="">
									</div>

								</div>
								<div class="card-footer">
									<div class="d-grid">
										<button class="btn btn-primary">Criar</button>
									</div>	
								</div>
							</div>
							<?php echo form_close(); ?>

						</div>
					</div>

				</div>
			</div>

		</section>
	</div>



<?php
	$this->endSection('content'); 
?>

<?php $time = time(); ?>
<?php $this->section('headers'); ?>

	<style>
	</style>

<?php $this->endSection('headers'); ?>

<?php $this->section('scripts'); ?>

	<script>
	</script>

<?php $this->endSection('scripts'); ?>