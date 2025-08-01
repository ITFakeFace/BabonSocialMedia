<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register</title>

    <!-- Bootstrap core CSS -->
    <link href="{!! url('assets/bootstrap/css/bootstrap.min.css') !!}" rel="stylesheet">
    <link href="{!! url('assets/css/signin.css') !!}" rel="stylesheet">
    
    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>

    
    <!-- Custom styles for this template -->
    <link href="signin.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body class="text-center " style="background-image: url('images/BG.png'); width:100%; height:100%">
    
    <main class="form-signin bg-light border rounded card o-hidden border-0 shadow-lg my-5">
    <section class="card-body p-0">
    <form method="post" action="{{ route('register.perform') }}" >

        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <img class="mb-4" src="{!! url('images/logo-gradient.svg') !!}" alt="" width="150px" height="100px">
        
        <h1 class="h3 mb-3 fw-large">Register</h1>

        <div class="form-group form-floating mb-3">
            <input type="email" class="form-control" name="email" value="{{ old('email') }}" required="required" autofocus>
            <label for="floatingEmail">Email address</label>
            @if ($errors->has('email'))
                <span class="text-danger text-left">{{ $errors->first('email') }}</span>
            @endif
        </div>
        <div class="form-group form-floating mb-3">
            <input type="tele" class="form-control" name="phone" value="{{ old('phone') }}" required="required" autofocus>
            <label for="floatingName">Phone</label>
            @if ($errors->has('phone'))
                    <span class="text-danger text-left">{{ $errors->first('phone') }}</span>   
            @endif
        </div>
        <div class="form-group form-floating mb-3">
            <input type="text" class="form-control" name="username" value="{{ old('username') }}" required="required" autofocus>
            <label for="floatingName">Username</label>
            @if ($errors->has('username'))
                <span class="text-danger text-left">{{ $errors->first('username') }}</span>
            @endif
        </div>
        <div class="form-group row">
        <div class="col-sm-6 mb-3 mb-sm-0">
        <input type="date" class="form-control" name="dob" autofocus required="required">
            @if ($errors->has('dob'))
                <span class="text-danger text-left">{{ $errors->first('dob') }}</span>
            @endif
        </div>
        <div class="col-sm-6">
            <div class="row" required="required">
                <div class="form-check col-sm-6">
                   <input class="form-check-input" type="radio" name="gender" id="flexRadioDefault1" value="0">
                   <label class="form-check-label" for="flexRadioDefault1">Male</label>
                </div>
                <div class="form-check col-sm-6">
                   <input class="form-check-input" type="radio" name="gender" id="flexRadioDefault2" value="1">
                   <label class="form-check-label" for="flexRadioDefault2">Female</label>
                </div>
            </div>
        </div>
        </div>
  
        <div class="form-group form-floating mb-3 mt-3">
            <input type="password" class="form-control" name="password" value="{{ old('password') }}" required="required">
            <label for="floatingPassword">Password</label>
            @if ($errors->has('password'))
                <span class="text-danger text-left">{{ $errors->first('password') }}</span>
            @endif
        </div>

        <div class="form-group form-floating mb-3">
            <input type="password" class="form-control" name="password_confirmation" value="{{ old('password_confirmation') }}" required="required">
            <label for="floatingConfirmPassword">Confirm Password</label>
            @if ($errors->has('password_confirmation'))
                <span class="text-danger text-left">{{ $errors->first('password_confirmation') }}</span>
            @endif
        </div>
        <button class="w-100 btn btn-lg btn-primary" type="submit">Register</button>
        

    </form>
    <hr>
    <p class="small fw-bold mt-2 pt-1 mb-0">Have an account? <a class="btn btn-success" href="{{ route('login.perform') }}">Login</a></p></div>
    </section>
</main>

    

    </body>
    </html>