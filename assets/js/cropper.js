define(function(require) {

    var $ = require('jquery');
    var cropper = require('cropper');

    var $cropper = $('[data-cropper] > img');
    var $options = $('[data-cropper]');
    var $rotateL = $('[data-rotate="left"]');
    var $rotateR = $('[data-rotate="right"]');
    var $zoomIn = $('[data-zoom="in"]');
    var $zoomOut = $('[data-zoom="out"]');

    $cropper.cropper({
        aspectRatio: $options.data('aspect-ratio'),
        background: $options.data('background'),
        guides: $options.data('guides'),
        dragMode: 'move',
        cropBoxResizable: false,
        cropBoxMovable: false,
        minCropBoxHeight: $options.data('minCropBoxHeight'),
        viewMode: $options.data('view-mode'),
        crop: function(e) {
            console.log(e);
            $('[name="x"]').val(e.x);
            $('[name="y"]').val(e.y);
            $('[name="width"]').val(e.width);
            $('[name="height"]').val(e.height);
            $('[name="rotate"]').val(e.rotate);
        }
    });

    $rotateL.click(function(){
        $cropper.cropper('rotate', -90);
    });

    $rotateR.click(function(){
        $cropper.cropper('rotate', 90);
    });

    $zoomIn.click(function(){
        $cropper.cropper('zoom', 0.1);
    });

    $zoomOut.click(function(){
        $cropper.cropper('zoom', -0.1);
    });
});

