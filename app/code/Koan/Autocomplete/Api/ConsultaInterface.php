<?php

namespace Koan\Autocomplete\Api;

interface ConsultaInterface
{
    /**
     * Consulta Cep
     *
     * @param string $cep
     * @return \Koan\Autocomplete\Api\Data\Dados|Bool
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function consultaCep($cep);

}
