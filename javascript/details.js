function showImage(url, thumbnail) {
    // Change the main image
    document.getElementById('product-detail-main-image').src = url;

    var thumbnails = document.getElementsByClassName('product-detail-thumbnail');
    for (var i = 0; i < thumbnails.length; i++) {
        thumbnails[i].classList.remove('product-detail-selected-thumbnail');
    }

    thumbnail.classList.add('product-detail-selected-thumbnail');
}
