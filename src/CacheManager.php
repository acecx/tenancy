<?php

namespace Stancl\Tenancy;

use Illuminate\Cache\CacheManager as BaseCacheManager;

class CacheManager extends BaseCacheManager
{
    public function __call($method, $parameters)
    {
        $tags = [config('tenancy.cache.prefix_base') . tenant('uuid')];
        
        if ($method === "tags") {
            if (count($parameters == 1) && is_array($parameters[0])) {
                $parameters = [$parameters]; // cache()->tags('foo') https://laravel.com/docs/5.7/cache#removing-tagged-cache-items
            }

            return $this->store()->tags(array_merge($tags, ...$parameters));
        }

        return $this->store()->tags($tags)->$method(...$parameters);
    }
}
