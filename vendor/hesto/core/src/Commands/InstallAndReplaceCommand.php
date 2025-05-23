<?php

namespace Hesto\Core\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Hesto\Core\Traits\CanReplaceKeywords;


abstract class InstallAndReplaceCommand extends InstallCommand
{
    use CanReplaceKeywords;

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
     * Compile content.
     *
     * @param $content
     * @return mixed
     */
    protected function compile($content)
    {
        $content = $this->replaceNames($content);

        return $content;
    }

    /**
     * Get info message output
     *
     * @param $filePath
     * @return mixed
     */
    protected function getInfoMessage($filePath)
    {
        return $this->info('Content changed in: ' . $filePath);
    }

    /**
     * Get the desired class name from the input.
     *
     * @return string
     */
    protected function getParsedNameInput()
    {
        return mb_strtolower(str_singular($this->getNameInput()));
    }

    /**
     * Get the desired class name from the input.
     *
     * @return string
     */
    protected function getNameInput()
    {
        return trim($this->argument('name'));
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    public function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the class'],
        ];
    }

    /**
     * Check if stub's content exists in given file (path)
     *
     * @param $path
     * @param $stub
     * @return bool
     */
    public function contentExists($path, $stub)
    {
        $originalContent = $this->files->get($path);
        $content = $this->replaceNames($this->files->get($stub));

        if(str_contains(trim($originalContent), trim($content))) {
            return true;
        }

        return false;
    }
}
