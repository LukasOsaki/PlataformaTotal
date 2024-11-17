<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class AppSettings extends BaseConfig
{

	public $CFG_COOKIE_NAME = "TOTALSERV-SESSION-COOKIE-BACKEND";


	public function getMetodoEnvio()
	{
		$cfg_array = [
			'frete_gratis'		=>  ['value' => '0', 'label' => 'Frete Grátis'],
			'frete_fixo'		=>  ['value' => '49', 'label' => 'Frete Fixo'],
			'retirada_local'	=>  ['value' => '8', 'label' => 'Retirada no Local'],
		];
		return $cfg_array;
	}


	public function getMetodoPagamento()
	{
		$cfg_array = [
			'pagto_transfer'	=>  ['value' => '', 'label' => 'Transferência bancária direta'],
			'pagto_check'		=>  ['value' => '', 'label' => 'Verifique pagamentos'],
			'pagto_entrega'		=>  ['value' => '', 'label' => 'Pagamento na entrega'],
		];
		return $cfg_array;
	}

	public function getStatusDefault()
	{
		$cfg_array = [
			'ativo'	=>  ['value' => '1', 'label' => 'Ativo'],
			'inativo'	=>  ['value' => '0', 'label' => 'Inativo'],
		];
		return $cfg_array;
	}

	public function getCategoriasAreas()
	{
		$cfg_array = [
			'pendencias-status'	=>  ['value' => '', 'label' => 'Pendências - Status'],
			'pendencias-tipo-serv'	=>  ['value' => '', 'label' => 'Pendências - Tipo Serviço'],
		];
		return $cfg_array;
	}

	public function getProgPeriodo()
	{
		$cfg_array = [
			'manha'	=>  ['value' => '', 'label' => 'Manhã'],
			'tarde'	=>  ['value' => '', 'label' => 'Tarde'],
		];
		return $cfg_array;
	}

	public function getSistemaAreas()
	{
		$cfg_array = [
			'clientes' => 'Clientes',
			'equipamentos' => 'Equipamentos',
			'categorias' => 'Categorias',
			'servicos' => 'Serviços',
			'programacao' => 'Programação',
			//'financeiro' => 'Financeiro',
			'colaborador' => 'Colaborador',
			'usuarios' => 'Usuários',
		];
		return $cfg_array;
	}

	public function getSistemaAcoes()
	{
		$cfg_array = [
			'visualizar' => 'Visualizar',
			'editar' => 'Editar',
			'excluir' => 'Excluir',
			'cadastrar' => 'Cadastrar' ,
		];
		return $cfg_array;
	}

}
