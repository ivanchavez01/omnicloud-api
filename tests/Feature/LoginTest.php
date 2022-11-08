<?php
declare(strict_types=1);

class LoginTest extends \Tests\TestCase
{
    public function testAnUserCanDoLogin()
    {
        $response = $this->post('/api/login', [
           "email" => "ichavez9001@gmail.com",
           "password" => "123456789"
        ]);

        $response->assertOk();
    }
}
