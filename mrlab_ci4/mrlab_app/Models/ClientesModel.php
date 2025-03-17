<?php
namespace App\Models;

use CodeIgniter\Model;

class ClientesModel extends Model
{
	/*
		CREATE TABLE tbl_clientes (
			clie_id INT(11) NOT NULL AUTO_INCREMENT,
			clie_hashkey VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			clie_urlpage VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			clie_nome_razao VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			clie_nome_fantasia VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			clie_cnpj VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			clie_email VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			clie_senha VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',

			clie_cep VARCHAR(10) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			clie_endereco VARCHAR(100) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			clie_end_numero VARCHAR(100) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			clie_end_compl VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			clie_bairro VARCHAR(100) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			clie_cidade VARCHAR(120) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			clie_estado VARCHAR(10) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			clie_observacoes LONGTEXT NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',

			clie_dte_cadastro DATETIME NULL DEFAULT NULL,
			clie_dte_alteracao DATETIME NULL DEFAULT NULL,
			clie_ativo TINYINT(4) NULL DEFAULT '0',
			PRIMARY KEY (clie_id) USING BTREE,
			UNIQUE INDEX clie_id (clie_id) USING BTREE
		)
		COLLATE='utf8mb4_general_ci'
		ENGINE=MyISAM
		AUTO_INCREMENT=1
		;

		ALTER TABLE `tbl_clientes`
			ADD COLUMN `clie_dte_ini_contrato` DATETIME NULL DEFAULT NULL AFTER `clie_observacoes`,
			ADD COLUMN `clie_dte_end_contrato` DATETIME NULL DEFAULT NULL AFTER `clie_dte_ini_contrato`;

			ALTER TABLE `tbl_clientes`
			ADD COLUMN `clie_raiz_id` INT NULL DEFAULT NULL AFTER `clie_id`;
	*/

	protected $db = null;
    protected $table = 'tbl_clientes';
	protected $primaryKey = 'clie_id';
	protected $useAutoIncrement = true;
	protected $returnType = 'object';
	protected $allowedFields = [
		'clie_id',
		'clie_hashkey',
		'clie_urlpage',
		'clie_nome_razao',
		'clie_nome_fantasia',
		'clie_cnpj',
		'clie_email',
		'clie_senha',
		'clie_cep',
		'clie_endereco',
		'clie_end_numero',
		'clie_end_compl',
		'clie_bairro',
		'clie_cidade',
		'clie_estado',
		'clie_observacoes',
		'clie_dte_ini_contrato',
		'clie_dte_end_contrato',
		'clie_dte_cadastro',
		'clie_dte_alteracao',
		'clie_ativo',
		'clie_raiz_id',
	];

    protected function initialize()
    {
		//$this->allowedFields[] = 'middlename';
		$db = \Config\Database::connect();
    }

}