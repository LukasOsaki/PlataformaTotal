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
		<div class="row justify-content-around align-items-start">
			<div class="col-12 col-md-12">

				<div class="d-flex align-items-center">
					<div style="margin-right: 15px;">
						<img src="assets/media/user.png" style="height: 32px;" />
					</div>
					<div>
						<h1 class="p-0 m-0">Gerenciar Usuário</h1>
					</div>
				</div>


				<?php if( $session_user_acesso == 'admin' ){ ?>
				<div class="d-flex justify-content-end">
					<div>
						<a href="<?php echo($link_list); ?>" class="btn btn-sm btn-primary">Voltar</a>
					</div>
				</div>
				<?php } ?>


				<div class="mt-4">

					<?php 
					$attr_form = ['class' => '', 'id' => 'formEditRegistro', 'name' => 'formEditRegistro', 'csrf_id' => 'secucity' ];
					echo form_open_multipart( current_url(), $attr_form ); ?>
					<?php echo( csrf_field() ) ?>
					<div class="row justify-content-around">
						<div class="col-12 col-md-9">

							<div class="row">
								<div class="col-12 col-md-12">
									<div class="form-group">
										<label class="form-label" for="user_nome">Nome:</label>
										<input type="text" name="user_nome" id="user_nome" class="form-control" value="<?php echo( (isset($rs_edit->user_nome) ? $rs_edit->user_nome : "") ); ?>">
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-12 col-md-12">
									<div class="form-group">
										<label class="form-label" for="user_email">E-mail:</label>
										<input type="text" name="user_email" id="user_email" class="form-control" value="<?php echo( (isset($rs_edit->user_email) ? $rs_edit->user_email : "") ); ?>">
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-12 col-md-12">
									<div class="form-group">
										<label class="form-label" for="user_senha">Senha</label>
										<input type="password" name="user_senha" id="user_senha" class="form-control" value="">
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-12 col-md-12">
									<div class="form-group">
										<label class="form-label" for="user_avatar_file">Avatar</label>
										<input type="file" name="user_avatar_file" id="user_avatar_file" class="form-control" value="">
									</div>
								</div>
								<div class="col-12 col-md-12">
									<div class="form-group">
										<input type="text" name="user_avatar" id="user_avatar" class="form-control" value="<?php echo( (isset($rs_edit->user_avatar) ? $rs_edit->user_avatar : "") ); ?>">
									</div>
								</div>
							</div>

							<div class="row justify-content-center align-items-center mt-3">
								<div class="col-12 col-md-6">
									<div class="d-grid">										
										<input type="submit" class="btn btn-success" value="Salvar">
									</div>
								</div>
							</div>

						</div>
					</div>
					<?php echo form_close(); ?>

				</div>

			</div>
		</div>
	</div>



<?php
	$this->endSection('content'); 

	$cliente_id = ( isset($cliente_id) ? $cliente_id : 0);
?>

<?php $time = time(); ?>
<?php $this->section('headers'); ?>

	<style>
		.colab-box-content{
			border-radius: .75rem;
			border: 1px solid #818181;
			padding: 4px 8px;	
			margin-bottom: 4px;
		}
		.colab-box-header{
			font-weight: bold;
			font-size: 1rem;
			text-align: center;
		}
		.colab-box-icons{
			padding: 8px;
			border-top: 1px solid #cbcbcb;
			display: flex;
			justify-content: space-around;
			margin-top: 8px;
			/*display:none;*/
		}
		.colab-box-icons img{
			height: 30px;
		}

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

<?php $this->endSection('headers'); ?>

<?php $this->section('scripts'); ?>

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
	<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
	<script src="assets/plugins/flatpickr/flatpickr-locale-br.js"></script>

	<script>
		$(document).ready(function(){
			$.ajaxSetup({cache: false});

			$('.flatpickr_date').flatpickr({
				"locale": "pt",
				dateFormat:"d/m/Y",
			});
		});
	</script>

<?php $this->endSection('scripts'); ?>