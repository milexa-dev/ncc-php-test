<?php

namespace Tests\Unit\cve\all;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tests\TestCase;

class GetAllCveTest extends TestCase
{

    /** @test */
    public function offset_should_not_be_string(){
        $response = $this->json(Request::METHOD_GET, route('all'),['offset' => 'xxx']);
        $response
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response
            ->assertExactJson([
            "message"   =>  "The given data was invalid.",
            'errors'    => [
                'offset' => [
                    "You must specify the offset as a numeric literal"
                ]
            ]
        ]);
    }

    /** @test */
    public function limit_should_not_be_string_or_too_long(){
        $response = $this->json(Request::METHOD_GET, route('all'),['limit' => 'xxx']);
        $response
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response
            ->assertExactJson([
                "message"   =>  "The given data was invalid.",
                'errors'    => [
                    'limit' => [
                        "You must specify the limit as a numeric literal",
                        "The limit value must be between 1 and 4 in numeric literals"
                    ]
                ]
            ]);
    }

    /** @test */
    public function year_should_not_be_string_or_too_long(){
        $response = $this->json(Request::METHOD_GET, route('all'),['year' => 'xxx']);
        $response
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response
            ->assertExactJson([
                "message"   =>  "The given data was invalid.",
                'errors'    => [
                    'year' => [
                        "The field {year} must be a date using this format {Y}",
                        "The field {year} must contain only 4 digits"
                    ]
                ]
            ]);
    }
}
