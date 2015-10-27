# Images plugin for CakePHP

## Warning

*Do not use, very early stage*

Easily add images and image manipulation to any model


## Installation

via composer
```
composer require gintonicweb/images
```

run the migration
```
bin/cake migrations migrate -p Images
```

in bootstrap
```
Plugin::load('Images', ['routes' => true, 'bootstrap' => 'true']);
```

## Usage

In your model add the following

```
$this->addBehavior('Images.Images');
```

In your controller, instead of calling save() you can now call
```createWithImages($requestData)``` like this

```
public function add() {
    if ($this->request->is('post')) {
        if ($this->Post->createWithAttachments($this->request->data)) {
            $this->Session->setFlash(__('The post has been saved'));
        } else {
            $this->Session->setFlash(__('Error saving the post'));
        }
    }
}
```

You'll need the field ```filename``` in your templates.

```
echo $this->Form->create('Post', array('type' => 'file'));
echo $this->Form->input('Image.0.attachment', array('type' => 'file', 'label' => 'Image'));
echo $this->Form->end(__('Add'));
```

