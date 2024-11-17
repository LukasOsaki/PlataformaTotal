<?php
namespace App\Models;

use CodeIgniter\Model;

class PermissoesModel extends Model
{
	/*
		CREATE TABLE `tbl_permissoes` (
			`perm_id` INT(11) NOT NULL AUTO_INCREMENT,
			`perm_hashkey` VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			`perm_urlpage` VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			`perm_titulo` VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			`perm_permissoes` LONGTEXT NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			`perm_dte_cadastro` DATETIME NULL DEFAULT NULL,
			`perm_dte_alteracao` DATETIME NULL DEFAULT NULL,
			`perm_ativo` TINYINT(4) NULL DEFAULT '0',
			PRIMARY KEY (`perm_id`) USING BTREE,
			UNIQUE INDEX `perm_id` (`perm_id`) USING BTREE
		)
		COLLATE='utf8mb4_general_ci'
		ENGINE=MyISAM
		;
	*/

	protected $db = null;
    protected $table = 'tbl_permissoes';
	protected $primaryKey = 'perm_id';
	protected $useAutoIncrement = true;
	protected $returnType = 'object';
    protected $allowedFields = [
        'perm_hashkey',
        'perm_urlpage',
        'perm_titulo',
        'perm_permissoes',
        'perm_dte_cadastro',
        'perm_dte_alteracao',
        'perm_ativo',
    ];


    protected function initialize()
    {
		//$this->allowedFields[] = 'middlename';
		$db = \Config\Database::connect();
    }

}