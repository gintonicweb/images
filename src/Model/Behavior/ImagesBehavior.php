<?php
namespace Images\Model\Behavior;

use Cake\ORM\Behavior;

class ImagesBehavior extends Behavior
{

    /**
     * Initialize hook
     *
     * @param array $config The config for this behavior.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->_table->hasMany('Images', [
            'className' => 'Images.Images',
            'foreignKey' => 'foreign_key',
        ]);
    }

    public function createWithImages($data)
    {
        $images = [];
        if (!empty($data['images'])) {
            foreach ($data['images'] as $key => $image) {
                $images[] = [
                    'model' => $this->_table->alias(),
                    'filename' => $image['filename'],
                    'uniqid' => uniqid(),
                ];
            }
        }

        $data['images'] = $images;
        $entity = $this->_table->newEntity($data, [
            'associated' => ['Images']
        ]);

        return $this->_table->save($entity);
    }
}
