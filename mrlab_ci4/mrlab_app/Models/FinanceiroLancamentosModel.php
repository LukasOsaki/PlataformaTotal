<?php
namespace App\Models;

use CodeIgniter\Model;

class FinanceiroLancamentosModel extends Model
{
	/*
		CREATE TABLE `tbl_financeiro_lancamentos` (
			`finc_lanc_id` INT(11) NOT NULL AUTO_INCREMENT,
			`finc_tipo_id` INT(11)  NULL DEFAULT NULL,
			`finc_class_id` INT(11)  NULL DEFAULT NULL,
			`func_id` INT(11) NULL DEFAULT NULL,
			`clie_id` INT(11) NULL DEFAULT NULL,
			`finc_lanc_hashkey` VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			`finc_lanc_periodicidade` VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			`finc_lanc_custo` VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			`finc_lanc_dte_lancamento` DATE NULL DEFAULT NULL,
			`finc_lanc_ie_porcentagem` TINYINT(4) NULL DEFAULT '0',
			`finc_lanc_porcentagem` DECIMAL(18,2) NULL DEFAULT NULL,
			`finc_lanc_valor` DECIMAL(18,2) NULL DEFAULT NULL,
			`finc_lanc_tipo` VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			`finc_lanc_dte_cadastro` DATETIME NULL DEFAULT NULL,
			`finc_lanc_dte_alteracao` DATETIME NULL DEFAULT NULL,
			`finc_lanc_ativo` TINYINT(4) NULL DEFAULT '0',
			PRIMARY KEY (`finc_lanc_id`) USING BTREE,
			UNIQUE INDEX `finc_lanc_id` (`finc_lanc_id`) USING BTREE,
			INDEX `finc_tipo_id` (`finc_tipo_id`) USING BTREE,
			INDEX `finc_class_id` (`finc_class_id`) USING BTREE,
			INDEX `func_id` (`func_id`) USING BTREE,
			INDEX `clie_id` (`clie_id`) USING BTREE
		)
		COLLATE='utf8mb4_general_ci'
		ENGINE=MyISAM
		AUTO_INCREMENT=1
		;
	*/

	protected $db = null;
    protected $table = 'tbl_financeiro_lancamentos';
	protected $primaryKey = 'finc_lanc_id';
	protected $useAutoIncrement = true;
	protected $returnType = 'object';
	protected $allowedFields = [
		'finc_lanc_id',
		'finc_tipo_id',
		'finc_class_id',
		'func_id',
		'clie_id',
		'finc_lanc_hashkey',
		'finc_lanc_ie_porcentagem',
		'finc_lanc_periodicidade',
		'finc_lanc_custo',
		'finc_lanc_dte_lancamento',
		'finc_lanc_porcentagem',
		'finc_lanc_valor',
		'finc_lanc_tipo',
		'finc_lanc_dte_cadastro',
		'finc_lanc_dte_alteracao',
		'finc_lanc_ativo',
	];

    protected function initialize()
    {
		//$this->allowedFields[] = 'middlename';
		$db = \Config\Database::connect();
    }

}