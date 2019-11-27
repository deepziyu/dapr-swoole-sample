<?php
$daprPort = $_ENV['DAPR_HTTP_PORT'] ?? 3500;
$invokeId = $_ENV['INVOKE_ID'] ?? 'swoole-app';
$daprUrl = "http://localhost:{$daprPort}/v1.0/invoke/{$invokeId}/method/newOrder";

$n = 0;
while (true) {
    $n ++;
    try{
        file_get_contents($daprUrl, false, stream_context_create([
            'http' => [
                "method" => "POST",
                "header" => "Content-Type: application/json",
                "content" => "{\"orderId\":{$n}}"
        ]]));
    }catch (\Throwable $throwable){
        var_dump($throwable->getMessage());
    }
    sleep(1);
}