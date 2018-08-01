<?php

namespace Controller;

use helpers\Controller;

class Main extends Controller
{

    public function index()
    {
        $parent = $this->getUri('/admin');
        $this->render("Main/index", array(
            "uri" => $parent,
            "title" => "Kraft AppFair",
            "active" => "home",
            "name" => $_SESSION['user_name'],
            "profile_id" => $_SESSION['user_profile_id']
        ));
    }

}