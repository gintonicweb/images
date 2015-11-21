<?php
namespace Images\Model\Behavior;

use ArrayObject;
use Cake\Event\Event;
use Cake\ORM\Entity;
use Josegonzalez\Upload\Model\Behavior\UploadBehavior;

class ImageBehavior extends UploadBehavior 
{
    protected $_defaultConfig = [
        'filename' => [
            'filesystem' => [
                'root' => ROOT,
            ],
            'path' => 'uploads{DS}{model}',
            'pathProcessor' => '\Images\File\Path\PolymorphicProcessor',
            'transformer' => '\Images\File\Transformer\UniqidTransformer'
        ],
    ];

    public function beforeSave(Event $event, Entity $entity, ArrayObject $options)
    {
        $entity->set('uniqid', uniqid());
        parent::beforeSave($event, $entity, $options);
    }

    // After recieving a crop thing
    public function transform(Entity $image, $data = null)
    {
        $sourcePath = $image->sourcePath;
        $image->filename = uniqid() . '.' . $image->ext;
        $result = $this->_table->save($image);

        if ($result) {
            $imagick = new \Imagick($sourcePath);

            if(!is_null($data)) {
                $imagick->rotateimage('#000', $data['rotate']);
                $imagick->cropImage(
                    $data['width'],
                    $data['height'],
                    $data['x'],
                    $data['y']
                );
            }

            $imagick->writeImage($result->sourcePath);
            unlink($sourcePath);
        }
    }
}
