<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <link rel="stylesheet" href="{{ URL::asset('css/userprofile.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('css/new.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>

        .create-post {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            flex: 1;
        }

        .post-avatar {
            margin-right: 10px;
        }

        .post-avatar img {
            border-radius: 50%;
        }

        .post-textarea {
            display: flex;
            flex-direction: column;
            width: 100%;
            border-radius: 10px;
            background-color: #f0f2f5;
            padding: 10px;
        }

        .post-textarea textarea {
            border: none;
            resize: none;
            font-size: 16px;
            font-weight: 400;
            padding: 10px;
            background-color: transparent;
        }

        .post-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 10px;
        }

        .post-option {
            display: flex;
            align-items: center;
            font-size: 14px;
            font-weight: 600;
            color: #65676b;
            cursor: pointer;
        }

        .post-option i {
            margin-right: 5px;
        }

        .post-option:hover {
            color: #1877f2;
        }
        .profile-post{
            max-height: 160.4px;
        }
        .publish-button {
            display: inline-block;
            background-color: #007bff;
            color: #fff;
            font-size: 14px;
            font-weight: bold;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.2s ease-in-out;
        }

        .publish-button:hover {
            background-color: #0062cc;
        }
        .list-posts{
            display: block;
            float: right;
            flex: 50%;
            margin-right: 3%;
            width: 1030px;
            flex-direction: column;
            align-items: center;
            margin-bottom: 15px;
            margin-top: -14%;
        }

        .modal {
            display:none;
            z-index: 9999;
            position: fixed; /* Set position to fixed */
            left: 50%; /* Center horizontally */
            top: 50%; /* Center vertically */
            transform: translate(-50%, -50%); /* Offset by half width and height */
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
            cursor: pointer;
        }

        .modal-content {
            background-color: white;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        .options_2 {
            display: inline-block;
            padding: 10px;
            background-color: #f2f2f2;
            border: none;
            border-radius: 50%;
            cursor: pointer;
        }
        img{
            object-fit: cover;
        }

    </style>
</head>
<body>
<div id="root">
    <section>
        {{-- Cover Photo  --}}
        <div
            class="cover-picture"
            @if ($user->coverPhoto)
                style="background-image: url('{{ asset('images/'.$user->coverPhoto)}}')"
            @else
                style="background-image: url('{{ asset('collect_file/newsfeed/image/trending feed 2.jpg ')}}')"
            @endif
        ></div>
        <div class="background-image" style="background-image: url('{{asset('collect_file/newsfeed/image/BG.png')}}')"></div>
        <div class="wrapper-profile">
            <a class="back-to-dashboard" href="/newsfeed/home"
            ><span
                    role="img"
                    aria-label="left"
                    class="anticon anticon-left"
                ><svg
                        viewBox="64 64 896 896"
                        focusable="false"
                        data-icon="left"
                        width="1em"
                        height="1em"
                        fill="currentColor"
                        aria-hidden="true"
                    >
                                <path
                                    d="M724 218.3V141c0-6.7-7.7-10.4-12.9-6.3L260.3 486.8a31.86 31.86 0 000 50.3l450.8 352.1c5.3 4.1 12.9.4 12.9-6.3v-77.3c0-4.9-2.3-9.6-6.1-12.6l-360-281 360-281.1c3.8-3 6.1-7.7 6.1-12.6z"
                                ></path></svg></span
                ></a>
            <div class="profile-information">
                <div class="profile-information-sticky">
                    <div class="user-infomation">

                        {{-- Avatar user --}}
                        <div class="post-avatar">
                            @if ($user->avatar)<img src=" {{ asset('images/'.$user->avatar) }}" alt="Default" style="width: 125px; height: 125px; border-radius: 50%; border: 3px solid #adb5bd;">
                            @else <img src="{{ asset('collect_file/newsfeed/image/jone-doe.jpg') }}" alt="Default" style="width: 125px; height: 125px; border-radius: 50%; border: 3px solid #adb5bd;">>
                            @endif
                        </div>

                        {{-- User name --}}
                        <span class="username">{{$user->username}}</span>
                        <span>{{ $user->description }}

                                </span>
                        {{-- xuat status  --}}
                        @if (session('status'))
                            <div class="alert alert-success text-color black">
                                <h1>{{session('status')}}</h1>
                            </div>
                        @endif
                    </div>
                    <div class="row">
                        <div class="btn-group">
                            <button>
                                <img
                                    src="{{asset('collect_file/newsfeed/icon/setting - gray.svg')}}"
                                    alt=""
                                    width="25px"
                                />
                                <a style="text-decoration: none;" href="{{ url('admin/editprofile/' .$user->id) }}"><span>Edit profile</span></a>
                            </button>
                            <button class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout.perform') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" style="text-decoration: none;">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout.perform') }}" class="d-none">
                                    @csrf
                                </form>
                            </button>

                        </div>
                    </div>
                    <div class="row">
                        <div class="btn-group">
                            <button>
                                <a href="{{ route('admin.dashboard.index') }}" style="text-decoration: none;">
                                    <img
                                        src=" {{asset('collect_file/newsfeed/icon/dashboard green.svg')}}"
                                        alt=""
                                        width="25px"
                                    />
                                    <span>Admin Dashboard</span></a>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="profile-post">
                <form method="POST" action="{{  route('admin.post')  }}" enctype="multipart/form-data">
                    @csrf
                    <div class="create-post">
                        <div class="post-avatar">
                            @if ($user->avatar)
                                <img src="{{ asset('images/'.$user->avatar) }}" alt="Default" style="width: 50px; height: 50px; border-radius: 50%; border: 3px solid #adb5bd;">
                            @else
                                <img src="{{ asset('collect_file/newsfeed/image/jone-doe.jpg') }}" alt="Default" style="width: 50px; height: 50px; border-radius: 50%;">
                            @endif
                        </div>
                        <div class="post-textarea">
                            <textarea id="post-text" name="content" placeholder="Notifications/Feelings of Admin ?"></textarea>
                            <div class="post-options">
                                <div class="post-option">
                                    <i class="fas fa-image"></i>
                                    <label for="post-file" class="post-file-label">Photo</label>
                                    <input type="file" id="post-file" name="post-file" accept="image/*,video/*" style="display:none">
                                </div>
                                <div class="post-option">
                                    <button type="submit" class="publish-button post-file-label">Publish</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="list-posts">
            @foreach ($post as $post)
                <div class="post-item">
                    <div class="post-item-header">
                        <div class="friend-info">
                            <div class="avatar-friend">
                                @if ($user->avatar)
                                    <img src="{{ asset('images/'.$user->avatar) }}" alt="Default">
                                @else
                                    <img src="collect_file/newsfeed/image/jone-doe.jpg" alt="Default">
                                @endif
                            </div>
                            <span style="font-size: 20px; font-weight: bold; margin-right: 5px;">{{$user->username}}</span>
                            <span style="font-size: 12px; color: #65676b;">{{ $post->created_at->format('d/m/y ') }}</span>
                        </div>
                        <button class="delete-button options">
                            <i class="fa fa-trash"></i>
                        </button>

                        <div class="delete-modal modal">
                            <div class="modal-content">
                                <h2>Are you sure you want to delete this?</h2>
                                <button class="confirm-delete-button"><a href="{{  url('admin/adminprofile/delete/'.$post->id)  }}">Delete</a></button>
                                <button class="cancel-delete-button">Cancel</button>
                            </div>
                        </div>
                    </div>
                    <div class="post-item-body">
                        <span>{!! $post->content !!}</span>
                        @if($post->file == null)
                            <img src="{{ asset('upload/post/'.$post->file) }}" alt="Image post" width="150px" height="150px" style="display:none">
                        @else
                            <img src="{{ asset('upload/post/'.$post->file) }}" alt="Image post" style="height:20%; width: 50%">
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </section>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        $('.delete-button').click(function() {
            $(this).siblings('.delete-modal').show();
        });

        $('.cancel-delete-button').click(function() {
            $(this).closest('.delete-modal').hide();
        });
    });
</script>

</body>
</html>


