<?php
use Phalcon\DiInterface;
use Vegas\DI\ServiceProviderInterface;
use Vegas\Media\Uploader as Uploader;

class UploaderServiceProvider implements ServiceProviderInterface
{
    const SERVICE_NAME = 'uploader';

    public function register(DiInterface $di)
    {
        $config = $di->get('config');
        $di->set(self::SERVICE_NAME, function () use ($config) {
            $uploaderAdapter = new Uploader(new \File\Models\File());
            $uploaderAdapter->setExtensions(['jpg', 'png']);
            $uploaderAdapter->setMimeTypes(['image/jpeg', 'image/png']);
            $uploaderAdapter->setMaxFileSize('10MB');
            $uploaderAdapter->setTempDestination(\Vegas\Utils\Path::getRootPath() .'/public/temp');
            $uploaderAdapter->setOriginalDestination(\Vegas\Utils\Path::getRootPath() . '/public/uploads');

            return $uploaderAdapter;
        }, true);
    }

    public function getDependencies()
    {
        return array();
    }
}
