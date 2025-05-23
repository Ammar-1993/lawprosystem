<?php

namespace Hesto\Core\Commands;

use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;


abstract class SimpleReplaceContentCommand extends InstallCommand
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
    protected function compileContent($path, $setting)
    {
        $content = str_replace($setting['search'], $setting['replace'], $this->files->get($path));

        return $content;
    }
}
