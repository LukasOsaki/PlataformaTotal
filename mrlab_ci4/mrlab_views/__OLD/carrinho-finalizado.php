<?php 
	$this->extend('templates/template_default');
	$this->section('content'); 
?>

	<div id="app">
		<section class="mt-4 mb-4">
			<div class="row justify-content-center mt-5">
				<div class="col-12 col-md-12 text-center mt-5">
					<h2><strong>Seu pedido foi concluído!</strong></h2>
					<h4>Obrigado. Seu pedido foi recebido.</h4>
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