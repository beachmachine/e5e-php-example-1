<?php

function myfunction($event, $context)
{
    echo "Print line 1" . PHP_EOL;
    echo "Print line 2" . PHP_EOL;
    echo "Print line 3" . PHP_EOL;

    $a = $event["data"]["a"] ?? 0;
    $b = $event["data"]["b"] ?? 0;

    $ipLocal = trim(shell_exec("ip addr"));

    $ipRemoteRequest = curl_init();
    curl_setopt($ipRemoteRequest, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ipRemoteRequest, CURLOPT_URL, "https://ip.anexia.at");
    curl_setopt($ipRemoteRequest, CURLOPT_HTTPHEADER, [
        "user-agent: curl/7.68.0",
    ]);
    curl_setopt($ipRemoteRequest, CURLOPT_RETURNTRANSFER, TRUE);
    $ipRemote = trim(curl_exec($ipRemoteRequest));
    curl_close($ipRemoteRequest);

    $resolve = trim(file_get_contents('/etc/resolv.conf'));
    $hosts = trim(file_get_contents('/etc/hosts'));

    return [
        "status" => 202,
        "response_headers" => [
            "x-custom-response-header-1" => "This is a custom response header 1",
            "x-custom-response-header-2" => "This is a custom response header 2",
            "x-custom-response-header-3" => "This is a custom response header 3",
        ],
        "data" => [
            "sum" => $a + $b,
            "version" => phpversion(),
            "event" => $event,
            "context" => $context,
            "ip_local" => $ipLocal,
            "ip_remote" => $ipRemote,
            "resolve" => $resolve,
            "hosts" => $hosts,
            "environment" => $_ENV,
        ]
    ];
}
