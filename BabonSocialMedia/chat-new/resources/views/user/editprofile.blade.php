<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styleeditprofile.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>


<body>
<div class="main-content">
    <!-- Header -->
    <div class="header align-items-center">
        <div class="cover-photo-container">
            <img class="cover-photo" id="cover-preview"
                 src="{{ $user->coverPhoto ? asset('images/'.$user->coverPhoto) : asset('collect_file/newsfeed/image/trending feed 2.jpg') }}" alt="default">
        </div>
    </div>

    <!-- Mask -->
    <span class="mask bg-gradient-default opacity-8"></span>
    <!-- Header container -->
    <div class="container-fluid d-flex align-items-center">
        <div class="row">
            <div class="col-lg-7 col-md-10">
            </div>
        </div>
    </div>
</div>
<!-- Page content -->
<div class="container-fluid mt--7">
    <div class="row">
        <div class="col-xl-4 order-xl-1 mb-5 mb-xl-0">
            <div class="card card-profile shadow">
                <div class="row justify-content-center">
                    <div class="col-lg-3 order-lg-2">
                        <div class="card-profile-image">
                            <a href="#">
                                <div class="avatar-friend upload">
                                    <img id="avatar-preview" src="{{ $user->avatar ? asset('images/'.$user->avatar) : asset('collect_file/newsfeed/image/jone-doe.jpg') }}" width="175" height="175" class="rounded-circle" alt="Default" style="object-fit:cover">
                                    <form id="avatar-form" action="{{ route('user.updateAvatar') }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div class="round">
                                            <input id="avatar-input" name="image" type="file" style="cursor:pointer;">
                                            <i class="fa fa-camera" style="color: #fff;"></i>
                                        </div>
                                        <button class="btn btn-primary" id="avatar-save" type="submit" style="display: none;position: absolute; top: -45px; left: 120%;">Save</button>
                                        <button class="btn btn-danger"  id="avatar-cancel" type="button" style="display: none;position: absolute; top: -45px; left: 200%;"><a href="{{ url('user/editprofile/' .$user->id) }}">Cancel</a></button>
                                    </form>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
                    <div class="d-flex justify-content-between">
                        <a href="#" class=""></a>
                        <a href="#" class=""></a>
                    </div>
                </div>

                <div class="card-body pt-0 pt-md-4">
                    <div class="row">
                        <div class="col">
                            <div class="card-profile-stats d-flex justify-content-center mt-md-5">
                                <div>
                                    <span class="heading">{{$totalPosts}}</span>
                                    <span class="description">Posts</span>
                                </div>
                                <div>
                                    <span class="heading">{{$totalTickets}}</span>
                                    <span class="description">Tickets</span>
                                </div>
                                <div>
                                    <span class="heading">{{$totalReports}}</span>
                                    <span class="description">Reports</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <h3>
                            {{$user->username}}
                        </h3>
                        <hr class="my-4">
                        <p>{{$user->description}}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-8 order-xl-2">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        @if (session('errorAvatar'))
                            <div class="alert alert-danger">
                                {{session('errorAvatar')}}
                            </div>
                        @endif
                        <div class="col-8">
                            <h3 class="mb-0">My account</h3>
                        </div>
                        <div class="col-4 text-right">
                            <form id="cover-form" enctype="multipart/form-data" action="{{ route('user.updateCover') }}" method="post">
                                @csrf
                                <input type="text" name="user_id" value="{{$user->id}}" style="display:none;">
                                <div style="display: flex; align-items: center; flex-wrap: wrap;">
                                    <label for="cover-input" class="btn btn-primary" style="margin-right: 10px; cursor: pointer">Edit cover</label>
                                    <input name="coverimage" type="file" id="cover-input" style="display: none;">
                                </div>
                                <div style="display: flex; flex-direction: column; align-items: center; position: relative;">
                                    <button class="btn btn-primary" id="cover-save" type="submit" style="display: none;">Save</button>
                                    <button class="btn btn-danger"  id="cover-cancel" type="button" style="display: none;"><a href="{{ url('user/editprofile/' .$user->id) }}">Cancel</a></button>
                                </div>
                                <div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('user.updateProfile') }}" method="post">
                        @csrf
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <h6 class="heading-small text-muted mb-4">User information</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="input-username">Username</label>
                                        <input type="text" name="username" id="input-username" class="form-control form-control-alternative" value="{{ $user->username }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-email">Email address</label>
                                        <input type="email" name="email" id="input-email" class="form-control form-control-alternative" value="{{ $user->email }}" >
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="input-first-name">Phone</label>
                                        <input type="tele" name="phone" id="input-first-name" class="form-control form-control-alternative" value="{{ $user->phone }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <label class="form-control-label">Gender</label>
                                        <div class="custom-control custom-radio mb-3">
                                            <input name="gender" class="custom-control-input" id="male" type="radio" value="0" {{ $user->gender == '0' ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="male">Male</label>
                                        </div>
                                        <div class="custom-control custom-radio mb-3">
                                            <input name="gender" class="custom-control-input" id="female" type="radio" value="1" {{ $user->gender == '1' ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="female">Female</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="input-first-name">Date of birth</label>
                                        <input type="date" name="dob" id="input-first-name" class="form-control form-control-alternative" value="{{ $user->dob }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="Submit" class="btn btn-info" value="Update profile">
                    </form>
                    <hr class="my-4">
                    <form action="{{ route('user.updatePassword') }}" method="post">
                        @csrf
                        @if (session('status2'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status2') }}
                            </div>
                        @elseif (session('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif
                        <h6 class="heading-small text-muted mb-4">Security information</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="input-address">Password</label>
                                        <input name="old_password" id="input-address" class="form-control form-control-alternative" value="{{ $user->password}}" type="password">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="input-address">New Password</label>
                                        <input name="new_password" id="input-address" class="form-control form-control-alternative" placeholder="Change password if you want" type="text">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="input-address">Confirm new password</label>
                                        <input name="new_password_confirmation" id="input-address" class="form-control form-control-alternative" placeholder="Confirm new password" type="text">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="Submit" class="btn btn-info" value="Update password">
                    </form>
                    <hr class="my-4">
                    <!-- Description -->
                    <form action="{{ route('user.updateDescription') }}" method="post">
                        @csrf
                        @if (session('status3'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status3') }}
                            </div>
                        @elseif (session('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif
                        <h6 class="heading-small text-muted mb-4">Description</h6>
                        <div class="pl-lg-4">
                            <div class="form-group focused">
                                <label>About Me</label>
                                <textarea rows="4" class="form-control form-control-alternative" name="description" placeholder="A few words about you ..." value="{{ $user->description }}"></textarea>
                            </div>
                        </div>
                        <input type="Submit" class="btn btn-info" value="Update description">
                        @if($user->level == '0')
                            <button type="button" class="btn"><a href="/user/userprofile">Back</a></button>
                        @elseif($user->level == '1')
                            <button type="button" class="btn"><a href="/admin/adminprofile">Back</a></button>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<section>
    <script>
        $(document).ready(function(){
            $("#user").DataTable();
        });
    </script>
    <script>
        const avatarInput = document.getElementById('avatar-input');
        const avatarPreview = document.getElementById('avatar-preview');
        const avatarForm = document.getElementById('avatar-form');
        const avatarSave = document.getElementById('avatar-save');
        const avatarCancel = document.getElementById('avatar-cancel');

        avatarInput.addEventListener('change', function() {
            const file = this.files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                avatarPreview.setAttribute('src', e.target.result);
                avatarSave.style.display = 'block';
                avatarCancel.style.display = 'block';
            }

            reader.readAsDataURL(file);
        });

        avatarForm.addEventListener('submit', function(e) {
            e.preventDefault();
            avatarSave.style.display = 'none';
            avatarCancel.style.display = 'none';
            this.submit();
        });
    </script>
    <script>
        const coverInput = document.getElementById('cover-input');
        const coverPreview = document.getElementById('cover-preview');
        const coverForm = document.getElementById('cover-form');
        const coverSave = document.getElementById('cover-save');
        const coverCancel = document.getElementById('cover-cancel');

        coverInput.addEventListener('change', function() {
            const file = this.files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                coverPreview.setAttribute('src', e.target.result);
                coverSave.style.display = 'block';
                coverCancel.style.display = 'block';
            }

            reader.readAsDataURL(file);
        });

        coverForm.addEventListener('submit', function(e) {
            e.preventDefault();
            coverSave.style.display = 'none';
            coverCancel.style.display = 'none';
            this.submit();
        });
    </script>
</section>
</body>
</html>
