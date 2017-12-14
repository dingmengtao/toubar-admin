<?php

return [
    'admin_menu' => [
        'caching' => 'Caching',
    ],
    'cache_management' => 'Cache management',
    'cache_commands' => 'Commands',
    'commands' => [
        'clear_cms_cache' => [
            'title' => 'Clear all CMS cache',
            'description' => 'Clear CMS caching: database caching, static blocks... Run this command when you don\'t see the changes after update data.',
        ],
        'refresh_compiled_views' => [
            'title' => 'Refresh compiled views',
            'description' => 'Clear compiled views to make views up to date.',
        ],
        'create_config_cache' => [
            'title' => 'Create config cache',
            'description' => 'To give your application a speed boost, you should cache all of your configuration files into a single file. This will combine all of the configuration options for your application into a single file which will be loaded quickly by the framework.',
        ],
        'clear_config_cache' => [
            'title' => 'Clear config cache',
            'description' => 'You might need to refresh the config caching when you change something on production environment.',
        ],
        'optimize_class_loader' => [
            'title' => 'Optimize class loader',
            'description' => 'You want your application to run as quickly as possible. ? We will optimize the autoloaded class.',
        ],
        'clear_optimized_class_loader' => [
            'title' => 'Clear optimized class loader',
            'description' => 'This might makes your app run slower.',
        ],
    ],
    'messages' => [
        'cache_cleaned' => 'Cache cleaned',
        'cache_view_refreshed' => 'Cache view refreshed',
        'cache_config_created' => 'Config cache created',
        'cache_config_cleaned' => 'Config cache cleaned',
        'class_loader_optimized' => 'The class loader has been optimized',
        'class_loader_cleaned' => 'The class loader has been cleaned',
        'cache_route_created' => 'The route cache has been created',
        'cache_route_cleaned' => 'The route cache has been cleaned'
    ],
];