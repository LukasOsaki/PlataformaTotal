<?php
namespace App\Models;

use CodeIgniter\Model;

class UsuariosModel extends Model
{
	/*
		CREATE TABLE `tbl_usuarios` (
			`user_id` INT(11) NOT NULL AUTO_INCREMENT,
			`user_hashkey` VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			`user_urlpage` VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			`user_nome` VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			`user_login` VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			`user_email` VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			`user_senha` VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			`user_dte_cadastro` DATETIME NULL DEFAULT NULL,
			`user_dte_alteracao` DATETIME NULL DEFAULT NULL,
			`user_ativo` TINYINT(4) NULL DEFAULT '0',
			PRIMARY KEY (`user_id`) USING BTREE,
			UNIQUE INDEX `user_id` (`user_id`) USING BTREE
		)
		COLLATE='utf8mb4_general_ci'
		ENGINE=MyISAM
		AUTO_INCREMENT=1
		;
	*/

	protected $db = null;
    protected $table = 'tbl_usuarios';
	protected $primaryKey = 'user_id';
	protected $useAutoIncrement = true;
	protected $returnType = 'object';
	protected $allowedFields = [
		'perm_id',
		'user_hashkey',
		'user_urlpage',
		'user_avatar',
		'user_nome',
		'user_login',
		'user_email',
		'user_senha',
		'user_dte_cadastro',
		'user_dte_alteracao',
		'user_ativo',
		'user_arquivado'
	];

    protected function initialize()
    {
		//$this->allowedFields[] = 'middlename';
		$db = \Config\Database::connect();
    }

}