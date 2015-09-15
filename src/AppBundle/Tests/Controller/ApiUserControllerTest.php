<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApiUserControllerTest extends WebTestCase
{
    /** @test */
    public function email_put_returns_json_response()
    {
        $client = $this->apiClientWithRequest(
            'PUT',
            '/api/user/1037/email'
        );
        $response = $client->getResponse();

        $this->assertJson($response->getContent());
    }

    /** @test */
    public function email_put_returns_404_on_non_existing_user_id()
    {
        $client = $this->apiClientWithRequest(
            'PUT',
            '/api/user/1234/email',
            ['email' => 'test@example.com']
        );
        $response = $client->getResponse();

        $this->assertJson($response->getContent());
        $this->assertEquals(404, $response->getStatusCode());
    }

    /** @test */
    public function email_put_returns_400_on_incorrect_email()
    {
        $client = $this->apiClientWithRequest(
            'PUT',
            '/api/user/1037/email',
            ['email' => 'wrong-email']
        );
        $response = $client->getResponse();

        $this->assertJson($response->getContent());
        $this->assertEquals(400, $response->getStatusCode());
    }

    /** @test */
    public function email_put_returns_201_on_correct_request()
    {
        $client = $this->apiClientWithRequest(
            'PUT',
            '/api/user/1037/email',
            ['email' => 'new@example.com']
        );
        $response = $client->getResponse();

        $this->assertJson($response->getContent());
        $this->assertEquals(201, $response->getStatusCode());
    }

    private function apiClientWithRequest($method, $endpoint, $data = [])
    {
        $client = static::createClient();
        $headers = ['CONTENT_TYPE' => 'application/json'];
        $jsonData = json_encode($data);

        $client->request(
            $method,
            $endpoint,
            [],
            [],
            $headers,
            $jsonData
        );

        return $client;
    }
}
