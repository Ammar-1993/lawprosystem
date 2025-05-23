<?php

namespace Hesto\Core\Commands;

use Hesto\Core\Traits\CanReplaceKeywords;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

abstract class TemplateGeneratorCommand extends InstallAndReplaceCommand
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
     * The type of class being generated.
     *
     * @var string
     */
    protected $type;

    /**
     * Get the destination path.
     *
     * @return string
     */
    abstract function getPath();

    /**
     * @return mixed
     */
    abstract function getTemplatePath();

    /**
     * Execute the console command.
     *
     * @return bool|null
     */
    public function handle()
    {
        $path = $this->getPath();

        if($this->files->isDirectory($this->getTemplatePath())) {
            $this->installFiles($path, $this->files->allFiles($this->getTemplate()));

            return true;
        }

        $template = new \SplFileInfo($this->getTemplatePath());

        if($this->putFile(base_path() . $path, $template)) {
            $this->info($this->type . ' template created successfully!');
        }

        return true;
    }

    /**
     * Get the desired template.
     *
     * @return array|string
     */
    public function getTemplate() {
        $templatesPath = $this->getTemplatePath();

        if($this->option('custom')) {
            $templatesPath = $this->option('path');
        }

        return $templatesPath . $this->getTemplateInput() . "/";
    }

    /**
     * Parse and format the type's name.
     *
     * @return mixed
     */
    public function parseTypeName()
    {
        return str_plural(strtolower($this->type));
    }

    /**
     * Get the desired template name from the input.
     *
     * @return array|string
     */
    public function getTemplateInput()
    {
        return $this->option('template');
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    public function getOptions()
    {
        return [
            ['template', 't', InputOption::VALUE_OPTIONAL, 'The template to generate', 'default'],
            ['layout', 'l', InputOption::VALUE_OPTIONAL, 'To which layout generate the template?', 'admin'],
            ['custom', 'c', InputOption::VALUE_OPTIONAL, 'Use custom templates instead of given ones', false],
            ['path', 'p', InputOption::VALUE_OPTIONAL, 'Local path for template stubs', '/resources/templates/'],
            ['force', 'f', InputOption::VALUE_NONE, 'Force override existing files'],
        ];
    }


}
