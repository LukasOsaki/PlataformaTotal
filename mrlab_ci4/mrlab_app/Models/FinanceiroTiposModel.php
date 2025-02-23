<?php
namespace App\Models;

use CodeIgniter\Model;

class FinanceiroTiposModel extends Model
{
	/*
		CREATE TABLE `tbl_financeiro_tipos` (
			`finc_tipo_id` INT(11) NOT NULL AUTO_INCREMENT,
			`finc_tipo_hashkey` VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			`finc_tipo_nome` VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			`finc_tipo_dte_cadastro` DATETIME NULL DEFAULT NULL,
			`finc_tipo_dte_alteracao` DATETIME NULL DEFAULT NULL,
			`finc_tipo_ativo` TINYINT(4) NULL DEFAULT '0',
			PRIMARY KEY (`finc_tipo_id`) USING BTREE,
			UNIQUE INDEX `finc_tipo_id` (`finc_tipo_id`) USING BTREE
		)
		COLLATE='utf8mb4_general_ci'
		ENGINE=MyISAM
		AUTO_INCREMENT=1
		;
	*/

	protected $db = null;
    protected $table = 'tbl_financeiro_tipos';
	protected $primaryKey = 'finc_tipo_id';
	protected $useAutoIncrement = true;
	protected $returnType = 'object';
	protected $allowedFields = [
		'finc_tipo_id',
		'finc_tipo_hashkey',
		'finc_tipo_nome',
		'finc_tipo_dte_cadastro',
		'finc_tipo_dte_alteracao',
		'finc_tipo_ativo',
	];

    protected function initialize()
    {
		//$this->allowedFields[] = 'middlename';
		$db = \Config\Database::connect();
    }

}