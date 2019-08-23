<?php

namespace BrandStudio\Elasticsearch\Console\Operations;

class CreateConfigurator extends Base
{

    public static function execute(string $name)
    {
        $index_name = self::getIndexName($name);
        $class_name = self::getConfiguratorClassName($name);
        $type_name = $name;
        $path = self::getConfiguratorPath($name);

        self::copyConfigurator($path, self::getTemplate($index_name, $class_name, $type_name));

        echo "{$class_name} created successfully!\n";
    }

    protected static function copyConfigurator(string $path, string $template)
    {
        if (file_exists($path)) {
            throw new \Exception("{$class_name} already exists!");
        }
        file_put_contents($path, self::getTemplate($class_name, $index_name, $type_name));
    }

    protected static function getTemplate(string $class_name, string $index_name, string $type_name) : string
    {
        return str_replace(
            ['{{ $class_name }}', '{{ $index_name }}', '{{ $type_name }}'],
            [$class_name, $index_name, $type_name],
            static::getStub()
        );
    }

    protected static function getStub() : string
    {
        return file_get_contents(__DIR__.'/../../Configurators/ConfiguratorTemplate.stub');
    }

}
