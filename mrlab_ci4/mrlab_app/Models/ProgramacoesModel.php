<?php
namespace App\Models;

use CodeIgniter\Model;

class ProgramacoesModel extends Model
{
	/*
		CREATE TABLE tbl_programacoes (
			prog_id INT(11) NOT NULL AUTO_INCREMENT,
			clie_id INT(11) NOT NULL,
			prog_hashkey VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			prog_urlpage VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			prog_dte_visita DATETIME NULL DEFAULT NULL,
			prog_periodo VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			prog_sequencia VARCHAR(100) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			prog_tecnico VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			prog_atividades LONGTEXT NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			prog_realizada TINYINT(4) NULL DEFAULT '0',
			prog_dte_cadastro DATETIME NULL DEFAULT NULL,
			prog_dte_alteracao DATETIME NULL DEFAULT NULL,
			prog_ativo TINYINT(4) NULL DEFAULT '0',
			PRIMARY KEY (prog_id) USING BTREE,
			UNIQUE INDEX prog_id (prog_id) USING BTREE,
			INDEX clie_id (clie_id) USING BTREE
		)
		COLLATE='utf8mb4_general_ci'
		ENGINE=MyISAM
		;
	*/

	protected $db = null;
    protected $table = 'tbl_programacoes';
	protected $primaryKey = 'prog_id';
	protected $useAutoIncrement = true;
	protected $returnType = 'object';
	protected $allowedFields = [
		'clie_id',
		'prog_hashkey',
		'prog_urlpage',
		'prog_dte_visita',
		'prog_periodo', // manha - tarde
		'prog_sequencia',
		'prog_tecnico',
		'prog_atividades',
		'prog_realizada',
		'prog_dte_cadastro',
		'prog_dte_alteracao',
		'prog_ativo',
	];

    protected function initialize()
    {
		//$this->allowedFields[] = 'middlename';
		$db = \Config\Database::connect();
    }

}