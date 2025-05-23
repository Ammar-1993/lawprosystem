<?php

namespace Hesto\Core\Commands;

use Illuminate\Filesystem\Filesystem;
use SplFileInfo;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;


abstract class InstallFilesCommand extends InstallAndReplaceCommand
{
    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description;

    /**
     * Get the destination path.
     *
     * @return string
     */
    abstract function getFiles();

    /**
     * Execute the console command.
     *
     * @return bool|null
     */
    public function handle()
    {
        $files = $this->getFiles();

        foreach ($files as $file) {
            $path = $file['path'];
            $fullPath = base_path() . $path;

            $fileObject = new SplFileInfo($file['stub']);

            if($this->putFile($fullPath, $fileObject)) {
                $this->getInfoMessage($fullPath);
            }
        }

        return true;
    }
}
