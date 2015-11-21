<link  href="/images/vendor/cropper/dist/cropper.min.css" rel="stylesheet">

<div data-cropper="data-cropper">
    <img src="<?= $imageUrl ?>">
</div>

<p class="text-center">
    <button data-rotate="left"><i class="fa fa-rotate-left"></i></button>
    <button data-rotate="left"><i class="fa fa-rotate-right"></i></button>
    <button data-zoom="in"><i class="fa fa-search-plus"></i></button>
    <button data-zoom="out"><i class="fa fa-search-minus"></i></button>
</p>

<div class="text-center">
    <?= $this->Form->create(null,[
        'url' => $this->request->here(false)
    ]) ?>
    <?= $this->Form->input('x', ['type'=>'hidden']) ?>
    <?= $this->Form->input('y', ['type'=>'hidden']) ?>
    <?= $this->Form->input('width', ['type'=>'hidden']) ?>
    <?= $this->Form->input('height', ['type'=>'hidden']) ?>
    <?= $this->Form->input('rotate', ['type'=>'hidden']) ?>
    <?= $this->Form->input('url', ['type'=>'hidden']) ?>
    <?= $this->Form->submit('save', ['class'=>'btn-primary']) ?>
</div>

<?php $this->loadHelper('Requirejs.Require') ?>
<?= $this->Require->module('images/cropper') ?>
