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

    /**
     * Every time the image is saved, the file is renamed. This eliminate the
     * need to handle cache busting in the browser.
     *
     * @param \Cake\Event\Event $event The beforeSave event that was fired
     * @param \Cake\Datasource\EntityInterface $entity The entity that is going to be saved
     * @param \ArrayObject $options the options passed to the save method
     * @return void
     */
    public function beforeSave(Event $event, Entity $entity, ArrayObject $options)
    {
        $entity->set('uniqid', uniqid());
        parent::beforeSave($event, $entity, $options);
    }

    /**
     * Apply transformations (rotate/crop) to an image
     *
     * ```
     * $data = [
     *     'rotate' => 90,
     *     'width' => 200,
     *     'height' => 300,
     *     'x' => 20,
     *     'y' => 50,
     * ];
     * ```
     *
     * @param \Cake\Datasource\EntityTrait $image the entity being transformed
     * @param array $data the transformation information
     * @return void
     */
    public function transform(Entity $image, array $data = null)
    {
        $sourcePath = $image->sourcePath;
        $image->filename = uniqid() . '.' . $image->ext;
        $result = $this->_table->save($image);

        if ($result) {
            $imagick = new \Imagick($sourcePath);

            if (!is_null($data)) {
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
