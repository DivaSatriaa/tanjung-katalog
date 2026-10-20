<?php

namespace Tests\Feature;

use App\Providers\AppServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HttpsUrlTest extends TestCase
{
    use RefreshDatabase;

    public function test_urls_use_https_when_app_url_is_https(): void
    {
        config(['app.url' => 'https://tanjungkatalog.test']);
        (new AppServiceProvider($this->app))->boot();

        $this->assertStringStartsWith('https://', route('home'));
        $this->assertStringStartsWith('https://', asset('images/og-image.jpg'));
    }
}
