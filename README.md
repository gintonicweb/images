# Images plugin for CakePHP

## Warning

*Do not use, very early stage*

Image upload, management and and manipulation based on
- josegonzalez/cakephp-upload
- admad/cakephp-glide
- fengyuanchen/cropper
- scottjehl/picturefill


## Installation

via composer
```
composer require gintonicweb/images
```

run the migration
```
bin/cake migrations migrate -p Images
```

in config/bootstrap.php
```
Plugin::load('Images', ['routes' => true, 'bootstrap' => 'true']);
```

## Upload and manage images

Any model can now ```haveOne``` or ```haveMany``` images. 
Start by adding the ImagesBehavior to the model of your choice.

```
$this->addBehavior('Images.Images');
```

In the controller, instead of calling save(), call ```createWithImages($requestData)```

```
public function add() {
    if ($this->request->is('post')) {
        if ($this->Post->createWithImages($this->request->data)) {
            $this->Session->setFlash(__('The post has been saved'));
        } else {
            $this->Session->setFlash(__('Error saving the post'));
        }
    }
}
```

Add the field ```filename``` in the template.

```
echo $this->Form->create('Post', array('type' => 'file'));
echo $this->Form->input('Image.0.attachment', array('type' => 'file', 'label' => 'Image'));
echo $this->Form->end(__('Add'));
```

Create a writable ```/upload``` folder in the ROOT folder of your app. That's 
where images will be stored with the following folder structure ```/uploads/Posts/1234567.jpg```.


## Display images

To display the freshly uploaded images, use the Images Helper. This is a simple
wrapper around Glide to render images with the option to set the size
server-side.


In the template:
```
<?php $this->loadHelper('Images.Images'); ?>
<?= $this->Images->image($imageEntity, [
    'name' => ' '
    'w' => 500,
    'h' => 500,
    'fit' => 'crop'
]) ?>

// <img src="https://mysite.com/_images/MyModel/123456.jpg?w=500&h=500&s=..." alt="My image">
```

The method```link()``` is also available for a simple anchor link to the image.
```
<?php $this->loadHelper('Images.Images'); ?>
<?= $this->Images->link($imageEntity, [
    'name' => 'My image'
    'w' => 500,
    'h' => 500
]) ?>

// <a href="https://mysite.com/_images/MyModel/123456.jpg?w=500&h=500&s=...">My image</a>
```


## Picturefill

The most efficient way to display responsive images is via picturefill. Call it
like this

```
<?php $this->loadHelper('Images.Images'); ?>

<?= $this->Images->picturefill($imageEntity, [
    'sizes' => '(min-width: 40em) 80vw, 100vw'
    'srcset' => [375, 480, 780]
    'name' => 'My picture',
    'alt' => 'alt text',
]) ?>
```

The ```sizes``` option represents the fraction of the view-width that the image
is supposed to take, and the srcset represents the different images widths that
you want to make available. This reduces the data transferred on mobile devices
by letting browsers choose the most suited dimensions for the image. for more
information, see [picturefill](https://scottjehl.github.io/picturefill/)

## Crop Images

Provide users with a crop and rotate tool. This feature is experimental and
currently relies on fengyuanchen/cropper and requirejs

Include cropper's stylesheet 
```
<link  href="webroot/vendor/cropper/dist/cropper.min.css" rel="stylesheet">
```

If you use gintonicweb/requirejs, simply add ['Images.config'] to the list of
plugins. If you prefer regular requirejs, load it like this.
```
require(['/images/js/config.js'], function(){require(['images/cropper']);});
```

To use the cropping panel, pass an Image entity to your template, and load the
cropping panel using the Images helper. The only mandatory configuration option
is the url, which is where users need to be redirected once they save the
cropped image.

```
<?php $this->loadHelper('Images.Images'); ?>
<?= $this->Images->cropper($imageEntity, [
    'name' => 'My image'
    'w' => 500,
    'h' => 500,
    'url' => ['controller' => 'Profiles', 'action' => 'view']
]) ?>
```
