<?php

namespace Tests\Unit\cve\single;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tests\TestCase;

class GetSingleCveTest extends TestCase
{
    /** @test */
    public function cve_number_should_be_in_the_right_format(){
        $response = $this->json(Request::METHOD_GET, '/api/cve/xxx');
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response
            ->assertExactJson([
                'cveNumber' => [
                    "The selected cve number is invalid."
                ]
            ]);
    }
}
