<?php

namespace Tests;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use MicrosoftAzure\Storage\Blob\BlobRestProxy;

final class ServiceProviderTest extends TestCase
{
    /** @test */
    public function it_sets_up_the_storage_correctly(): void
    {
        $storage = $this->app['filesystem'];
        $this->assertEquals('azure', $storage->getDefaultDriver());
        $this->assertEquals('azure', $storage->getDefaultCloudDriver());
    }

    /** @test */
    public function it_sets_up_the_config_correctly(): void
    {
        $storage = $this->app['filesystem'];

        $settings = $this->app['config']->get('filesystems.disks.azure');

        foreach ($settings as $key => $value) {
            $this->assertEquals($value, Arr::get($storage->getConfig(), $key));
        }
    }

    /** @test */
    public function it_sets_up_the_cache_adapter_correctly(): void
    {
        $this->markTestSkipped();
        $adapter = Storage::getDriver()->getAdapter();
        $this->assertEquals(\League\Flysystem\Cached\CachedAdapter::class, get_class($adapter));
    }

    /** @test */
    public function it_handles_custom_blob_endpoint(): void
    {
        $endpoint = 'http://custom';
        $container = $this->app['config']->get('filesystems.disks.azure.container');
        $this->app['config']->set('filesystems.disks.azure.endpoint', $endpoint);

        $this->assertEquals("$endpoint/$container/a.txt", Storage::url('a.txt'));
    }

    /** @test */
    public function custom_url_overrides_endpoint(): void
    {
        $endpoint = 'http://custom';
        $customUrl = 'http://cdn.com';
        $container = $this->app['config']->get('filesystems.disks.azure.container');
        $this->app['config']->set('filesystems.disks.azure.endpoint', $endpoint);
        $this->app['config']->set('filesystems.disks.azure.url', $customUrl);

        $this->assertEquals("$customUrl/$container/a.txt", Storage::url('a.txt'));
    }

    /** @test */
    public function it_resolves_the_azure_client(): void
    {
        $this->assertTrue($this->app->bound(BlobRestProxy::class));

        Storage::disk();

        $this->assertTrue($this->app->resolved(BlobRestProxy::class));
    }

    /** @test */
    public function it_sets_up_the_retry_middleware(): void
    {
        $this->app['config']->set('filesystems.disks.azure.retry', [
            'tries' => 3,
            'interval' => 500,
            'increase' => 'exponential'
        ]);

        $this->assertNotNull($this->app->get(BlobRestProxy::class));

        $this->assertTrue($this->app->resolved(BlobRestProxy::class));
    }
}
