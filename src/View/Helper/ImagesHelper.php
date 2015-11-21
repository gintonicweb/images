<?php
namespace Images\View\Helper;

use Cake\Core\Configure;
use Cake\Utility\Inflector;
use Cake\View\Helper;
use Cake\View\StringTemplateTrait;

class ImagesHelper extends Helper
{
    use StringTemplateTrait;

    public $helpers = ['Requirejs.Require','Html'];

    /**
     * todo: Use the Image helper instead of going free for all
     *
     * $options = [
     *     'sizes' => '(min-width: 40em) 80vw, 100vw'
     *     'srcset' => [375, 480, 780]
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
        $options['srcset'] = implode(" ,", $srcset);

        $this->Html->image($this->getUrl($entity, $options), $options);
        $selfLoad = $this->Require->module('picturefill');

        return $picturefill . $selfLoad;
    }
}
