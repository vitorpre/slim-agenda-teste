<?php
/**
 * Created by PhpStorm.
 * User: vitor
 * Date: 16/07/2018
 * Time: 13:20
 */

namespace controller;

use helpers\MensagemRetorno ;
use Slim\Views\Twig;

class Usuario extends Controller
{

    public function index( $request, $response, $args )
    {
        $uri = "http://" . $request->getUri()->getHost() . "/";

        $usuarios = $this->db->table("usuarios")->get() ;

        $this->view->render( $response,"usuarios/index.twig", array(
            "uri" => $uri,
            "title" => "Usuários",
            "usuarios" => $usuarios
        ));
    }

    public function cadastrar( $request, $response, $args )
    {
        $uri = "http://" . $request->getUri()->getHost() . "/";

        $this->view->render($response, "usuarios/cadastro.twig", array(
            "uri" => $uri,
            "title" => "Usuários - Cadastro"
        ));
    }

    public function inserir( $request, $response, $args )
    {
        $uri = "http://" . $request->getUri()->getHost() . "/";

        $nome = filter_input(INPUT_POST, "nome") ;

        $usuario = new \StdClass() ;
        $usuario->nome = $nome ;

        $id = UsuariosRepository::insertUsuario($usuario) ;

        if ($usuario = UsuariosRepository::getUsuario($id)) {
            $mensagem = MensagemRetorno::getMensagemSucesso("Cadastrado com sucesso!") ;
        }

        $this->view->render($response, "usuarios/cadastro.twig", array(
            "uri" => $uri,
            "title" => "Usuários - Editar",
            "usuario" => $usuario,
            "mensagem" => $mensagem
        ));
    }

    public function editar( $request, $response, $args )
    {
        $uri = "http://" . $request->getUri()->getHost() . "/";

        $usuario = $this->db->table("usuarios")->find($args['id']) ;

        $this->view->render($response, "usuarios/cadastro.twig", array(
            "uri" => $uri,
            "title" => "Usuários - Editar",
            "usuario" => $usuario
        ));
    }

    public function alterar( $request, $response, $args )
    {
        $uri = "http://" . $request->getUri()->getHost() . "/";

        $id = filter_input(INPUT_POST, "id") ;
        $nome = filter_input(INPUT_POST, "nome") ;

        $usuario = (object) UsuariosRepository::getUsuario($id) ;
        $usuario->nome = $nome ;

        if (UsuariosRepository::updateUsuario($usuario)) {
            $mensagem = MensagemRetorno::getMensagemSucesso("Alterado com sucesso!") ;
        }

        $this->view->render($response, "usuarios/cadastro.twig", array(
            "uri" => $uri,
            "title" => "Usuários - Editar",
            "usuario" => $usuario,
            "mensagem" => $mensagem
        ));
    }

}
