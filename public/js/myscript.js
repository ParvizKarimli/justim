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

// When friends search input element gets focused
function focusSearch() {
    var filterMembersBtns = document.querySelectorAll('.filterMembersBtn');
    for(var i=0; i<filterMembersBtns.length; i++) {
        filterMembersBtns[i].classList.remove('active');
        filterMembersBtns[i].classList.remove('show');
    }
    filterMembersBtns[0].classList.add('active');
    filterMembersBtns[0].classList.add('show');
}

// Get friends by search term using AJAX
function getFriendsBySearchTerm(search_term) {
    if(window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        var xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        var xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.open('POST', '/users/search_friends', true);
    // Send the proper header information along with the request
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
    xmlhttp.send('search_term=' + search_term);

    xmlhttp.onreadystatechange = function()
    {
        if(this.readyState == 4 && this.status == 200)
        {
            document.getElementById('contacts').innerHTML = this.responseText;
        }
    };

    return;
}

// Make user online by sending AJAX request periodically if user is active
setInterval(function () {
    if(window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        var xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        var xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.open('POST', '/users/make_user_online', true);
    // Send the proper header information along with the request
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
    xmlhttp.send();
}, 60000);
