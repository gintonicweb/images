<?php

namespace Images\View\Helper;

use Cake\Core\Configure;
use Cake\Utility\Inflector;
use Cake\Utility\Security;
use Cake\View\Helper;
use Cake\View\StringTemplateTrait;
use League\Glide\Urls\UrlBuilderFactory;

class ImagesHelper extends Helper
{
    use StringTemplateTrait;

    protected $_defaultConfig = [
        'templates' => [
            'link' => '<a href="{{url}}">{{name}}</a>',
            'image' => '<img src="{{url}}" alt="{{name}}">',
        ]
    ];

    /**
     * $options = [
     *     'w' => 300,
     *     'h' => 400,
     *     'fit' => 'crop',
     *     'name' => 'My picture',
     *     'alt' => 'alt text',
     * ]
     */
    function link($entity, $options = []) 
    {
        return $this->templater()->format('link',[
            'url' => $this->getUrl($entity, $options),
            'name' => $entity->filename,
        ]);
    }

    function image($entity, $options = []) 
    {
        return $this->templater()->format('image',[
            'url' => $this->getUrl($entity, $options),
            'name' => Inflector::humanize($entity->entity),
        ]);
    }

    function cropper($entity, $options = []) 
    {
        return $this->_View->Element('Images.cropbox', [
            'url' => $this->getUrl($entity, $options),
            'name' => Inflector::humanize($entity->entity),
            'imageId' => $entity->id,
        ]);
    }

    function getUrl($entity, $options)
    {
        $urlBuilder = UrlBuilderFactory::create(
            Configure::read('Glide.serverConfig.base_url'),
            Configure::read('Glide.secureUrls') ? Security::salt() : null
        );
        $url = $entity->model . '/' . $entity->filename;
        return $urlBuilder->getUrl($url, $options);
    }

}
