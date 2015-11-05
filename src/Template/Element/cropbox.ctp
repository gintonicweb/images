<div data-cropper="data-cropper">
    <img src="<?= $imageUrl ?>" alt="<?= $name ?>">
    </div>
</div>
<div class="text-center">

<p>
    <button data-rotate="left"><i class="fa fa-rotate-left"></i></button>
    <button data-rotate="left"><i class="fa fa-rotate-right"></i></button>
    <button data-zoom="in"><i class="fa fa-search-plus"></i></button>
    <button data-zoom="out"><i class="fa fa-search-minus"></i></button>
</p>

<?= $this->Form->create(null,[
    'url' => $url
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
