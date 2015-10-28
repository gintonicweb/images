requirejs.config({
    paths: {
        cropper: 'images/vendor/cropper/dist/cropper',
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
