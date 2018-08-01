<?php
/**
 * Created by PhpStorm.
 * User: vitor
 * Date: 16/07/2018
 * Time: 15:44
 */

namespace helpers;


class MensagemRetorno
{
    public $mensagem ;
    public $classe ;

    public function __construct($mensagem, $classe)
    {
        $this->mensagem = $mensagem ;
        $this->classe = $classe ;
    }

    public static function getMensagemSucesso($mensagem)
    {
        return new MensagemRetorno($mensagem, "success") ;
    }

}