<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <title>JustIM</title>
    <link href="dist/img/favicon.png" type="image/png" rel="icon">

    <link rel="stylesheet" href="dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="dist/css/perfect-scrollbar.min.css" >
    <link rel="stylesheet" href="dist/css/themify-icons.css">
    <link rel="stylesheet" href="dist/css/emoji.css">
    <link rel="stylesheet" href="dist/css/style.css" >
    <link rel="stylesheet" href="dist/css/responsive.css" >

</head>
<body>

<main>
    <div class="layout">
        @include('inc.navbar')
        @include('inc.sidebar')
        @include('inc.add_friends')
        @include('inc.create_chat')
        @include('inc.chat_dialog')
    </div> <!-- Layout -->
</main>

<script src="dist/js/jquery3.3.1.js"></script>
<script src="dist/js/vendor/jquery-slim.min.js"></script>
<script src="dist/js/vendor/popper.min.js"></script>
<script src="dist/js/bootstrap.min.js"></script>
<script src="dist/js/perfect-scrollbar.min.js"></script>
<script src="dist/js/script.js"></script>

</body>
</html>
