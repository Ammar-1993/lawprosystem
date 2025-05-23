<?php

namespace Witty\LaravelDbBackup\Commands\Helpers;

use Illuminate\Support\Facades\Config;
use Spatie\Dropbox\Client;
use Spatie\FlysystemDropbox\DropboxAdapter;
use League\Flysystem\Filesystem;

/**
 * Class DropBox
 * @package Witty\LaravelDbBackup\Commands\Helpers
 */
class DropBox
{
    private $accessToken = null;
    private $appSecret = null;
    private $prefix = null;
    private $client = null;
    private $adapter = null;
    private $filesystem = null;

    /**
     * DropBox constructor.
     */
    public function __construct()
    {
        $this->accessToken = Config::get('db-backup.dropbox.accessToken');
        $this->appSecret = Config::get('db-backup.dropbox.appSecret');
        $this->prefix = Config::get('db-backup.dropbox.prefix');

        $this->client = new Client($this->accessToken);
        $this->adapter = new DropboxAdapter($this->client);
        $this->filesystem = new Filesystem($this->adapter);
    }

    /**
     * @param $fileName
     * @param $file
     * @return bool
     */
    public function saveFile($fileName, $file)
    {

        $content = file_get_contents($file);

        return $this->filesystem->put($this->prefix . '/' . $fileName, $content);

    }

    /**
     * @param $filename
     * @return bool|false|string
     * @throws \League\Flysystem\FileNotFoundException
     */
    public function getFileContent($filename)
    {

        if ($this->filesystem->has($this->prefix . '/' . $filename)) {
            $content = $this->filesystem->read($this->prefix . '/' . $filename);
            return $content;
        }
        return false;
    }


}