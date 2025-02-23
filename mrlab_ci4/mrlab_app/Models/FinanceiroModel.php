<?php
namespace App\Models;

use CodeIgniter\Model;

class FinanceiroModel extends Model
{
	/*
		CREATE TABLE `tbl_financeiro` (
			`finc_id` INT(11) NOT NULL AUTO_INCREMENT,
			`finc_tipo_id` INT(11) NULL DEFAULT NULL ,
			`finc_class_id` INT(11) NULL DEFAULT NULL ,
			`finc_hashkey` VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			`finc_periodicidade` VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			`finc_tipo` VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			`finc_nome` VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			`finc_centro_custo` VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			`finc_nr_parcela` INT(11) NULL DEFAULT NULL,
			`finc_valor` DECIMAL(18,2) NULL DEFAULT NULL,
			`finc_dte_vencimento` DATETIME NULL DEFAULT NULL,
			`finc_efetuado` TINYINT(4) NULL DEFAULT '0',
			`finc_dte_efetuado` DATETIME NULL DEFAULT NULL,
			`finc_competencia` VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			`finc_nr_doc` VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			`finc_dte_pagamento` DATETIME NULL DEFAULT NULL,
			`finc_anotacoes` LONGTEXT NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			`finc_conta` VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			`finc_forma_pagamento` VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			`finc_observacoes` LONGTEXT NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			`finc_status` VARCHAR(250) NULL DEFAULT 'PENDENTE' COLLATE 'utf8mb4_general_ci',
			`finc_dte_cadastro` DATETIME NULL DEFAULT NULL,
			`finc_dte_alteracao` DATETIME NULL DEFAULT NULL,
			`finc_ativo` TINYINT(4) NULL DEFAULT '0',
			PRIMARY KEY (`finc_id`) USING BTREE,
			UNIQUE INDEX `finc_id` (`finc_id`) USING BTREE,
			INDEX `finc_tipo_id` (`finc_tipo_id`) USING BTREE,
			INDEX `finc_class_id` (`finc_class_id`) USING BTREE
		)
		COLLATE='utf8mb4_general_ci'
		ENGINE=MyISAM
		AUTO_INCREMENT=1
		;

		ALTER TABLE tbl_financeiro 
		ADD finc_nr_parcela_total DECIMAL(18,2) NULL DEFAULT 0 AFTER `finc_nr_parcela`,
		ADD finc_modalidade VARCHAR(250) NULL DEFAULT "GERENCIAL" AFTER `finc_hashkey`,
		ADD finc_juros DECIMAL(18,2) NULL DEFAULT 0 AFTER `finc_observacoes`,
		ADD finc_multa DECIMAL(18,2) NULL DEFAULT 0 AFTER `finc_observacoes`
	*/

	protected $db = null;
    protected $table = 'tbl_financeiro';
	protected $primaryKey = 'finc_id';
	protected $useAutoIncrement = true;
	protected $returnType = 'object';
	protected $allowedFields = [
		'finc_id',
		'finc_tipo_id',
		'finc_class_id',
		'finc_hashkey',
		'finc_periodicidade',
		'finc_tipo',
		'finc_nome',
		'finc_centro_custo',
		'finc_nr_parcela',
		'finc_nr_parcela_total',
		'finc_valor',
		'finc_dte_vencimento',
		'finc_efetuado',
		'finc_dte_efetuado',
		'finc_competencia',
		'finc_nr_doc',
		'finc_dte_pagamento',
		'finc_anotacoes',
		'finc_conta',
		'finc_forma_pagamento',
		'finc_observacoes',
		'finc_status',
		'finc_multa',
		'finc_juros',
		'finc_dte_cadastro',
		'finc_dte_alteracao',
		'finc_ativo',
	];

    protected function initialize()
    {
		//$this->allowedFields[] = 'middlename';
		$db = \Config\Database::connect();
    }

}