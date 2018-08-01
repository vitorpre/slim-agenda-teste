<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes

$app->get('/usuarios', "\controller\Usuario:index" );
$app->get('/usuarios/cadastrar', "\controller\Usuario:cadastrar" );
$app->get('/usuarios/editar/{id}', "\controller\Usuario:editar" );
$app->post('/usuarios/alterar', "\controller\Usuario:alterar" );
$app->post('/usuarios/inserir', "\controller\Usuario:inserir" );

$app->get('/agendamentos/horarios', "\controller\AgendamentoController:horarios" )->setName("agendamento.horarios");
$app->post('/agendamentos/marcar', "\controller\AgendamentoController:marcar" );
$app->get('/api/agendamentos/horarios/dia/{data}', "\controller\AgendamentoController:buscarHorariosDia" );


$app->get('/hello/{nome}', "\controller\Hello:hello" );

$app->get('/[{name}]', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});
