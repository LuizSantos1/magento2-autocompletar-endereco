<?php
namespace Koan\Autocomplete\Model;

use Koan\Autocomplete\Api\ConsultaInterface;
use Koan\Autocomplete\Api\Data\Dados;
use Koan\Autocomplete\Model\Endereco\Correios;
use Koan\Autocomplete\Model\Endereco\Republicavirtual;
use Koan\Autocomplete\Model\Endereco\Viacep;

/**
 * Class Consulta
 * @package Koan\Autocomplete\Model
 */
class Consulta extends \Magento\Framework\DataObject implements Dados, ConsultaInterface {


	/**
	 * @var \Magento\Directory\Model\Region
	 */
	protected $_modelRegion;

	/**
	 * @var \Magento\Framework\App\Request\Http
	 */
	protected $_request;

	/**
	 * Consulta constructor.
	 * @param \Magento\Directory\Model\Region $modelRegion
	 * @param \Magento\Framework\App\Request\Http $request
	 */
	public function __construct(\Magento\Directory\Model\Region $modelRegion,
		\Magento\Framework\App\Request\Http $request
	) {
		$this->_modelRegion = $modelRegion;
		$this->_request = $request;
	}

	/**
	 * Consulta cep em diferentes serviços
	 * @param int $cep
	 * @return $this|bool
	 */
	public function consultaCep($cep) {

		$data = Correios::getEndereco($cep);
		if ($data) {
			$this->setData('logradouro', $data['logradouro']);
			$this->setData('bairro', $data['bairro']);
			$this->setData('cep', $data['cep']);
			$this->setData('cidade', $data['cidade']);
			$this->setData('uf', $this->getRegionId($data['uf']));
			return $this;
		}

		$data = Viacep::getEndereco($cep);
		if ($data) {
			$this->setData('logradouro', $data['logradouro']);
			$this->setData('bairro', $data['bairro']);
			$this->setData('cep', $data['cep']);
			$this->setData('cidade', $data['cidade']);
			$this->setData('uf', $this->getRegionId($data['uf']));
			return $this;
		}

		$data = Republicavirtual::getEndereco($cep);
		if ($data) {
			$this->setData('logradouro', $data['logradouro']);
			$this->setData('bairro', $data['bairro']);
			$this->setData('cep', $data['cep']);
			$this->setData('cidade', $data['cidade']);
			$this->setData('uf', $this->getRegionId($data['uf']));
			return $this;
		}

		return false;
	}


	/**
	 * @param string $uf
	 * @param string $country_id
	 * @return mixed
	 */
	public function getRegionId($uf, $country_id = "BR") {
		return $this->_modelRegion->loadByCode($uf, $country_id)->getId();
	}

	/**
	 * @return string
	 */
	public function getLogradouro() {
		return $this->getData('logradouro');
	}

	/**
	 * @return string
	 */
	public function getBairro() {
		return $this->getData('bairro');
	}

	/**
	 * @return string
	 */
	public function getCep() {
		return $this->getData('cep');
	}

	/**
	 * @return string
	 */
	public function getCidade() {
		return $this->getData('cidade');
	}

	/**
	 * @return string
	 */
	public function getUf() {
		return $this->getData('uf');
	}

	public function getError() {
		return $this->getData('error');
	}

}