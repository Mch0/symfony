<?php

namespace tgw\AdminBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdminControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', 'admin');
    }

    public function testShowarticles()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/admin/articles');
    }

}
