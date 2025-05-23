<?php

namespace Hesto\Core\Commands;

use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;


abstract class AppendContentCommand extends InstallAndReplaceCommand
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
     * Get settings array.
     *
     * @return array
     */
    abstract function getSettings();

    /**
     * Execute the console command.
     *
     * @return bool|null
     */
    public function handle()
    {
        $settings = $this->getSettings();

        foreach ($settings as $setting) {
            $path = $setting['path'];
            $fullPath = base_path() . $path;

            if ($this->putContent($fullPath, $this->compileContent($fullPath, $setting))) {
                $this->getInfoMessage($fullPath);
            }

        }

        return true;
    }

    /**
     * Compile content.
     *
     * @param $path
     * @param $setting
     * @return mixed
     */
    protected function compileContent($path, $setting) //It should be compile method instead
    {
        $originalContent = $this->files->get($path);
        $content = $this->replaceNames($this->files->get($setting['stub']));

        if( ! str_contains(trim($originalContent), trim($content))) {

            if ($setting['prefix']) {
                $stub = $content . $setting['search'];
            } else {
                $stub = $setting['search'] . $content;
            }

            $originalContent = str_replace($setting['search'], $stub, $originalContent);
        }

        return $originalContent;
    }
}
