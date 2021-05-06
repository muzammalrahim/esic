    function esicPreloadImages(array) {
        if (!esicPreloadImages.list) {
            esicPreloadImages.list = [];
        }
        var list = esicPreloadImages.list;
        for (var i = 0; i < array.length; i++) {
            var img = new Image();
            img.onload = function() {
                var index = list.indexOf(this);
                if (index !== -1) {
                    // remove image from the array once it's loaded
                    // for memory consumption reasons
                    list.splice(index, 1);
                }
            }
            list.push(img);
            img.src = array[i];
        }
    }
    function FindAllImagesSrc() {
    var imgs = document.getElementsByTagName("img");
    var imgSrcs = [];

    for (var i = 0; i < imgs.length; i++) {
        imgSrcs.push(imgs[i].src);
    }

    return imgSrcs;
}
jQuery(document).ready(function($) {
    var allImages = FindAllImagesSrc();
    esicPreloadImages(allImages);
});