<?php
/* Moloni
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Invoicing\Moloni\Libraries\MoloniLibrary\Classes;

use \Invoicing\Moloni\Libraries\MoloniLibrary\Moloni;

class ProductsTaxes
{

    private $moloni;

    /**
     * ProductsTaxes constructor.
     * @param Moloni $moloni
     */
    public function __construct(Moloni $moloni)
    {
        $this->moloni = $moloni;
    }

    /**
     * @param bool $company_id
     * @return bool|mixed
     */
    public function getAll($company_id = false)
    {
        $values = ["company_id" => ($company_id ? $company_id : $this->moloni->session->companyId)];
        $result = $this->moloni->execute("taxes/getAll", $values);
        if (is_array($result) && isset($result[0]['tax_id'])) {
            return $result;
        } else {
            $this->moloni->errors->throwError(
                __("Não tem acesso à informação das taxas de artigos"),
                __(print_r($result, true)),
                __CLASS__ . "/" . __FUNCTION__
            );
            return false;
        }
    }
}
