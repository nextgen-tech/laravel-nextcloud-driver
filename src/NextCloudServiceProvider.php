<?php

namespace Jedlikowski\NextCloudStorage;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use Jedlikowski\NextCloudStorage\NextCloudAdapter;
use League\Flysystem\Filesystem;
use Sabre\DAV\Client as WebDAVClient;

class NextCloudServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Storage::extend('nextcloud', function ($app, $config) {
            $pathPrefix = 'remote.php/dav/files/' . $config['userName'];
            if (array_key_exists('pathPrefix', $config)) {
                $pathPrefix = rtrim($config['pathPrefix'], '/') . '/' . $pathPrefix;
            }

            $client = new WebDAVClient($config);
            $adapter = new NextCloudAdapter($client, $pathPrefix);

            return new Filesystem($adapter);
        });
    }

    public function register()
    {

    }
}