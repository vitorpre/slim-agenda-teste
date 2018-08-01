<?php

namespace library\agendamento ;

use Illuminate\Database\Capsule\Manager;
use library\database\ConexaoPrincipal;

/**
 * Created by PhpStorm.
 * User: vitor
 * Date: 19/07/2018
 * Time: 11:56
 */
class Agendamento
{
    private $horasOcupadas = null ;
    private $db ;

    function __construct(Manager $conexao)
    {
        $this->db = $conexao;
    }

    public function buscarHorariosDia( \DateTime $data )
    {
        $horarios = array() ;

        $agendaParametros = $this->db->table('agendamento_parametros')->first() ;

        $horario = \DateTime::createFromFormat('Y-m-d H:i:s' ,
            $data->format('Y-m-d') . " " .$agendaParametros->horarioInicial ) ;

        $horarioFinal = \DateTime::createFromFormat('Y-m-d H:i:s' ,
            $data->format('Y-m-d') . " " . $agendaParametros->horarioFinal ) ;

        while ( $horario <= $horarioFinal )
        {
            $horarioEstaDisponivel = $this->verificarHorarioEstaDisponivel($horario) ;

            $horarios[] = new Horario( $horario->format("H:i"), $horarioEstaDisponivel) ;

            $horario->modify("+{$agendaParametros->tempoAgendamento} minutes") ;
        }

        return $horarios ;

    }

    private function buscarHorariosOcupadosDia( \DateTime $data )
    {
        if( $this->horasOcupadas == null )
        {
            $this->horasOcupadas = $this->db->table('horarios')
                ->whereDate('horarioInicial', '=', $data->format('Y-m-d'))
                ->get();
        }

        return $this->horasOcupadas ;
    }

    private function verificarHorarioEstaDisponivel( \DateTime $data )
    {
        $estaDisponivel = true;

        $this->buscarHorariosOcupadosDia($data);

        foreach ( $this->horasOcupadas as $horarioOcupado ) {

            $horarioInicial = \DateTime::createFromFormat( "Y-m-d H:i:s" , $horarioOcupado->horarioInicial ) ;
            $horarioFinal = \DateTime::createFromFormat( "Y-m-d H:i:s" , $horarioOcupado->horarioFinal ) ;

            /*
            if( $data >= $horarioInicial ) {
                if( $data < $horarioFinal ) {
                    $estaDisponivel = false ;
                }
            }
            */

            if( $data == $horarioInicial ) {
                $estaDisponivel = false ;
            }
        }

        return $estaDisponivel ;

    }

    public function agendarHorario(\DateTime $horario)
    {
        $objHorario = array();
        $objHorario["horarioInicial"] = $horario->format("Y-m-d H:i:s") ;

        $result = $this->db->table('horarios')->insert( $objHorario ) ;
    }

    private function verificarHorarioOcupado(\DateTime $horario)
    {
        $retorno = false;

        $objHorario = $this->db->table('horarios')
            ->where("horarioInicial" , "=", $horario->format("Y-m-d H:i:s"))->first() ;

        if($objHorario != null)
        {
            $retorno = true;
        }

        return $retorno ;
    }



}