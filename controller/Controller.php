<?php
/**
 * Created by PhpStorm.
 * User: vitor
 * Date: 17/07/2018
 * Time: 14:30
 */

namespace Controller;

use Illuminate\Database\Capsule\Manager;
use Slim\Container;
use Slim\Http\Request;
use Slim\Views\Twig;

class Controller
{
    /**
     * @var Twig
     */
    protected $view ;
    protected $baseUri ;
    /**
     * @var Manager
     */
    protected $db ;
    /**
     * @var Router
     */
    protected $router ;

    function __construct(Container $c)
    {
        $this->db = $c["db"] ;
        $this->view = $c["view"] ;
        $this->router = $c['router'] ;

        $this->baseUri = getenv('BASE_DIR_SLIM');
    }

    public function montarUrlBase(Request $request)
    {
        return $request->getUri()->getScheme() . "://" . $request->getUri()->getHost() . $this->baseUri . "/";
    }

}