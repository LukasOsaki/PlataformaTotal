<?php
namespace App\Models;

use CodeIgniter\Model;

class PedidosModel extends Model
{
	/*
		CREATE TABLE tbl_pedidos (
			ped_id INT(11) NOT NULL AUTO_INCREMENT,
			cad_id INT(11) NOT NULL DEFAULT '0',
			ped_hashkey VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			ped_urlpage VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			ped_nome VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			ped_sobrenome VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			ped_email VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			ped_cep VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			ped_endereco VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			ped_bairro VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			ped_cidade VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			ped_estado VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			ped_envio_tipo VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			ped_envio_valor DECIMAL(16,2) NULL DEFAULT NULL,
			ped_dte_cadastro DATETIME NULL DEFAULT NULL,
			ped_dte_alteracao DATETIME NULL DEFAULT NULL,
			ped_ativo TINYINT(4) NULL DEFAULT '0',
			PRIMARY KEY (ped_id) USING BTREE,
			UNIQUE INDEX ped_id (ped_id) USING BTREE,
			INDEX cad_id (cad_id) USING BTREE
		)
		COLLATE='utf8mb4_general_ci'
		ENGINE=MyISAM
		;
	*/

	protected $db = null;
    protected $table = 'tbl_pedidos';
	protected $primaryKey = 'ped_id';
	protected $useAutoIncrement = true;
	protected $returnType = 'object';
	protected $allowedFields = [
		'cad_id',
		'ped_hashkey',
		'ped_urlpage',
		'ped_nome',
		'ped_sobrenome',
		'ped_email',
		'ped_cep',
		'ped_endereco',
		'ped_bairro',
		'ped_cidade',
		'ped_estado',
		'ped_envio_tipo',
		'ped_envio_valor',
		'ped_pagto_tipo',
		'ped_observacoes',
		'ped_dte_cadastro',
		'ped_dte_alteracao',
		'ped_ativo',
	];

    protected function initialize()
    {
		//$this->allowedFields[] = 'middlename';
		$db = \Config\Database::connect();
    }

}