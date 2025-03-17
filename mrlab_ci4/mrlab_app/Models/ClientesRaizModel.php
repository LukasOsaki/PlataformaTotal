<?php
namespace App\Models;

use CodeIgniter\Model;

class ClientesRaizModel extends Model
{
	/*
		CREATE TABLE tbl_clientes_raiz (
			clie_raiz_id INT(11) NOT NULL AUTO_INCREMENT,
			clie_raiz_hashkey VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			clie_raiz_urlpage VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			clie_raiz_nome_razao VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			clie_raiz_nome_fantasia VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			clie_raiz_cnpj VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			clie_raiz_login VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			clie_raiz_senha VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',

			
			clie_raiz_dte_cadastro DATETIME NULL DEFAULT NULL,
			clie_raiz_dte_alteracao DATETIME NULL DEFAULT NULL,
			clie_raiz_ativo TINYINT(4) NULL DEFAULT '0',
			PRIMARY KEY (clie_raiz_id) USING BTREE,
			UNIQUE INDEX clie_raiz_id (clie_raiz_id) USING BTREE
		)
		COLLATE='utf8mb4_general_ci'
		ENGINE=MyISAM
		AUTO_INCREMENT=1
		;

	*/

	protected $db = null;
    protected $table = 'tbl_clientes_raiz';
	protected $primaryKey = 'clie_raiz_id';
	protected $useAutoIncrement = true;
	protected $returnType = 'object';
	protected $allowedFields = [
		'clie_raiz_id',
		'clie_raiz_hashkey',
		'clie_raiz_urlpage',
		'clie_raiz_nome_razao',
		'clie_raiz_nome_fantasia',
		'clie_raiz_cnpj',
		'clie_raiz_login',
		'clie_raiz_senha',
		'clie_raiz_dte_cadastro',
		'clie_raiz_dte_alteracao',
		'clie_raiz_ativo',
	];

    protected function initialize()
    {
		//$this->allowedFields[] = 'middlename';
		$db = \Config\Database::connect();
    }

}