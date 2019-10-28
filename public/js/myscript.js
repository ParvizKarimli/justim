<!-- Show avatar preview thumbnail before uploading -->
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            $('#avatar-xl').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

$("#avatar-input").change(function() {
    readURL(this);
});

<!-- Show deleteAccountModal if there's any error upon validation -->
$(document).ready(function() {
    if($('#deleteAccountModal').attr('data-has-error') == 'yes') {
        $('#deleteAccountModal').modal('show');
    }
    else {
        $('#deleteAccountModal').modal('hide');
    }
});

<!-- Infinite Scroll initialization -->
$('.infinite-scroll-container').infiniteScroll({
    // options
    path: '.pagination li.active + li a',
    append: '.infinite-scroll-item',
    history: false,
    hideNav: '.pagination',
    elementScroll: '.infinite-scroll-container',
});