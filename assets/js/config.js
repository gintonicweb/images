requirejs.config({
    paths: {
        cropper: 'images/vendor/cropper/dist/cropper',
        picturefill: 'images/vendor/picturefill/dist/picturefill',
        'images': 'images/js',
    },
    shim: {
        cropper: [
            'jquery'
        ]
    },
    packages: [

    ]
});
