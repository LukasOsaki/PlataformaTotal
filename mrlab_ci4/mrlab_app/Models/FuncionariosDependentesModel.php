<?php
namespace App\Models;

use CodeIgniter\Model;

class FuncionariosDependentesModel extends Model
{
	/*
		CREATE TABLE tbl_funcionarios_dependentes (
			func_dep_id INT(11) NOT NULL AUTO_INCREMENT,
			func_id INT(11) NOT NULL,
			func_dep_nome VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			func_dep_tipo VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			func_dep_sexo VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			func_dep_dt_nasc DATE NULL DEFAULT NULL ,
			func_dep_sn_ir VARCHAR(1) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			func_dep_sn_sf VARCHAR(1) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			func_dep_dte_cadastro DATETIME NULL DEFAULT NULL,
			func_dep_dte_alteracao DATETIME NULL DEFAULT NULL,
			func_dep_ativo TINYINT(4) NULL DEFAULT '0',
			PRIMARY KEY (func_dep_id) USING BTREE,
			UNIQUE INDEX func_dep_id (func_dep_id) USING BTREE,
			INDEX `func_id` (`func_id`) USING BTREE
		)
		COLLATE='utf8mb4_general_ci'
		ENGINE=MyISAM
		AUTO_INCREMENT=1
		;

		
	*/

	protected $db = null;
    protected $table = 'tbl_funcionarios_dependentes';
	protected $primaryKey = 'func_dependente_id';
	protected $useAutoIncrement = true;
	protected $returnType = 'object';
	protected $allowedFields = [
		'func_dep_id',
		'func_id',
		'func_dep_nome',
		'func_dep_tipo',
		'func_dep_sexo',
		'func_dep_dt_nasc',
		'func_dep_sn_ir',
		'func_dep_sn_sf',
		'func_dep_dte_cadastro',
		'func_dep_dte_alteracao',
		'func_dep_ativo',
	];

    protected function initialize()
    {
		//$this->allowedFields[] = 'middlename';
		$db = \Config\Database::connect();
    }

}