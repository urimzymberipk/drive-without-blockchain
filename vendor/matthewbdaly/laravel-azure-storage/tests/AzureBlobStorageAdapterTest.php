<?php

namespace Tests;

use Matthewbdaly\LaravelAzureStorage\AzureBlobStorageAdapter;
use MicrosoftAzure\Storage\Blob\BlobRestProxy;

final class AzureBlobStorageAdapterTest extends TestCase
{
    /** @test */
    public function it_correctly_generates_the_file_url(): void
    {
        $client = BlobRestProxy::createBlobService('DefaultEndpointsProtocol=https;AccountName=azure_account;AccountKey=' . base64_encode('azure_key'));

        $adapter = new AzureBlobStorageAdapter($client, 'azure_container', 'azure_key');

        $this->assertEquals('https://azure_account.blob.core.windows.net/azure_container/test.txt', $adapter->getUrl('test.txt'));
    }

    /** @test */
    public function it_now_supports_the_url_method(): void
    {
        $storage = $this->app['filesystem'];

        $this->assertEquals('https://my_azure_storage_name.blob.core.windows.net/MY_AZURE_STORAGE_CONTAINER/test.txt', $storage->url('test.txt'));
    }

    /** @test */
    public function it_supports_preceding_slash(): void
    {
        $storage = $this->app['filesystem'];

        $this->assertEquals('https://my_azure_storage_name.blob.core.windows.net/MY_AZURE_STORAGE_CONTAINER/test.txt', $storage->url('/test.txt'));
    }

    /** @test */
    public function it_supports_custom_url(): void
    {
        $client = BlobRestProxy::createBlobService('DefaultEndpointsProtocol=https;AccountName=azure_account;AccountKey=' . base64_encode('azure_key'));
        $adapter = new AzureBlobStorageAdapter($client, 'azure_container','azure_key', 'https://example.com');

        $this->assertEquals('https://example.com/azure_container/test.txt', $adapter->getUrl('test.txt'));
    }

    /** @test */
    public function it_supports_custom_url_with_root_container(): void
    {
        $client = BlobRestProxy::createBlobService('DefaultEndpointsProtocol=https;AccountName=azure_account;AccountKey=' . base64_encode('azure_key'));
        $adapter = new AzureBlobStorageAdapter($client, '$root','azure_key', 'https://example.com');

        $this->assertEquals('https://example.com/test.txt', $adapter->getUrl('test.txt'));
    }

    /** @test */
    public function it_supports_temporary_url(): void
    {
        $client = BlobRestProxy::createBlobService('DefaultEndpointsProtocol=https;AccountName=azure_account;AccountKey=' . base64_encode('azure_key'));
        $adapter = new AzureBlobStorageAdapter($client, 'azure_container', 'azure_key', null, 'test_path');
        $tempUrl = $adapter->getTemporaryUrl('test_path/test.txt', now()->addMinutes(1));

        $this->assertStringStartsWith('https://azure_account.blob.core.windows.net/azure_container/test_path/test.txt', $tempUrl);
        $this->assertStringContainsString('sig=', $tempUrl);
    }

    /** @test */
    public function it_handles_invalid_custom_url(): void
    {
        $this->expectException('Matthewbdaly\LaravelAzureStorage\Exceptions\InvalidCustomUrl');
        $client = BlobRestProxy::createBlobService('DefaultEndpointsProtocol=https;AccountName=azure_account;AccountKey=' . base64_encode('azure_key'));
        $adapter = new AzureBlobStorageAdapter($client, 'azure_container', 'azure_key','foo');
    }

    /** @test */
    public function it_handles_custom_prefix(): void
    {
        $client = BlobRestProxy::createBlobService('DefaultEndpointsProtocol=https;AccountName=azure_account;AccountKey=' . base64_encode('azure_key'));
        $adapter = new AzureBlobStorageAdapter($client, 'azure_container', 'azure_key',null, 'test_path');

        $this->assertEquals('https://azure_account.blob.core.windows.net/azure_container/test_path/test.txt', $adapter->getUrl('test_path/test.txt'));
    }
}
