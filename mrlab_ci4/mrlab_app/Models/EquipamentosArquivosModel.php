<?php
namespace App\Models;

use CodeIgniter\Model;

class EquipamentosArquivosModel extends Model
{
	/*
		CREATE TABLE `tbl_equipamentos_arquivos` (
			`arq_id` INT(11) NOT NULL AUTO_INCREMENT,
			`eqto_id` INT(11) NOT NULL,
			`arq_hashkey` VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			`arq_hash_item` VARCHAR(100) NOT NULL ,
			`arq_urlpage` VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			`arq_nome_doc` VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			`arq_data` DATETIME NULL DEFAULT NULL,
			`arq_validade` DATETIME NULL DEFAULT NULL,
			`arq_anexo` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			`arq_status` VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			`arq_dte_cadastro` DATETIME NULL DEFAULT NULL,
			`arq_dte_alteracao` DATETIME NULL DEFAULT NULL,
			`arq_ativo` TINYINT(4) NULL DEFAULT '0',
			PRIMARY KEY (`arq_id`) USING BTREE,
			UNIQUE INDEX `arq_id` (`arq_id`) USING BTREE,
			INDEX `eqto_id` (`eqto_id`) USING BTREE
		)
		COLLATE='utf8mb4_general_ci'
		ENGINE=MyISAM
		;
	*/

	protected $db = null;
    protected $table = 'tbl_equipamentos_arquivos';
	protected $primaryKey = 'arq_id';
	protected $useAutoIncrement = true;
	protected $returnType = 'object';
    protected $allowedFields = [
        'arq_id',
        'eqto_id',
        'arq_hashkey',
		'arq_hash_item',
        'arq_urlpage',
        'arq_nome_doc',
        'arq_data',
        'arq_validade',
        'arq_anexo',
        'arq_status',
        'arq_dte_cadastro',
        'arq_dte_alteracao',
        'arq_ativo',
    ];

    protected function initialize()
    {
		//$this->allowedFields[] = 'middlename';
		$db = \Config\Database::connect();
    }

}