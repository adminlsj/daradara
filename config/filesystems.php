<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

<<<<<<< HEAD
    'default' => env('FILESYSTEM_DRIVER', 's3'),
=======
    'default' => env('FILESYSTEM_DRIVER', 'local'),
>>>>>>> 66270956aa8ff1aadc870cf50685126f1bc1e11c

    /*
    |--------------------------------------------------------------------------
    | Default Cloud Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Many applications store files both locally and in the cloud. For this
    | reason, you may specify a default "cloud" driver here. This driver
    | will be bound as the Cloud disk implementation in the container.
    |
    */

    'cloud' => env('FILESYSTEM_CLOUD', 's3'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
<<<<<<< HEAD
    | Supported Drivers: "local", "ftp", "s3", "rackspace"
=======
    | Supported Drivers: "local", "ftp", "sftp", "s3", "rackspace"
>>>>>>> 66270956aa8ff1aadc870cf50685126f1bc1e11c
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],

        's3' => [
            'driver' => 's3',
<<<<<<< HEAD
            'key' => env('AWS_KEY'),
            'secret' => env('AWS_SECRET'),
            'region' => env('AWS_REGION', 'us-west-2'),
            'bucket' => env('AWS_BUCKET'),
=======
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
>>>>>>> 66270956aa8ff1aadc870cf50685126f1bc1e11c
        ],

    ],

];
