<?php
namespace App\Models;

use CodeIgniter\Model;

class PendenciasModel extends Model
{
	/*
		CREATE TABLE tbl_pendencias (
			pend_id INT(11) NOT NULL AUTO_INCREMENT,
			clie_id INT(11) NOT NULL,
			eqto_id INT(11) NOT NULL,
			pend_hashkey VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			pend_urlpage VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			pend_cliente VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			pend_equipamento VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			pend_dte_registro DATETIME NULL DEFAULT NULL,
			pend_status VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			pend_num_os VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			pend_descricao LONGTEXT NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			pend_dte_compra DATETIME NULL DEFAULT NULL,
			pend_dte_instalacao DATETIME NULL DEFAULT NULL,
			pend_coment_interno LONGTEXT NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			pend_observacoes LONGTEXT NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			pend_dte_cadastro DATETIME NULL DEFAULT NULL,
			pend_dte_alteracao DATETIME NULL DEFAULT NULL,
			pend_ativo TINYINT(4) NULL DEFAULT '0',
			PRIMARY KEY (pend_id) USING BTREE,
			UNIQUE INDEX pend_id (pend_id) USING BTREE
		)
		COLLATE='utf8mb4_general_ci'
		ENGINE=MyISAM
		AUTO_INCREMENT=1
		;

	ALTER TABLE `tbl_pendencias`
		ADD COLUMN `pend_tipo` INT(11) NULL DEFAULT '0' AFTER `pend_dte_registro`,
		CHANGE COLUMN `pend_status` `pend_status` INT(11) NULL DEFAULT '0' COLLATE 'utf8mb4_general_ci' AFTER `pend_tipo`;
	*/

	protected $db = null;
    protected $table = 'tbl_pendencias';
	protected $primaryKey = 'pend_id';
	protected $useAutoIncrement = true;
	protected $returnType = 'object';
	protected $allowedFields = [
		'clie_id',
		'eqto_id',
		'pend_cliente',
		'pend_equipamento',
		'pend_dte_registro',
		'pend_tipo_serv',
		'pend_status',
		'pend_num_os',
		'pend_tag',
		'pend_descricao',
		'pend_dte_compra',
		'pend_dte_instalacao',
		'pend_coment_interno',
		'pend_observacoes',
		'pend_dte_cadastro',
		'pend_dte_alteracao',
		'pend_ativo',
	];

    protected function initialize()
    {
		//$this->allowedFields[] = 'middlename';
		$db = \Config\Database::connect();
    }

}