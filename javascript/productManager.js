function addImageUrlField() {
    var container = document.getElementById("image_urls_container");
    var input = document.createElement("input");
    input.type = "text";
    input.name = "image_urls[]";
    container.appendChild(input);
    container.appendChild(document.createElement("br"));
}
