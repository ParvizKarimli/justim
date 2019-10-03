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
    <link rel="stylesheet" href="dist/css/responsive.css">

</head>
<body class="start">
<main>
    <div class="layout">
        <!-- Start of Sign In -->
        <div class="sign-bg">
            <div class="start">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 col-lg-4">
                            <div class="register-content">
                                <div class="login-header">
                                    <div class="logo">
                                        <img src="/storage/images/logo.png" alt="">
                                    </div>
                                    <h1><i class="ti-key"></i>Sign up</h1>
                                </div>
                                <form class="login-up" method="post">
                                    {{ csrf_field() }}
                                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                        <input type="text" id="" class="form-control" placeholder="Name" name="name" value="{{ old('name') }}" required autofocus>
                                        <button class="btn icon"><i class="ti-user"></i></button>
                                        @if ($errors->has('name'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                                        <input type="text" id="inputuser" class="form-control" placeholder="User Name" name="username" value="{{ old('username') }}" required>
                                        <button class="btn icon"><i class="ti-user"></i></button>
                                        @if ($errors->has('username'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('username') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                        <input type="email" id="inputEmail" class="form-control" placeholder="Email Address" name="email" value="{{ old('email') }}" required>
                                        <button class="btn icon"><i class="ti-email"></i></button>
                                        @if ($errors->has('email'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                        <input type="password" id="inputPassword" class="form-control" placeholder="Password" name="password" required>
                                        <button class="btn icon"><i class="ti-lock"></i></button>
                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <input type="password" id="" class="form-control" placeholder="Confirm Password" name="password_confirmation" required>
                                        <button class="btn icon"><i class="ti-lock"></i></button>
                                    </div>
                                    <button type="submit" class="btn button" formaction="{{ route('register') }}">Sign Up</button>
                                    <div class="callout">
                                        <span>Already have account? <a href="{{ route('login') }}">Click Here</a></span>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-8">
                            <div class="page-meta">
                                <h2>JustIM is a simple instant messenger.</h2>
                                <span>Join us and enjoy!</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End of Sign In -->
    </div>
</main>

<script src="dist/js/jquery3.3.1.js"></script>
<script src="dist/js/vendor/jquery-slim.min.js"></script>
<script src="dist/js/vendor/popper.min.js"></script>
<script src="dist/js/bootstrap.min.js"></script>
<script src="dist/js/perfect-scrollbar.min.js"></script>
<script src="dist/js/script.js"></script>
</body>
</html>
