<?php
namespace App\Models;

use CodeIgniter\Model;

class FuncionariosArquivosModel extends Model
{
	/*
		CREATE TABLE `tbl_funcionarios_arquivos` (
			`func_arq_id` INT(11) NOT NULL AUTO_INCREMENT,
			`func_id` INT(11) NOT NULL,
			`func_arq_hashkey` VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			`func_arq_hash_item` VARCHAR(100) NOT NULL ,
			`func_arq_urlpage` VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			`func_arq_nome_doc` VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			`func_arq_data` DATETIME NULL DEFAULT NULL,
			`func_arq_validade` DATETIME NULL DEFAULT NULL,
			`func_arq_anexo` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			`func_arq_status` VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			`func_arq_tipo` VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			`func_arq_dte_cadastro` DATETIME NULL DEFAULT NULL,
			`func_arq_dte_alteracao` DATETIME NULL DEFAULT NULL,
			`func_arq_ativo` TINYINT(4) NULL DEFAULT '0',
			PRIMARY KEY (`func_arq_id`) USING BTREE,
			UNIQUE INDEX `func_arq_id` (`func_arq_id`) USING BTREE,
			INDEX `func_id` (`func_id`) USING BTREE
		)
		COLLATE='utf8mb4_general_ci'
		ENGINE=MyISAM
		;
	*/

	protected $db = null;
    protected $table = 'tbl_funcionarios_arquivos';
	protected $primaryKey = 'func_arq_id';
	protected $useAutoIncrement = true;
	protected $returnType = 'object';
    protected $allowedFields = [
        'func_arq_id',
        'func_id',
        'func_arq_hashkey',
		'func_arq_hash_item',
        'func_arq_urlpage',
        'func_arq_nome_doc',
        'func_arq_data',
        'func_arq_validade',
        'func_arq_anexo',
        'func_arq_status',
        'func_arq_tipo',
        'func_arq_dte_cadastro',
        'func_arq_dte_alteracao',
        'func_arq_ativo',
    ];

    protected function initialize()
    {
		//$this->allowedFields[] = 'middlename';
		$db = \Config\Database::connect();
    }

}