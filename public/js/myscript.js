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

<!-- Show sendFriendRequestModal if there's any error upon validation -->
$(document).ready(function() {
    if($('#sendFriendRequestModal').attr('data-has-error') == 'yes') {
        $('#sendFriendRequestModal').modal('show');
    }
    else {
        $('#sendFriendRequestModal').modal('hide');
    }
});

<!-- Infinite Scroll initialization -->
// For friends
$('#contacts').infiniteScroll({
    // options
    path: '.pagination li.active + li a',
    append: '.contact',
    history: false,
    hideNav: '.pagination',
    elementScroll: '#contacts',
    status: '.page-load-status-contacts',
});
// For friend requests
$('#friend-requests').infiniteScroll({
    // options
    path: '.pagination li.active + li a',
    append: '.friend-request',
    history: false,
    hideNav: '.pagination',
    elementScroll: '#friend-requests',
    status: '.page-load-status-friend-requests',
});

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

var friendRequestActionBtns = document.querySelectorAll('.friend-request-action-btn');
for(var i=0; i<friendRequestActionBtns.length; i++) {
    friendRequestActionBtns[i].addEventListener('click', friendRequestAction);
}

function friendRequestAction() {
    event.preventDefault();

    var dataFriendId = this.getAttribute('data-friend-id');
    var dataAction = this.getAttribute('data-action');

    if(window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        var xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        var xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.open('POST', '/users/friend_request_action', true);
    // Send the proper header information along with the request
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
    xmlhttp.send('data_action=' + dataAction + '&data_friend_id=' + dataFriendId);

    xmlhttp.onreadystatechange = function()
    {
        if(this.readyState == 4 && this.status == 200)
        {
            document.getElementById('friend-request-action-container-' + dataFriendId).innerHTML = this.responseText;
        }
    };
}
