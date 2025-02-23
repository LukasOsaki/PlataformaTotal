<?php
namespace App\Models;

use CodeIgniter\Model;

class PendenciasMateriaisModel extends Model
{
	/*
		CREATE TABLE `tbl_pendencias_materiais` (
			`pend_mat_id` INT(11) NOT NULL AUTO_INCREMENT,
			`pend_id` INT(11) NOT NULL,
			`clie_id` INT(11) NOT NULL,
			`eqto_id` INT(11) NULL,
			`pend_mat_hashkey` VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			`pend_mat_material` VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			`pend_mat_tipo` VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			`pend_mat_status` VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			`pend_mat_eqto` VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			`pend_mat_observacoes` LONGTEXT NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			`pend_mat_qtd` INT NULL DEFAULT NULL ,
			`pend_mat_dte_compra` DATETIME NULL DEFAULT NULL,
			`pend_mat_dte_disponivel` DATETIME NULL DEFAULT NULL,
			`pend_mat_dte_utilizado` DATETIME NULL DEFAULT NULL,
			`pend_mat_dte_cadastro` DATETIME NULL DEFAULT NULL,
			`pend_mat_dte_alteracao` DATETIME NULL DEFAULT NULL,
			`pend_mat_ativo` TINYINT(4) NULL DEFAULT '0',
			PRIMARY KEY (`pend_mat_id`) USING BTREE,
			UNIQUE INDEX `pend_mat_id` (`pend_mat_id`) USING BTREE
		)
		COLLATE='utf8mb4_general_ci'
		ENGINE=MyISAM
		AUTO_INCREMENT=3
		;
	*/

	protected $db = null;
    protected $table = 'tbl_pendencias_materiais';
	protected $primaryKey = 'pend_mat_id';
	protected $useAutoIncrement = true;
	protected $returnType = 'object';
    protected $allowedFields = [
        'pend_id',
        'clie_id',
        'eqto_id',
		'pend_mat_hashkey',
        'pend_mat_material',
		'pend_mat_tipo',
		'pend_mat_status',
		'pend_mat_eqto',
        'pend_mat_observacoes',
        'pend_mat_qtd',
        'pend_mat_dte_compra',
        'pend_mat_dte_disponivel',
        'pend_mat_dte_utilizado',
        'pend_mat_dte_cadastro',
		'pend_mat_dte_alteracao',
        'pend_mat_ativo',
    ];

    protected function initialize()
    {
		//$this->allowedFields[] = 'middlename';
		$db = \Config\Database::connect();
    }

}