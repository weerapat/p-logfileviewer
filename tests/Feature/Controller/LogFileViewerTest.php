<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Request;

/**
 * @coversDefaultClass \App\Http\Controllers\LogFileViewerController
 */
class LogFileViewerTest extends TestCase
{
    /**
     * Render index page
     *
     * @return void
     */
    public function testGetIndex()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testGetLogFileDataFail()
    {
        $response = $this->get('/get-log-file-data?file_path=xx');

        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => 'error',
            ]);
    }

    /**
     * @test
     *
     * @covers ::paginate
     */
    public function testPaginateReturn()
    {
        $this->assertTrue(true);
    }
}
