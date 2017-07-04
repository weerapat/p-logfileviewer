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

    /**
     * @covers ServerFileReaderServiceTest::paginate
     */
    public function testPaginate()
    {
        // Content 12 lines
        $contents = [
            'Lorem ipsum dolor sit amet, consectetur adipiscing elit',
            'Lorem ipsum dolor sit amet, consectetur adipiscing elit',
            'Lorem ipsum dolor sit amet, consectetur adipiscing elit',
        ];

        $page = 1;
        $result = $this->service->paginate($contents, $page);

        $this->assertEquals([
                'page' => 1,
                'totalPages' => 1,
                'logs' => [
                    'Lorem ipsum dolor sit amet, consectetur adipiscing elit',
                    'Lorem ipsum dolor sit amet, consectetur adipiscing elit',
                    'Lorem ipsum dolor sit amet, consectetur adipiscing elit',
                ]
            ], $result);
    }
}
