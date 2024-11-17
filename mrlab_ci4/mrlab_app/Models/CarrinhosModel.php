<?php
namespace App\Models;

use CodeIgniter\Model;

class CarrinhosModel extends Model
{
	/*
		CREATE TABLE `tbl_carrinhos` (
			`cart_id` INT(11) NOT NULL AUTO_INCREMENT,
			`prod_id` INT(11) NOT NULL DEFAULT '0',
			`cad_id` INT(11) NOT NULL DEFAULT '0',
			`user_hashkey` VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			`cart_hashkey` VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			`cart_quant` INT(11) NULL DEFAULT '0',
			`cart_produto` VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			`cart_valor` DECIMAL(16,2) NULL DEFAULT '0.00',
			`cart_dte_cadastro` DATETIME NULL DEFAULT NULL,
			`cart_dte_alteracao` DATETIME NULL DEFAULT NULL,
			`cart_ativo` TINYINT(4) NULL DEFAULT '0',
			PRIMARY KEY (`cart_id`) USING BTREE,
			UNIQUE INDEX `cart_id` (`cart_id`) USING BTREE
		)
		COLLATE='utf8mb4_general_ci'
		ENGINE=MyISAM
		;
	*/

	protected $db = null;
    protected $table = 'tbl_carrinhos';
	protected $primaryKey = 'cart_id';
	protected $useAutoIncrement = true;
	protected $returnType = 'object';
	protected $allowedFields = [
		'prod_id',
		'cad_id',
		'user_hashkey',
		'cart_hashkey',
		'cart_produto',
		'cart_valor',
		'cart_quant',
		'cart_dte_cadastro',
		'cart_dte_alteracao',
		'cart_ativo',
	];

    protected function initialize()
    {
		//$this->allowedFields[] = 'middlename';
		$db = \Config\Database::connect();
    }

}