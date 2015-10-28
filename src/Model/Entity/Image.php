<?php
namespace Images\Model\Entity;

use Cake\Core\Configure;
use Cake\ORM\Entity;

/**
 * Image Entity.
 */
class Image extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     * Note that '*' is set to true, which allows all unspecified fields to be
     * mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
    ];

    public function getFilePath()
    {
        $path = Configure::read('Glide.serverConfig.source');
        return $path . $this->model . DS . $this->filename;
    }

    public function getExt()
    {
        return pathinfo($this->getFilePath(), PATHINFO_EXTENSION);
    }
}
