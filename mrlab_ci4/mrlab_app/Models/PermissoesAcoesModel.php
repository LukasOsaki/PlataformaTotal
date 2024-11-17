<?php
namespace App\Models;

use CodeIgniter\Model;

class PermissoesAcoesModel extends Model
{
	/*
		CREATE TABLE `tbl_permissoes_acoes` (
			`pract_id` INT(11) NOT NULL AUTO_INCREMENT,
			`pract_hashkey` VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			`pract_urlpage` VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			`pract_titulo` VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			`pract_visualizar` TINYINT(4) NULL DEFAULT '0',
			`pract_editar` TINYINT(4) NULL DEFAULT '0',
			`pract_excluir` TINYINT(4) NULL DEFAULT '0',
			`pract_cadastrar` TINYINT(4) NULL DEFAULT '0',
			`pract_dte_cadastro` DATETIME NULL DEFAULT NULL,
			`pract_dte_alteracao` DATETIME NULL DEFAULT NULL,
			`pract_ativo` TINYINT(4) NULL DEFAULT '0',
			PRIMARY KEY (`pract_id`) USING BTREE,
			UNIQUE INDEX `pract_id` (`pract_id`) USING BTREE
		)
		COLLATE='utf8mb4_general_ci'
		ENGINE=MyISAM
		;
	*/

	protected $db = null;
    protected $table = 'tbl_permissoes_acoes';
	protected $primaryKey = 'pract_id';
	protected $useAutoIncrement = true;
	protected $returnType = 'object';
    protected $allowedFields = [
		'perm_id',
        'pract_hashkey',
        'pract_urlpage',
        'pract_titulo',
        'pract_visualizar',
        'pract_editar',
        'pract_excluir',
        'pract_cadastrar',
        'pract_dte_cadastro',
        'pract_dte_alteracao',
        'pract_ativo',
    ];

    protected function initialize()
    {
		//$this->allowedFields[] = 'middlename';
		$db = \Config\Database::connect();
    }

}