<?php

use Tests\TestCase;

class FileReaderServiceTest extends TestCase
{
    protected $service;

    public function setUp()
    {
        parent::setUp();
        $this->service = $this->app->make('App\Services\FileReaderService');
    }

    /**
     * @covers FileReaderServiceTest::paginate
     */
    public function testPaginate()
    {
        // Content 3 lines
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
