<?php

namespace controller ;
use library\agendamento\Agendamento;
use library\database\ConexaoPrincipal;
use Slim\Container;
use Slim\Flash\Messages;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Router;
use Slim\Views\Twig;

/**
 * Created by PhpStorm.
 * User: vitor
 * Date: 16/07/2018
 * Time: 09:56
 */
class AgendamentoController extends Controller
{
    /**
     * @var Messages
     */
    protected $flash ;


    public function __construct(Container $c)
    {
        parent::__construct($c) ;

        $this->flash = $c['flash'] ;
    }

    public function horarios($request, $response, $args)
    {
        $uri = "http://" . $request->getUri()->getHost() . "/";

        $data = new \DateTime() ;

        $agendamento = new Agendamento($this->db) ;
        $horarios = $agendamento->buscarHorariosDia($data)  ;

        $this->view->render( $response,"agendamento/horarios.twig", array(
            "uri" => $uri,
            "title" => "Home",
            "horarios" => $horarios,
            "data" => $data->format("Y-m-d"),
            "mensagem" => $this->flash->getMessage("mensagem")[0]
        ));

    }

    public function marcar(Request $request, Response $response, $args)
    {
        $uri = "http://" . $request->getUri()->getHost() . "/";

        $objHorario = array();
        $objHorario["horarioInicial"] = $request->getParam("dataSelecionada") . " "
            . $request->getParam("horarioSelecionado") . ":00" ;

        $result = $this->db->table('horarios')->insert( $objHorario ) ;

        $this->flash->addMessage( "mensagem", "Agendamento feito com sucesso!" ) ;

        return $response->withRedirect( $uri . 'agendamentos/horarios') ;

    }

    public function buscarHorariosDia($request, $response, $args)
    {
        $data = \DateTime::createFromFormat("Y-m-d", $args["data"]) ;

        $agendamento = new Agendamento() ;

        $horarios = $agendamento->buscarHorariosDia($data) ;

        return $response->withJson( json_encode( $horarios ) ) ;
    }
}
