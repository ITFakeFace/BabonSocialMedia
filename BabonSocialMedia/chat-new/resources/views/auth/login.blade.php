<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Babon Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
<section class="vh-100 background-login">
    <div class="container-fluid h-custom ">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-md-9 col-lg-6 col-xl-5 p-5 pb-5">
            </div>
            <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1 p-5 pb-5 border shadow form-login">
                <img src="images/logo-gradient.svg" alt="logo" style="display: block; margin-left: auto; margin-right: auto; width: 50%;" class="p-2">
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                @if (session('message'))
                    <div class="alert alert-danger">
                        {{ session('message') }}
                    </div>
                @endif
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                <form method="post" action="{{ route('login.perform') }}">
                    @csrf
                    <!-- Email input -->
                    <div class="form-outline mb-4">

                        <input type="text" class="form-control" name="username" value="{{ old('username') }}" placeholder="Username/Email" required="required" autofocus>

                        @if ($errors->has('username'))
                            <span class="text-danger text-left">{{ $errors->first('username') }}</span>
                        @endif
                    </div>

                    <!-- Password input -->
                    <div class="form-outline mb-3 ">

                        <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Enter password"/>

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <!-- Checkbox -->
                        <div class="form-check mb-0">
                            <input class="form-check-input me-2" type="checkbox" value="" id="remember" {{ old('remember') ? 'checked' : '' }} />
                            <label class="form-check-label" for="form2Example3 remember">
                                Remember me
                            </label>
                        </div>
                        @if (Route::has('forget.password.get'))
                            <a href="{{ route('forget.password.get') }}" class="text-body" style="text-decoration: none;"> <span style="color:#6c77bc;">Forgot password?</span></a>
                        @endif

                    </div>

                    <div class="text-center text-lg-start mt-4 pt-2">
                        <input type="submit" value="Log in" id="form3Example4" class="form-control form-control-lg" style="background-color:rgb(111,196,172); color: #6c77bc; font-size: 25px; font-weight: 650 ;" />
                        <p class="small fw-bold mt-2 pt-1 mb-0">Don't have an account? <a class="btn btn-primary" href="{{ route('register.perform') }}">Register</a></p>
                    </div>
                </form>
                @if($errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <div>{{$error}}</div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

</body>
</html>
