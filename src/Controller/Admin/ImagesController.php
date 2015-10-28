<?php
namespace Images\Controller\Admin;

use App\Controller\Admin\AppController;
use App\Model\Entity\Image;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Utility\Security;
use League\Glide\Urls\UrlBuilderFactory;

class ImagesController extends AppController
{
    private $fields = [];
    public function beforeFilter(Event $event)
    {
        $action = $this->Crud->action();
        $action->config('scaffold.fields', [
            'id',
            'model',
            'foreign_key',
            'filename' => [
                'formatter' => function ($name, $value, $entity) {
                    $urlBuilder = UrlBuilderFactory::create(
                        Configure::read('Glide.serverConfig.base_url'),
                        Configure::read('Glide.secureUrls') ? Security::salt() : null
                    );
                    $url = $urlBuilder->getUrl(
                        $entity->model . '/' . $entity->filename
                    );
                    return '<a href="' . $url . '">' . $entity->filename. '</a>';
                },
                'type' => 'file'
            ],
        ]);
    }

    
    public function add()
    {
        $this->Crud->action()->saveMethod('createImage');
        return $this->Crud->execute();
    }
}
