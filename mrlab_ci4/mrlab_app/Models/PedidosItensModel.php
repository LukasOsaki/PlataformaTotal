<?php
namespace App\Models;

use CodeIgniter\Model;

class PedidosItensModel extends Model
{
	/*
		CREATE TABLE tbl_pedidos_itens (
			item_id INT(11) NOT NULL AUTO_INCREMENT,
			prod_id INT(11) NOT NULL DEFAULT '0',
			cad_id INT(11) NOT NULL DEFAULT '0',
			ped_id INT(11) NOT NULL DEFAULT '0',
			item_hashkey VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			item_produto VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
			item_valor DECIMAL(16,2) NULL DEFAULT '0.00',
			item_quant INT(11) NULL DEFAULT '0',
			item_dte_cadastro DATETIME NULL DEFAULT NULL,
			item_dte_alteracao DATETIME NULL DEFAULT NULL,
			item_ativo TINYINT(4) NULL DEFAULT '0',
			PRIMARY KEY (item_id) USING BTREE,
			UNIQUE INDEX item_id (item_id) USING BTREE
		)
		COLLATE='utf8mb4_general_ci'
		ENGINE=MyISAM
		;
	*/

	protected $db = null;
    protected $table = 'tbl_pedidos_itens';
	protected $primaryKey = 'item_id';
	protected $useAutoIncrement = true;
	protected $returnType = 'object';
	protected $allowedFields = [
		'prod_id',
		'cad_id',
		'ped_id',
		'item_hashkey',
		'item_produto',
		'item_valor',
		'item_quant',
		'item_dte_cadastro',
		'item_dte_alteracao',
		'item_ativo',
	];

    protected function initialize()
    {
		//$this->allowedFields[] = 'middlename';
		$db = \Config\Database::connect();
    }

}