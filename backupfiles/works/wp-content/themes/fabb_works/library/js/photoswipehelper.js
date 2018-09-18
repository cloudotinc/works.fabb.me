

function setupPhotoSwipeOne($elm, options) {
    var $pswp = $('.pswp')[0];
    var image = [];


    var $pic = $elm,
        getItems = function () {
            var items = [];

            var $href = $pic.attr('href'),
                $size = $pic.data('size').split('x'),
                $width = $size[0],
                $height = $size[1];

            var item = {
                src: $href,
                w: $width,
                h: $height
            }

            var $caption = $pic.siblings(".caption");
            if ($caption[0]) {
                item.title = $caption.text();
            }

            items.push(item);

            return items;
        }

    var items = getItems();

    $.each(items, function (index, value) {
        image[index] = new Image();
        image[index].src = value['src'];
    });

    $pic.on('click', function (event) {
        event.preventDefault();

        var $index = $(this).index();
        if (!options) {
            options = {
                index: $index,
                bgOpacity: 0.7,
                showHideOpacity: true
            }
        }

        options["index"] = $index;

        var lightBox = new PhotoSwipe($pswp, PhotoSwipeUI_Default, items, options);
        lightBox.init();
    });
}


function setupPhotoSwipeGallery(options) {
    var $pswp = $('.pswp')[0];
    var image = [];

    $('.gallery').each(function () {
        var $pic = $(this),
            getItems = function () {
                var items = [];
                $pic.find('a').each(function () {
                    var $href = $(this).attr('href'),
                        $size = $(this).data('size').split('x'),
                        $width = $size[0],
                        $height = $size[1];

                    var item = {
                        src: $href,
                        w: $width,
                        h: $height
                    }

                    var $caption = $(this).siblings(".caption");
                    if ($caption[0]) {
                        item.title = $caption.text();
                    }

                    items.push(item);
                });
                return items;
            }

        var items = getItems();

        $.each(items, function (index, value) {
            image[index] = new Image();
            image[index].src = value['src'];
        });

        $pic.on('click', 'dl', function (event) {
            event.preventDefault();

            var $index = $(this).index();
            if (!options) {
                options = {
                    index: $index,
                    bgOpacity: 0.7,
                    showHideOpacity: true
                }
            }

            options["index"] = $index;

            var lightBox = new PhotoSwipe($pswp, PhotoSwipeUI_Default, items, options);
            lightBox.init();
        });
    });
}


function setupPhotoSwipe(options) {
    var $pswp = $('.pswp')[0];
    var image = [];

    $('.my-gallery').each(function () {
        var $pic = $(this),
            getItems = function () {
                var items = [];
                $pic.find('a').each(function () {
                    var $href = $(this).attr('href'),
                        $size = $(this).data('size').split('x'),
                        $width = $size[0],
                        $height = $size[1];

                    var item = {
                        src: $href,
                        w: $width,
                        h: $height
                    }

                    var $caption = $(this).siblings(".caption");
                    if ($caption[0]) {
                        item.title = $caption.text();
                    }

                    items.push(item);
                });
                return items;
            }

        var items = getItems();

        $.each(items, function (index, value) {
            image[index] = new Image();
            image[index].src = value['src'];
        });

        $pic.on('click', 'figure', function (event) {
            event.preventDefault();

            var $index = $(this).index();
            if (!options) {
                options = {
                    index: $index,
                    bgOpacity: 0.7,
                    showHideOpacity: true
                }
            }

            options["index"] = $index;

            var lightBox = new PhotoSwipe($pswp, PhotoSwipeUI_Default, items, options);
            lightBox.init();
        });
    });
}
