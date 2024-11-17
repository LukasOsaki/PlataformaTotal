<?php
namespace App\Models;

use CodeIgniter\Model;

class CadastrosModel extends Model
{
	/*
		CREATE TABLE `tbl_cadastros` (
			`cad_id` INT(11) NOT NULL AUTO_INCREMENT,
			`cad_hashkey` VARCHAR(250) NULL DEFAULT NULL COLLATE 'latin1_swedish_ci',
			`cad_urlpage` VARCHAR(250) NULL DEFAULT NULL COLLATE 'latin1_swedish_ci',
			`cad_nome` VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8_general_ci',
			`cad_email` VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8_general_ci',
			`cad_senha` VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8_general_ci',
			`cad_dte_cadastro` DATETIME NULL DEFAULT NULL,
			`cad_dte_alteracao` DATETIME NULL DEFAULT NULL,
			`cad_ativo` TINYINT(4) NULL DEFAULT '0',
			PRIMARY KEY (`cad_id`) USING BTREE,
			UNIQUE INDEX `cad_id` (`cad_id`) USING BTREE
		)
		COLLATE='utf8_general_ci'
		ENGINE=MyISAM
		AUTO_INCREMENT=1
		;

	*/

	protected $db = null;
    protected $table = 'tbl_cadastros';
	protected $primaryKey = 'cad_id';
	protected $useAutoIncrement = true;
	protected $returnType = 'object';
	protected $allowedFields = [
		'cad_id',
		'cad_hashkey',
		'cad_urlpage',
		'cad_nome',
		'cad_email',
		'cad_senha',
		'cad_dte_cadastro',
		'cad_dte_alteracao',
		'cad_ativo',
	];

    protected function initialize()
    {
		//$this->allowedFields[] = 'middlename';
		$db = \Config\Database::connect();
    }

}