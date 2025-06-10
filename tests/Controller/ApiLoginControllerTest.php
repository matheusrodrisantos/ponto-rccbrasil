<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class ApiLoginControllerTest extends WebTestCase
{
    public function test_index(): void
    {
        $client = static::createClient();
        $client->request('POST', '/api/login');

        self::assertResponseIsSuccessful();
    }
}
