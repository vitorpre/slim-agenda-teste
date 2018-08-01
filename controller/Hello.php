<?php

namespace controller ;
use Slim\Views\Twig;

/**
 * Created by PhpStorm.
 * User: vitor
 * Date: 16/07/2018
 * Time: 09:56
 */
class Hello extends Controller
{
    public function hello($request, $response, $args)
    {
        $uri = "http://" . $request->getUri()->getHost() . "/";

        $this->view->render( $response,"home/index.twig", array(
            "uri" => $uri,
            "title" => "Home",
            "nome" => $args['nome']
        ));

    }
}
