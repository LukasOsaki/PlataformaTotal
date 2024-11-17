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
						<h1 class="p-0 m-0">Usuários</h1>
					</div>
				</div>


				<?php if( $session_user_acesso == 'admin' ){ ?>
				<div class="d-flex justify-content-end">
					<div>
						<a href="<?php echo($link_form); ?>" class="btn btn-sm btn-primary">Adicionar Novo Registro</a>
					</div>
				</div>
				<?php } ?>


				<div class="mt-4">

					<div class="row justify-content-around">
						<div class="col-12 col-md-9">
							<?php
							if( isset($rs_user) ){
								foreach ($rs_user->getResult() as $row) {
									$user_id = ($row->user_id);
									$user_hashkey = ($row->user_hashkey);
									$user_nome = ($row->user_nome);
									$user_email = ($row->user_email);

									$link_form_edit = $link_form .'/'. $user_id; 
							?>
							<div class="colab-box-content">
								<div class="colab-box-header d-flex justify-content-between align-items-center">
									<div style="width: 100%;">
										<a href="<?php echo($link_form_edit); ?>"><?php echo($user_nome); ?> / <?php echo($user_email); ?></a>
									</div>
									<div style="width: 40px;font-size: .8rem; text-align: end;">
										<a href="javascript:;" class="cmdArquivarRegistro" data-hashkey="<?php echo($user_hashkey); ?>"><img src="assets/media/delete.png" class="img-fluid" style="max-width: 24px;" /></a>
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



<?php
	$this->endSection('content'); 
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

	<!-- Sweet Alert -->
	<link href="assets/plugins/sweet-alert2/sweetalert2.min.css" rel="stylesheet" type="text/css">
	<script src="assets/plugins/sweet-alert2/sweetalert2.min.js"></script>

	<script>
	$(document).ready(function () {
		$(document).on('click', '.cmdArquivarRegistro', function (e) {
			e.preventDefault();
			let $this = $(this);
			let $hashkey = $this.data( "hashkey" );
			let $row = $this.closest( ".trRow" );

			Swal.fire({
				title: 'Atenção!',
				icon: 'warning',
				html:
					'Você esta prestes a arquivar este registro.<br>' +
					'Deseja Continuar?',
				//type: 'warning',
				showCancelButton: true,
				cancelButtonColor: "#AAAAAA",
				confirmButtonColor: "#3c973e",
				//confirmButtonColor: '$danger',
				//cancelButtonColor: '$success',
				confirmButtonText: 'Sim! Continue',
				cancelButtonText: 'Cancelar',
				reverseButtons: true
			}).then(function(result) {
				if (result.value) {
					//$row.remove();

					// ------------------------------------------------------
					let $formData = {
						hashkey: $hashkey
					};

					//$msg.html('Aguarde. Estamos processando').show();
					$.ajax({
						url: SITE_URL  +'usuarios/ajaxform/ARQUIVAR-USUARIO',
						method:"POST",
						type: "POST",
						dataType: "json",
						data: $formData,
						crossDomain: true,
						beforeSend: function(response) {
							//console.log('1 beforeSend');
							//console.log(response);
						},
						complete: function(response) { 
							//console.log('3 complete');
							//console.log(response);
						},
						success:function(response){
							//console.log('2 success');
							console.log(response);

							$row.remove();
						},
						error: function (jqXHR, textStatus, errorThrown) {
						}
					});
					// ------------------------------------------------------
				}
			});
		});
	});
	</script>

<?php $this->endSection('scripts'); ?>