<?php

namespace BrandStudio\Elasticsearch\Console\Operations;

class CreateConfigurator extends Base
{

    public static function execute(string $name)
    {
        $index_name = self::getIndexName($name);
        $class_name = self::getConfiguratorClassName($name);

        $path = self::getConfiguratorPath($name);
        $template = self::getTemplate($class_name, $index_name);

        self::copyConfigurator($path, $template);

        echo "{$class_name} created successfully!\n";
    }

    protected static function copyConfigurator(string $path, string $template)
    {
        if (!is_dir(self::getConfiguratorsDir())) {
            mkdir(self::getConfiguratorsDir());
        }
        if (file_exists($path)) {
            throw new \Exception("{$path} already exists!");
        }
        file_put_contents($path, $template);
    }

    protected static function getTemplate(string $class_name, string $index_name) : string
    {
        return str_replace(
            ['{{ $class_name }}', '{{ $index_name }}'],
            [$class_name, $index_name],
            static::getStub()
        );
    }

    protected static function getStub() : string
    {
        return file_get_contents(__DIR__.'/../../Configurators/ConfiguratorTemplate.stub');
    }

}
