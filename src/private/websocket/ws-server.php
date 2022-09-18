<?php
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
require 'Logic.php';
use websocket\Notification;


    $server = IoServer::factory(
        new HttpServer(
            new WsServer(
                new Notification()
            )
        ),
        8080
    );

    $server->run();