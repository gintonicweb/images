define(function(require) {

    var $ = require('jquery');
    var cropper = require('cropper');

    var $cropper= $('[data-cropper] > img');
    var $rotateL = $('[data-rotate="left"]');
    var $rotateR = $('[data-rotate="right"]');
    var $zoomIn = $('[data-zoom="in"]');
    var $zoomOut = $('[data-zoom="out"]');

    $cropper.cropper({
        aspectRatio: 1,
        dragCrop: false,
        cropBoxMovable: false,
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

