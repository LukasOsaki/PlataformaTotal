<?php
namespace App\Models;

use CodeIgniter\Model;

class EquipamentosModel extends Model
{
	/*
		CREATE TABLE tbl_equipamentos (
			eqto_id INT(11) NOT NULL AUTO_INCREMENT,
			clie_id INT(11) NOT NULL,
			eqto_hashkey VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			eqto_urlpage VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			eqto_titulo VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			eqto_tag VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			eqto_setor VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			eqto_local VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			eqto_capacidade VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			eqto_fluido_ref VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			eqto_fabricante VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			eqto_modelo_cond VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			eqto_modelo_evap VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			eqto_observacoes LONGTEXT NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			eqto_dte_cadastro DATETIME NULL DEFAULT NULL,
			eqto_dte_alteracao DATETIME NULL DEFAULT NULL,
			eqto_ativo TINYINT(4) NULL DEFAULT '0',
			PRIMARY KEY (eqto_id) USING BTREE,
			UNIQUE INDEX eqto_id (eqto_id) USING BTREE
		)
		COLLATE='utf8mb4_general_ci'
		ENGINE=MyISAM
		AUTO_INCREMENT=1
		;
	*/

	protected $db = null;
    protected $table = 'tbl_equipamentos';
	protected $primaryKey = 'eqto_id';
	protected $useAutoIncrement = true;
	protected $returnType = 'object';
	protected $allowedFields = [
		'clie_id',
		'eqto_hashkey',
		'eqto_urlpage',
		'eqto_titulo',
		'eqto_tag',
		'eqto_setor',
		'eqto_local',
		'eqto_capacidade',
		'eqto_fluido_ref',
		'eqto_fabricante',
		'eqto_modelo_cond',
		'eqto_modelo_evap',
		'eqto_observacoes',
		'eqto_dte_cadastro',
		'eqto_dte_alteracao',
		'eqto_ativo',
	];

    protected function initialize()
    {
		//$this->allowedFields[] = 'middlename';
		$db = \Config\Database::connect();
    }

}