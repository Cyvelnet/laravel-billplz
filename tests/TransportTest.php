<?php

/**
 * Class TransportTest.
 */
class TransportTest extends Orchestra\Testbench\TestCase
{
    /**
     * @test
     */
    public function it_should_has_api_set_in_auth_header()
    {
        $transport = $this->getApiTransport('foobar');

        $this->assertSame(['auth' => ['foobar', null]], $transport->getAuthOption());
    }

    /**
     * @test
     */
    public function it_should_uses_production_configuration_when_sandbox_mode_is_off()
    {
        $transport = $this->getApiTransport('production_key');

        $this->assertEquals('https://www.billplz.com/foo/bar', $transport->getRequestUrl('/foo/bar'));
    }

    /**
     * @test
     */
    public function it_should_uses_production_configuration_when_sandbox_mode_is_on()
    {
        $transport = $this->getApiTransport('test_api', true);

        $this->assertEquals('https://billplz-staging.herokuapp.com/foo/bar', $transport->getRequestUrl('/foo/bar'));
        $this->assertSame(['auth' => ['test_api', null]], $transport->getAuthOption());
    }

    /**
     * @param string $apiKey
     * @param bool   $sandbox
     *
     * @return \Cyvelnet\LaravelBillplz\Transports\BillplzApiTransport
     */
    private function getApiTransport($apiKey = 'test_key', $sandbox = false)
    {
        $client = $this->getMock(\GuzzleHttp\Client::class);

        return new \Cyvelnet\LaravelBillplz\Transports\BillplzApiTransport($client, $apiKey, $sandbox);
    }
}
