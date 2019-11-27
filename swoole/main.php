<?php
namespace main;
use Swoole\Http\Server;
use Swoole\Coroutine\Http\Client;
use Swoole\Http\Request;
use Swoole\Http\Response;

$daprPort = $_ENV['DAPR_HTTP_PORT'] ?? 3500;
$stateUri  = '/v1.0/state'; //http://localhost:3500/v1.0/state/order

$port = $_ENV['SERVER_HTTP_PORT'] ?? 3000;
$server =  new Server("0.0.0.0",$port);

$server->set(['daemonize' => 0]);
$server->on("request",function (Request $request,Response $response){
    $uri = preg_replace('/^[\/\-]+/i', '', $request->server['request_uri']);
    $method = $request->server['request_method'];
    $method = "main\\{$method}{$uri}";
    if(function_exists($method)){
        return call_user_func_array($method, [$request, $response]);
    }

    $response->status(404,"method not find");
    $response->end("$method not found");
    return null;
});

function postNewOrder(Request $request,Response $response) {
    global $daprPort, $stateUri;
    $data =json_decode($request->rawContent(),true);

    $client = new Client("localhost", $daprPort);
    $client->setHeaders([
        'Content-Type' => 'application/json'
    ]);
    $client->post($stateUri, json_encode([
        ['key' => 'order', 'value'=> (int)$data['orderId']]
    ]));

    echo "persisted state:" . $client->getStatusCode() .PHP_EOL;
    $response->end($client->getBody());
}

function getOrder(Request $request,Response $response){
    global $daprPort, $stateUri;

    $client = new Client("localhost", $daprPort);
    $client->setHeaders([
        'Content-Type' => 'application/json'
    ]);
    $client->get("{$stateUri}/order");
    echo "get state:" . $client->getStatusCode() .PHP_EOL;
    $response->end($client->getBody());
}

$server->start();