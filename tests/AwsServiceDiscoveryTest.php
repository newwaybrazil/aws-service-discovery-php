<?php

namespace AwsServiceDiscovery;

use Aws\ServiceDiscovery\ServiceDiscoveryClient;
use AwsServiceDiscovery\AwsServiceDiscovery;
use Mockery;
use PHPUnit\Framework\TestCase;
use Exception;

class AwsServiceDiscoveryTest extends TestCase
{
    /**
     * @covers AwsServiceDiscovery\AwsServiceDiscovery::__construct
     */
    public function testAwsServiceDiscoveryCanBeInstanciated()
    {
        $configs = [];
        $awsServiceDiscovery = new AwsServiceDiscovery($configs);
        $this->assertInstanceOf(AwsServiceDiscovery::class, $awsServiceDiscovery);
    }

    /**
     * @covers AwsServiceDiscovery\AwsServiceDiscovery::getNamespace
     */
    public function testGetNamespace()
    {
        $configs = [];
        $namespaceId = 'namespace';
        $data = [
            'Id' => $namespaceId,
        ];

        $serviceDiscoveryClient = Mockery::mock(ServiceDiscoveryClient::class)
            ->shouldReceive('getNamespace')
            ->with($data)
            ->once()
            ->andReturnSelf()
            ->shouldReceive('toArray')
            ->withNoArgs()
            ->once()
            ->andReturn(['Namespace' => ['test']])
            ->getMock();

        $awsServiceDiscovery = Mockery::mock(
            AwsServiceDiscovery::class,
            [$configs]
        )->makePartial();

        $awsServiceDiscovery->shouldReceive('newServiceDiscovery')
            ->withNoArgs()
            ->once()
            ->andReturn($serviceDiscoveryClient);

        $getNamespace = $awsServiceDiscovery->getNamespace($namespaceId);

        $this->assertEquals($getNamespace, ['test']);
    }

    /**
     * @covers AwsServiceDiscovery\AwsServiceDiscovery::getNamespace
     */
    public function testGetNamespaceButEmpty()
    {
        $configs = [];
        $namespaceId = 'namespace';
        $data = [
            'Id' => $namespaceId,
        ];

        $serviceDiscoveryClient = Mockery::mock(ServiceDiscoveryClient::class)
            ->shouldReceive('getNamespace')
            ->with($data)
            ->once()
            ->andReturnSelf()
            ->shouldReceive('toArray')
            ->withNoArgs()
            ->once()
            ->andReturn(['test' => ['test']])
            ->getMock();

        $awsServiceDiscovery = Mockery::mock(
            AwsServiceDiscovery::class,
            [$configs]
        )->makePartial();

        $awsServiceDiscovery->shouldReceive('newServiceDiscovery')
            ->withNoArgs()
            ->once()
            ->andReturn($serviceDiscoveryClient);

        $getNamespace = $awsServiceDiscovery->getNamespace($namespaceId);

        $this->assertEquals($getNamespace, []);
    }

    /**
     * @covers AwsServiceDiscovery\AwsServiceDiscovery::listServices
     */
    public function testListServices()
    {
        $configs = [];
        $namespaceId = 'namespace';
        $data = [
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
        ];

        $serviceDiscoveryClient = Mockery::mock(ServiceDiscoveryClient::class)
            ->shouldReceive('listServices')
            ->with($data)
            ->once()
            ->andReturnSelf()
            ->shouldReceive('toArray')
            ->withNoArgs()
            ->once()
            ->andReturn(['Services' => ['test']])
            ->getMock();

        $awsServiceDiscovery = Mockery::mock(
            AwsServiceDiscovery::class,
            [$configs]
        )->makePartial();

        $awsServiceDiscovery->shouldReceive('newServiceDiscovery')
            ->withNoArgs()
            ->once()
            ->andReturn($serviceDiscoveryClient);

        $listServices = $awsServiceDiscovery->listServices($namespaceId);

        $this->assertEquals($listServices, ['test']);
    }

    /**
     * @covers AwsServiceDiscovery\AwsServiceDiscovery::listServices
     */
    public function testListServicesButEmpty()
    {
        $configs = [];
        $namespaceId = 'namespace';
        $data = [
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
        ];

        $serviceDiscoveryClient = Mockery::mock(ServiceDiscoveryClient::class)
            ->shouldReceive('listServices')
            ->with($data)
            ->once()
            ->andReturnSelf()
            ->shouldReceive('toArray')
            ->withNoArgs()
            ->once()
            ->andReturn([])
            ->getMock();

        $awsServiceDiscovery = Mockery::mock(
            AwsServiceDiscovery::class,
            [$configs]
        )->makePartial();

        $awsServiceDiscovery->shouldReceive('newServiceDiscovery')
            ->withNoArgs()
            ->once()
            ->andReturn($serviceDiscoveryClient);

        $listServices = $awsServiceDiscovery->listServices($namespaceId);

        $this->assertEquals($listServices, []);
    }

    /**
     * @covers AwsServiceDiscovery\AwsServiceDiscovery::getService
     */
    public function testGetService()
    {
        $configs = [];
        $serviceId = 'serviceId';
        $data = [
            'Id' => $serviceId
        ];

        $serviceDiscoveryClient = Mockery::mock(ServiceDiscoveryClient::class)
            ->shouldReceive('getService')
            ->with($data)
            ->once()
            ->andReturnSelf()
            ->shouldReceive('toArray')
            ->withNoArgs()
            ->once()
            ->andReturn(['Service' => ['test']])
            ->getMock();

        $awsServiceDiscovery = Mockery::mock(
            AwsServiceDiscovery::class,
            [$configs]
        )->makePartial();

        $awsServiceDiscovery->shouldReceive('newServiceDiscovery')
            ->withNoArgs()
            ->once()
            ->andReturn($serviceDiscoveryClient);

        $getService = $awsServiceDiscovery->getService($serviceId);

        $this->assertEquals($getService, ['test']);
    }

    /**
     * @covers AwsServiceDiscovery\AwsServiceDiscovery::getService
     */
    public function testGetServiceEmpty()
    {
        $configs = [];
        $serviceId = 'serviceId';
        $data = [
            'Id' => $serviceId
        ];

        $serviceDiscoveryClient = Mockery::mock(ServiceDiscoveryClient::class)
            ->shouldReceive('getService')
            ->with($data)
            ->once()
            ->andReturnSelf()
            ->shouldReceive('toArray')
            ->withNoArgs()
            ->once()
            ->andReturn([])
            ->getMock();

        $awsServiceDiscovery = Mockery::mock(
            AwsServiceDiscovery::class,
            [$configs]
        )->makePartial();

        $awsServiceDiscovery->shouldReceive('newServiceDiscovery')
            ->withNoArgs()
            ->once()
            ->andReturn($serviceDiscoveryClient);

        $getService = $awsServiceDiscovery->getService($serviceId);

        $this->assertEquals($getService, []);
    }

    /**
     * @covers AwsServiceDiscovery\AwsServiceDiscovery::getInstances
     */
    public function testGetInstances()
    {
        $configs = [];
        $namespaceName = 'namespaceName';
        $service = 'service';
        $data = [
            'HealthStatus' => 'ALL',
            'MaxResults' => 10,
            'NamespaceName' => $namespaceName,
            'ServiceName' => $service,
        ];

        $serviceDiscoveryClient = Mockery::mock(ServiceDiscoveryClient::class)
            ->shouldReceive('discoverInstances')
            ->with($data)
            ->once()
            ->andReturnSelf()
            ->shouldReceive('toArray')
            ->withNoArgs()
            ->once()
            ->andReturn(['Instances' => ['test']])
            ->getMock();

        $awsServiceDiscovery = Mockery::mock(
            AwsServiceDiscovery::class,
            [$configs]
        )->makePartial();

        $awsServiceDiscovery->shouldReceive('newServiceDiscovery')
            ->withNoArgs()
            ->once()
            ->andReturn($serviceDiscoveryClient);

        $getInstances = $awsServiceDiscovery->getInstances($namespaceName, $service);

        $this->assertEquals($getInstances, ['test']);
    }

    /**
     * @covers AwsServiceDiscovery\AwsServiceDiscovery::getInstances
     */
    public function testGetInstancesEmpty()
    {
        $configs = [];
        $namespaceName = 'namespaceName';
        $service = 'service';
        $data = [
            'HealthStatus' => 'ALL',
            'MaxResults' => 10,
            'NamespaceName' => $namespaceName,
            'ServiceName' => $service,
        ];

        $serviceDiscoveryClient = Mockery::mock(ServiceDiscoveryClient::class)
            ->shouldReceive('discoverInstances')
            ->with($data)
            ->once()
            ->andReturnSelf()
            ->shouldReceive('toArray')
            ->withNoArgs()
            ->once()
            ->andReturn([])
            ->getMock();

        $awsServiceDiscovery = Mockery::mock(
            AwsServiceDiscovery::class,
            [$configs]
        )->makePartial();

        $awsServiceDiscovery->shouldReceive('newServiceDiscovery')
            ->withNoArgs()
            ->once()
            ->andReturn($serviceDiscoveryClient);

        $getInstances = $awsServiceDiscovery->getInstances($namespaceName, $service);

        $this->assertEquals($getInstances, []);
    }

    /**
     * @covers AwsServiceDiscovery\AwsServiceDiscovery::getServiceFirstHealthUrl
     */
    public function testGetServiceFirstHealthUrl()
    {
        $configs = [];
        $namespaceName = 'namespaceName';
        $service = 'service';
        $instances = ['instances'];
        $url = 'http://localhost';
        $port = '8088';

        $awsServiceDiscovery = Mockery::mock(
            AwsServiceDiscovery::class,
            [$configs]
        )->makePartial();

        $awsServiceDiscovery->shouldReceive('getInstances')
            ->with($namespaceName, $service, 'HEALTHY')
            ->once()
            ->andReturn($instances)
            ->shouldReceive('getInstanceAttr')
            ->with($instances, 'AWS_INSTANCE_IPV4', 0)
            ->once()
            ->andReturn($url)
            ->shouldReceive('getInstanceAttr')
            ->with($instances, 'AWS_INSTANCE_PORT', 0)
            ->once()
            ->andReturn($port);

        $getServiceFirstHealthUrl = $awsServiceDiscovery->getServiceFirstHealthUrl(
            $namespaceName,
            $service
        );

        $this->assertEquals($getServiceFirstHealthUrl, $url . ':' . $port);
    }

    /**
     * @covers AwsServiceDiscovery\AwsServiceDiscovery::getServiceFirstHealthUrl
     */
    public function testGetServiceFirstHealthUrlAndUrlEmpty()
    {
        $configs = [];
        $namespaceName = 'namespaceName';
        $service = 'service';
        $instances = ['instances'];
        $url = 'http://localhost';
        $port = '8088';

        $awsServiceDiscovery = Mockery::mock(
            AwsServiceDiscovery::class,
            [$configs]
        )->makePartial();

        $awsServiceDiscovery->shouldReceive('getInstances')
            ->with($namespaceName, $service, 'HEALTHY')
            ->once()
            ->andReturn($instances)
            ->shouldReceive('getInstanceAttr')
            ->with($instances, 'AWS_INSTANCE_IPV4', 0)
            ->once()
            ->andReturn(null)
            ->shouldReceive('getInstanceAttr')
            ->with($instances, 'AWS_INSTANCE_PORT', 0)
            ->once()
            ->andReturn($port);

        $getServiceFirstHealthUrl = $awsServiceDiscovery->getServiceFirstHealthUrl(
            $namespaceName,
            $service
        );

        $this->assertEquals($getServiceFirstHealthUrl, null);
    }

    /**
     * @covers AwsServiceDiscovery\AwsServiceDiscovery::getServiceFirstHealthUrl
     */
    public function testGetServiceFirstHealthUrlAndPortEmpty()
    {
        $configs = [];
        $namespaceName = 'namespaceName';
        $service = 'service';
        $instances = ['instances'];
        $url = 'http://localhost';
        $port = '8088';

        $awsServiceDiscovery = Mockery::mock(
            AwsServiceDiscovery::class,
            [$configs]
        )->makePartial();

        $awsServiceDiscovery->shouldReceive('getInstances')
            ->with($namespaceName, $service, 'HEALTHY')
            ->once()
            ->andReturn($instances)
            ->shouldReceive('getInstanceAttr')
            ->with($instances, 'AWS_INSTANCE_IPV4', 0)
            ->once()
            ->andReturn($url)
            ->shouldReceive('getInstanceAttr')
            ->with($instances, 'AWS_INSTANCE_PORT', 0)
            ->once()
            ->andReturn(null);

        $getServiceFirstHealthUrl = $awsServiceDiscovery->getServiceFirstHealthUrl(
            $namespaceName,
            $service
        );

        $this->assertEquals($getServiceFirstHealthUrl, null);
    }

    /**
     * @covers AwsServiceDiscovery\AwsServiceDiscovery::getServiceRandomHealthUrl
     */
    public function testGetServiceRandomHealthUrl()
    {
        $configs = [];
        $namespaceName = 'namespaceName';
        $service = 'service';
        $instances = ['instances'];
        $shuffle = 0;
        $url = 'http://localhost';
        $port = '8088';

        $awsServiceDiscovery = Mockery::mock(
            AwsServiceDiscovery::class,
            [$configs]
        )->makePartial();

        $awsServiceDiscovery->shouldReceive('getInstances')
            ->with($namespaceName, $service, 'HEALTHY')
            ->once()
            ->andReturn($instances)
            ->shouldReceive('getShuffleIndex')
            ->with(1)
            ->once()
            ->andReturn($shuffle)
            ->shouldReceive('getInstanceAttr')
            ->with($instances, 'AWS_INSTANCE_IPV4', $shuffle)
            ->once()
            ->andReturn($url)
            ->shouldReceive('getInstanceAttr')
            ->with($instances, 'AWS_INSTANCE_PORT', $shuffle)
            ->once()
            ->andReturn($port);

        $getServiceRandomHealthUrl = $awsServiceDiscovery->getServiceRandomHealthUrl(
            $namespaceName,
            $service
        );

        $this->assertEquals($getServiceRandomHealthUrl, $url . ':' . $port);
    }

    /**
     * @covers AwsServiceDiscovery\AwsServiceDiscovery::getServiceRandomHealthUrl
     */
    public function testGetServiceRandomHealthUrlAndEmptyUrl()
    {
        $configs = [];
        $namespaceName = 'namespaceName';
        $service = 'service';
        $instances = ['instances'];
        $shuffle = 0;
        $url = 'http://localhost';
        $port = '8088';

        $awsServiceDiscovery = Mockery::mock(
            AwsServiceDiscovery::class,
            [$configs]
        )->makePartial();

        $awsServiceDiscovery->shouldReceive('getInstances')
            ->with($namespaceName, $service, 'HEALTHY')
            ->once()
            ->andReturn($instances)
            ->shouldReceive('getShuffleIndex')
            ->with(1)
            ->once()
            ->andReturn($shuffle)
            ->shouldReceive('getInstanceAttr')
            ->with($instances, 'AWS_INSTANCE_IPV4', $shuffle)
            ->once()
            ->andReturn(null)
            ->shouldReceive('getInstanceAttr')
            ->with($instances, 'AWS_INSTANCE_PORT', $shuffle)
            ->once()
            ->andReturn($port);

        $getServiceRandomHealthUrl = $awsServiceDiscovery->getServiceRandomHealthUrl(
            $namespaceName,
            $service
        );

        $this->assertEquals($getServiceRandomHealthUrl, null);
    }

    /**
     * @covers AwsServiceDiscovery\AwsServiceDiscovery::getServiceRandomHealthUrl
     */
    public function testGetServiceRandomHealthUrlAndEmptyPort()
    {
        $configs = [];
        $namespaceName = 'namespaceName';
        $service = 'service';
        $instances = ['instances'];
        $shuffle = 0;
        $url = 'http://localhost';
        $port = '8088';

        $awsServiceDiscovery = Mockery::mock(
            AwsServiceDiscovery::class,
            [$configs]
        )->makePartial();

        $awsServiceDiscovery->shouldReceive('getInstances')
            ->with($namespaceName, $service, 'HEALTHY')
            ->once()
            ->andReturn($instances)
            ->shouldReceive('getShuffleIndex')
            ->with(1)
            ->once()
            ->andReturn($shuffle)
            ->shouldReceive('getInstanceAttr')
            ->with($instances, 'AWS_INSTANCE_IPV4', $shuffle)
            ->once()
            ->andReturn($url)
            ->shouldReceive('getInstanceAttr')
            ->with($instances, 'AWS_INSTANCE_PORT', $shuffle)
            ->once()
            ->andReturn(null);

        $getServiceRandomHealthUrl = $awsServiceDiscovery->getServiceRandomHealthUrl(
            $namespaceName,
            $service
        );

        $this->assertEquals($getServiceRandomHealthUrl, null);
    }

    /**
     * @covers AwsServiceDiscovery\AwsServiceDiscovery::getServiceRandomHealthUrl
     */
    public function testGetServiceRandomHealthUrlAndEmptyInstances()
    {
        $configs = [];
        $namespaceName = 'namespaceName';
        $service = 'service';
        $instances = [];
        $shuffle = 0;
        $url = 'http://localhost';
        $port = '8088';

        $awsServiceDiscovery = Mockery::mock(
            AwsServiceDiscovery::class,
            [$configs]
        )->makePartial();

        $awsServiceDiscovery->shouldReceive('getInstances')
            ->with($namespaceName, $service, 'HEALTHY')
            ->once()
            ->andReturn($instances)
            ->shouldReceive('getShuffleIndex')
            ->with(1)
            ->never()
            ->andReturn($shuffle)
            ->shouldReceive('getInstanceAttr')
            ->with($instances, 'AWS_INSTANCE_IPV4', $shuffle)
            ->never()
            ->andReturn($url)
            ->shouldReceive('getInstanceAttr')
            ->with($instances, 'AWS_INSTANCE_PORT', $shuffle)
            ->never()
            ->andReturn(null);

        $getServiceRandomHealthUrl = $awsServiceDiscovery->getServiceRandomHealthUrl(
            $namespaceName,
            $service
        );

        $this->assertEquals($getServiceRandomHealthUrl, null);
    }

    /**
     * @covers AwsServiceDiscovery\AwsServiceDiscovery::getServiceAllHealthUrl
     */
    public function testGetServiceAllHealthUrl()
    {
        $configs = [];
        $namespaceName = 'namespaceName';
        $service = 'service';
        $instances = ['instance'];
        $url = 'http://localhost';
        $port = '8088';

        $awsServiceDiscovery = Mockery::mock(
            AwsServiceDiscovery::class,
            [$configs]
        )->makePartial();

        $awsServiceDiscovery->shouldReceive('getInstances')
            ->with($namespaceName, $service, 'HEALTHY')
            ->once()
            ->andReturn($instances)
            ->shouldReceive('getInstanceAttr')
            ->with($instances, 'AWS_INSTANCE_IPV4', 'instance')
            ->once()
            ->andReturn($url)
            ->shouldReceive('getInstanceAttr')
            ->with($instances, 'AWS_INSTANCE_PORT', 'instance')
            ->once()
            ->andReturn($port);

        $getServiceAllHealthUrl = $awsServiceDiscovery->getServiceAllHealthUrl(
            $namespaceName,
            $service
        );

        $this->assertEquals($getServiceAllHealthUrl, [$url . ':' . $port]);
    }

/**
     * @covers AwsServiceDiscovery\AwsServiceDiscovery::getServiceAllHealthUrl
     */
    public function testGetServiceAllHealthUrlEmptyInstances()
    {
        $configs = [];
        $namespaceName = 'namespaceName';
        $service = 'service';
        $instances = [];
        $url = 'http://localhost';
        $port = '8088';

        $awsServiceDiscovery = Mockery::mock(
            AwsServiceDiscovery::class,
            [$configs]
        )->makePartial();

        $awsServiceDiscovery->shouldReceive('getInstances')
            ->with($namespaceName, $service, 'HEALTHY')
            ->once()
            ->andReturn($instances)
            ->shouldReceive('getInstanceAttr')
            ->never()
            ->andReturn(null);

        $getServiceAllHealthUrl = $awsServiceDiscovery->getServiceAllHealthUrl(
            $namespaceName,
            $service
        );

        $this->assertEquals($getServiceAllHealthUrl, []);
    }

    /**
     * @covers AwsServiceDiscovery\AwsServiceDiscovery::getInstanceAttr
     */
    public function testGetInstanceAttr()
    {
        $configs = [];
        $instances = [
            [
                'Attributes' => [
                    'attr' => true,
                ],
            ],
        ];

        $attr = 'attr';
        $index = 0;

        $awsServiceDiscovery = new AwsServiceDiscovery($configs);
        $getInstanceAttr = $awsServiceDiscovery->getInstanceAttr($instances, $attr, $index);

        $this->assertEquals($getInstanceAttr, true);
    }

    /**
     * @covers AwsServiceDiscovery\AwsServiceDiscovery::getInstanceAttr
     */
    public function testGetInstanceAttrAndNotFound()
    {
        $configs = [];
        $instances = [
            [
                'Attributes' => [
                    'attr' => true,
                ],
            ],
        ];

        $attr = 'attr';
        $index = 1;

        $awsServiceDiscovery = new AwsServiceDiscovery($configs);
        $getInstanceAttr = $awsServiceDiscovery->getInstanceAttr($instances, $attr, $index);

        $this->assertEquals($getInstanceAttr, null);
    }

    /**
     * @covers AwsServiceDiscovery\AwsServiceDiscovery::getShuffleIndex
     */
    public function testGetShuffleIndexAndTotalIsOne()
    {
        $configs = [];
        $totalInstances = 1;

        $awsServiceDiscovery = new AwsServiceDiscovery($configs);
        $getShuffleIndex = $awsServiceDiscovery->getShuffleIndex($totalInstances);

        $this->assertEquals($getShuffleIndex, 0);
    }

    /**
     * @covers AwsServiceDiscovery\AwsServiceDiscovery::getShuffleIndex
     */
    public function testGetShuffleIndex()
    {
        $configs = [];
        $totalInstances = 2;

        $awsServiceDiscovery = new AwsServiceDiscovery($configs);

        $getShuffleIndex = $awsServiceDiscovery->getShuffleIndex($totalInstances);

        $this->assertInternalType('int', $getShuffleIndex);
        $this->assertGreaterThanOrEqual(0, $getShuffleIndex);
        $this->assertLessThanOrEqual(1, $getShuffleIndex);
    }

    public function tearDown()
    {
        Mockery::close();
    }
}
