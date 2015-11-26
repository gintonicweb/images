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

In config/bootstrap.php
```
Plugin::load('Images', ['bootstrap' => 'true']);
```

## Quickstart

1. Add the ```filename``` field to the table of your choice.


2. Add the ImagesBehavior to the Table object of your choice. 

```
class Avatars extends Table
{
    public function initialize(array $config)
    {
        $this->addBehavior('Images.Image');
    }
}
```

3. Add the ImageTrait to the matching Entity

```
use Images\Model\Entity\ImageTrait;

class Avatar extends Entity
{
    use ImageTrait;
}
```

## Saving Images

Create a writable ```/upload``` folder in the ROOT folder of your app. That's 
where images will be stored with the following folder structure ```APP/uploads/Avatars/1234567.jpg```.  
Then, simply add the field ```filename``` to your forms.

```
echo $this->Form->create('Pictures', ['type' => 'file']);
echo $this->Form->input('filename', ['type' => 'file', 'label' => 'Picture']);
echo $this->Form->end(__('Add'));
```

## Display images

Use the entity's virtual property to create an image of the right dimensions and
cache it server-side. The options match
The method used to generate urls is the following

```
$imageEntity->getUrl([
    'w' => 300,
    'h' => 400,
    'fit' => 'crop',
]);
```

It's possible to use that url in your calls to cake's default Html helper.

## Picturefill

The most efficient way to display responsive images is via picturefill. This 
feature is experimental and relies on scottjehl/picturefill and requirejs

```
<?php $this->loadHelper('Images.Images'); ?>

<?= $this->Images->picturefill($imageEntity, [
    'sizes' => '(min-width: 40em) 80vw, 100vw',
    'srcset' => [375, 480, 780],
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
currently relies on fengyuanchen/cropper and requirejs and twbs/bootstrap.

Render the following element to benefit from a simple rotate/crop panel

```
<?= $this->Element('Images.cropbox', [
    'imageUrl' => $entity->getUrl(),
    'height' => '400px',
]) ?>
```

This form should post the following data back.
```
[
    'rotate' => 90,
    'width' => 200,
    'height' => 300,
    'x' => 20,
    'y' => 50,
];
```

You can apply it to your Image entity with a controller resemblig this

```
if ($this->request->is(['post'])) {
    $imagesTable->transform($imageEntity, $this->request->data);
}
```
