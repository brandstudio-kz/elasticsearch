<?php

namespace BrandStudio\Elasticsearch\Console\Operations;

class Base
{

    protected static function getIndexName(string $name) : string
    {
        return "{$name}_index";
    }

    protected static function getConfiguratorClassName(string $name) : string
    {
        return ucfirst($name)."Configurator";
    }

    protected static function getConfiguratorsDir() : string
    {
        return base_path("app/Configurators");
    }

    protected static function getConfiguratorPath(string $name) : string
    {
        $class_name = self::getConfiguratorClassName($name);
        return self::getConfiguratorsDir()."/{$class_name}.php";
    }

    protected static function getConfiguratorClass(string $name) : string
    {
        return "App\\Configurators\\".self::getConfiguratorClassName($name);
    }

}
