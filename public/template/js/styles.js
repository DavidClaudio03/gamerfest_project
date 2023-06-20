var checkboxes = document.getElementsByClassName('image-checkbox');
var countElement = document.getElementById('count');
var count = 0;

for (var i = 0; i < checkboxes.length; i++) {
    checkboxes[i].addEventListener('change', function () {
        var imagen = this.parentNode.getElementsByTagName('img')[0];

        if (this.checked) {
            imagen.style.border = '2px solid red';
            count++;
        } else {
            imagen.style.border = 'none';
            count--;
        }
        countElement.innerHTML = count;
    });
}

window.addEventListener('load', function () {
    var checkboxes = document.querySelectorAll('input[type="checkbox"]');
    checkboxes.forEach(function (checkbox) {
        checkbox.checked = false;
    });
});
