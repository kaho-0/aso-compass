//画像
function previewImage(event) {
    var preview = document.getElementById('preview');
    var file = event.target.files[0];
    var reader = new FileReader();

    reader.onload = function() {
        var image = new Image();
        image.src = reader.result;
        preview.innerHTML = '';
        preview.appendChild(image);
    }

    if (file) {
        reader.readAsDataURL(file);
    }
}