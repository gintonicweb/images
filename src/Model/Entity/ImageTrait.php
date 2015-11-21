<?php 
namespace Images\Model\Entity;

use Cake\Core\Configure;
use Cake\Utility\Security;
use League\Glide\Urls\UrlBuilderFactory;

trait ImageTrait 
{
    protected function _getImageUrl()
    {
        return $this->source() . DS . $this->filename;
    }

    protected function _getSourcePath()
    {
        $filesystemPath = Configure::read('Glide.serverConfig.source');
        return $filesystemPath . $this->source() . DS . $this->filename;
    }

    protected function _getExt()
    {
        return pathinfo($this->filename, PATHINFO_EXTENSION);
    }

    public function getUrl($options)
    {
        $urlBuilder = UrlBuilderFactory::create(
            Configure::read('Glide.serverConfig.base_url'),
            Configure::read('Glide.secureUrls') ? Security::salt() : null
        );
        return $urlBuilder->getUrl($this->imageUrl, $options);
    }
}
