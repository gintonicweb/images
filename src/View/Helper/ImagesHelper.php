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
            'picturefill' => '<img src="{{url}}" srcset="{{srcset}}" sizes="{{sizes}}" alt="{{name}}" class="{{class}}">',
        ]
    ];

    public $helpers = ['Requirejs.Require'];

    /**
     * $options = [
     *     'w' => 300,
     *     'h' => 400,
     *     'fit' => 'crop',
     *     'name' => 'My picture',
     *     'alt' => 'alt text',
     * ]
     */
    public function link($entity, $options = []) 
    {
        return $this->templater()->format('link',[
            'url' => $this->getUrl($entity, $options),
            'name' => $entity->filename,
        ]);
    }

    public function image($entity, $options = []) 
    {
        return $this->templater()->format('image',[
            'url' => $this->getUrl($entity, $options),
            'name' => Inflector::humanize($entity->entity),
        ]);
    }

    /**
     * $options = [
     *     'sizes' => '(min-width: 40em) 80vw, 100vw'
     *     'srcset' => [375, 480, 780]
     *     'name' => 'My picture',
     *     'alt' => 'alt text',
     * ]
     */
    public function picturefill($entity, $options)
    {
        $srcset = '';
        foreach ($options['srcset'] as $size) {
            $src = $this->getUrl($entity, ['w' => $size]);
            $src .= " " . $size . "w"; 
            $srcset[] = $src;
        }
        $srcset = implode(" ,", $srcset);

        $picturefill = $this->templater()->format('picturefill',[
            'url' => $this->getUrl($entity, $options),
            'srcset' => $srcset,
            'sizes' => $options['sizes'],
            'name' => Inflector::humanize($entity->entity),
            'class' => isset($options['class']) ? $options['class'] : '',
        ]);
        $selfLoad = $this->Require->module('picturefill');
        return $picturefill . $selfLoad;
    }

    /**
     * $options = [
     *     'w' => 300,
     *     'h' => 400,
     *     'fit' => 'crop',
     *     'name' => 'My picture',
     *     'alt' => 'alt text',
     * ]
     */
    public function cropper($entity, $options = []) 
    {
        return $this->_View->Element('Images.cropbox', [
            'url' => $this->getUrl($entity, $options),
            'name' => Inflector::humanize($entity->entity),
            'imageId' => $entity->id,
        ]);
    }

    public function getUrl($entity, $options)
    {
        $urlBuilder = UrlBuilderFactory::create(
            Configure::read('Glide.serverConfig.base_url'),
            Configure::read('Glide.secureUrls') ? Security::salt() : null
        );
        $url = $entity->model . '/' . $entity->filename;
        return $urlBuilder->getUrl($url, $options);
    }
}
