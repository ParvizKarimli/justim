// Show avatar preview thumbnail before uploading
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

// Show deleteAccountModal if there's any error upon validation
$(document).ready(function() {
    if($('#deleteAccountModal').attr('data-has-error') == 'yes') {
        $('#deleteAccountModal').modal('show');
    }
    else {
        $('#deleteAccountModal').modal('hide');
    }
});

// Show sendFriendRequestModal if there's any error upon validation
$(document).ready(function() {
    if($('#sendFriendRequestModal').attr('data-has-error') == 'yes') {
        $('#sendFriendRequestModal').modal('show');
    }
    else {
        $('#sendFriendRequestModal').modal('hide');
    }
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

    var senderId = e.getAttribute('data-sender-id');
    var action = e.getAttribute('data-action');

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
    xmlhttp.send('action=' + action + '&sender_id=' + senderId);

    xmlhttp.onreadystatechange = function() {
        if(this.readyState == 4 && this.status == 200)
        {
            document.getElementById('friend-request-action-container-' + senderId).innerHTML = this.responseText;

            // And the jQuery method which doesn't print out any error to console
            //$('#friend-request-action-container-' + senderId).html(this.responseText);
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

// Send friend data to friend modal on click friend field/on show friend modal
$(document).on("click", ".filterMembers", function () {
    var friendId = $(this).data('friend-id');
    var friendName = $(this).data('friend-name');
    var friendUsername = $(this).data('friend-username');
    var friendAvatar = $(this).data('friend-avatar');
    if(friendAvatar == '') {
        friendAvatar = 'default.jpg';
    }
    var friendSince = $(this).data('friend-since');

    $("#removeFriend").attr( 'data-friend-id', friendId );
    $("#blockUser").attr( 'data-username', friendUsername );
    $("#friendName").html( friendName );
    $("#friendUsername").html( '@' + friendUsername );
    $("#friendAvatar").attr( 'src', '/storage/images/avatars/' + friendAvatar );
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
            document.getElementById('friend-action-response').innerHTML = this.responseText;
        }
    };
}

// Block user
function blockUser(e) {
    event.preventDefault();

    //var username = e.getAttribute('data-username'); // For some reason it doesn't work anymore
    // but the jQuery version below works
    var username = $(e).data('username');

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
    xmlhttp.send('username=' + username);

    xmlhttp.onreadystatechange = function() {
        if(this.readyState == 4 && this.status == 200)
        {
            document.getElementById('friend-action-response').innerHTML = this.responseText;
        }
    };
}

// Mark as read
/*var notifReadToggleBtns = document.querySelectorAll('.notif-read-toggle-btn');
for(var i=0; i<notifReadToggleBtns.length; i++) {
    notifReadToggleBtns[i].addEventListener('click', notifReadToggle);
}*/

function notifReadToggle(e) {
    var notification_id = e.closest('.notification').id;

    if(window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        var xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        var xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.open('POST', '/users/notif_read_toggle', true);
    // Send the proper header information along with the request
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
    xmlhttp.send('notification_id=' + notification_id);

    xmlhttp.onreadystatechange = function() {
        if(this.readyState == 4 && this.status == 200)
        {
            e.closest('.notification').classList.toggle('notification-read');

            if(e.innerHTML === "⚪") {
                e.innerHTML = '&#9899;'
                e.title = 'Mark as read';
            } else {
                e.innerHTML = '&#9898;'
                e.title = 'Mark as unread';
            }
        }
    };

    return;
}
