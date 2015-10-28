<?php

use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Routing\DispatcherFactory;

Plugin::load('Josegonzalez/Upload');
Plugin::load('ADmad/Glide');
Configure::write('Glide', [
    'serverConfig' => [
        'base_url' => '/_images/',
        'source' => ROOT . DS . 'uploads/',
        'cache' => WWW_ROOT . 'cache',
        'response' => new ADmad\Glide\Responses\CakeResponseFactory(),
    ],
    'secureUrls' => true,
]);
DispatcherFactory::add('ADmad/Glide.Glide', ['for' => '/_images']);
