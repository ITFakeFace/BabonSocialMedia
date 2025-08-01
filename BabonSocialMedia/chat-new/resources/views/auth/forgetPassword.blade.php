<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
    <section class="vh-100 background-login">
        <div class="container-fluid h-custom">
          <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-md-9 col-lg-6 col-xl-5 p-5 pb-5">
            </div>
            <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1 p-5 pb-5 border shadow form-login">  
                <img src="images/logo-gradient.svg" alt="logo" style="display: block; margin-left: auto; margin-right: auto; width: 50%;" class="p-2">
                <form method="POST" action="{{ route('forget.password.post') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-form-label">{{ __('Email Address') }}</label>

                            <div>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div>
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Send Password Reset') }}
                                </button>
                                <button type="submit" class="btn btn-danger">
                                    <a href="{{ route('login.show') }}" style="text-decoration:none;color:white">{{__('Cancel')}}</a>
                                </button>
                            </div>            
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