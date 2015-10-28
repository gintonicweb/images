<?php
namespace Images\Controller;

use App\Controller\AppController;
use App\Model\Entity\Image;
use Cake\Event\Event;
use League\Glide\Urls\UrlBuilderFactory;

class ImagesController extends AppController
{
    public function crop($imageId)
    {
        $this->autoRender = false;
        $image = $this->Images->get($imageId);
        if ($this->request->is(['post', 'put'])) {
            $imagick = $this->Images->transform($image, $this->request->data);
        }
        $this->set(compact('image'));
    }
}
