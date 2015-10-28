<?php
namespace Images\Model\Table;

use Images\Model\Entity\Image;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Images Model
 *
 */
class ImagesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('images');
        $this->displayField('filename');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->addBehavior('Josegonzalez/Upload.Upload', [
            'filename' => [
                'filesystem' => [
                    'root' => ROOT,
                ],
                'path' => 'uploads{DS}{relatedModel}',
                'pathProcessor' => '\Images\File\Path\PolymorphicProcessor',
                'transformer' => '\Images\File\Transformer\UniqidTransformer'
            ],
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->add('id', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('model', 'create')
            ->notEmpty('model');

        $validator
            ->requirePresence('filename', 'create')
            ->allowEmpty('filename');

        return $validator;
    }

    public function createImage(Image $image)
    {
        $image->uniqid = uniqid();
        return $this->save($image);
    }

    public function transform(Image $image, $data = null)
    {
        $sourcePath = $image->getFilePath();
        $image->filename = uniqid() . '.' . $image->getExt();
        $result = $this->save($image);

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

            $imagick->writeImage($result->getFilePath());
            unlink($sourcePath);
        }



    }

}
