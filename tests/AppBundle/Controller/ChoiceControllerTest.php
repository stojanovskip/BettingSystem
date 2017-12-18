<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ChoiceControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/choices');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $this->assertContains('List of choices', $crawler->filter('h1')->text());

    }
}
