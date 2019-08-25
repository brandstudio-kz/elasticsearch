<?php

namespace BrandStudio\Elasticsearch\Models;

use Illuminate\Database\Eloquent\Model;

abstract class ElasticModel extends Model
{

    public abstract function getConfiguratorName() : string;

    public static function boot()
    {
        parent::boot();
    }

}
