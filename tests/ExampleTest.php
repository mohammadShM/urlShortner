<?php

// use Laravel\Lumen\Testing\DatabaseMigrations;
// use Laravel\Lumen\Testing\DatabaseTransactions;

class ExampleTest extends TestCase
{

    public function testExample(): void
    {
        $this->get('/test');
        $this->assertEquals(
            $this->app->version(), $this->response->getContent()
        );
    }
}
