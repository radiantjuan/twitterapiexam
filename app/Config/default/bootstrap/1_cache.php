<?PHP
Configure::write('Cache.viewPrefix', 'tomatocake');
Configure::write('Cache.check', false);
Configure::write('Cache.DefaultEngine', 'file');

Configure::write('TomatoCms.CacheViewConfigKey', '__cache_view__');

// Setup a 'default' cache configuration for use in the application.
Cache::config('default', array('engine' => 'File'));

Cache::config('short', array(
    'engine'   => 'File',
    'duration' => 300,
    'path'     => CACHE,
    'prefix'   => Configure::read('Cache.viewPrefix').'_short_'
));

Cache::config('long', array(
    'engine'   => 'File',
    'duration' => 3600,
    'path'     => CACHE,
    'prefix'   => Configure::read('Cache.viewPrefix').'_short_'
));


Cache::config('web_config_cache', array(
    'engine'   => 'File',
    'duration' => 3600,
    'path'     => CACHE,
    'prefix'   => '__web_config_cache__'
));

Cache::config(Configure::read('TomatoCms.CacheViewConfigKey'), array(
    'engine'   => 'File',
    'duration' => 3600/2, // 30 Mins
    'path'     => CACHE . 'views' . DS,
    'prefix'   => '__cache_view__'
));
