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
				<h2 class="page-title">Calendário</h2>
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

										<!-- <div class="d-flex justify-content-end"> -->
										<!-- 	<div style="margin-left: 5px;"><a href="<?php echo(site_url('calendario/form')); ?>" class="btn btn-sm btn-primary">Novo Registro</a></div> -->
										<!-- </div> -->

									</div>
								</div>
							</div>
							<div class="card-body" style="padding: 1rem 0;">
								<div class="box-content">

									<div class="row">
										<div class="col-9">
											<?php 
												//print_r($rs_evet);
											?>
											<div class="mb-3" id="calendar" style="padding: 0rem 0;"></div>
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


<?php $this->endSection('headers'); ?>

<?php $this->section('scripts'); ?>

	<script>
		let URL_EVENT_CALENDAR = '<?php echo(site_url()); ?>/calendario/ajaxform/GET-EVENTOS-CALENDAR';
	</script>

	<script src='assets/plugins/fullcalendar/dist/index.global.js'></script>
	<script src='assets/plugins/fullcalendar/packages/core/locales/pt-br.global.js'></script>

	<style>

		.fc .fc-daygrid-day-events {
			display: flex !important;
			padding-left: 6px;
		}
		.fc-daygrid-event-dot {
			border: calc(14px/2) solid var(--fc-event-border-color);
			border-radius: 50%;
			border-color: rgb(246 0 0) !important;
			box-sizing: content-box;
			height: 0px;
			margin: 0px !important;
			width: 0px;
		}
		.fc-daygrid-event-dot:hover {
			border-color: rgb(170 220 46) !important;
		}
		a.fc-event{
			/*height: 14px !important;*/
			/*width: 14px !important;*/
			/*border-radius: 50%;*/
			/*text-indent: -5000px;*/
			/*margin-bottom: 2px !important;*/

			margin: 1px;
			font-size: 10px !important;
			height: 13px !important;
			width: 13px !important;
			border-radius: 50% !important;
			text-indent: -5000px;
			/*margin-right: 5px;*/
		}
	</style>

    <script>
		document.addEventListener('DOMContentLoaded', function() {
			var calendarEl = document.getElementById('calendar');
			var calendar = new FullCalendar.Calendar(calendarEl, {
				initialView: 'dayGridMonth',
				locale: 'pt-br',
				headerToolbar: {
					left: 'title',
					right: 'today prev,next',
					//right: 'dayGridMonth'
				},
				<?php if( isset($rs_eventos)) { ?>
				events: <?php echo($rs_eventos); ?>
				<?php } ?>
			});
		calendar.render();
		});
    </script>

<?php $this->endSection('scripts'); ?>