<?php

namespace Tests\Feature\Admin\Auth;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    #[Test]
    public function it_should_login_an_user(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }
}
