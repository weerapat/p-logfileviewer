<?php

use Tests\TestCase;

class ServerFileReaderServiceTest extends TestCase
{
    protected $service;

    public function setUp()
    {
        parent::setUp();
        $this->service = $this->app->make('App\Services\ServerFileReaderService');
    }

    /**
     * @dataProvider logPathFileProvider
     *
     * @param string $filePath
     */
    public function testReadLogFileSuccess(string $filePath)
    {
        $result = $this->service->read($filePath);
        $this->assertEquals('success', $result['status']);
    }

    /**
     * @dataProvider randomPathFileProvider
     *
     * @param string $filePath
     */
    public function testReadLogFileFailure(string $filePath)
    {
        $result = $this->service->read($filePath);
        $this->assertEquals('error', $result['status']);
    }

    public function logPathFileProvider()
    {
        return [
            ['/var/log/apache2/access_log'],
            ['/var/log/apache2/error_log'],
        ];
    }

    public function randomPathFileProvider()
    {
        return [
            ['/var/log/xx.log'],
            ['/var/tmp/bb'],
        ];
    }
}
