<?php

namespace Hesto\Core\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Input\InputOption;


abstract class InstallCommand extends Command
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
     * Create a new controller creator command instance.
     *
     * @param  \Illuminate\Filesystem\Filesystem  $files
     * @return void
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    /**
     * Execute the console command.
     *
     * @return bool|null
     */
    abstract function handle();

    /**
     * Install files method.
     *
     * @param $path
     * @param $files
     */
    protected function installFiles($path, $files)
    {
        foreach($files as $file)
        {
            $filePath = base_path(). $path . $file->getRelativePath() . '/' . $this->parseFilename($file);

            if($this->putFile($filePath, $file)) {
                $this->getInfoMessage($filePath);
            }
        }
    }

    /**
     * @param $file
     * @return string
     */
    protected function parseFilename($file)
    {
        return $this->getFileName($file) . $this->getExtension($file);
    }

    /**
     * @param $file
     * @return mixed
     */
    protected function getFileName($file)
    {
        return $this->getFileRealName($file);
    }

    /**
     * @param $file
     * @return mixed
     */
    protected function getFileRealName($file)
    {
        return $file->getBasename($file->getExtension());
    }

    /**
     * Get file extension.
     *
     * @param $file
     * @return bool
     */
    protected function getExtension($file)
    {
        return $file->getExtension();
    }

    /**
     * Put given file in path
     *
     * @param $path
     * @param $file
     * @return bool
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function putFile($path, $file)
    {
        if($this->alreadyExists($path) && !$this->option('force')) {
            $this->error($path . ' already exists!');

            return false;
        }

        $this->makeDirectory($path);

        $this->files->put($path, $this->compile($this->files->get($file->getPathname())));

        return true;
    }

    /**
     * Append given file in path
     *
     * @param $path
     * @param $file
     * @return bool
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function appendFile($path, $file)
    {
        if($this->alreadyExists($path) && !$this->option('force')) {
            $this->error($path . ' already exists!');

            return false;
        }

        $this->makeDirectory($path);

        $this->files->append($path, $this->compile($this->files->get($file->getPathname())));

        return true;
    }

    /**
     * Put given content in path
     *
     * @param $path
     * @param $content
     * @return bool
     * @internal param $file
     */
    protected function putContent($path, $content)
    {
        if($this->alreadyExists($path) && !$this->option('force')) {
            $this->error($path . ' already exists!');

            return false;
        }

        $this->makeDirectory($path);

        $this->files->put($path, $content);

        return true;
    }

    protected function getInfoMessage($filePath)
    {
        return $this->info('Copied: ' . $filePath);
    }

    /**
     * Determine if the class already exists.
     *
     * @param $path
     * @return bool
     */
    protected function alreadyExists($path)
    {
        return $this->files->exists($path);
    }

    /**
     * Build the directory for the class if necessary.
     *
     * @param  string  $path
     * @return string
     */
    protected function makeDirectory($path)
    {
        if (! $this->files->isDirectory(dirname($path))) {
            $this->files->makeDirectory(dirname($path), 0777, true, true);
        }
    }

    /**
     * Compile content.
     *
     * @param $content
     * @return mixed
     */
    protected function compile($content)
    {
        return $content;
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    public function getOptions()
    {
        return [
            ['force', 'f', InputOption::VALUE_NONE, 'Force override existing files'],
        ];
    }
}
