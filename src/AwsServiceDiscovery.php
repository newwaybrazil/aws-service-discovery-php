<?php

namespace AwsServiceDiscovery;

use Aws\ServiceDiscovery\ServiceDiscoveryClient;

class AwsServiceDiscovery
{
    public $serviceDiscoveryConfig;

    const ALL = 'ALL';
    const HEALTHY = 'HEALTHY';
    const UNHEALTHY = 'UNHEALTHY';

    const URL_ATTR = 'AWS_INSTANCE_IPV4';
    const PORT_ATTR = 'AWS_INSTANCE_PORT';

    /**
     * Constructor
     * @param array $serviceDiscoveryConfig
     */
    public function __construct(array $serviceDiscoveryConfig)
    {
        $this->serviceDiscoveryConfig = $serviceDiscoveryConfig;
    }

    /**
     * get namespace by id
     * @param string $namespaceId
     * @return array
     */
    public function getNamespace(
        string $namespaceId
    ) : array {
        $serviceDiscovery = $this->newServiceDiscovery();
        $namespace = $serviceDiscovery->getNamespace(
            [
                'Id' => $namespaceId,
            ]
        );
        $result = $namespace->toArray() ?? [];
        return $result['Namespace'] ?? [];
    }

    /**
     * List services
     * @param string $namespaceId
     * @return array
     */
    public function listServices(
        string $namespaceId
    ) : array {
        $serviceDiscovery = $this->newServiceDiscovery();
        $services = $serviceDiscovery->listServices([
            'Filters' => [
                [
                    'Name' => 'NAMESPACE_ID',
                    'Values' => [
                        $namespaceId,
                    ],
                    'Condition' => 'EQ'
                ],
            ],
            'MaxResults' => 20,
        ]);
        $result = $services->toArray() ?? [];
        return $result['Services'] ?? [];
    }

    /**
     * get service
     * @param string $serviceId
     * @return array
     */
    public function getService(
        string $serviceId
    ) : array {
        $serviceDiscovery = $this->newServiceDiscovery();
        $service = $serviceDiscovery->getService(
            [
                'Id' => $serviceId,
            ]
        );
        $result = $service->toArray() ?? [];
        return $result['Service'] ?? [];
    }

    /**
     * get service
     * @param string $namespaceName
     * @param string $service
     * @param string $status
     * @param int $maxResults
     * @return array
     */
    public function getInstances(
        string $namespaceName,
        string $service,
        string $status = self::ALL,
        int $maxResults = 10
    ) : array {
        $serviceDiscovery = $this->newServiceDiscovery();
        $instances = $serviceDiscovery->discoverInstances(
            [
                'HealthStatus' => $status,
                'MaxResults' => $maxResults,
                'NamespaceName' => $namespaceName,
                'ServiceName' => $service,
            ]
        );
        $result = $instances->toArray() ?? [];
        return $result['Instances'] ?? [];
    }

    /**
     * get service first url
     * @param string $namespaceName
     * @param string $service
     * @return string|null
     */
    public function getServiceFirstHealthUrl(
        string $namespaceName,
        string $service
    ) : ?string {
        $instances = $this->getInstances(
            $namespaceName,
            $service,
            self::HEALTHY
        );

        $url = $this->getInstanceAttr(
            $instances,
            self::URL_ATTR,
            0
        );
        $port = $this->getInstanceAttr(
            $instances,
            self::PORT_ATTR,
            0
        );

        if (empty($url) || empty($port)) {
            return null;
        }

        return $url . ':' . $port;
    }


    /**
     * get service random url
     * @param string $namespaceName
     * @param string $service
     * @return string|null
     */
    public function getServiceRandomHealthUrl(
        string $namespaceName,
        string $service
    ) : ?string {
        $instances = $this->getInstances(
            $namespaceName,
            $service,
            self::HEALTHY
        );

        if (empty($instances)) {
            return null;
        }

        $totalInstances = count($instances);

        $shuffle = $this->getShuffleIndex(
            $totalInstances
        );

        $url = $this->getInstanceAttr(
            $instances,
            self::URL_ATTR,
            $shuffle
        );
        $port = $this->getInstanceAttr(
            $instances,
            self::PORT_ATTR,
            $shuffle
        );

        if (empty($url) || empty($port)) {
            return null;
        }
        return $url . ':' . $port;
    }

    /**
     * get all service urls
     * @param string $namespaceName
     * @param string $service
     * @return array
     */
    public function getServiceAllHealthUrl(
        string $namespaceName,
        string $service
    ) : array {
        $instances = $this->getInstances(
            $namespaceName,
            $service,
            self::HEALTHY
        );
        $result = [];

        if (empty($instances)) {
            return $result;
        }

        foreach (array_keys($instances) as $index) {
            $url = $this->getInstanceAttr(
                $instances,
                self::URL_ATTR,
                $index
            );
            $port = $this->getInstanceAttr(
                $instances,
                self::PORT_ATTR,
                $index
            );
    
            if (!empty($url) && !empty($port)) {
                $result[] = $url . ':' . $port;
            }
        }
        return $result;
    }

    /**
     * get instance attr
     * @param array $instances
     * @param int $index
     * @param string $attr
     * @return string|null
     */
    public function getInstanceAttr(
        array $instances,
        string $attr,
        int $index
    ) : ?string {
        return $instances[$index]['Attributes'][$attr] ?? null;
    }

    /**
     * get shuffle index
     * @param int $totalInstances
     * @return int
     */
    public function getShuffleIndex(
        int $totalInstances
    ) : int {
        if ($totalInstances === 1) {
            return 0;
        }
        return rand(0, $totalInstances - 1);
    }

    /**
     * @codeCoverageIgnore
     * create service discovery client instance
     * @return \Aws\ServiceDiscovery\ServiceDiscoveryClient
     */
    public function newServiceDiscovery()
    {
        return new ServiceDiscoveryClient($this->serviceDiscoveryConfig);
    }
}
