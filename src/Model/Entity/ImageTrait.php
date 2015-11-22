<?php
namespace Images\Model\Entity;

use Cake\Core\Configure;
use Cake\Utility\Security;
use League\Glide\Urls\UrlBuilderFactory;

trait ImageTrait
{
    /**
     * Get the source path of the image file on the filesystem
     *
     * @return string
     */
    protected function _getSourcePath()
    {
        $filesystemPath = Configure::read('Glide.serverConfig.source');
        return $filesystemPath . $this->source() . DS . $this->filename;
    }

    /**
     * Get the file extension of the image, without the dot. e.g. 'jpg'.
     *
     * @return string
     */
    protected function _getExt()
    {
        return pathinfo($this->filename, PATHINFO_EXTENSION);
    }

    /**
     * Get the full url for the image. Glide options can be used. A security
     * key is generated to prevent unsolicited image generation.
     *
     * ```
     * $options = [
     *     'h' => 200,
     *     'w' => 300,
     *     'fit' => 'crop',
     * ]
     * ```
     *
     * @param array $options Glide compatible options
     * @return string
     */
    public function getUrl($options)
    {
        $urlBuilder = UrlBuilderFactory::create(
            Configure::read('Glide.serverConfig.base_url'),
            Configure::read('Glide.secureUrls') ? Security::salt() : null
        );
        $prefixedPath = $this->source() . DS . $this->filename;
        return $urlBuilder->getUrl($prefixedPath, $options);
    }
}
