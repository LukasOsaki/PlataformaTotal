<?php
namespace App\Controllers;
use App\Controllers\PainelController;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

use \DateTime;

class Importacao extends PainelController
{

	protected $clieMD = null;
	protected $eqtoMD = null;

	public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {

		parent::initController($request, $response, $logger);

		// Load the model
		 $this->clieMD = new \App\Models\ClientesModel();
		 $this->eqtoMD = new \App\Models\EquipamentosModel();

		date_default_timezone_set('America/Sao_Paulo');

		helper('text');
    }


	public function index()
	{
		
		if ($this->request->getMethod() == 'post')
		{
			$newFILENAME = "";
			$uplArqFileUpl = $this->request->getFile('uplArqFileUpl');
			if( $uplArqFileUpl )
			{
				if ($uplArqFileUpl->isValid() && ! $uplArqFileUpl->hasMoved())
				{
					//$newName = $uplArqFileUpl->getRandomName();
					$ext = $uplArqFileUpl->guessExtension();
					
					$newFILENAME = 'planilha_'. date("Y-m-d_His") .".". $uplArqFileUpl->guessExtension();

					$uplArqFileUpl->move( WRITEPATH .'/uploads/importacao', $newFILENAME);

					$arq_hashkey = md5(date("Y-m-d H:i:s"));

					$data_db = [
						'arq_hashkey' => $arq_hashkey,
						'arq_filename' => $newFILENAME,
						'arq_dte_alteracao' => date("Y-m-d H:i:s"),
						'arq_dte_cadastro' => date("Y-m-d H:i:s"),
						'arq_ativo' => 1,
					];
					//$this->data['data_db'] = $data_db;
					$arq_id = $this->arqMD->insert($data_db);





					return $this->response->redirect( admin_url('importacao/executar/'. $arq_hashkey) );

				}
			}

			return $this->response->redirect( admin_url('importacao/') );
		}

		return view($this->directory .'/importacao', $this->data);
	}


	public function importar_novos_clientes()
	{
		ini_set('memory_limit', '2048M');

		$executar = false;
		$executar_query = true;
		$query_insert_PRINT = "";

		// matricula	nome	prefixo	nome_uor_localizacao	Diretoria
		$data_colunas = [
			'B' => 'clie_nome_fantasia',
			'C' => 'clie_nome_razao',
			'D' => 'clie_cnpj',
			'E' => 'clie_endereco',
			'F' => 'clie_bairro',
			'G' => 'clie_cidade',
			'H' => 'clie_estado',
			'I' => 'clie_cep',
			'J' => 'clie_observacoes',
		];
		$path_file = WRITEPATH ."/uploads/importacao/Lista-para-Portal.xls";

		$inputFileName = $path_file;
		$inputFileType = IOFactory::identify($inputFileName);
		
		$reader = IOFactory::createReader($inputFileType);
		$spreadsheet = $reader->load($inputFileName);
		$sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

		// linhas
		$linha = 1;
		$clie_nome_fantasia = "";
		$clie_nome_razao = "";
		$clie_cnpj = "";
		$clie_endereco = "";
		$clie_bairro = "";
		$clie_cidade = "";
		$clie_estado = "";
		$clie_cep = "";
		$clie_observacoes = "";
		foreach ($sheetData as $row) {
			$linha++;

			// colunas
			print('<div style="padding: 2px; border-bottom: 1px dotted gray;">');
			//print( '<h3>'. $linha .'</h3><br>' );
			print( $linha .' | ' );
			foreach ($data_colunas as $key => $col) {
				$value = $spreadsheet->getActiveSheet()->getCell($key . $linha)->getValue();
				print( $value .' | ' );
				if( $key == 'B' ) { $clie_nome_fantasia = $value; }
				if( $key == 'C' ) { $clie_nome_razao = $value; }
				if( $key == 'D' ) { $clie_cnpj = $value; }
				if( $key == 'E' ) { $clie_endereco = $value; }
				if( $key == 'F' ) { $clie_bairro = $value; }
				if( $key == 'G' ) { $clie_cidade = $value; }
				if( $key == 'H' ) { $clie_estado = $value; }
				if( $key == 'I' ) { $clie_cep = $value; }
				if( $key == 'J' ) { $clie_observacoes = $value; }
				//if( $key == 'C' ) { 
				//	$cad_tipo_perfil = $value; 
				//	// mascaras para cpf
				//	//$cad_cpf = preg_replace("/[^0-9]/", "", $cad_cpf);
				//	//$cad_cpf = str_pad($cad_cpf, 11, '0', STR_PAD_LEFT);
				//	//$cad_cpf = fct_mask($cad_cpf, '###.###.###-##');
				//	//$cad_documento = $value;
				//}
			}

			if( !empty($clie_nome_razao) ){
				$data_db = [
					'clie_hashkey' =>md5(date("Y-m-d H:i:s") ."-". random_string('alnum', 16)),
					'clie_urlpage' => url_title( convert_accented_characters($clie_nome_razao), '-', TRUE ),
					'clie_nome_razao' => $clie_nome_razao,
					'clie_nome_fantasia' => $clie_nome_fantasia,
					'clie_cnpj' => $clie_cnpj,
					'clie_cep' => $clie_cep,
					'clie_endereco' => $clie_endereco,
					'clie_bairro' => $clie_bairro,
					'clie_cidade' => $clie_cidade,
					'clie_estado' => $clie_estado,
					'clie_observacoes' => $clie_observacoes,

					'clie_dte_cadastro' => date("Y-m-d H:i:s"),
					'clie_dte_alteracao' => date("Y-m-d H:i:s"),
					'clie_ativo' => 1,
				];
				$clie_id = $this->clieMD->insert($data_db);
				//$cad_id = $this->cadTempMD->insert($data_db);
				//print( $cad_id .' | ' );
			}else{
				print( '<span style="color:black;"><strong>em branco</strong></span> | ' );	
			}
			print('</div>');
		}
	}


	public function importar_novos_equipamentos()
	{
		ini_set('memory_limit', '2048M');

		$executar = false;
		$executar_query = true;
		$query_insert_PRINT = "";

		// matricula	nome	prefixo	nome_uor_localizacao	Diretoria
		$data_colunas = [
			'C' => 'clie_nome_fantasia',
			'E' => 'eqto_tag',
			'F' => 'eqto_titulo',
			'G' => 'eqto_setor',
			'H' => 'eqto_local',
			'I' => 'eqto_capacidade',
			'K' => 'eqto_fluido_ref',
			'L' => 'eqto_fabricante',
			'M' => 'eqto_modelo_cond',
			'N' => 'eqto_modelo_evap',
		];
		$path_file = WRITEPATH ."/uploads/importacao/Lista-para-Portal.xls";

		$inputFileName = $path_file;
		$inputFileType = IOFactory::identify($inputFileName);
		
		$reader = IOFactory::createReader($inputFileType);
		$spreadsheet = $reader->load($inputFileName);
		$sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

		// linhas
		$linha = 1;

		$clie_nome_fantasia = "";
		$eqto_tag = "";
		$eqto_titulo = "";
		$eqto_setor = "";
		$eqto_local = "";
		$eqto_capacidade = "";
		$eqto_fluido_ref = "";
		$eqto_fabricante = "";
		$eqto_modelo_cond = "";
		$eqto_modelo_evap = "";
		foreach ($sheetData as $row) {
			$linha++;

			// colunas
			print('<div style="padding: 2px; border-bottom: 1px dotted gray;">');
			//print( '<h3>'. $linha .'</h3><br>' );
			print( $linha .' | ' );
			foreach ($data_colunas as $key => $col) {
				$value = $spreadsheet->getActiveSheet()->getCell($key . $linha)->getValue();
				print( $value .' | ' );
				if( $key == 'C' ) { 
					$clie_nome_fantasia = $value; 

					$this->clieMD->where('clie_nome_fantasia', $clie_nome_fantasia)->orderBy('clie_id', 'DESC')->limit(1);
					$query_cliente = $this->clieMD->get();
					if( $query_cliente && $query_cliente->resultID->num_rows >=1 )
					{
						$rs_cliente = $query_cliente->getRow();
						$clie_id = (int)$rs_cliente->clie_id;
					}						
				}
				if( $key == 'E' ) { $eqto_tag = $value; }
				if( $key == 'F' ) { $eqto_titulo = $value; }
				if( $key == 'G' ) { $eqto_setor = $value; }
				if( $key == 'H' ) { $eqto_local = $value; }
				if( $key == 'I' ) { $eqto_capacidade = $value; }
				if( $key == 'K' ) { $eqto_fluido_ref = $value; }
				if( $key == 'L' ) { $eqto_fabricante = $value; }
				if( $key == 'M' ) { $eqto_modelo_cond = $value; }
				if( $key == 'N' ) { $eqto_modelo_evap = $value; }
			}

			if( !empty($eqto_titulo) ){
				$data_db = [
					'clie_id' => (int)$clie_id,
					'eqto_hashkey' => md5(date("Y-m-d H:i:s") ."-". random_string('alnum', 16)),
					'eqto_urlpage' => url_title( convert_accented_characters($eqto_titulo), '-', TRUE ),
					'eqto_titulo' => $eqto_titulo,
					'eqto_tag' => $eqto_tag,
					'eqto_setor' => $eqto_setor,
					'eqto_local' => $eqto_local,
					'eqto_capacidade' => $eqto_capacidade,
					'eqto_fluido_ref' => $eqto_fluido_ref,
					'eqto_fabricante' => $eqto_fabricante,
					'eqto_modelo_cond' => $eqto_modelo_cond,
					'eqto_modelo_evap' => $eqto_modelo_evap,
					'eqto_observacoes' => $clie_nome_fantasia,
					'eqto_dte_cadastro' => date("Y-m-d H:i:s"),
					'eqto_dte_alteracao' => date("Y-m-d H:i:s"),
					'eqto_ativo' => 1,
				];
				$eqto_id = $this->eqtoMD->insert($data_db);
			}else{
				print( '<span style="color:black;"><strong>em branco</strong></span> | ' );	
			}
			print('</div>');
		}
	}


	public function importar_novos_cadastros_temp()
	{
		ini_set('memory_limit', '2048M');

		$executar = false;
		$executar_query = true;
		$query_insert_PRINT = "";

		// NOME	EMAIL CPF	ESTADO TIPO PERFIL
		$data_colunas = [
			'A' => 'cad_nome_completo',
			'B' => 'cad_email',
			'C' => 'cad_cpf',
			'D' => 'cad_estado',
			'E' => 'cad_tipo_perfil',
		];

		//$path_file = WRITEPATH ."/uploads/importacao/ciopar2023_Inscritos_2023920_1944_alysson.xlsx";
		//$path_file = WRITEPATH ."/uploads/importacao/relacao-participantes-Identificare-email.xlsx";
		$path_file = WRITEPATH ."/uploads/importacao/relacao-participantes-Identificare--NOVA.xlsx";
		
		$inputFileName = $path_file;
		$inputFileType = IOFactory::identify($inputFileName);
		
		$reader = IOFactory::createReader($inputFileType);
		$spreadsheet = $reader->load($inputFileName);
		$sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

		// linhas
		$linha = 1;
		$cad_documento = '';
		foreach ($sheetData as $row) {
			$linha++;

			// colunas
			print('<div style="padding: 2px; border-bottom: 1px dotted gray;">');
			//print( '<h3>'. $linha .'</h3><br>' );
			print( $linha .' | ' );
			foreach ($data_colunas as $key => $col) {
				$value = $spreadsheet->getActiveSheet()->getCell($key . $linha)->getValue();
				print( $value .' | ' );
				//if( $key == 'A' ) { $cad_codigo = $value; }
				//if( $key == 'E' ) { $cad_nome_completo = $value; }
				//if( $key == 'F' ) { $cad_nome_credencial = $value; }
				//if( $key == 'H' ) { $cad_conselho = $value; }
				//if( $key == 'L' ) { 
				//	$cad_cpf = $value; 
				//}

				if( $key == 'A' ) { $cad_nome_completo = $value; }
				if( $key == 'B' ) { $cad_email = $value; }
				if( $key == 'C' ) { 
					$cad_cpf = $value; 

					// mascaras para cpf
					$cad_cpf = preg_replace("/[^0-9]/", "", $cad_cpf);
					$cad_cpf = str_pad($cad_cpf, 11, '0', STR_PAD_LEFT);
					$cad_cpf = fct_mask($cad_cpf, '###.###.###-##');

					$cad_documento = $value;
				}
				if( $key == 'D' ) { $cad_estado = $value; }
				if( $key == 'E' ) { $cad_tipo_perfil = $value; }
			}

			if( !empty($cad_nome_completo) ){
				$cad_ativo = 1;

				$num_random = random_string('alnum', 3);
				$num_random = strtoupper($num_random);

				$data_db = [
					'cad_hashkey' => md5(date("Y-m-d H:i:s") ."-". random_string('alnum', 16)),
					'cad_urlpage' => url_title( convert_accented_characters($cad_nome_completo), '-', TRUE ),
					'cad_nome_completo' => $cad_nome_completo,
					'cad_email' => $cad_email,
					'cad_cpf' => $cad_cpf,
					'cad_documento' => $cad_documento,
					'cad_qrsalt' => $num_random,
					'cad_tipo_perfil' => $cad_tipo_perfil,
					'cad_estado' => $cad_estado,
					'cad_dte_cadastro' => date("Y-m-d H:i:s"),
					'cad_dte_alteracao' => date("Y-m-d H:i:s"),
					'cad_ativo' => $cad_ativo,
				];
				$cad_id = $this->cadTempMD->insert($data_db);
				//$cad_id = $this->cadTempMD->insert($data_db);
				//print( $cad_id .' | ' );
			}else{
				print( '<span style="color:black;"><strong>em branco</strong></span> | ' );	
			}
			print('</div>');
		}
	}


	public function presenca()
	{
		ini_set('memory_limit', '2048M');


		$executar = false;
		$executar_query = true;
		$query_insert_PRINT = "";


		$data = array();

		/*
		 * LOAD LIBRARIES
		**/
			$objPHPExcel = new PHPExcel();


		/*
		 * -------------------------------------------------------------
		 * Verifica se o arquivo informado existe no diretório
		 * -------------------------------------------------------------
		**/
			$fileNameDB = "3-CPFs_Corretora-Parceira-Lojacorr.xlsx";
			$path_file = WRITEPATH ."/uploads/importacao/". $fileNameDB;
			//$objPHPExcel = PHPExcel_IOFactory::load($path_file);

				// print '<pre>';
				// print_r( $path_file );
				// print '</pre>';

			if( is_file($path_file) && file_exists($path_file) ){
				$executar = true;	
			}

			if( $executar == true )
			{
				//$objPHPExcel = PHPExcel_IOFactory::load($path_file);
				// print '<pre>';
				// print_r( $objPHPExcel );
				// print '</pre>';

				$_fields = array(
					0 => array('col' => 'A', 'coluna' => 'codigo'),			// codigo ident
					array('col' => 'B',	'coluna' => 'nome'),				// Unidade
				);

				$objWorksheet = $objPHPExcel->getActiveSheet();
				print '<pre>';
				print_r( $objWorksheet );
				print '</pre>';
				exit();

				$linha = 0;
				$limiteLinhas = 10;
				$linhaInicial = 7;

				echo('<table border="1">');
				$arr_data = array();

				foreach ($objWorksheet->getRowIterator() as $row) {
					if ($linha >= $limiteLinhas) break;

					$linha++;
					if( $linha >= $linhaInicial ){
						echo('<tr>
								<td>'. $linha .'</td>');

						// colunas
						$arr_colunas = array();
						//$col_codigo = $objPHPExcel->getActiveSheet()->getCell('A'. $linha)->getValue();
						//$col_nome = $objPHPExcel->getActiveSheet()->getCell('B'. $linha)->getValue();

						// //if( !empty($col_codigo) && !empty($col_nome) ){
						// 	foreach ($_fields as $key => $itemCol) {
						// 		$celula = $itemCol["col"] .''. $linha;

						// 		//if( $itemCol["col"] && $itemCol["col"] )
						// 		$value = $objPHPExcel->getActiveSheet()->getCell($celula)->getValue();
						// 		//echo('<div>'. $value .'</div>');
						// 		//$arr_colunas[ $itemCol["coluna"] ] = $value;  

						// 		echo('<td>'. $value .'</td>');
						// 		//print '<br />'. $itemCol["col"]; 
						// 		//$str_fields_col = (isset($itemCol["col"]) ? $itemCol["col"] : "");
						// 		//$str_fields_title = (isset($itemCol["title"]) ? $itemCol["title"] : "");
						// 		//$sheet->setCellValue($str_fields_col . $xCol,  $str_fields_title);
						// 	}
						// 	//array_push($arr_data, $arr_colunas);
						// //}
						//$data_post_bd = array_merge($data_post_bd, $data_post_arq);
						echo('</tr>');
					}					
				}
				echo('</table>');

				print '<pre>';
				print_r( $linha );
				print '</pre>';		
			}
	}

	public function parceiros()
	{
		ini_set('memory_limit', '2048M');

		helper('text');

		$executar = false;
		$executar_query = true;
		$query_insert_PRINT = "";

		$data_colunas = [
			'A' => 'pess_nome',
			'B' => 'pess_cpf',
			'C' => 'pess_acesso',
			'D' => 'pess_categoria',
		];
		$path_file = WRITEPATH ."/uploads/importacao/3-CPFs_Corretora-Parceira-Lojacorr.xlsx";

		$inputFileName = $path_file;
		$inputFileType = IOFactory::identify($inputFileName);
		
		$reader = IOFactory::createReader($inputFileType);
		$spreadsheet = $reader->load($inputFileName);
		$sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

		// linhas
		$linha = 1;
		foreach ($sheetData as $row) {
			$linha++;
			// print('<pre>');
			// print_r($row );
			// print('</pre>');	

			$pess_nome = '';
			$pess_cpf = '000.000.000-00';
			$pess_acesso = '';
			$pess_categoria = '';
			$pess_cpf_mask = '';		

			// colunas
			print('<div>');
			//print( '<h3>'. $linha .'</h3><br>' );
			print( $linha .' | ' );
			foreach ($data_colunas as $key => $col) {
				$value = $spreadsheet->getActiveSheet()->getCell($key . $linha)->getValue();
				print( $value .' | ' );
				if( $key == 'A' ) { $pess_nome = $value; }
				if( $key == 'B' ) { $pess_cpf = $value; }
				if( $key == 'C' ) { $pess_acesso = $value; }
				if( $key == 'D' ) { $pess_categoria = $value; }
				if( $key == 'B' && !empty($pess_nome) ) { // CPF
					$pess_cpf_mask = preg_replace("/[^0-9]/", "", $value);
					$pess_cpf_mask = str_pad($pess_cpf_mask, 11, '0', STR_PAD_LEFT);
					$pess_cpf_mask = fct_mask($pess_cpf_mask, '###.###.###-##');
					print( '<span style="color:blue;">'. $pess_cpf_mask .'</span> | ' );
					//$pess_cpf_mask = $pess_cpf_mask;
				}
			}

			if( !empty($pess_nome) ){
				$pess_status = 'existente';
				$pess_ativo = 0;
				if( $pess_cpf_mask != '000.000.000-00' ){
					$queryEdit = $this->pessMD->where('pess_cpf_mask', $pess_cpf_mask)->get();
					if( $queryEdit && $queryEdit->resultID->num_rows >= 1 )
					{
						print( '<span style="color:red;">existente </span> | ' );
					}else{
						$pess_status = 'novo';
						$pess_ativo = 1;						
						print( '<span style="color:green;">novo </span> | ' );
					}
				}

				$data_db = [
					'pess_hashkey' => md5(date("Y-m-d H:i:s") ."-". random_string('alnum', 16)),
					'pess_urlpage' => url_title( convert_accented_characters($pess_nome), '-', TRUE ),
					'pess_area' => 'parceira',
					'pess_nome' => $pess_nome,
					'pess_cpf' => $pess_cpf,
					'pess_cpf_mask' => $pess_cpf_mask,					
					'pess_acesso' => $pess_acesso,
					'pess_categoria' => $pess_categoria,
					'pess_status' => $pess_status,
					'pess_dte_cadastro' => date("Y-m-d H:i:s"),
					'pess_dte_alteracao' => date("Y-m-d H:i:s"),
					'pess_ativo' => $pess_ativo,
				];
				$pess_id = $this->pessMD->insert($data_db);
				print( $pess_id .' | ' );
			}else{
				print( '<span style="color:black;"><strong>em branco</strong></span> | ' );	
			}
			print('</div>');
		}



		// $a2 = $spreadsheet->getActiveSheet()->getCell('A2')->getValue();
		// echo "\nValue of A2: $a2\n\n";
		
		// //var_dump($sheetData);

		// print('<pre>');
		// print_r($sheetData );
		// print('</pre>');	
		exit();








		# Create a new Xls Reader
		$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

		// Tell the reader to only read the data. Ignore formatting etc.
		$reader->setReadDataOnly(true);

		// Read the spreadsheet file.
		$spreadsheet = $reader->load($path_file);

		$sheet = $spreadsheet->getSheet($spreadsheet->getFirstSheetIndex());
		$data = $sheet->toArray();



		// output the data to the console, so you can see what there is.
		print('<pre>');
		print_r($data);
		print('</pre>');
	 

		exit();







		/*
		 * LOAD LIBRARIES
		**/
			$objPHPExcel = new PHPExcel();


		/*
		 * -------------------------------------------------------------
		 * Verifica se o arquivo informado existe no diretório
		 * -------------------------------------------------------------
		**/
			$fileNameDB = "3-CPFs_Corretora-Parceira-Lojacorr.xlsx";
			$path_file = WRITEPATH ."/uploads/importacao/". $fileNameDB;
			//$objPHPExcel = PHPExcel_IOFactory::load($path_file);

				// print '<pre>';
				// print_r( $path_file );
				// print '</pre>';

			if( is_file($path_file) && file_exists($path_file) ){
				$executar = true;	
			}

			if( $executar == true )
			{
				//$objPHPExcel = PHPExcel_IOFactory::load($path_file);
				// print '<pre>';
				// print_r( $objPHPExcel );
				// print '</pre>';

				$_fields = array(
					0 => array('col' => 'A', 'coluna' => 'codigo'),			// codigo ident
					array('col' => 'B',	'coluna' => 'nome'),				// Unidade
				);

				$objWorksheet = $objPHPExcel->getActiveSheet();
				print '<pre>';
				print_r( $objWorksheet );
				print '</pre>';
				exit();

				$linha = 0;
				$limiteLinhas = 10;
				$linhaInicial = 7;

				echo('<table border="1">');
				$arr_data = array();

				foreach ($objWorksheet->getRowIterator() as $row) {
					if ($linha >= $limiteLinhas) break;

					$linha++;
					if( $linha >= $linhaInicial ){
						echo('<tr>
								<td>'. $linha .'</td>');

						// colunas
						$arr_colunas = array();
						//$col_codigo = $objPHPExcel->getActiveSheet()->getCell('A'. $linha)->getValue();
						//$col_nome = $objPHPExcel->getActiveSheet()->getCell('B'. $linha)->getValue();

						// //if( !empty($col_codigo) && !empty($col_nome) ){
						// 	foreach ($_fields as $key => $itemCol) {
						// 		$celula = $itemCol["col"] .''. $linha;

						// 		//if( $itemCol["col"] && $itemCol["col"] )
						// 		$value = $objPHPExcel->getActiveSheet()->getCell($celula)->getValue();
						// 		//echo('<div>'. $value .'</div>');
						// 		//$arr_colunas[ $itemCol["coluna"] ] = $value;  

						// 		echo('<td>'. $value .'</td>');
						// 		//print '<br />'. $itemCol["col"]; 
						// 		//$str_fields_col = (isset($itemCol["col"]) ? $itemCol["col"] : "");
						// 		//$str_fields_title = (isset($itemCol["title"]) ? $itemCol["title"] : "");
						// 		//$sheet->setCellValue($str_fields_col . $xCol,  $str_fields_title);
						// 	}
						// 	//array_push($arr_data, $arr_colunas);
						// //}
						//$data_post_bd = array_merge($data_post_bd, $data_post_arq);
						echo('</tr>');
					}					
				}
				echo('</table>');

				print '<pre>';
				print_r( $linha );
				print '</pre>';		
			}
	}

	public function parceiros_vetor()
	{
		ini_set('memory_limit', '2048M');

		helper('text');

		$arr_dados = [
			[
				'nome' => 'Denise França',
				'cpf' => '073.790.349-01',
				'acesso' => 'Teste Lojacorr',
				'categoria' => 'Corretora Parceira Lojacorr',
			]
		];

		print('<pre>');
		print_r($arr_dados );
		print('</pre>');
		//exit();
		foreach ($arr_dados as $key => $val) {
			$pess_nome = $val['nome'];
			$pess_cpf = $val['cpf'];
			$pess_acesso = $val['acesso'];
			$pess_categoria = $val['categoria'];
			$pess_cpf_mask = '';

			print('<pre>');
			print_r($pess_cpf );
			print('</pre>');
			exit();

			$pess_cpf_mask = preg_replace("/[^0-9]/", "", $pess_cpf);
			$pess_cpf_mask = str_pad($pess_cpf_mask, 11, '0', STR_PAD_LEFT);
			$pess_cpf_mask = fct_mask($pess_cpf_mask, '###.###.###-##');
			//print( '<span style="color:blue;">'. $pess_cpf_mask .'</span> | ' );

			$pess_status = 'existente';
			$pess_ativo = 0;
			if( $pess_cpf_mask != '000.000.000-00' ){
				$queryEdit = $this->pessMD->where('pess_cpf_mask', $pess_cpf_mask)->get();
				if( $queryEdit && $queryEdit->resultID->num_rows >= 1 )
				{
					print( '<span style="color:red;">existente </span> | ' );
				}else{
					$pess_status = 'novo';
					$pess_ativo = 1;

					$data_db = [
						'pess_hashkey' => md5(date("Y-m-d H:i:s") ."-". random_string('alnum', 16)),
						'pess_urlpage' => url_title( convert_accented_characters($pess_nome), '-', TRUE ),
						'pess_area' => 'parceira',
						'pess_nome' => $pess_nome,
						'pess_cpf' => $pess_cpf,
						'pess_cpf_mask' => $pess_cpf_mask,					
						'pess_acesso' => $pess_acesso,
						'pess_categoria' => $pess_categoria,
						'pess_status' => $pess_status,
						'pess_dte_cadastro' => date("Y-m-d H:i:s"),
						'pess_dte_alteracao' => date("Y-m-d H:i:s"),
						'pess_ativo' => $pess_ativo,
					];
					//$pess_id = $this->pessMD->insert($data_db);					
					
					print( '<span style="color:green;">novo </span> | ' );
				}
			}
		}

	}

	public function unidades()
	{
		ini_set('memory_limit', '2048M');

		helper('text');

		$executar = false;
		$executar_query = true;
		$query_insert_PRINT = "";

		$data_colunas = [
			'A' => 'pess_unidade',
			'B' => 'pess_nome',
			'C' => 'pess_cpf',
			'D' => 'pess_acesso',
			'E' => 'pess_categoria',
		];
		$path_file = WRITEPATH ."/uploads/importacao/CPFs_Unidades-de-Negocios-Lojacorr.xlsx";

		$inputFileName = $path_file;
		$inputFileType = IOFactory::identify($inputFileName);
		
		$reader = IOFactory::createReader($inputFileType);
		$spreadsheet = $reader->load($inputFileName);
		$sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);


		print( '<h1 style="color:black;"><strong>UNIDADES</strong></h1>' );	
		// linhas
		$linha = 1;
		foreach ($sheetData as $row) {
			$linha++;
			// print('<pre>');
			// print_r($row );
			// print('</pre>');	

			$pess_unidade = '';
			$pess_nome = '';
			$pess_cpf = '000.000.000-00';
			$pess_acesso = '';
			$pess_categoria = '';
			$pess_cpf_mask = '';		

			// colunas
			print('<div>');
			//print( '<h3>'. $linha .'</h3><br>' );
			print( $linha .' | ' );
			foreach ($data_colunas as $key => $col) {
				$value = $spreadsheet->getActiveSheet()->getCell($key . $linha)->getValue();
				print( $value .' | ' );
				
				if( $key == 'A' ) { $pess_unidade = $value; }
				if( $key == 'B' ) { $pess_nome = $value; }
				if( $key == 'C' ) { $pess_cpf = $value; }
				if( $key == 'D' ) { $pess_acesso = $value; }
				if( $key == 'E' ) { $pess_categoria = $value; }
				if( $key == 'C' && !empty($pess_nome) ) { // CPF
					$pess_cpf_mask = preg_replace("/[^0-9]/", "", $value);
					$pess_cpf_mask = str_pad($pess_cpf_mask, 11, '0', STR_PAD_LEFT);
					$pess_cpf_mask = fct_mask($pess_cpf_mask, '###.###.###-##');
					print( '<span style="color:blue;">'. $pess_cpf_mask .'</span> | ' );
					//$pess_cpf_mask = $pess_cpf_mask;
				}
			}

			if( !empty($pess_nome) ){
				$pess_status = 'existente';
				$pess_ativo = 0;
				if( $pess_cpf_mask != '000.000.000-00' ){
					$queryEdit = $this->pessMD->where('pess_cpf_mask', $pess_cpf_mask)->get();
					if( $queryEdit && $queryEdit->resultID->num_rows >= 1 )
					{
						print( '<span style="color:red;">existente </span> | ' );
					}else{
						$pess_status = 'novo';
						$pess_ativo = 1;						
						print( '<span style="color:green;">novo </span> | ' );
					}
				}

				$data_db = [
					'pess_hashkey' => md5(date("Y-m-d H:i:s") ."-". random_string('alnum', 16)),
					'pess_urlpage' => url_title( convert_accented_characters($pess_nome), '-', TRUE ),
					'pess_area' => 'unidade',
					'pess_unidade' => $pess_unidade,
					'pess_nome' => $pess_nome,
					'pess_cpf' => $pess_cpf,
					'pess_cpf_mask' => $pess_cpf_mask,					
					'pess_acesso' => $pess_acesso,
					'pess_categoria' => $pess_categoria,
					'pess_status' => $pess_status,
					'pess_dte_cadastro' => date("Y-m-d H:i:s"),
					'pess_dte_alteracao' => date("Y-m-d H:i:s"),
					'pess_ativo' => $pess_ativo,
				];
				$pess_id = $this->pessMD->insert($data_db);
				print( $pess_id .' | ' );
			}else{
				print( '<span style="color:black;"><strong>em branco</strong></span> | ' );	
			}
			print('</div>');
		}



		// $a2 = $spreadsheet->getActiveSheet()->getCell('A2')->getValue();
		// echo "\nValue of A2: $a2\n\n";
		
		// //var_dump($sheetData);

		// print('<pre>');
		// print_r($sheetData );
		// print('</pre>');	
		exit();








		# Create a new Xls Reader
		$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

		// Tell the reader to only read the data. Ignore formatting etc.
		$reader->setReadDataOnly(true);

		// Read the spreadsheet file.
		$spreadsheet = $reader->load($path_file);

		$sheet = $spreadsheet->getSheet($spreadsheet->getFirstSheetIndex());
		$data = $sheet->toArray();



		// output the data to the console, so you can see what there is.
		print('<pre>');
		print_r($data);
		print('</pre>');
	 

		exit();







		/*
		 * LOAD LIBRARIES
		**/
			$objPHPExcel = new PHPExcel();


		/*
		 * -------------------------------------------------------------
		 * Verifica se o arquivo informado existe no diretório
		 * -------------------------------------------------------------
		**/
			$fileNameDB = "3-CPFs_Corretora-Parceira-Lojacorr.xlsx";
			$path_file = WRITEPATH ."/uploads/importacao/". $fileNameDB;
			//$objPHPExcel = PHPExcel_IOFactory::load($path_file);

				// print '<pre>';
				// print_r( $path_file );
				// print '</pre>';

			if( is_file($path_file) && file_exists($path_file) ){
				$executar = true;	
			}

			if( $executar == true )
			{
				//$objPHPExcel = PHPExcel_IOFactory::load($path_file);
				// print '<pre>';
				// print_r( $objPHPExcel );
				// print '</pre>';

				$_fields = array(
					0 => array('col' => 'A', 'coluna' => 'codigo'),			// codigo ident
					array('col' => 'B',	'coluna' => 'nome'),				// Unidade
				);

				$objWorksheet = $objPHPExcel->getActiveSheet();
				print '<pre>';
				print_r( $objWorksheet );
				print '</pre>';
				exit();

				$linha = 0;
				$limiteLinhas = 10;
				$linhaInicial = 7;

				echo('<table border="1">');
				$arr_data = array();

				foreach ($objWorksheet->getRowIterator() as $row) {
					if ($linha >= $limiteLinhas) break;

					$linha++;
					if( $linha >= $linhaInicial ){
						echo('<tr>
								<td>'. $linha .'</td>');

						// colunas
						$arr_colunas = array();
						//$col_codigo = $objPHPExcel->getActiveSheet()->getCell('A'. $linha)->getValue();
						//$col_nome = $objPHPExcel->getActiveSheet()->getCell('B'. $linha)->getValue();

						// //if( !empty($col_codigo) && !empty($col_nome) ){
						// 	foreach ($_fields as $key => $itemCol) {
						// 		$celula = $itemCol["col"] .''. $linha;

						// 		//if( $itemCol["col"] && $itemCol["col"] )
						// 		$value = $objPHPExcel->getActiveSheet()->getCell($celula)->getValue();
						// 		//echo('<div>'. $value .'</div>');
						// 		//$arr_colunas[ $itemCol["coluna"] ] = $value;  

						// 		echo('<td>'. $value .'</td>');
						// 		//print '<br />'. $itemCol["col"]; 
						// 		//$str_fields_col = (isset($itemCol["col"]) ? $itemCol["col"] : "");
						// 		//$str_fields_title = (isset($itemCol["title"]) ? $itemCol["title"] : "");
						// 		//$sheet->setCellValue($str_fields_col . $xCol,  $str_fields_title);
						// 	}
						// 	//array_push($arr_data, $arr_colunas);
						// //}
						//$data_post_bd = array_merge($data_post_bd, $data_post_arq);
						echo('</tr>');
					}					
				}
				echo('</table>');

				print '<pre>';
				print_r( $linha );
				print '</pre>';		
			}
	}	


	public function gerarvouchers()
	{

		// loop para gera uma quantidad de códigos

		$count_ini = 1;
		$count_fim = 380;

		helper('text');

		for ($i = $count_ini; $i <= $count_fim; $i++) {
			//echo $i;
			$do = 0;
			do{
				$block_01 = 'CD';
				$block_02 = random_string('alpha', 4);
				$block_03 = random_string('alnum', 4);
				$block_04 = random_string('alpha', 4);

				$rand_id = str_pad($i , 3 , '0' , STR_PAD_LEFT);
				$voucher_number = strtoupper($block_01 .'.'. $block_02 .'.'. $block_03 .'.'. $block_04 .'-'. $rand_id);

				print '<div>';
				print $voucher_number;
				print '</div>';

				$qry_exists = $this->vochMD->where('voch_codigo', $voucher_number)->limit(1)->get();
				if( $qry_exists->resultID->num_rows == 0 )
				{
					$data_db = [
						'voch_hashkey' => md5(date("Y-m-d H:i:s") ."-". random_string('alnum', 16)),
						'voch_urlpage' => url_title( convert_accented_characters($voucher_number), '-', TRUE ),
						'voch_codigo' => $voucher_number,
						'voch_dte_cadastro' => date("Y-m-d H:i:s"),
						'voch_dte_alteracao' => date("Y-m-d H:i:s"),
						'voch_ativo' => '1',
					];
					//$this->vochMD->insert($data_db);	

					$do = 1;
				}
			}while($do == 0);
		}	

	
	}
	public function fct_gerarvouchers()
	{
	}


	public function criarexcel()
	{
		// $spreadsheet = new Spreadsheet();
		// $sheet = $spreadsheet->getActiveSheet();
		// $sheet->setCellValue('A1', 'Hello World !');

		// $writer = new Xlsx($spreadsheet);

		// $path_file = WRITEPATH ."/uploads/importacao/teste.xlsx";

		// $writer->save($path_file);	


		// $spreadsheet = new Spreadsheet();
		// $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Xlsx");

		// $path_file = WRITEPATH ."/uploads/importacao/teste.xlsx";
		// $arquivo = $path_file;

		// $spreadsheet = $reader->load($arquivo);
		// $sheet_count = $spreadsheet->getSheetCount();

		// for ($i=0 ; $i < $sheet_count ; $i++) {
		//     $sheet = $spreadsheet->getSheet($i);
		//     // processa os dados da planilha


		//     //print_r( $sheet);
		// }



		$path_file = WRITEPATH ."/uploads/importacao/relatorio-local-por-presenca.xls";

		# Create a new Xls Reader
		$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

		// Tell the reader to only read the data. Ignore formatting etc.
		$reader->setReadDataOnly(true);

		// Read the spreadsheet file.
		$spreadsheet = $reader->load($path_file);

		$sheet = $spreadsheet->getSheet($spreadsheet->getFirstSheetIndex());


		$data = $sheet->toArray();

		// output the data to the console, so you can see what there is.
		die(print_r($data, true)); 


	}

	public function lerxls()
	{
		$path_file = WRITEPATH ."/uploads/importacao/relatorio-local-por-presenca.xls";


		// $header_values = $rows = [
		// 	'Código',
		// 	'Nome',
		// 	'Empresa',
		// 	'Presença',
		// 	'Hr. Entrada',
		// 	'Hr. Saída',
		// ];
		if ( $xls = SimpleXLS::parse($path_file) ) {

			helper('text');

		    // $linha = 0;
			// $limiteLinhas = 10;
			// $linhaInicial = 5;

		    // foreach ($xls->rows() as $k => $r) {
		    // 	$linha++;
		    // 	if( $linha >= $linhaInicial ){

		    // 		if( $linha === $linhaInicial ){
		    // 			$header_values = $rows = array();
		    // 			$header_values = $r;
		    // 		}



			//         // if ($k === 0) {
			//         //     $header_values = $r;
			//         //     //continue;
			//         // }
		    //     	$rows[] = array_combine($header_values, $r);
		    // 	}
		    // }
			// print '<pre>';
			// print_r( $rows );
			// print '</pre>';

			
			$linha = 0;
			$limiteLinhas = 26;
			$linhaInicial = 6;

			$_fields = array(
				0 => array('col' => 'A', 	'coluna' => 'pat_codigo', 	'titulo' => 'Código'), 
				1 => array('col' => 'B', 	'coluna' => 'pat_nome', 	'titulo' => 'Nome'),
				8 => array('col' => 'B', 	'coluna' => 'pat_empresa', 'titulo' => 'Empresa'),
				9 => array('col' => 'B', 	'coluna' => 'outros', 'titulo' => 'Presença'),
				12 => array('col' => 'B', 	'coluna' => 'outros', 'titulo' => 'Hora Entrada'),
				15 => array('col' => 'B', 	'coluna' => 'outros', 'titulo' => 'Hora Saída'),  
			);

			/*
			Array
			(
			    [0] => Código
			    [1] => Nome
			    [2] => 
			    [3] => 
			    [4] => 
			    [5] => 
			    [6] => 
			    [7] => 
			    [8] => Empresa
			    [9] => Presença
			    [10] => 
			    [11] => 
			    [12] => Hr. Entrada
			    [13] => 
			    [14] => 
			    [15] => Hr. Saída
			)
			*/

			$qryInsertBatch = [];
			

			echo '<table border="1" cellpadding="3" style="border-collapse: collapse">';
			foreach( $xls->rows() as $r ) {
				$linha++;
				if( $linha >= $linhaInicial && $linha <= $limiteLinhas ){
					echo '<tr>
					<td>'. $linha .'</td>';


					$qryInsertBatch_push = [];
					$qryInsertBatch_json = [];
					foreach ($_fields as $key => $itemCol) {
						echo '<td>'. $r[$key] .'</td>';


						$coluna = $_fields[$key]['coluna'];
						if( $coluna != 'outros' ){
							$qryInsertBatch_push[$coluna] = $r[$key];
						}else{
							$qryInsertBatch_json[$_fields[$key]['titulo']] = $r[$key];	
						}
					}

					$qryInsertBatch_push['pat_hashkey'] = md5(date("Y-m-d H:i:s") ."-". random_string('alnum', 16));
					$qryInsertBatch_push['pat_json_infos'] = json_encode($qryInsertBatch_json);
					//<td>'.implode('</td><td>', $r ).'</td></tr>';
					echo '</tr>';

					array_push($qryInsertBatch,$qryInsertBatch_push);				
				}


				//array_push($qryInsertBatch,$qryInsertBatch_push);	
			}
			echo '</table>';

			// print '<pre>';
			// print_r( $qryInsertBatch );
			// print '</pre>';

			$countInsertBatch = is_array($qryInsertBatch) || $qryInsertBatch instanceof Countable ? count($qryInsertBatch) : 0;
			if( $countInsertBatch >= 1 ){
				//$this->patMD->insertBatch($qryInsertBatch);
				$qryInsertBatch = [];
				//$countRow = 0;
			}

		} else {
			echo SimpleXLS::parseError();
		}	
	}


	


	public function executar()
	{
		$fileNameDB = "";
		$executar = false;
		$executar_query = true;
		$query_insert_PRINT = "";
		//$fileNameDB = "produtos-sanremo.csv";
		$fileNameDB = "produtos-sanremo-23-03-2022.csv";

		$fileNameDB = "lojas-site.xlxs";


		/*
		 * -------------------------------------------------------------
		 * Executar importacao
		 * -------------------------------------------------------------
		**/
			$pathFile = WRITEPATH .'/uploads/importacao/'. $fileNameDB;
			if( is_file($pathFile) && file_exists($pathFile) ){
				$executar = true;	
			}
			//var_dump( $executar );
			//exit();

			if( $executar == true )
			{
				//print_r("FILE EXISTE");
				//print_r($fileNameDB);

				$fields = array();
				try {
					//if( $executar_query == true ){
						//print 'IREMOS LIMPAR A TABELA';
						//$this->db->truncate('tbl_ordem_compra');
						//$this->db->truncate('tbl_empresas');
					//}
					$file = fopen($pathFile, 'r');

					$query_insert = "";
					$query_group = "";

					/*
						`sanremo_id` INT(11) NOT NULL AUTO_INCREMENT,
						`sanremo_codigo_sku` TEXT NOT NULL COLLATE 'latin1_general_ci',
						`sanremo_codigo_ean` TEXT NOT NULL COLLATE 'latin1_general_ci',
						`sanremo_linha` TEXT NOT NULL COLLATE 'latin1_general_ci',
						`sanremo_produto` TEXT NOT NULL COLLATE 'latin1_general_ci',
					*/

					/*
						"","LINHA","SKU","Texto breve material","EAN"					
					*/
					
					$_fields = array(
						0 => 'sanremo_linha',
						1 => 'sanremo_codigo_sku',
						2 => 'sanremo_produto',
						3 => 'sanremo_codigo_ean',
					);

					//$str_fields_tbl = '';
					//foreach ($_fields as $key=>$item) {
						//$str_fields_tbl .= ( !empty($str_fields_tbl) ? ", " : "" );
						//$str_fields_tbl .= (isset($item) ? $item : "");
					//}
					//$insert_into = "INSERT INTO tbl_sanremo (". $str_fields_tbl .") VALUES "; 
					//echo( $insert_into ); 
					//exit();


					$count = 0;
					$countRow = 0;
					$qryInsertBatch = array();
					while (!feof($file)) {
						$count++;
						$countRow++;
						$arr_rows = fgetcsv($file, null, ',');

						//print_r('<pre>');
						//print_r( $arr_rows );
						//print_r('</pre>');

						// if( $arr_rows[0] == "cvd_id" OR empty($arr_rows[0]) OR empty($arr_rows[1]) ){
						// IGNORAR A PRIMEIRA LINHA
						if( $count == 1 ){
							// linha inválida
						}else{
							$col_fields_tbl = '';




							print '<div style="padding: 2px; border: 1px solid red; margin: 10px 0;">';
							foreach ($_fields as $key => $item) {

								print '	<div style="padding-left: 30px;">'. $countRow .') '. $key ." | ". $item .' --> '. $arr_rows[$key] .'</div>';
								//print '	<div>'. $arr_rows[$key] .'</div>';


								$col_fields_tbl .= ( !empty($col_fields_tbl) ? ", " : "" );

								$fields_value = (isset($arr_rows[$key]) ? $arr_rows[$key] : "");
								if( !empty($arr_rows[1]) ){ $col_fields_tbl .= "'". $fields_value ."'"; }
								$qryInsertBatch_push[$item] = $fields_value;


							}
							print '</div>';

							if( !empty($col_fields_tbl)){
								//$qryInsertBatch_push['plan_dte_cadastro'] = date("Y-m-d H:i:s");
								array_push($qryInsertBatch,$qryInsertBatch_push);
							}
							$countInsertBatch = is_array($qryInsertBatch) || $qryInsertBatch instanceof Countable ? count($qryInsertBatch) : 0;
							if( $countRow >= 500 && $countInsertBatch >= 1 ){
								$this->srTemMD->insertBatch($qryInsertBatch);
								$qryInsertBatch = array();
								$countRow = 0;
							}
						}
					}
					$countProd = is_array($qryInsertBatch) || $qryInsertBatch instanceof Countable ? count($qryInsertBatch) : 0;
					if( $countProd >= 1){
						$this->srTemMD->insertBatch($qryInsertBatch);
						$qryInsertBatch = array();
					}


					echo( '<h1>'. count($qryInsertBatch) .'</h1>');
					print '<pre>';
					print_r( $qryInsertBatch );
					print '</pre>';


					fclose($file);
					//return $this->response->redirect( admin_url('importacao/mensagem/') );

				} catch (\Throwable $e) {
					echo $e->getMessage();
				}

			}
	






		//return $this->response->redirect( admin_url('importacao/?mensagem=ok') );
	}





	public function importar_certificados( )
	{
		ini_set('memory_limit', '2048M');

		$executar = false;
		$executar_query = true;
		$query_insert_PRINT = "";

		$nomedoarquivo = "lista-de-presentes-albanir-meeting.xlsx";

		$arr_fields = [
			"cad_cod_antigo"		=> ['col'=> 'A', 'label' => 'CODIGO ANTIGO'],
			"cad_nome_completo"		=> ['col'=> 'B', 'label' => 'NOME'], 
			"cad_cpf"				=> ['col'=> 'C', 'label' => 'CPF'], 
			"cad_outros"			=> ['col'=> 'D', 'label' => 'OUTROS'], 
		];

		$path_file = WRITEPATH ."/uploads/importacao/". $nomedoarquivo;

		$inputFileName = $path_file;
		$inputFileType = IOFactory::identify($inputFileName);

		$reader = IOFactory::createReader($inputFileType);
		$spreadsheet = $reader->load($inputFileName);
		$sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

		// linhas
		$linha = 1;
		foreach ($sheetData as $row) {
			$linha++;

			$arrInsertBatch_push = [];
			$cad_nome_completo = $spreadsheet->getActiveSheet()->getCell($arr_fields['cad_nome_completo']['col'] . $linha)->getValue();
			if( !empty($cad_nome_completo)  ){
				// colunas
				//print('<div>');
				////print( '<h3>'. $linha .'</h3><br>' );
				//print( '<strong>'. $linha .' </strong>|<br>' );

				$qryInsertBatch = [];
				foreach ($arr_fields as $k => $r) {
					$col = $r['col']  .$linha;
					$field = $k;
					$value = $spreadsheet->getActiveSheet()->getCell($col)->getValue();
					//print( '<small>'. $value .'</small>' );

					//if( $field == 'cad_classificacao' ){ $value = "Diretoria Sindicatos"; }

					if( $field == 'cad_cpf' ){
						// mascaras para cpf
						$cad_cpf = preg_replace("/[^0-9]/", "", $value);
						$cad_cpf = str_pad($cad_cpf, 11, '0', STR_PAD_LEFT);
						$cad_cpf = fct_mask($cad_cpf, '###.###.###-##');
						$value = $cad_cpf; 
					}

					$arrInsertBatch_push[$field] = $value;
					
					//$data_db = [
					//	'cad_hashkey' => md5(date("Y-m-d H:i:s") ."-". random_string('alnum', 16)),
					//	'cad_urlpage' => url_title( convert_accented_characters($cad_nome_completo), '-', TRUE ),
					//	'cad_nome_completo' => $cad_nome_completo,
					//	'cad_nome_cracha' => $cad_nome_cracha,
					//	'cad_qrcode' => $cad_qrcode,
					//	'cad_empresa' => $cad_empresa,
					//	'cad_cidade' => $cad_cidade,
					//	'cad_tematica_01' => $cad_tematica_01,
					//	'cad_tematica_02' => $cad_tematica_02,
					//	'cad_tematica_03' => $cad_tematica_03,
					//	'cad_tematica_04' => $cad_tematica_04,
					//	'cad_tematica_05' => $cad_tematica_05,
					//	'cad_tematica_06' => $cad_tematica_06,
					//	'cad_tematica_07' => $cad_tematica_07,
					//	'cad_tematica_08' => $cad_tematica_08,
					//	'cad_dte_cadastro' => date("Y-m-d H:i:s"),
					//	'cad_dte_alteracao' => date("Y-m-d H:i:s"),
					//	'cad_ativo' => $cad_ativo,
					//];
					//$cad_id = $this->cadTempMD->insert($data_db);
					//print( $cad_id .' | ' );
				}
	
				//if( !empty($arrInsertBatch_push['cad_email']) ){
				//	$arr_cad_email = $arrInsertBatch_push['cad_email'];
				//	$cad_email = array_map('trim', preg_split('/[\/;]/', mb_strtolower($arr_cad_email)));
				//	$arrInsertBatch_push['cad_email'] = json_encode($cad_email);
				//}

				unset($arrInsertBatch_push['cad_id']);
				unset($arrInsertBatch_push['cad_dte_cadastro']);

				$arrInsertBatch_push['cad_hashkey'] = md5(date("Y-m-d H:i:s") ."-". random_string('alnum', 16));
				$arrInsertBatch_push['cad_urlpage'] = url_title( convert_accented_characters($arrInsertBatch_push['cad_nome_completo']), '-', TRUE );

				//print( '<pre><small>' );
				//print_r( $arrInsertBatch_push );
				$this->certMD->insert($arrInsertBatch_push);
				//print( '</small></pre>' );
				//print( '<hr>' );
				//print('</div>');
			}
		}
	}


}
