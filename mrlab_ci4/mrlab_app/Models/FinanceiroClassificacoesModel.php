<?php
namespace App\Models;

use CodeIgniter\Model;

class FinanceiroClassificacoesModel extends Model
{
	/*
		CREATE TABLE `tbl_financeiro_classificacoes` (
			`finc_class_id` INT(11) NOT NULL AUTO_INCREMENT,
			`finc_class_hashkey` VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			`finc_class_nome` VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			`finc_class_func` TINYINT(4) NULL DEFAULT '0',
			`finc_class_cliente` TINYINT(4) NULL DEFAULT '0',
			`finc_class_dte_cadastro` DATETIME NULL DEFAULT NULL,
			`finc_class_dte_alteracao` DATETIME NULL DEFAULT NULL,
			`finc_class_ativo` TINYINT(4) NULL DEFAULT '0',
			PRIMARY KEY (`finc_class_id`) USING BTREE,
			UNIQUE INDEX `finc_class_id` (`finc_class_id`) USING BTREE
		)
		COLLATE='utf8mb4_general_ci'
		ENGINE=MyISAM
		AUTO_INCREMENT=1
		;

		ALTER TABLE tbl_financeiro_classificacoes
		ADD finc_class_modalidade VARCHAR(250) DEFAULT "GERENCIAL" NULL AFTER `finc_class_cliente`;
	*/

	protected $db = null;
    protected $table = 'tbl_financeiro_classificacoes';
	protected $primaryKey = 'finc_class_id';
	protected $useAutoIncrement = true;
	protected $returnType = 'object';
	protected $allowedFields = [
		'finc_class_id',
		'finc_class_hashkey',
		'finc_class_nome',
		'finc_class_func',
		'finc_class_cliente',
		'finc_class_modalidade',
		'finc_class_dte_cadastro',
		'finc_class_dte_alteracao',
		'finc_class_ativo',
	];

    protected function initialize()
    {
		//$this->allowedFields[] = 'middlename';
		$db = \Config\Database::connect();
    }

}