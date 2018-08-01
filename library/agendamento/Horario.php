<?php
/**
 * Created by PhpStorm.
 * User: vitor
 * Date: 19/07/2018
 * Time: 15:43
 */

namespace library\agendamento;


class Horario
{
    public $horario ;
    public $status ;

    function __construct($horario, $status)
    {
        $this->horario = $horario ;
        $this->status = $status ;
    }


}