<?php
namespace Images\View\Helper;

use Cake\Core\Configure;
use Cake\ORM\Entity;
use Cake\Utility\Inflector;
use Cake\View\Helper;
use Cake\View\StringTemplateTrait;

class ImagesHelper extends Helper
{
    use StringTemplateTrait;

    public $helpers = ['Requirejs.Require', 'Html'];

    /**
     * Generates an image tag that handle multiple sizes and rendered with picturefill
     *
     * ```
     * $options = [
     *     'sizes' => '(min-width: 40em) 80vw, 100vw'
     *     'srcset' => [375, 480, 780]
     * ]
     * ```
     *
     * @param \Cake\Datasource\EntityInterface $entity The entity that is going to be saved
     * @param array $options picturefill options
     * @return string
     */
    public function picturefill(Entity $entity, array $options)
    {
        $srcset = '';
        foreach ($options['srcset'] as $size) {
            $src = $entity->getUrl(['w' => $size]);
            $src .= " " . $size . "w";
            $srcset[] = $src;
        }
        $options['srcset'] = implode(" ,", $srcset);

        $picturefill = $this->Html->image($entity->getUrl($options), $options);
        $selfLoad = $this->Require->module('picturefill');

        return $picturefill . $selfLoad;
    }
}
