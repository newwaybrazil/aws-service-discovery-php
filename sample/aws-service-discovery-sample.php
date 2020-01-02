<?php

require_once __DIR__ . '/../vendor/autoload.php';

use AwsServiceDiscovery\AwsServiceDiscovery;

$config = [
    'credentials' => [
        'key' => '', // put here your aws key
        'secret' => '', // put here your aws secret
    ],
    'version' => 'latest', // service version
    'region' => 'us-east-1', // aws region
];

$namespaceId = ''; // put here your namespace id
$serviceId = ''; // put here your service id
$namespaceName = ''; // put here your namespace name
$serviceName = ''; // put here your service name

$serviceDiscovery = new AwsServiceDiscovery($config);

$namespace = $serviceDiscovery->getNamespace(
    $namespaceId
);
print_r($namespace);
echo PHP_EOL;

$listServices = $serviceDiscovery->listServices(
    $namespaceId
);
print_r($listServices);
echo PHP_EOL;

$serviceData = $serviceDiscovery->getService(
    $serviceId
);
print_r($serviceData);
echo PHP_EOL;

$instances = $serviceDiscovery->getInstances(
    $namespaceName,
    $serviceName
);
print_r($instances);
echo PHP_EOL;

$firstUrl = $serviceDiscovery->getServiceFirstHealthUrl(
    $namespaceName,
    $serviceName
);
print_r($firstUrl);
echo PHP_EOL;

$randomUrl = $serviceDiscovery->getServiceRandomHealthUrl(
    $namespaceName,
    $serviceName
);
print_r($randomUrl);
echo PHP_EOL;

$allUrls = $serviceDiscovery->getServiceAllHealthUrl(
    $namespaceName,
    $serviceName
);
print_r($allUrls);
echo PHP_EOL;
