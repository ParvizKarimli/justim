<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <title>JustIM</title>
    <link href="/storage/images/favicon.png" type="image/png" rel="icon">

    <link rel="stylesheet" href="dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="dist/css/perfect-scrollbar.min.css" >
    <link rel="stylesheet" href="dist/css/themify-icons.css">
    <link rel="stylesheet" href="dist/css/emoji.css">
    <link rel="stylesheet" href="dist/css/style.css" >
    <link rel="stylesheet" href="dist/css/responsive.css" >
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
    </div> <!-- Layout -->
</main>

<script src="dist/js/jquery3.3.1.js"></script>
<script src="dist/js/vendor/jquery-slim.min.js"></script>
<script src="dist/js/vendor/popper.min.js"></script>
<script src="dist/js/bootstrap.min.js"></script>
<script src="dist/js/perfect-scrollbar.min.js"></script>
<script src="dist/js/script.js"></script>

<!-- Show avatar preview thumbnail before uploading -->
<script>
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
</script>

<!-- Show deleteAccountModal if there's any error upon validation -->
<script>
    $(document).ready(function() {
        if($('#deleteAccountModal').attr('data-has-error') == 'yes') {
            $('#deleteAccountModal').modal('show');
        }
        else {
            $('#deleteAccountModal').modal('hide');
        }
    });
</script>

<!-- Infinite Scroll -->
<script src="{{ asset('js/infinite-scroll.pkgd.min.js') }}"></script>
<script>
    $('#contacts').infiniteScroll({
        // options
        path: '.pagination li.active + li a',
        append: '.filterMembers',
        history: false,
        hideNav: '.pagination',
    });
</script>

</body>
</html>
