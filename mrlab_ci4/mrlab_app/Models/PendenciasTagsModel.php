<?php
namespace App\Models;

use CodeIgniter\Model;

class PendenciasTagsModel extends Model
{
	/*
		CREATE TABLE `tbl_pendencias_tags` (
			`pendtag_id` INT(11) NOT NULL AUTO_INCREMENT,
			`pend_id` INT(11) NOT NULL,
			`clie_id` INT(11) NOT NULL,
			`eqto_id` INT(11) NOT NULL,
			`pendtag_tag` VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			`pendtag_descricao` LONGTEXT NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			`pendtag_coment_interno` LONGTEXT NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			`pendtag_observacoes` LONGTEXT NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			`pendtag_dte_cadastro` DATETIME NULL DEFAULT NULL,
			`pendtag_dte_alteracao` DATETIME NULL DEFAULT NULL,
			`pendtag_ativo` TINYINT(4) NULL DEFAULT '0',
			PRIMARY KEY (`pendtag_id`) USING BTREE,
			UNIQUE INDEX `pendtag_id` (`pendtag_id`) USING BTREE
		)
		COLLATE='utf8mb4_general_ci'
		ENGINE=MyISAM
		AUTO_INCREMENT=3
		;
	*/

	protected $db = null;
    protected $table = 'tbl_pendencias_tags';
	protected $primaryKey = 'pendtag_id';
	protected $useAutoIncrement = true;
	protected $returnType = 'object';
    protected $allowedFields = [
        'pend_id',
        'clie_id',
        'eqto_id',
		'pendtag_hashkey',
		'pendtag_tipo_serv',
		'pendtag_status',
		'pendtag_dte_registro',
		'pendtag_dte_instalacao',
        'pendtag_tag',
        'pendtag_descricao',
        'pendtag_observacoes',
		'pendtag_anexo',
        'pendtag_dte_cadastro',
        'pendtag_dte_alteracao',
        'pendtag_ativo',
    ];

    protected function initialize()
    {
		//$this->allowedFields[] = 'middlename';
		$db = \Config\Database::connect();
    }

}