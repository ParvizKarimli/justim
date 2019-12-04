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
// .pagination does not get hidden for friend requests
// So let's hide it manually
$(document).ready(function(){
    $('.pagination').hide();
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

    xmlhttp.onreadystatechange = function() {
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

// Take a friend request action: accept or deny a friend request
var friendRequestActionTaken = false;
function friendRequestAction(e) {
    event.preventDefault();

    var dataFriendId = e.getAttribute('data-friend-id');
    var dataAction = e.getAttribute('data-action');

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

    xmlhttp.onreadystatechange = function() {
        if(this.readyState == 4 && this.status == 200)
        {
            document.getElementById('friend-request-action-container-' + dataFriendId).innerHTML = this.responseText;
        }
    };

    friendRequestActionTaken = true;

    return;
}

// Refresh page after friendRequestsModal gets hidden if a friend request actions has been taken
$('#friendRequestsModal').on('hidden.bs.modal', refreshPage);
function refreshPage() {
    if(friendRequestActionTaken === true) {
        location.reload();
    }
    return;
}

// Send friend data to friend modal
$(document).on("click", ".filterMembers", function () {
    var friendId = $(this).data('friend-id');
    var friendName = $(this).data('friend-name');
    var friendUsername = $(this).data('friend-username');
    var friendThumbnail = $(this).data('friend-thumbnail');
    if(friendThumbnail == '') {
        friendThumbnail = 'default_thumbnail.jpg';
    } else {
        friendThumbnail = $(this).data('friend-thumbnail');
    }
    var friendSince = $(this).data('friend-since');

    $("#removeFriend").attr( 'data-friend-id', friendId );
    $("#blockUser").attr( 'data-user-id', friendId );
    $("#friendName").html( friendName );
    $("#friendUsername").html( '@' + friendUsername );
    $("#friendThumbnail").attr( 'src', '/storage/images/avatars/thumbnails/' + friendThumbnail );
    $("#friendSince").html( friendSince );
});


// Remove friend
function removeFriend(e) {
    event.preventDefault();

    var friendId = e.getAttribute('data-friend-id');

    if(window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        var xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        var xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.open('POST', '/users/remove_friend', true);
    // Send the proper header information along with the request
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
    xmlhttp.send('friend_id=' + friendId);

    xmlhttp.onreadystatechange = function() {
        if(this.readyState == 4 && this.status == 200)
        {
            alert('Friend removed successfully.');
            location.reload();
        }
    };
}

// Block user
function blockUser(e) {
    event.preventDefault();

    var userId = e.getAttribute('data-user-id');

    if(window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        var xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        var xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.open('POST', '/users/block_user', true);
    // Send the proper header information along with the request
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
    xmlhttp.send('user_id=' + userId);

    xmlhttp.onreadystatechange = function() {
        if(this.readyState == 4 && this.status == 200)
        {
            alert('User blocked successfully.');
            location.reload();
        }
    };
}
