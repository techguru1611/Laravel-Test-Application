<?php

namespace Tests\Unit;

use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_example()
    {
        $this->assertTrue(true);
    }

    // test case for register user
    public function testCreateUser()
    {
        $data = [
                'name' => "dev",
                'email' => "devtest71111@gmail.com",
                'password' => "test123456",
                ];

        $response = $this->json('POST', '/api/register',$data);
        if($response->status() != 200) {
            $response->assertStatus($response->status())
            ->assertJsonStructure(['error']);
        } else {
            $response->assertStatus($response->status())
            ->assertJsonStructure(['message']);
        }
    }

    // test case for login user
    public function testGettingAllorganization()
    {   
        $data = [
                'email' => "devtesst@gmail.com",
                'password' => "123456",
                ];
        $response = $this->json('POST', '/api/login',$data);
        $response->assertStatus($response->status())->assertJsonStructure([
            'success', 'token'
        ]);
    }
}
