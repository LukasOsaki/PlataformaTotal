<?php
namespace App\Models;

use CodeIgniter\Model;

class ProdutosModel extends Model
{
	/*
		CREATE TABLE `tbl_produtos` (
			`prod_id` INT(11) NOT NULL AUTO_INCREMENT,
			`prod_hashkey` VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			`prod_urlpage` VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			`prod_tipo` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			`prod_titulo` VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			`prod_resumo` TEXT NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			`prod_descricao` LONGTEXT NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',			
			`prod_arquivo` VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			`prod_dte_cadastro` DATETIME NULL DEFAULT NULL,
			`prod_dte_alteracao` DATETIME NULL DEFAULT NULL,
			`prod_ativo` TINYINT(4) NULL DEFAULT '0',
			PRIMARY KEY (`prod_id`) USING BTREE,
			UNIQUE INDEX `prod_id` (`prod_id`) USING BTREE
		)
		COLLATE='utf8_general_ci'
		ENGINE=MyISAM
		AUTO_INCREMENT=1
		;
	*/

	protected $db = null;
    protected $table = 'tbl_produtos';
	protected $primaryKey = 'prod_id';
	protected $useAutoIncrement = true;
	protected $returnType = 'object';
	protected $allowedFields = [
		'categ_id',
		'prod_hashkey',
		'prod_urlpage',
		'prod_titulo',
		'prod_resumo',
		'prod_descricao',
		'prod_info_adicional',
		'prod_valor',
		'prod_arquivo',
		'prod_dte_cadastro',
		'prod_dte_alteracao',
		'prod_ativo',
	];

    protected function initialize()
    {
		//$this->allowedFields[] = 'middlename';
		$db = \Config\Database::connect();
    }

}