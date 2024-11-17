<?php
namespace App\Models;

use CodeIgniter\Model;

class CategoriasModel extends Model
{
	/*
		CREATE TABLE `tbl_categorias` (
			`categ_id` INT(11) NOT NULL AUTO_INCREMENT,
			`categ_hashkey` VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			`categ_urlpage` VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			`categ_titulo` VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			`categ_area` VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			`categ_color` VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			`categ_dte_cadastro` DATETIME NULL DEFAULT NULL,
			`categ_dte_alteracao` DATETIME NULL DEFAULT NULL,
			`categ_ativo` TINYINT(4) NULL DEFAULT '0',
			PRIMARY KEY (`categ_id`) USING BTREE,
			UNIQUE INDEX `categ_id` (`categ_id`) USING BTREE
		)
		COLLATE='utf8mb4_general_ci'
		ENGINE=MyISAM
		AUTO_INCREMENT=1
		;
	*/

	protected $db = null;
    protected $table = 'tbl_categorias';
	protected $primaryKey = 'categ_id';
	protected $useAutoIncrement = true;
	protected $returnType = 'object';
	protected $allowedFields = [
		'categ_id',
		'categ_hashkey',
		'categ_urlpage',
		'categ_titulo',
		'categ_area',
		'categ_color',
		'categ_dte_cadastro',
		'categ_dte_alteracao',
		'categ_ativo',
	];

    protected function initialize()
    {
		//$this->allowedFields[] = 'middlename';
		$db = \Config\Database::connect();
    }

}