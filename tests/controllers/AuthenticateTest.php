<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AuthenticateTest extends TestCase
{
    /**
     * Test the authenticate route response
     *
     * @return void
     */
    public function testAuthenticate()
    {
      $response = $this->call('POST', '/api/authenticate', ['email' => 'jorge@paralideres.org', 'password' => 'test123']);
      $object = json_decode($response->getContent());

      $this->assertNotNull($object->token);
      $this->assertInternalType('string', $object->token);
    }
}
