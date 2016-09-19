<?php

namespace Cyvelnet\LaravelBillplz\Consoles;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Config\Repository as Config;
use Illuminate\View\Factory as View;
use Illuminate\Filesystem\Filesystem as Filesystem;

/**
 * Class BillGenerationConsole
 *
 * @package Cyvelnet\LaravelBillplz\Consoles
 */
class BillGenerationConsole extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:bill';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a reusable billplz bill.';
    /**
     * @var \Illuminate\Config\Repository
     */
    private $config;
    /**
     * @var \Illuminate\View\Factory
     */
    private $view;
    /**
     * @var \Illuminate\Filesystem\Filesystem
     */
    private $filesystem;

    /**
     * BillGenerationConsole constructor.
     *
     * @param \Illuminate\Config\Repository $config
     * @param \Illuminate\View\Factory $view
     * @param \Illuminate\Filesystem\Filesystem $filesystem
     */
    public function __construct(Config $config, View $view, Filesystem $filesystem)
    {
        parent::__construct();
        $this->config = $config;
        $this->view = $view;
        $this->filesystem = $filesystem;
    }


    /**
     * @return bool
     */
    public function handle()
    {

        try {

            $class = ucwords($this->argument('name'));
            $directory = app_path($this->config->get('billplz.directory'));
            $namespace = $this->config->get('billplz.namespace');


            // loading transformers template from views
            $view = $this->view->make('billplz::bill',
                ['namespace' => $namespace, 'class_name' => $class]);

            // create directory is not exists
            if (!$this->filesystem->exists($directory)) {
                return $this->filesystem->makeDirectory($directory, 0755, true);
            }

            if ($this->checkFileExist($directory, $class)) {
                $this->askForOverwrite($class);
            }

            $this->filesystem->put("{$directory}/{$class}.php", $view->render());

            $this->info("Bill {$class} created!");

        } catch (\Exception $e) {
            $this->error("Failed to generate bill class due to : {$e->getMessage()}");
        }


    }

    /**
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'Name of the bill class'],
        ];
    }

    /**
     *
     */
    private function askForOverwrite($class)
    {
        if ('n' === $this->ask("The class {$class} exists, overwrite ? [y/n]", 'n')) {
            exit();
        }
    }

    /**
     * check if a file is already exists
     */
    private function checkFileExist($directory, $class)
    {
        return $this->filesystem->exists("{$directory}/{$class}.php");
    }
}
