<?php

namespace App\Console\Commands;

use Illuminate\Foundation\Console\ModelMakeCommand as BaseModelMakeCommand;
use Illuminate\Support\Str;

class DomainModelMakeCommand extends BaseModelMakeCommand
{
    protected $name = 'make:model';

    protected $description = 'Create a new Eloquent model class inside a domain';

    protected function getDefaultNamespace($rootNamespace)
    {
        if ($this->option('domain')) {
            return $rootNamespace . '\Domains\\' . $this->option('domain') . '\Models';
        }

        return $rootNamespace . '\Models';
    }

    protected function buildClass($name)
    {
        $stub = parent::buildClass($name);

        if ($this->option('domain')) {
            $stub = str_replace(
                'DummyNamespace',
                'App\Domains\\' . $this->option('domain') . '\Models',
                $stub
            );
        }

        return $stub;
    }

    protected function getOptions()
    {
        return array_merge(parent::getOptions(), [
            ['domain', null, \Symfony\Component\Console\Input\InputOption::VALUE_OPTIONAL, 'The domain name where the model should be stored'],
        ]);
    }

    protected function getPath($name)
    {
        if ($this->option('domain')) {
            $name = Str::replaceFirst($this->rootNamespace(), '', $name);
            return base_path('app/Domains/' . $this->option('domain') . '/Models/') . class_basename($name) . '.php';
        }

        return parent::getPath($name);
    }
}
