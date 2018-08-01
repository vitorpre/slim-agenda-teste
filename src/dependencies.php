<?php
// DIC configuration

$container = $app->getContainer();

// view renderer
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    return new Slim\Views\PhpRenderer($settings['template_path']);
};

$container['flash'] = function ($c) {
    return new Slim\Flash\Messages();
};

$container['view'] = function ($c) {
    return new \Slim\Views\Twig("view") ;
};

$container['db'] = function ($c) {
    return \library\database\ConexaoPrincipal::getConexao() ;
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};

/*
$container['AgendamentoController'] = function($c) {
    $flash = $c->get("flash");
    $router = $c->get("router");
    return new \controller\AgendamentoController($flash, $router);
};
*/

