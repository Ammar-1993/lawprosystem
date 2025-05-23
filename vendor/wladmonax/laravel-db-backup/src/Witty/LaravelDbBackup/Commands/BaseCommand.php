<?php

namespace Witty\LaravelDbBackup\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Witty\LaravelDbBackup\DatabaseBuilder;
use Witty\LaravelDbBackup\ConsoleColors;
use Witty\LaravelDbBackup\Console;

/**
 * Class BaseCommand
 * @package Witty\LaravelDbBackup\Commands
 */
class BaseCommand extends Command
{
    /**
     * @var Witty\LaravelDbBackup\DatabaseBuilder
     */
    protected $databaseBuilder;

    /**
     * @var Witty\LaravelDbBackup\ConsoleColors
     */
    protected $colors;

    /**
     * @var Witty\LaravelDbBackup\Console
     */
    protected $console;

    /**
     * @param Witty\LaravelDbBackup\DatabaseBuilder $databaseBuilder
     * @return Witty\LaravelDbBackup\Commands\BaseCommand
     */
    public function __construct(DatabaseBuilder $databaseBuilder)
    {
        parent::__construct();

        $this->databaseBuilder = $databaseBuilder;
        $this->colors = new ConsoleColors();
        $this->console = new Console();
    }

    /**
     * @return Witty\LaravelDbBackup\Databases\DatabaseContract
     */
    public function getDatabase($database)
    {
        $database = $database ?: Config::get('database.default');
        $realConfig = Config::get('database.connections.' . $database);

        return $this->databaseBuilder->getDatabase($realConfig);
    }

    /**
     * @return string
     */
    protected function getDumpsPath()
    {
        return Config::get('db-backup.path');
    }

    /**
     * @return boolean
     */
    public function enableCompression()
    {
        return Config::set('db-backup.compress', true);
    }

    /**
     * @return boolean
     */
    public function disableCompression()
    {
        return Config::set('db-backup.compress', false);
    }

    /**
     * @return boolean
     */
    public function isCompressionEnabled()
    {
        return Config::get('db-backup.compress');
    }

    /**
     * @return boolean
     */
    public function isCompressed($fileName)
    {
        return pathinfo($fileName, PATHINFO_EXTENSION) === "gz";
    }
}
