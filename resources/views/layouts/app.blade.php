<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>JustIM</title>

    <link href="/storage/images/favicon.png" type="image/png" rel="icon">

    <link rel="stylesheet" href="dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="dist/css/perfect-scrollbar.min.css" >
    <link rel="stylesheet" href="dist/css/themify-icons.css">
    <link rel="stylesheet" href="dist/css/emoji.css">
    <link rel="stylesheet" href="dist/css/style.css" >
    <link rel="stylesheet" href="dist/css/responsive.css" >
    <link rel="stylesheet" href="/css/mystyle.css" >
    @if(auth()->user()->nightmode == 1)
        <link href="dist/css/dark.css" type="text/css" rel="stylesheet">
    @endif

</head>
<body>

<main>
    <div class="layout">
        @include('inc.navbar')
        @include('inc.sidebar')
        @include('inc.add_friends')
        @include('inc.create_chat')
        @include('inc.chat_dialog')
        @include('inc.system.messages')
        @include('inc.delete_account_modal')
        @include('inc.friend_requests_modal')
        @include('inc.friend_modal')
    </div> <!-- Layout -->
</main>

<script src="dist/js/jquery3.3.1.js"></script>
<script src="dist/js/vendor/jquery-slim.min.js"></script>
<script src="dist/js/vendor/popper.min.js"></script>
<script src="dist/js/bootstrap.min.js"></script>
<script src="dist/js/perfect-scrollbar.min.js"></script>
<script src="dist/js/script.js"></script>
<!-- Infinite Scroll -->
<script src="{{ asset('js/infinite-scroll.pkgd.min.js') }}"></script>
<!-- My Script -->
<script src="{{ asset('js/myscript.js') }}"></script>

<!-- Infinite Scroll initializations -->

<!-- For friends -->
@if(auth()->user()->getFriendsCount() > 10)
    <script>
        $('#contacts').infiniteScroll({
            // options
            path: '.pagination li.active + li a',
            append: '.contact',
            history: false,
            hideNav: '.pagination',
            elementScroll: '#contacts',
            status: '.page-load-status-contacts',
        });
    </script>
@endif

<!-- For friend requests -->
@if($friend_requests_count > 10)
    <script>
        $('#friend-requests').infiniteScroll({
            // options
            path: '.pagination li.active + li a',
            append: '.friend-request',
            history: false,
            hideNav: '.pagination',
            elementScroll: '#friend-requests',
            status: '.page-load-status-friend-requests',
        });
    </script>
@endif

<!-- For blocked users -->
@if(count(auth()->user()->getBlockedFriendships()) > 10)
    <script>
        $('#blocked-users').infiniteScroll({
            // options
            path: '.pagination li.active + li a',
            append: '.blocked-user',
            history: false,
            hideNav: '.pagination',
            elementScroll: '#blocked-users',
            scrollThreshold: false,
            button: '.view-more-button',
        });
    </script>
@endif

<!-- End of Infinite Scroll initializations -->

</body>
</html>
