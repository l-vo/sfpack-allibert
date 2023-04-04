<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HelloControllerTest extends WebTestCase
{
    public function provideHello(): array
    {
        return [
            'with name' => ['/hello', 'Hello!'],
            'without name' => ['/hello/john', 'Hello john! ✅'],
        ];
    }

    /**
     * @dataProvider provideHello
     */
    public function testHello(string $path, string $expectedText): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', $path);

        $this->assertTrue($client->getResponse()->isSuccessful());
        // or $this->assertResponseIsSuccessful();

        $this->assertSame($expectedText, $crawler->filter('h1')->text());
        // or $this->assertSelectorTextSame('h1', $expectedText);
    }
}
