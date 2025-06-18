<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomeTest extends TestCase
{
    /**
     * Ensure the home page returns a successful response.
     */
    public function test_home_page_is_accessible(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
