<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>

    <link rel="stylesheet" href="{{ asset('css/home/sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home/general.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home/content.css') }}">

    <script src="https://kit.fontawesome.com/6d3cbfa844.js" crossorigin="anonymous"></script>
</head>

<body>

<div class="row m-0">
    {{-- SideBar --}}
    <div class="col-md-3 SideBar">
        <a href="{{ url('newsfeed/home') }}">
            <img src="/collect_file/logo/logo-gradient.svg" alt="logo" class="SideBar-Logo">
        </a>

        <div class="miniProfile">
            @if (Auth::user()->level == '0')
                <a href="{{ route('view.profile.userprofile') }}" class="SideBar-Link">
                    <img src="/images/{{ Auth::user()->avatar ? Auth::user()->avatar : 'jone-doe.jpg' }}"
                         alt="" class="profile-avatar" style="object-fit: cover">
                    <span class="profile-name">{{ Auth::user()->username }}</span>
                </a>
            @elseif(Auth::user()->level == '1')
                <a href="{{ url('admin/adminprofile') }}" class="SideBar-Link">
                    <img src="/images/{{ Auth::user()->avatar ? Auth::user()->avatar : 'jone-doe.jpg' }}"
                         alt="" class="profile-avatar" style="object-fit: cover">
                    <span class="profile-name">{{ Auth::user()->username }}</span>
                </a>
            @endif
        </div>

        @if (Auth::user()->level == '0')
            <div class="SideBar-Box SideBar-SelectedBox" style="display:none;">
                <a href="{{ url('newsfeed/home') }}" class="SideBar-Link SideBar-Icon">
                    <i class="fas fa-sharp fa-regular fa-gauge"></i> Dashboard
                </a>
            </div>
        @elseif(Auth::user()->level == '1')
            <div class="SideBar-Box SideBar-SelectedBox">
                <a href="{{ route('admin.dashboard.index') }}" class="SideBar-Link SideBar-Icon">
                    <i class="fas fa-sharp fa-regular fa-gauge"></i> Dashboard
                </a>
            </div>
        @endif

        <div class="SideBar-Box">
            <a href="{{ url('/chat') }}" class="SideBar-Link SideBar-Icon">
                <i class="fas fa-brands fa-rocketchat"></i> Chat
            </a>
        </div>
        <div class="SideBar-Box">
            <a href="{{ url('user/editprofile/' . Auth::user()->id) }}" class="SideBar-Link SideBar-Icon">
                <i class="fas fa-regular fa-gear"></i> Edit Profile
            </a>
        </div>
        <div class="SideBar-Box">
            <a href="{{ route('logout.perform') }}" class="SideBar-Link SideBar-Icon">
                <i class="fa-solid fa-right-from-bracket"></i> Logout
            </a>
        </div>
    </div>
    <div class="col-md-9 MidBlock" style='margin-top:100px'>

        {{-- Content Block --}}
        <div class="row" >
            {{-- Newsfeed --}}
            <div class="col-md-12 Content-Newsfeed" >
                {{-- Welcome Statement --}}
                <div class="row">
                    <div class="col-12 Content-Welcome">
                        <div class="Content-Welcome-Name">Hello {{ Auth::user()->username }},</div>
                        <div class="Content-Welcome-Slogan">
                            Share something with your friends
                        </div>
                    </div>
                </div>

                {{-- Create Post --}}
                <div class="row">
                    <div class="col-12 Content-Post-Create">
                        <form action="#" method="post" id="postCreateForm" enctype="multipart/form-data">
                            @csrf
                            <div class="Content-Post-Create-Title">Create Post</div>
                            <div class="Content-Post-Create-Text">
                                    <textarea class="Content-Post-Create-TextField" id="Content-Post-Create-TextField"
                                              placeholder="&#xf0eb; How are you today, {{ Auth::user()->username }} ?" name="content"></textarea>
                                <span id="CreatePostError" style="color:red; font-size:24px"></span>
                                <div id="PostCreateFileInfo" hidden>
                                    <img src="" id='CreatePostImageReview' alt=""
                                         style='width: 300px; height: auto;'>
                                    <span id="btnDeleteFileCreatePost"
                                          style="border: none; border-radius: 20px; padding: 10px 30px 10px 30px;color: white; background: rgb(236, 92, 92)">Delete</span>
                                </div>
                            </div>
                            <div class="Content-Post-Create-Extend">
                                <div class="row">
                                    <div class="col-7">
                                        <label for="PostImage" id="lblPostImage">
                                            <i class="fas fa-light fa-image"></i>
                                            Image
                                        </label>
                                        <input type="file" id="PostImage" name="PostImage" hidden>
                                        {{-- <span class="Content-Post-Create-Extend-Line"></span>
                                        <label for="PostVideo">
                                            <i class="fas fa-regular fa-video"></i>
                                            Video
                                        </label>
                                        <input type="file" id="PostVideo" name="PostVideo" hidden> --}}
                                    </div>
                                    <div class="col-5">
                                        <button type="submit" id="btnPostCreatePublish">Publish</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Feeds --}}
                <div class="row">
                    <div class="col-12 Content-Feeds">
                        <div class="Content-Feeds-Post-Own" id="Post-Prepare">
                            {{-- <div hidden>abc</div> --}}
                        </div>
                        <div class="Content-Feeds-Posts">
                            @foreach ($posts as $post)
                                <div class="Content-Feeds-Post" id="post{{ $post['post']->id }}">
                                    <div class="row">
                                        <div class="col-10 Content-Feeds-Post-InfoLine">
                                            <a href="{{ url('/user/userprofile') . '/' . $post['extra']['user']->id }}"
                                               id="PostAvatarLink{{ $post['extra']['user']->id }}"
                                               style="text-decoration: none">
                                                <img style="object-fit: cover" src="/images/{{ $post['extra']['user']->avatar != null ? $post['extra']['user']->avatar : 'jone-doe.jpg' }}"
                                                     alt="" class="Content-Feeds-Post-Avatar">
                                                <div class="Content-Feeds-Post-Info">
                                                        <span
                                                            class="Content-Feeds-Post-Info-Name">{{ $post['extra']['user']->username }}</span>
                                                    <br>
                                                    <span
                                                        class="Content-Feeds-Post-Info-Status">{{ date('H:m d/m/Y', strtotime($post['post']->created_at)) }}</span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-2 Content-Feeds-Post-Option">
                                        <div class="dropdown">
                                            <button class="btn dropdown-toggle" type="button"
                                                    id="dropdownMenuButton{{ $post['post']->id }}"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-regular fa-ellipsis"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end"
                                                aria-labelledby="dropdownMenuButton{{ $post['post']->id }}">
                                                <li><button class="dropdown-item editPostBtn" href="#"
                                                            data-bs-toggle="modal" data-bs-target="#editModal"
                                                            data-id="{{ $post['post']->id }}"
                                                            @if ($post['post']->user_id != Auth::user()->id) hidden @endif>Edit <i
                                                            class="fas fa-solid fa-pen"></i></button>
                                                </li>
                                                <li><button class="dropdown-item postDeleteBtn"
                                                            data-id="{{ $post['post']->id }}" href="#"
                                                            @if ($post['post']->user_id != Auth::user()->id) hidden @endif>Delete <i
                                                            class="fas fa-solid fa-trash"></i></button></li>
                                                <li>
                                                    <button class="dropdown-item reportPostBtn" href="#"
                                                            data-bs-toggle="modal" data-bs-target="#reportModal"
                                                            data-id="{{ $post['post']->id }}" style="color:red"
                                                            @if ($post['post']->user_id == Auth::user()->id) hidden @endif>Report
                                                        !</button>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12 Content-Feeds-Post-Content">
                                            {!! $post['post']->content !!}
                                        </div>
                                        <div class="Content-Feeds-Post-File">
                                            @if ($post['post']->file != null)
                                                <div style="width: 100%; height: 400px; display: flex; justify-content: center; align-items: center">
                                                    <img src="{{ asset('upload/post/' . $post['post']->file) }}"
                                                         alt="" class="Content-Feeds-Post-Image" style="height: 100%; max-width: 100%;">
                                                </div>
                                            @endif
                                        </div>
                                        <div class="Content-Feeds-Post-Interact">
                                            <div class="row">
                                                <div class="col-3">
                                                    <button>
                                                        <label for="like_post{{ $post['post']->id }}"
                                                               data-id="{{ $post['post']->id }}"
                                                               class="Content-Feeds-Post-Interact-Like Content-Feeds-Post-Interact-Like_{{ $post['post']->id }} @if ($post['extra']['emoteStatus'] == 1) checked @endif">
                                                            <i class="fas fa-solid fa-thumbs-up"></i>
                                                            <span>{{ $post['extra']['like'] }}</span>
                                                        </label>
                                                        |
                                                        <label for="dislike_post{{ $post['post']->id }}"
                                                               data-id="{{ $post['post']->id }}"
                                                               class="Content-Feeds-Post-Interact-Dislike Content-Feeds-Post-Interact-Dislike_{{ $post['post']->id }} @if ($post['extra']['emoteStatus'] == 2) checked @endif">
                                                            <i class="fa-solid fa-thumbs-up fa-rotate-180"></i>
                                                            <span>{{ $post['extra']['dislike'] }}</span>
                                                        </label>
                                                    </button>
                                                </div>

                                                <input type="radio" name="react"
                                                       id="like_post{{ $post['post']->id }}" value="like" hidden>
                                                <input type="radio" name="react"
                                                       id="dislike_post{{ $post['post']->id }}" value="dislike"
                                                       hidden>
                                                <div class="col-9">
                                                    <button type="button"
                                                            class="Content-Feeds-Post-Interact-CommentBtn"
                                                            data-id="{{ $post['post']->id }}" data-bs-toggle="modal"
                                                            data-bs-target="#PostDetail">
                                                        <i class="fas fa-regular fa-comment-dots"></i>
                                                        @if ($post['extra']['comments']->count() > 1)
                                                            {{ $post['extra']['comments']->count() }} Comments
                                                        @else
                                                            {{ $post['extra']['comments']->count() }} Comment
                                                        @endif
                                                    </button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>



        <!-- The Modal -->
        <div class="PostDetailModal modal fade" id="PostDetail">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <!-- Modal Header -->
                    {{-- <div class="modal-header">
                            <h4 class="modal-title">Modal Heading</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div> --}}

                    <!-- Modal body -->
                    <div class="PostDetailModal-Content modal-body">
                        <div class="row">
                            <div class="Content-Feeds-Post " style="margin-bottom: 0">
                                <div class="row">
                                    <div
                                        class="col-12 Content-Feeds-Post-InfoLine Content-Feeds-Post-Modal-InfoLine">
                                        <img style='object-fit: cover' src="/collect_file/newsfeed/image/jone-doe.jpg" alt=""
                                             class="Content-Feeds-Post-Avatar Content-Feeds-Post-Modal-Avatar">
                                        <a href=""
                                           style="text-decoration: none; align-items: center; vertical-align: middle">
                                            <div class="Content-Feeds-Post-Info">
                                                    <span
                                                        class="Content-Feeds-Post-Info-Name Content-Feeds-Post-Modal-Info-Name"></span>
                                                <br>
                                                <span class="Content-Feeds-Post-Info-Status">Just now</span>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div
                                        class="col-12 Content-Feeds-Post-Content Content-Feeds-Post-Modal-Content">

                                    </div>
                                    <div class="Content-Feeds-Post-File Content-Feeds-Post-Modal-File">

                                    </div>
                                    <div class="Content-Feeds-Post-Interact">
                                        <div class="row">
                                            <div class="col-3">
                                                <button>
                                                    <label for="like_post{{ $post['post']->id }}"
                                                           data-id="{{ $post['post']->id }}"
                                                           class="Content-Feeds-Post-Interact-Like Content-Feeds-Post-Modal-Interact-Like">
                                                        <i class="fas fa-solid fa-thumbs-up"></i>
                                                        <span></span>
                                                    </label>
                                                    |
                                                    <label for="dislike_post{{ $post['post']->id }}"
                                                           data-id="{{ $post['post']->id }}"
                                                           class="Content-Feeds-Post-Interact-Dislike Content-Feeds-Post-Modal-Interact-Dislike">
                                                        <i class="fa-solid fa-thumbs-up fa-rotate-180"></i>
                                                        <span>{{ $post['extra']['dislike'] }}</span>
                                                    </label>
                                                </button>
                                            </div>

                                            <input type="radio" name="react" id="like_post_modal"
                                                   value="like" hidden>
                                            <input type="radio" name="react" id="dislike_post_modal"
                                                   value="dislike" hidden>
                                            <div class="col-9">
                                                <button type="button"
                                                        class="Content-Feeds-Post-Interact-CommentBtn"
                                                        data-id="{{ $post['post']->id }}" data-bs-toggle="modal"
                                                        data-bs-target="#PostDetail">
                                                    <i class="fas fa-regular fa-comment-dots"></i>
                                                    <span id="ModalPostComment"></span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div
                                class="col-12 Content-Feeds-Post-Interact-Comment Content-Feeds-Post-Modal-Interact-Comment">
                                <hr>
                                <form action="" id="PostCommentForm">
                                    <textarea name="Comment" id="ModalCommentInput" placeholder="&#xf4ad;Write some comment to the post!!"></textarea>
                                    <span id="CmtPostError" style="color:red; font-size:20px"></span>
                                    <div id="PostCommentFileInfo" style="margin-left: 20px" hidden>
                                        <img src="" id='PostCommentImageReview' alt=""
                                             style='width: 200px; height: auto;'>
                                        <span id="btnDeleteFilePostComment"
                                              style="border: none; border-radius: 20px; padding: 5px 15px 5px 15px;color: white; background: rgb(236, 92, 92)">Delete</span>
                                    </div>
                                    <div
                                        style="display: flex; justify-content: space-between; align-items: center; margin-top: 10px">
                                        <label for="ModalCommentUploadFile" class="CommentOption"
                                               style="font-size: 14px">
                                            <i class="fas fa-light fa-image"></i>
                                            Image
                                        </label>
                                        <input type="file" id="ModalCommentUploadFile" hidden>
                                        <div class="PostCommentBtnWrapper">
                                            <button class="PostCommentBtn">Publish</button>
                                        </div>
                                    </div>
                                </form>
                                <hr>
                            </div>
                            <div class="col-12 Content-Feeds-Post-Modal-Comment">
                            </div>
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    </div>

                </div>
            </div>
        </div>

        {{--  --}}

        <!-- Edit Modal -->
        <div class="editModal modal fade" id="editModal" tabindex="-1" aria-labelledby="editModal"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModal">Edit Post</h5>
                        <button type="button" class="btn-close editModalCloseBtn" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="Content-Feeds-Post " style="margin-bottom: 0">
                            <div class="row">
                                <div class="col-12 Content-Feeds-Post-InfoLine Content-Feeds-Post-Edit-InfoLine">
                                    <img src="/collect_file/newsfeed/image/jone-doe.jpg" alt=""
                                         class="Content-Feeds-Post-Avatar Content-Feeds-Post-Edit-Avatar">
                                    <div class="Content-Feeds-Post-Info">
                                            <span
                                                class="Content-Feeds-Post-Info-Name Content-Feeds-Post-Edit-Info-Name">John</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <form id="editModalForm">
                                        <textarea class="col-12 Content-Feeds-Post-Content Content-Feeds-Post-Edit-Content">

                                            </textarea>
                                    <div class="Content-Feeds-Post-File Content-Feeds-Post-Edit-File">

                                    </div>
                                    <div id="PostEditModalFileInfo" hidden>
                                        <img src="" id='ModaLEditPostImageReview' alt=""
                                             style='width: 200px; height: auto;'>
                                        <span id="btnDeleteFileEditPost"
                                              style="border: none; border-radius: 20px; padding: 5px 15px 5px 15px;color: white; background: rgb(236, 92, 92)">Delete</span>
                                    </div>
                                    <hr>
                                    <div class="col-12">
                                        <label for="PostEditImage">
                                            <i class="fas fa-light fa-image"></i>
                                            Image
                                        </label>
                                        <input type="file" id="PostEditImage" name="PostImage" hidden>

                                    </div>
                                </form>

                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary savePostBtn">Save changes</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Report Modal -->
        <div class="reportModal modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModal"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModal" style="color:red">Report Post</h5>
                        <button type="button" class="btn-close editModalCloseBtn" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="" id="reportForm">
                            <h3>Title</h3>
                            <textarea name="Title" class="Content-Textarea" id="ModalReportTitle"
                                      placeholder="&#xf4ad;Write title for the report!!"></textarea>
                            <h3>Content</h3>
                            <textarea name="Content" class="Content-Textarea" id="ModalReportContent"
                                      placeholder="&#xf4ad;Write reason for the report!!"></textarea>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                                id="reportCloseBtn">Close</button>
                        <button type="button" class="btn btn-primary sendReportPostBtn"
                                id="reportSendBtn">Send</button>
                    </div>
                </div>
            </div>
        </div>
        {{-- Suggestion --}}
        <div class="col-md-4 Content-Suggest">

        </div>
    </div>
</div>
</div>
<form action="" id="FormCmt" method="post" enctype='multipart/form-data' hidden>
    <input type="file" id="CommentFileInput" hidden>
    <button type="submit" id="btnCmtEditUpload"></button>
</form>
<script>
    var loginUser = {{ Auth::user()->id }}
    $(document).ready(function() {
        $('.SideBar-Box').click(function() {
            $('.SideBar-SelectedBox').removeClass('SideBar-SelectedBox');
            $(this).addClass('SideBar-SelectedBox');
        });
        $('.Content-Post-Create-TextField').keypress(function() {
            $(this).height('0px');
            $(this).height($(this).prop('scrollHeight') - 53 + 'px');
        });
        $('.Content-Feeds-Post-Interact-Comment textarea').keypress(function() {
            $(this).height('0px');
            $(this).height($(this).prop('scrollHeight') - 15 + 'px');
        });
        $('#ModalReportTitle, #ModalReportContent').keypress(function() {
            $(this).height('0px');
            $(this).height($(this).prop('scrollHeight') - 50 + 'px');
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).on('submit', '#postCreateForm', function(e) {
            e.preventDefault()
            $(this)[0].reset()
        });

        $(document).on('click', '#btnPostCreatePublish', function(e) {
            if ($('#Content-Post-Create-TextField').val() != "") {
                var output_post = "";
                // alert($('#Content-Post-Create-TextField').val())
                var files = $('#PostImage')[0].files;
                if (files.length > 0) {
                    var fd = new FormData();
                    fd.append('content', $('#Content-Post-Create-TextField').val())
                    fd.append("file", files[0]);
                } else {
                    var fd = new FormData();
                    fd.append('content', $('#Content-Post-Create-TextField').val())
                    fd.append("file", "");
                }
                $.ajax({
                    context: this,
                    type: "POST",
                    url: "{{ url('/newsfeed/create') }}",
                    processData: false,
                    contentType: false,
                    cache: false,
                    data: fd,
                    success: function(response) {
                        let created_time = new Date(response["post"].created_at);
                        $('#Post-Prepare').prepend("<div class='Content-Feeds-Post' id='post" + response[
                                'post']
                                .id + "'>" +
                            "<div class='row'>" +
                            "<div class='col-10 Content-Feeds-Post-InfoLine'>" +
                            "<a href='/view.profile.userprofile'" +
                            "style='text-decoration: none'>" +
                            "<img style='object-fit: cover' src='/images/" + (response["user"].avatar != null ?
                                response["user"].avatar : 'jone-doe.jpg') +
                            "' alt = '' class = 'Content-Feeds-Post-Avatar' > " +
                            "<div class='Content-Feeds-Post-Info'>" +
                            "<span class='Content-Feeds-Post-Info-Name'>" + response[
                                "user"]
                                .username + "</span>" +
                            "<br>" +
                            "<span class='Content-Feeds-Post-Info-Status'>" + (
                                created_time.getHours() < 10 ? "0" + created_time
                                    .getHours() : created_time.getHours()) + ":" + (
                                created_time.getMinutes() < 10 ? "0" + created_time
                                    .getMinutes() : created_time.getMinutes()) + " " + (
                                created_time.getDate() < 10 ? "0" + created_time
                                    .getDate() : created_time.getDate()) + "/" + ((
                                created_time.getMonth() + 1) ? "0" + (created_time
                                .getMonth() + 1) : created_time.getMonth()) + "/" +
                            created_time.getFullYear() +
                            "</span>" +
                            "</a>" +
                            "</div>" +
                            "</div>" +
                            "<div class='col-2 Content-Feeds-Post-Option'>" +
                            "<div class='dropdown'>" +
                            "<button class='btn dropdown-toggle' type='button'" +
                            "id='dropdownMenuButton" + response["post"].id + "'" +
                            "data-bs-toggle='dropdown' aria-expanded='false'>" +
                            "<i class='fas fa-regular fa-ellipsis'></i>" +
                            "</button>" +
                            "<ul class='dropdown-menu dropdown-menu-end'" +
                            "aria-labelledby='dropdownMenuButton" + response["post"]
                                .id +
                            "'>" +
                            "<li><button class='dropdown-item editPostBtn' href='#'" +
                            "data-bs-toggle='modal' data-bs-target='#editModal'" +
                            "data-id='" + response["post"].id +
                            "'>Edit <i class='fas fa-solid fa-pen'></i></button>" +
                            "</li>" +
                            "<li><button class='dropdown-item postDeleteBtn'" +
                            "data-id='" + response["post"].id +
                            "' href='#'> Delete <i class='fas fa-solid fa-trash'></i></button></li>" +
                            "</ul>" +
                            "</div>" +
                            "</div>" +

                            "<div class='row'>" +
                            "<div class='col-12 Content-Feeds-Post-Content'>" +
                            response["post"].content +
                            "</div>" +
                            "<div class='Content-Feeds-Post-File'>" +
                            (response["post"].file != null ?
                                ("<div style='width: 100%; height: 400px; display: flex; justify-content: center; align-items: center'>"+
                                    "<img src='/upload/post/" + response["post"].file +"' "+
                                    "alt='' class='Content-Feeds-Post-Image' style='height: 100%; max-width: 100%;'>"+
                                    "</div>"): "") +
                            "</div>" +
                            "<div class='Content-Feeds-Post-Interact'>" +
                            "<div class='row'>" +
                            "<div class='col-3'>" +
                            "<button>" +
                            "<label for='like_post" + response["post"].id + "'" +
                            "data-id='" + response["post"].id + "'" +
                            "class='Content-Feeds-Post-Interact-Like Content-Feeds-Post-Interact-Like_" +
                            response["post"].id + "'>" +
                            "<i class='fas fa-solid fa-thumbs-up'></i>" +
                            "<span> 0</span>" +
                            "</label>" +
                            " | " +
                            "<label for='dislike_post" + response["post"].id + "'" +
                            "data-id='" + response["post"].id + "'" +
                            "class='Content-Feeds-Post-Interact-Dislike Content-Feeds-Post-Interact-Dislike_" +
                            response["post"].id + "'>" +
                            "<i class='fa-solid fa-thumbs-up fa-rotate-180'></i>" +
                            "<span> 0</span>" +
                            "</label>" +
                            "</button>" +
                            "</div>" +

                            "<input type='radio' name='react'" +
                            "id='like_post" + response["post"].id +
                            "' value='like' hidden>" +
                            "<input type='radio' name='react'" +
                            "id='dislike_post" + response["post"].id +
                            "' value='dislike' hidden>" +
                            "<div class='col-9'>" +
                            "<button type='button'" +
                            "class='Content-Feeds-Post-Interact-CommentBtn'" +
                            "data-id='" + response["post"].id +
                            "' data-bs-toggle='modal'" +
                            "data-bs-target='#PostDetail'>" +
                            "<i class='fas fa-regular fa-comment-dots'></i>" +
                            " 0 Comment" +
                            "</button>" +
                            "</div>" +
                            "</div>" +
                            "</div>" +
                            "</div>" +
                            "</div>")
                        $('#PostCreateFileInfo').attr("hidden", true)
                    }
                });

                $('#CreatePostError').html("")
            } else {
                $('#CreatePostError').html("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;*Post cannot be blank !!!")
            }

        })

        $(document).on('change', '#PostImage', function(e) {
            // var files = $('#PostImage')[0].files;
            // if (files.length > 0) {
            $('#PostCreateFileInfo').removeAttr("hidden");
            $('#CreatePostImageReview').attr('src', URL.createObjectURL(this.files[0]))
            // }
        })

        $(document).on('click', '#btnDeleteFileCreatePost', function() {
            // $('#PostCreateImgInputForm')[0].reset();
            $('#PostCreateFileInfo').attr("hidden", "true");
            $('#PostImage').val("")
            old_EditPostFile = "";
        })

        $(document).on('click', '.Content-Feeds-Post-Interact-Like', function(e) {
            $.ajax({
                context: this,
                type: "POST",
                url: "{{ url('emote/emoteCreate') }}",
                data: {
                    post_id: $(this).data('id'),
                    type: 1
                },
                success: function(response) {
                    $(this).children('span').html(response['like']);
                    $(this).parent().children('.Content-Feeds-Post-Interact-Dislike_' + $(
                        this).data('id')).children('span').html(response['dislike']);
                    if (!$(this).hasClass('checked') && !$(this).parent().children(
                        '.Content-Feeds-Post-Interact-Dislike_' + $(this).data('id'))
                        .hasClass('checked')) {
                        $(this).addClass("checked");
                    } else if ($(this).hasClass('checked') && !$(this).parent().children(
                        '.Content-Feeds-Post-Interact-Dislike_' + $(this).data('id'))
                        .hasClass('checked')) {
                        $(this).removeClass("checked");
                    } else {
                        $(this).addClass("checked");
                        $(this).parent().children('.Content-Feeds-Post-Interact-Dislike_' +
                            $(this).data('id'))
                            .removeClass('checked');
                    }
                }
            });
        });

        $(document).on('click', '.Content-Feeds-Post-Interact-Dislike', function(e) {
            $.ajax({
                context: this,
                type: "POST",
                url: "{{ url('emote/emoteCreate') }}",
                data: {
                    post_id: $(this).data('id'),
                    type: 2
                },
                success: function(response) {
                    $(this).children('span').html(response['dislike']);
                    $(this).parent().children('.Content-Feeds-Post-Interact-Like_' + $(this)
                        .data('id')).children('span').html(response['like']);
                    if (!$(this).hasClass('checked') && !$(this).parent().children(
                        '.Content-Feeds-Post-Interact-Like_' + $(this).data('id'))
                        .hasClass('checked')) {
                        $(this).addClass("checked");
                    } else if ($(this).hasClass('checked') && !$(this).parent().children(
                        '.Content-Feeds-Post-Interact-Like_' + $(this).data('id'))
                        .hasClass('checked')) {
                        $(this).removeClass("checked");
                    } else {
                        $(this).addClass("checked");
                        $(this).parent().children('.Content-Feeds-Post-Interact-Like_' + $(
                            this).data('id')).removeClass('checked');
                    }
                }
            });
        });

        // Modal Process
        var recent_post_id;
        var old_EditPostFile;


        $(document).on('click', '.Content-Feeds-Post-Modal-Interact-Dislike', function(e) {
            $.ajax({
                context: this,
                type: "POST",
                url: "{{ url('emote/emoteCreate') }}",
                data: {
                    post_id: recent_post_id,
                    type: 2
                },
                success: function(response) {
                    $(this).children('span').html(response['dislike']);
                    $('.Content-Feeds-Post-Interact-Dislike_' + recent_post_id).children(
                        'span').html(response['dislike']);
                    $('.Content-Feeds-Post-Interact-Like_' + recent_post_id).children(
                        'span').html(response['like']);
                    $(this).parent().children('.Content-Feeds-Post-Modal-Interact-Like')
                        .children('span').html(response['like']);
                    if (!$(this).hasClass('checked') && !$(this).parent().children(
                        '.Content-Feeds-Post-Modal-Interact-Like').hasClass(
                        'checked')) {
                        $(this).addClass("checked");
                        $('.Content-Feeds-Post-Interact-Dislike_' + recent_post_id)
                            .addClass('checked');
                    } else if ($(this).hasClass('checked') && !$(this).parent().children(
                        '.Content-Feeds-Post-Modal-Interact-Like').hasClass(
                        'checked')) {
                        $(this).removeClass("checked");
                        $('.Content-Feeds-Post-Interact-Dislike_' + recent_post_id)
                            .removeClass('checked');
                    } else {
                        $(this).addClass("checked");
                        $(this).parent().children('.Content-Feeds-Post-Modal-Interact-Like')
                            .removeClass('checked');
                        $('.Content-Feeds-Post-Interact-Dislike_' + recent_post_id)
                            .addClass('checked');
                        $('.Content-Feeds-Post-Interact-Like_' + recent_post_id)
                            .removeClass('checked');
                    }
                }
            });
        });

        $(document).on('click', '.Content-Feeds-Post-Modal-Interact-Like', function(e) {
            $.ajax({
                context: this,
                type: "POST",
                url: "{{ url('emote/emoteCreate') }}",
                data: {
                    post_id: recent_post_id,
                    type: 1
                },
                success: function(response) {
                    $(this).children('span').html(response['like']);
                    $('.Content-Feeds-Post-Interact-Dislike_' + recent_post_id).children(
                        'span').html(response['dislike']);
                    $('.Content-Feeds-Post-Interact-Like_' + recent_post_id).children(
                        'span').html(response['like']);
                    $(this).parent().children('.Content-Feeds-Post-Modal-Interact-Dislike')
                        .children('span').html(response['dislike']);
                    if (!$(this).hasClass('checked') && !$(this).parent().children(
                        '.Content-Feeds-Post-Modal-Interact-Dislike').hasClass(
                        'checked')) {
                        $(this).addClass("checked");
                        $('.Content-Feeds-Post-Interact-Like_' + recent_post_id).addClass(
                            'checked');
                    } else if ($(this).hasClass('checked') && !$(this).parent().children(
                        '.Content-Feeds-Post-Modal-Interact-Dislike').hasClass(
                        'checked')) {
                        $(this).removeClass("checked");
                        $('.Content-Feeds-Post-Interact-Like_' + recent_post_id)
                            .removeClass('checked');
                    } else {
                        $(this).addClass("checked");
                        $(this).parent().children(
                            '.Content-Feeds-Post-Modal-Interact-Dislike').removeClass(
                            'checked');
                        $('.Content-Feeds-Post-Interact-Like_' + recent_post_id).addClass(
                            'checked');
                        $('.Content-Feeds-Post-Interact-Dislike_' + recent_post_id)
                            .removeClass('checked');
                    }
                }
            });
        });



        $(document).on('click', '.postDeleteBtn', function() {
            var post_id = $(this).data('id');
            $.ajax({
                context: this,
                type: "get",
                url: "{{ url('newsfeed/delete') }}/" + post_id,
                data: {
                    post_id
                },
                success: function(response) {
                    if (response == "Success") {
                        $('#post' + post_id).hide();
                    } else {
                        alert("false to delete this post");
                    }
                }
            });
        })

        $(document).on('click', '.editPostBtn', function() {
            recent_post_id = $(this).data('id');
            $()
            $.ajax({
                type: "POST",
                url: "{{ url('post/getPost') }}",
                data: {
                    post_id: recent_post_id
                },
                success: function(response) {
                    $('.Content-Feeds-Post-Edit-Avatar').attr('src', '/images/' +
                        (response[0].extra.avatar != null ? response[0].extra.avatar :
                            "jone-doe.jpg"));
                    $('.Content-Feeds-Post-Edit-Info-Name').html(response[0].extra
                        .username);
                    if (response[0].post.file != null) {
                        $('#ModaLEditPostImageReview').attr("src", "/upload/post/" +
                            response[0].post.file)
                        $('#PostEditModalFileInfo').removeAttr('hidden')
                    } else {
                        $('.Content-Feeds-Post-Edit-File').html("<span></span>");
                        $('#PostEditModalFileInfo').attr('hidden', true)
                    }
                    old_EditPostFile = response[0].post.file
                    $('.Content-Feeds-Post-Edit-Content').html(response[0].post.content);
                    $('#PostCommentFileInfo').attr('hidden', true)
                }
            });
        });

        $(document).on('change', '#PostEditImage', function() {
            $('#PostEditModalFileInfo').removeAttr("hidden");
            $('#ModaLEditPostImageReview').attr('src', URL.createObjectURL(this.files[0]))
        })

        $(document).on('click', '#btnDeleteFileEditPost', function() {
            $('#PostEditModalFileInfo').attr('hidden', true)
            $('#PostEditImage').val('')
            old_EditPostFile = "";
        })

        $(document).on('click', '.editModalCloseBtn', function(e) {
            $('#editModalForm')[0].reset();
        })

        $(document).on('click', '.savePostBtn', function() {
            var files = $('#PostEditImage')[0].files;
            if (files.length > 0) {
                var fd = new FormData();
                fd.append('post_id', recent_post_id);
                fd.append('content', $('.Content-Feeds-Post-Edit-Content').val())
                fd.append("file", files[0]);
            } else {
                if (old_EditPostFile != "") {
                    var fd = new FormData();
                    fd.append('post_id', recent_post_id);
                    fd.append('content', $('#ModalCommentInput').val())
                    fd.append("file", old_EditPostFile);
                } else {
                    var fd = new FormData();
                    fd.append('post_id', recent_post_id);
                    fd.append('content', $('.Content-Feeds-Post-Edit-Content').val())
                    fd.append("file", "");
                }
            }
            $.ajax({
                context: this,
                type: "POST",
                processData: false,
                contentType: false,
                cache: false,
                url: "{{ url('newsfeed/edit') }}",
                data: fd,
                success: function(response) {
                    $('#post' + recent_post_id + ' .row .Content-Feeds-Post-Content').html(
                        response.content);
                    // alert(JSON.stringify(response));
                    // $('.Content-Feeds-Post-Edit-File').html("<img src='/upload/post/" +
                    //     response.file + "' alt='' class='Content-Feeds-Post-Image'>")
                    if (response.file != "") {
                        $('#post' + recent_post_id + ' .row .Content-Feeds-Post-File').html(
                            "<img src='/upload/post/" + response.file +
                            "' alt='' class='Content-Feeds-Post-Image'>")
                    } else {
                        $('#post' + recent_post_id + ' .row .Content-Feeds-Post-File').html(
                            "")
                    }
                }
            });
            old_EditPostFile = "";
            $("#editModalForm")[0].reset();
            $('.editModalCloseBtn').click();
        });


        $(document).on('click', '.reportPostBtn', function() {
            recent_post_id = $(this).data('id');
        });

        $(document).on('click', '#reportCloseBtn', function() {
            $('#reportForm')[0].reset();
        });

        $(document).on('click', '#reportSendBtn', function() {
            // alert(recent_post_id + "............." + $('#ModalReportTitle').val() +
            //     ".................." + $('#ModalReportContent').val())
            var fd = new FormData();
            fd.append("user_id", loginUser);
            fd.append("post_id", recent_post_id);
            fd.append("title", $('#ModalReportTitle').val());
            fd.append("content", $('#ModalReportContent').val());
            if ($('#ModalReportTitle').val() != null && $('#ModalReportContent').val() != null) {
                $.ajax({
                    context: this,
                    type: "POST",
                    processData: false,
                    contentType: false,
                    cache: false,
                    url: "{{ url('newsfeed/report') }}",
                    data: fd,
                    success: function(response) {
                        // alert("success");
                        // alert(JSON.stringify(response))
                    }
                });
                $('#reportForm')[0].reset();
            }
        });

        $(document).on('click', '.btnDeleteCmt', function() {
            let cmt_id = $(this).data('id')
            $.ajax({
                context: this,
                type: "get",
                url: "{{ url('comment/delete') }}/" + cmt_id,
                data: {
                    cmt_id
                },
                success: function(response) {
                    if (response == "Success") {
                        $('#cmt' + cmt_id).hide();
                    } else {
                        alert("false to delete this post");
                    }
                }
            });
        })


        $(document).on('change', '#ModalCommentUploadFile', function(e) {
            // var files = $('#PostImage')[0].files;
            // if (files.length > 0) {
            $('#PostCommentFileInfo').removeAttr("hidden");
            $('#PostCommentImageReview').attr('src', URL.createObjectURL(this.files[0]))
            // }
        })

        $(document).on('click', '#btnDeleteFilePostComment', function() {
            // $('#PostCreateImgInputForm')[0].reset();
            $('#PostCommentFileInfo').attr("hidden", "true");
            $('#ModalCommentUploadFile').val("")
        })

        $(document).on('submit', '#PostCommentForm', function(e) {
            if ($('#ModalCommentInput').val() != "") {
                var files = $('#ModalCommentUploadFile')[0].files;
                if (files.length > 0) {
                    var fd = new FormData();
                    fd.append('post_id', recent_post_id);
                    fd.append('content', $('#ModalCommentInput').val())
                    fd.append("file", files[0]);
                } else {
                    var fd = new FormData();
                    fd.append('post_id', recent_post_id);
                    fd.append('content', $('#ModalCommentInput').val())
                    fd.append("file", "");
                }
                $.ajax({
                    context: this,
                    type: "POST",
                    processData: false,
                    contentType: false,
                    cache: false,
                    url: "{{ url('comment/commentCreate') }}",
                    data: fd,
                    success: function(response) {
                        // alert(JSON.stringify(response))
                        $("#post" + recent_post_id +
                            " .row .Content-Feeds-Post-Interact .row .col-9  .Content-Feeds-Post-Interact-CommentBtn"
                        ).html("<i class='fas fa-regular fa-comment-dots'></i> " +
                            response["cmtCount"] + " Comments")
                        $('#ModalPostComment').html(response["cmtCount"] + " Comments")
                        $('.Content-Feeds-Post-Modal-Comment').prepend(
                            "<div class='commentWrapper row' id='cmt" + response['comment_info']['comment'].id + "'>" +
                            "<div class='commentAvatar col-2'>" +
                            "<img style='object-fit: cover' src='/images/" + (response['comment_info']['user'].avatar != null ? response['comment_info']['user'].avatar : "jone-doe.jpg") + "' alt=''>" +
                            "</div>" +
                            "<div class='col-8 commentContent'>" +
                            "<a href='{{ url('user/userprofile') }}/" + response['comment_info']['comment'].user_id + "' class='commentUserName'>" +
                            response["comment_info"]['user'].username +
                            "</a> " + ((response['comment_info']['comment'].user_id == loginUser) ?
                                "<button class='btnEditCmt btnCmtFunc' data-src='" +
                                response['comment_info']['comment'].file + "' id='btnEditCmt" +
                                response['comment_info']['comment'].id + "' data-id='" + response['comment_info']['comment'].id +
                                "'><i class='fas fa-solid fa-pen-to-square'></i></button><button class='btnDeleteCmt btnCmtFunc' id='btnDeleteCmt" +
                                response['comment_info']['comment'].id + "' data-id='" + response['comment_info']['comment'].id +
                                "'><i class='fas fa-solid fa-trash'></i></button><button type='submit' class='btnSaveCmt btnCmtFunc' id='btnSaveCmt" +
                                response['comment_info']['comment'].id + "' data-id='" + response['comment_info']['comment'].id +
                                "'><i class='fas fa-solid fa-floppy-disk'></i></button><button class='btnResetCmt btnCmtFunc' id='btnResetCmt" +
                                response['comment_info']['comment'].id + "' data-id='" + response['comment_info']['comment'].id +
                                "'><i class='fas fa-solid fa-rotate-left'></i></button>" :
                                "") +
                            "<hr>" +
                            "<span class='cmtContent' id='cmtContent" + response["comment_info"]['comment'].id + "'>" + response['comment_info']['comment'].content +
                            "</span>" +
                            "<br>" +
                            "<div class='row imgContent'>" +
                            "<img src='/upload/post/" + response['comment_info']['comment'].file +
                            "' alt='' id='imgCmt" + response['comment_info']['comment'].id +
                            "' style='height: 200px; width: auto' " + (response['comment_info']['comment'].file == null ? "hidden" : "") + ">" +
                            "</div>" +
                            "<div id='editCmtOption" + response['comment_info']['comment'].id +
                            "' style='margin-top:10px' hidden><label for='CommentFileInput' id='lblCommentFileInput" +
                            response['comment_info']['comment'].id +
                            "' ><i class='fas fa-light fa-image'></i> Image</label><span class='editCmtDeleteBtn' id='editCmtDeleteBtn" +
                            response['comment_info']['comment'].id +
                            "' style='border-radius:10px;margin-left: 20px; padding: 5px 10px 5px 10px; background:red; color:white'>Delete Image</span></div>" +
                            "</div> <br><hr style='margin-top: 20px'>" +
                            "</div> ")
                        $('.btnSaveCmt, .btnResetCmt').hide()
                    }
                });
                $('#CmtPostError').html("");
                $(this)[0].reset();
            } else {
                $('#CmtPostError').html("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;*Comment cannot be blank");
            }
            $('#PostCommentFileInfo').attr('hidden', true)
            old_EditPostFile = "";
            e.preventDefault();
        });

        $(document).on('click', '.Content-Feeds-Post-Interact-CommentBtn', function(e) {
            recent_post_id = $(this).data('id');
            $.ajax({
                type: "POST",
                url: "{{ url('post/getPost') }}",
                data: {
                    post_id: $(this).data('id')
                },
                success: function(response) {
                    $('.Content-Feeds-Post-Modal-Comment').html(JSON.stringify(response));
                    $('.Content-Feeds-Post-Modal-Info-Name').html(response[0].extra
                        .username);
                    $('.Content-Feeds-Post-Modal-Content').html(response[0].post.content);
                    if (response[0].post.file != null) {
                        $('.Content-Feeds-Post-Modal-File').html("<div style='width: 100%; height: 400px; display: flex; justify-content: center; align-items: center'>"+
                            "<img src='/upload/post/" + response[0].post.file + "' alt='' class='Content-Feeds-Post-Image' style='height: 100%; max-width: 100%;'>"+
                            "</div>")
                        old_EditPostFile = response[0].post.file
                    } else {
                        $('.Content-Feeds-Post-Modal-File').html("<span></span>");
                    }
                    $('.Content-Feeds-Post-Modal-Interact-Like, .Content-Feeds-Post-Modal-Interact-Dislike')
                        .removeClass('checked');
                    if ($('.Content-Feeds-Post-Interact-Like_' + recent_post_id).hasClass(
                        'checked')) {
                        $('.Content-Feeds-Post-Modal-Interact-Like').addClass('checked');
                    } else if ($('.Content-Feeds-Post-Interact-Dislike_' + recent_post_id)
                        .hasClass('checked')) {
                        $('.Content-Feeds-Post-Modal-Interact-Dislike').addClass('checked');
                    }
                    $('.Content-Feeds-Post-Modal-Interact-Like').children('span').html(
                        response[0].extra.like);
                    $('.Content-Feeds-Post-Modal-Interact-Dislike').children('span').html(
                        response[0].extra.dislike);
                    $('#ModalPostComment').html(response[0].extra.comment_count > 1 ? (
                        response[0].extra.comment_count + " Comments") : (response[
                        0].extra.comment_count + " Comment"))
                    var comment_output = "";
                    // alert(JSON.stringify(response[0]))
                    response[0].extra.comments.forEach(comment => {
                        comment_output +=
                            "<div class='commentWrapper row' id='cmt" + comment
                                .comment_info.id + "'>" +
                            "<div class='commentAvatar col-2'>" +
                            "<img style='object-fit: cover' src='/images/" + (comment.avatar != null ? comment
                                .avatar : "jone-doe.jpg") + "' alt=''>" +
                            // "<div class-'col-12'><button class='btnEditCmt'><i class='fas fa-solid fa-pen-to-square'></i></button><button class='btnDeleteCmt'><i class='fas fa-solid fa-trash'></i></button></div>" +
                            "</div>" +
                            "<div class='col-8 commentContent'>" +
                            "<a href='{{ url('user/userprofile') }}/" + comment
                                .comment_info.user_id + "' class='commentUserName'>" +
                            comment
                                .username +
                            "</a> " + ((comment.comment_info.user_id == loginUser) ?
                                "<button class='btnEditCmt btnCmtFunc' data-src='" +
                                comment.comment_info.file + "' id='btnEditCmt" +
                                comment.comment_info.id + "' data-id='" + comment
                                    .comment_info.id +
                                "'><i class='fas fa-solid fa-pen-to-square'></i></button><button class='btnDeleteCmt btnCmtFunc' id='btnDeleteCmt" +
                                comment.comment_info.id + "' data-id='" + comment
                                    .comment_info.id +
                                "'><i class='fas fa-solid fa-trash'></i></button><button type='submit' class='btnSaveCmt btnCmtFunc' id='btnSaveCmt" +
                                comment.comment_info.id + "' data-id='" + comment
                                    .comment_info.id +
                                "'><i class='fas fa-solid fa-floppy-disk'></i></button><button class='btnResetCmt btnCmtFunc' id='btnResetCmt" +
                                comment.comment_info.id + "' data-id='" + comment
                                    .comment_info.id +
                                "'><i class='fas fa-solid fa-rotate-left'></i></button>" :
                                "") +
                            "<hr>" +
                            "<span class='cmtContent' id='cmtContent" + comment
                                .comment_info.id + "'>" + comment.comment_info.content +
                            "</span>" +
                            "<br>" +
                            "<div class='row imgContent'>" +
                            "<img src='/upload/post/" + comment.comment_info.file +
                            "' alt='' id='imgCmt" + comment.comment_info.id +
                            "' style='height: 200px; width: auto' " + (comment
                                .comment_info.file == null ? "hidden" : "") + ">" +
                            "</div>" +
                            "<div id='editCmtOption" + comment.comment_info.id +
                            "' style='margin-top:10px' hidden><label for='CommentFileInput' id='lblCommentFileInput" +
                            comment.comment_info.id +
                            "' ><i class='fas fa-light fa-image'></i> Image</label><span class='editCmtDeleteBtn' id='editCmtDeleteBtn" +
                            comment.comment_info.id +
                            "' style='border-radius:10px;margin-left: 20px; padding: 5px 10px 5px 10px; background:red; color:white'>Delete Image</span></div>" +
                            "</div> <br><hr style='margin-top: 20px'>" +
                            "</div> ";
                    })
                    $('.Content-Feeds-Post-Modal-InfoLine a').attr('href', $(
                        '#PostAvatarLink' + response[0].post.user_id).attr('href'))
                    $('.Content-Feeds-Post-Modal-Avatar').attr("src", $('#PostAvatarLink' +
                        response[0].post.user_id + " img").attr('src'))
                    $('.Content-Feeds-Post-Modal-Comment').html(comment_output);
                    $('.btnSaveCmt, .btnResetCmt').hide()
                    $('#PostCommentFileInfo').attr('hidden', 'true')

                    // alert(JSON.stringify(response))
                }
            });
        });

        var recent_cmt_id;
        var old_cmt;
        var old_Cmt_img;
        $(document).on('click', '.btnEditCmt', function() {
            recent_cmt_id = $(this).data('id');
            old_cmt = $('#cmtContent' + recent_cmt_id).text();
            $('#cmtContent' + recent_cmt_id).html("<textarea class='Comment-Textarea' id='editingCmt" +
                recent_cmt_id + "'>" + $('#cmtContent' + recent_cmt_id).text() + "</textarea>")
            $('#btnEditCmt' + recent_cmt_id + ", #btnDeleteCmt" + recent_cmt_id).hide();
            $('#btnSaveCmt' + recent_cmt_id + ", #btnResetCmt" + recent_cmt_id).show();
            $('#editCmtOption' + recent_cmt_id).removeAttr('hidden')
            old_Cmt_img = $(this).data('src')
            // alert(old_Cmt_img+"|")
        })

        $(document).on('click', '.btnSaveCmt', function() {
            $('#FormCmt').submit()
        })
        $(document).on('submit', '#FormCmt', function(e) {
            e.preventDefault()
            var output_post = "";
            // alert($('#Content-Post-Create-TextField').val())
            var files = $('#CommentFileInput')[0].files;
            if (files.length > 0) {
                var fd = new FormData();
                fd.append('cmt_id', recent_cmt_id)
                fd.append('content', $('#editingCmt' + recent_cmt_id).val())
                fd.append("file", files[0]);
            } else {
                if (old_Cmt_img != "") {
                    var fd = new FormData();
                    fd.append('cmt_id', recent_cmt_id)
                    fd.append('content', $('#editingCmt' + recent_cmt_id).val())
                    fd.append("file", "remain");
                } else {
                    var fd = new FormData();
                    fd.append('cmt_id', recent_cmt_id)
                    fd.append('content', $('#editingCmt' + recent_cmt_id).val())
                    fd.append("file", "");
                }
            }
            $.ajax({
                context: this,
                type: "POST",
                url: "{{ url('comment/editCmt') }}",
                processData: false,
                contentType: false,
                cache: false,
                data: fd,
                success: function(response) {
                    $('#cmtContent' + recent_cmt_id).html(response.content)
                    $('#btnEditCmt' + recent_cmt_id + ", #btnDeleteCmt" + recent_cmt_id)
                        .show();
                    $('#btnSaveCmt' + recent_cmt_id + ", #btnResetCmt" + recent_cmt_id)
                        .hide();
                    $('#CommentFileInput').val("")
                    $('#editCmtOption' + recent_cmt_id).attr('hidden', true)
                }
            })
        });

        // $(document).on('change','#CommentFileInput',function(){
        //     $('#imgCmt'+recent_cmt_id).attr('src',URL.createObjectURL(this.files[0]))
        // })

        $(document).on('change', '#CommentFileInput', function() {
            if ($('#CommentFileInput').val() != "") {
                $('#imgCmt' + recent_cmt_id).attr('src', URL.createObjectURL(this.files[0]))
                $('#imgCmt' + recent_cmt_id).removeAttr('hidden')
                $('#editCmtDeleteBtn' + recent_cmt_id).removeAttr('hidden')
            }
        })

        $(document).on('click', '.editCmtDeleteBtn', function() {
            old_Cmt_img = "";
            $('#CommentFileInput').val("")
            $(this).attr('hidden', true)
            $('#imgCmt' + recent_cmt_id).attr('hidden', true)
        })


    });
</script>
</body>

</html>
