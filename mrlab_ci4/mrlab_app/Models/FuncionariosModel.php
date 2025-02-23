<?php
namespace App\Models;

use CodeIgniter\Model;

class FuncionariosModel extends Model
{
	/*
		CREATE TABLE tbl_funcionarios (
			func_id INT(11) NOT NULL AUTO_INCREMENT,
			func_hashkey VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			func_registro VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			func_nome VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			func_nome_mae VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			func_nome_pai VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			func_cpf VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			func_uf_rg VARCHAR(2) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			func_rg VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			func_titulo VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			func_estado_civil VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			func_dt_nasc DATE NULL DEFAULT NULL ,
			func_email VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			func_senha VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',

			func_cep VARCHAR(10) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			func_endereco VARCHAR(100) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			func_end_numero VARCHAR(100) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			func_end_compl VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			func_bairro VARCHAR(100) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			func_cidade VARCHAR(120) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			func_estado VARCHAR(10) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',

			func_telefone VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			func_celular VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			
			func_sn_vt VARCHAR(1) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			func_salario DECIMAL(18,2) NULL DEFAULT NULL,


			func_observacoes LONGTEXT NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',

			func_dte_cadastro DATETIME NULL DEFAULT NULL,
			func_dte_alteracao DATETIME NULL DEFAULT NULL,
			func_ativo TINYINT(4) NULL DEFAULT '0',
			PRIMARY KEY (func_id) USING BTREE,
			UNIQUE INDEX func_id (func_id) USING BTREE
		)
		COLLATE='utf8mb4_general_ci'
		ENGINE=MyISAM
		AUTO_INCREMENT=1
		;

		
	*/

	protected $db = null;
    protected $table = 'tbl_funcionarios';
	protected $primaryKey = 'func_id';
	protected $useAutoIncrement = true;
	protected $returnType = 'object';
	protected $allowedFields = [
		'func_id',
		'func_hashkey',
		'func_registro',
		'func_nome',
		'func_nome_mae',
		'func_nome_pai',
		'func_nome',
		'func_cpf',
		'func_uf_rg',
		'func_rg',
		'func_titulo',
		'func_estado_civil',
		'func_dt_nasc',
		'func_email',
		'func_senha',
		'func_cep',
		'func_endereco',
		'func_end_numero',
		'func_end_compl',
		'func_bairro',
		'func_cidade',
		'func_estado',
		'func_telefone',
		'func_celular',
		'func_sn_vt',
		'func_salario',
		'func_observacoes',
		'func_dte_cadastro',
		'func_dte_alteracao',
		'func_ativo',
	];

    protected function initialize()
    {
		//$this->allowedFields[] = 'middlename';
		$db = \Config\Database::connect();
    }

}