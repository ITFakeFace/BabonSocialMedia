<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>


    <link rel="stylesheet" href="{{ URL::asset('css/userprofile.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('css/new.css') }}">
</head>

<body>
<div id="root">
    <section>
        {{-- Cover Photo  --}}
        <div
            class="cover-picture"
            @if ($user->coverPhoto)
                style="
                        background-image: url('{{asset('images/'.$user->coverPhoto)}}')"
            @else
                style="
                         background-image: url('{{asset('images/trending feed 2.jpg')}}')"
            @endif
        ></div>

        <div class="background-image" style=" background-image: url('{{asset('images/BG-newsfeed.png')}}')"></div>
        <div class="wrapper-profile">
            <a class="back-to-dashboard" href="{{url('/newsfeed/home')}}"
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
                        <div class="avatar-friend">
                            @if ($user->avatar)<img src="{{ asset('images/'.$user->avatar) }}" alt="Default">
                            @else <img src="{{ asset('images/jone-doe.jpg') }}" alt="Default">
                            @endif
                        </div>

                        {{-- User name --}}
                        <span class="username">{{$user->username}}</span>
                        @if ($user->description)
                            <span>{{$user->description}}</span>
                        @else
                            <span>Multidisciplinary Photographer focused on
                                        travel and nature content

                                    </span>
                        @endif

                        {{-- xuat status  --}}
                        @if (session('status'))
                            <div class="alert alert-success text-color black">
                                <h1>{{session('status')}}</h1>
                            </div>
                        @endif

                    </div>

                    <div class="btn-group">

                        <button id="myBtn" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <img
                                src="{{URL::asset('collect_file/newsfeed/icon/communication - gray.svg')}}"
                                alt=""
                                width="30px"
                            />
                            <span>Friends</span>
                        </button>
                        <!-- The Modal -->
                        <div id="myModal" class="modal">

                            <!-- Modal content -->
                            <div class="modal-content" style="max-height: 520px;
                                            min-height: 520px;
                                            width:300px;
                                            padding: 0px 120px;
                                            border-radius: 20px;
                                            overflow-y: scroll;box-shadow: 0px 5px 15px rgba(0,0,0,0.3);">
                                <span class="close">&times;</span>

                                {{-- test --}}
                                <div style="display: flex; flex-direction: column; gap:5px">
                                    <input type="hidden" value="{{$Friended}}" id='listUsers'>
                                    <div style="border: 1px solid black; margin: 5px 0px; padding: 10px 7px; display: flex;align-items: center;border-radius: 5px">
                                        <input type="text" id='modal-search-user' placeholder="Search...">
                                        <img src="{{asset('collect_file/newsfeed/icon/search.svg')}}" alt="Search" width="25px">
                                    </div>
                                    <ul style="display: flex; flex-direction: column; list-style: none" id='listUser-inModal'>
                                    </ul>
                                    <!-- {{-- @foreach ($strangers as $nofriend )

                                        <p >
                                        <a class="avatar-friend" href="{{url('userprofile/'.$nofriend->id)}}">

                                            @if ($nofriend->avatar)<img src="images/{{$nofriend->avatar}}" alt="Default">
                                            @else <img src="images/jone-doe.jpg" alt="Default">
                                            @endif
                                        </a>
                                        <span class="name">{{$nofriend->username}}</span>
                                        <form method="POST" action="{{ url('add-friend') }}" style="margin: 0 460px">
                                            @csrf
                                            <input type="hidden" name="friend_id" value="{{ $nofriend->id }}">
                                            <button type="submit">Add Friend</button>
                                        </form>
                                    </p>
                                    @endforeach --}} -->
                                </div>


                            </div>

                        </div>

                        {{-- Model of Friendlist --}}
                        {{-- <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> <img
                                    src="collect_file/newsfeed/icon/communication - gray.svg"
                                    alt=""
                                    width="30px"
                                /></button>
                                </div>
                                <div class="modal-body">
                                  ...
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                                </div>
                              </div>
                            </div>
                          </div> --}}
                        <button>
                            <a href="{{ url('user/editprofile/' .$user->id) }}"><span>Edit profile</span></a>
                        </button>
                        </button>
                        <button class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <img
                                src="{{asset('collect_file/newsfeed/icon/bulb.svg')}}"
                                alt=""
                                width="25px"
                            />
                            <a class="dropdown-item" href="#"
                               onclick="event.preventDefault();
                                                     document.getElementById('ticket-form').submit();">
                                {{ __('Support') }}
                            </a>

                            <form id="ticket-form" action="{{ url('user/ticketsupport/'.$user->id) }}" class="d-none">
                                @csrf
                            </form>
                        </button>
                        <button class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout.perform') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout.perform') }}" class="d-none">
                                @csrf
                            </form>
                        </button>
                    </div>

                </div>
            </div>
            <div class="profile-post">
                <div class="create-post">
                    <form action="{{ url('/newsfeed/create') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <label for="">Create post</label>
                        <div class="input-create">
                                <textarea
                                    placeholder="How are you today, {{$user->username}}?"
                                    id="myTextarea"
                                    name="content"
                                ></textarea>
                        </div>
                        <div class="btn-group">
                            <div class="input-group">
                                <label for="uploadImg" class="upload"
                                ><svg
                                        stroke="currentColor"
                                        fill="currentColor"
                                        stroke-width="0"
                                        viewBox="0 0 24 24"
                                        height="1em"
                                        width="1em"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <g>
                                            <path
                                                fill="none"
                                                d="M0 0h24v24H0z"
                                            ></path>
                                            <path
                                                d="M21 15v3h3v2h-3v3h-2v-3h-3v-2h3v-3h2zm.008-12c.548 0 .992.445.992.993V13h-2V5H4v13.999L14 9l3 3v2.829l-3-3L6.827 19H14v2H2.992A.993.993 0 0 1 2 20.007V3.993A1 1 0 0 1 2.992 3h18.016zM8 7a2 2 0 1 1 0 4 2 2 0 0 1 0-4z"
                                            ></path>
                                        </g>
                                    </svg>
                                    Image</label
                                ><label for="uploadImg" class="upload"
                                ><svg
                                        stroke="currentColor"
                                        fill="currentColor"
                                        stroke-width="0"
                                        viewBox="0 0 24 24"
                                        height="1em"
                                        width="1em"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <g>
                                            <path
                                                fill="none"
                                                d="M0 0h24v24H0z"
                                            ></path>
                                            <path
                                                d="M17 9.2l5.213-3.65a.5.5 0 0 1 .787.41v12.08a.5.5 0 0 1-.787.41L17 14.8V19a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v4.2zm0 3.159l4 2.8V8.84l-4 2.8v.718zM3 6v12h12V6H3zm2 2h2v2H5V8z"
                                            ></path>
                                        </g></svg>
                                    Video</label
                                ><input type="file" id="uploadImg" />
                            </div>
{{--                            <button type="submit">Publish</button>--}}
                        </div>
                    </form>

                </div>
                <div class="list-posts">
                    @foreach ($post as $p)
                        <div class="post-item">
                            <div class="post-item-header">
                                <div class="friend-info" >
                                    <div class="avatar-friend" >
                                        @if ($user->avatar)<img src="{{asset('images/'.$user->avatar)}}" alt="Default">
                                        @else <img src="{{asset('images/jone-doe.jpg')}}" alt="Default">
                                        @endif
                                    </div>

                                    <span>{{$user->username}}</span>
                                </div>
                                <button class="options" >
                                    <svg
                                        stroke="currentColor"
                                        fill="currentColor"
                                        stroke-width="0"
                                        viewBox="0 0 24 24"
                                        height="1em"
                                        width="1em"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <g>
                                            <path
                                                fill="none"
                                                d="M0 0h24v24H0z"
                                            ></path>
                                            <path
                                                d="M4.5 10.5c-.825 0-1.5.675-1.5 1.5s.675 1.5 1.5 1.5S6 12.825 6 12s-.675-1.5-1.5-1.5zm15 0c-.825 0-1.5.675-1.5 1.5s.675 1.5 1.5 1.5S21 12.825 21 12s-.675-1.5-1.5-1.5zm-7.5 0c-.825 0-1.5.675-1.5 1.5s.675 1.5 1.5 1.5 1.5-.675 1.5-1.5-.675-1.5-1.5-1.5z"
                                            ></path>
                                        </g>
                                    </svg>
                                </button>
                            </div>
                            <div class="post-item-body">
                                <span>{{ str_replace('&nbsp;', ' ', $p->content) }}</span>
                            </div>
                            <div class="post-item-footer">
                                <div class="options">
                                    <img
                                        src="{{asset('collect_file/newsfeed/icon/heart-line.svg')}}"
                                        alt=""
                                        width="20px"
                                    />Likes
                                </div>
                                <div class="options">
                                    <img
                                        src="{{asset('collect_file/newsfeed/icon/comment.svg')}}"
                                        alt=""
                                        width="20px"
                                    />
                                    Comments
                                </div>
                                <div class="options">
                                    <img
                                        src="{{asset('collect_file/newsfeed/icon/share.svg')}}"
                                        alt=""
                                        width="16px"
                                    />
                                    Shares
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
            <div class="profile-suggestion">
                <section class="trending-feeds">
                            <span class="trending-title"
                            >Suggestion for you</span
                            >
                    <ul class="list-suggest">

                        @foreach ($strangers as $nofriend )
                            <div style="display: flex; flex-direction: column">
                                <a class="avatar-friend" href="{{url('user/userprofile/'.$nofriend->id)}}">

                                    @if ($nofriend->avatar)<img src="{{ asset('images/'.$nofriend->avatar)}}" alt="Default">
                                    @else <img src="{{ asset('images/jone-doe.jpg')}}" alt="Default">
                                    @endif
                                </a>
                                <span class="name">{{$nofriend->username}}</span>
                            </div>

                        @endforeach

                    </ul>

                    <h1>Pending accepted</h1>
                    <ul class="list-suggest">
                        @foreach ($NotFriendRequestor as $nfrt )
                            <div class="avatar-friend">
                                @if ($nfrt->avatar)<img src="{{asset('images/'.$nfrt->avatar)}}" alt="Default">
                                @else <img src="{{asset('images/jone-doe.jpg')}}" alt="Default">
                                @endif
                            </div>
                            <span class="name">{{$nfrt->username}}</span>
                        @endforeach
                    </ul>


                    <h1>Cancel request</h1>
                    @foreach ($NotFriendReceveior as $nfrv )
                        <div class="avatar-friend">
                            @if ($nfrv->avatar)<img src="{{asset('images/'.$nfrv->avatar)}}" alt="Default">
                            @else <img src="{{asset('images/jone-doe.jpg')}}" alt="Default">
                            @endif
                        </div>
                        <span class="name">{{$nfrv->username}}</span>
                    @endforeach
                </section>
            </div>
            <!-- Use a button to open the snackbar -->

            <!-- The actual snackbar -->
            <div id="snackbar">Some text some message..</div>
            <div class="dropdown">
                <button id="dropdownButton"   class="dropbtn"><img src="{{ asset('collect_file/newsfeed/icon/noti - green.svg')}}" alt="Notifications" width="30px"></button>
                <div class="badge"><?php echo count($notifications) ?></div>
                <div id="myDropdown" class="dropdown-content" >
                    <input type="hidden" value="{{$notifications}}" id='valueNoti'>

                    <ul id="listNoti">
                        @foreach ($notifications as $notification)
                            <li>
                                <a href="{{url('user/userprofile/'.$notification->data['senderid'])}}" data-id="{{$notification->id}}">
                                    {{$notification->data['message']}}
                                </a>

                                <div class="btn-group1">
                                    <form method="POST" action="{{ url('accept-friend-request') }}">
                                        @csrf
                                        <input type="hidden" name="friend_id" value="{{$notification->data['senderid']}}">
                                        <button type="submit">Accept</button>
                                    </form>

                                    <form method="POST" action="{{ url('reject-friend-request') }}">
                                        @csrf
                                        <input type="hidden" name="friend_id" value="{{$notification->data['senderid']}}" >
                                        <button type="submit">Reject</button>
                                    </form>
                                </div>
                            </li>
                        @endforeach
                    </ul>



                </div>
            </div>
        </div>
    </section>
</div>
<input type="hidden" id="loggedUserId" value="{{ $user->id }}">
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="https://js.pusher.com/4.3/pusher.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

{{-- Pusher display friendrequest --}}
<script>
    // lay gia tri ID nguoi dang dang nhap
    var loggedUserId = $('#loggedUserId').val();

    // Pusher.logToConsole = true;

    var pusher = new Pusher('{{env('PUSHER_APP_KEY')}}', {
        cluster: 'ap1',
        encrypted: true
    });
    var channel = pusher.subscribe('notify-' + loggedUserId);
    channel.bind('friend-request', function(data) {
        // Hiển thị thông báo với nội dung từ dữ liệu nhận được
        var check = false
        myFunction1(data, check);
        // build DOM
    });
</script>

{{-- Pusher display friend accept --}}
<script>
    // lay gia tri ID nguoi dang dang nhap
    var loggedUserId = $('#loggedUserId').val();

    // Pusher.logToConsole = true;

    var pusher = new Pusher('{{env('PUSHER_APP_KEY')}}', {
        cluster: 'ap1',
        encrypted: true
    });
    var channel = pusher.subscribe('receive-' + loggedUserId);
    channel.bind('friend-accept', function(data) {
        // Hiển thị thông báo với nội dung từ dữ liệu nhận được
        var check = true
        myFunction1(data, check);
    });
</script>

{{-- Ajax Makrked as read
<script>
    $('#dropdownButton').click(function(){
        var url = "{{url('markasread/'.$user->id)}}";
        $.ajax({
    type: "GET",
    url: url,
    data: {
        "_token": "{{ csrf_token() }}",

        }
    success: function() {
        $('.badge').html('0');
    },
    error: function(xhr, status, error) {
        console.log(xhr.responseText);
    }
         });;
    });
</script>     --}}
{{-- Modal Friend List --}}
<script>
    // Get the modal
    var modal = document.getElementById("myModal");

    // Get the button that opens the modal
    var btn = document.getElementById("myBtn");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // Get the trending-feeds element
    var trendingFeeds = document.getElementsByClassName("trending-feeds")[0];

    // Get the textarea element
    var textarea = document.getElementById("myTextarea");

    // When the user clicks the button, open the modal
    btn.onclick = function() {
        modal.style.display = "block";
        trendingFeeds.style.display = "none";
        textarea.style.display = "none"; // Hide the textarea element

    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
        trendingFeeds.style.display = "block";
        textarea.style.display = "block"; // Show the textarea element

    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
            trendingFeeds.style.display = "block";
            textarea.style.display = "block"; // Show the textarea element

        }
    }
</script>
{{-- Search User name --}}
<script >
    let listUser = JSON.parse($('#listUsers').val())
    let valueInput = '';
    let elemenLi = '';
    listUser.map((item) => (
        elemenLi += `<li style='display:flex; flex-direction:column;align-items: center'>
                <div>
                    <a style='text-decoration: none;' class="avatar-friend" href="userprofile/${item.id}">
                        <img src="{{ asset('images/') }}/${item.avatar ? item.avatar : 'jone-doe.jpg'}">
                    </a>
                    <span class="name">${item.username}</span>
                </div>
                <form method="POST" action="{{ url('remove-friend') }}" >
                    @csrf
        <input type="hidden" name="friend_id" value="${item.id}">
                    <button style="padding: 0 40px" type="submit">Remove Friend</button>
                </form>

                </li>`
    ))
    $('#listUser-inModal').html(elemenLi)

    $("#modal-search-user").keyup(function(){
        elemenLi = '';
        valueInput = $("#modal-search-user").val();
        newListUser = listUser.filter((item) => (item.username.toLowerCase().search(valueInput.toLowerCase()) !== -1))
        newListUser.length !== 0 ?
            newListUser.map((item) => (
                elemenLi += `<li style='display:flex; flex-direction:column;align-items: center'>
                <div>
                    <a style='text-decoration: none;' class="avatar-friend" href="userprofile/${item.id}">
                        <img src="{{ asset('images/') }}/${item.avatar ? item.avatar : 'jone-doe.jpg'}">
                    </a>
                    <span class="name">${item.username}</span>
                </div>
                <form method="POST" action="{{ url('add-friend') }}" >
                    @csrf
                <input type="hidden" name="friend_id" value="${item.id}">
                    <button style="padding: 0 40px" type="submit">Add Friend</button>
                </form>

                </li>`

            )) : elemenLi += `<li>No user</li>`
        $('#listUser-inModal').html(elemenLi)
    });
</script>
{{-- Dropdown --}}
<script src="{{ URL::asset('js/dropdown.js') }}"></script>

<script>
</script>

<script>

    function myFunction1(data, check) {
        // Get the snackbar DIV
        const x = document.getElementById("snackbar");
        const countBadge = $('.badge')[0].innerHTML;

        const elementFrom = `<form method="POST" action="{{ url('accept-friend-request') }}">
                                            @csrf
        <input type="hidden" name="friend_id" value="${data.user_id}">
                                            <button type="submit">Accept</button>
                                        </form>

                                        <form method="POST" action="{{ url('reject-friend-request') }}">
                                            @csrf
        <input type="hidden" name="friend_id" value="${data.user_id}" >
                                            <button type="submit">Reject</button>
                                        </form>`

        if(data){
            $('#listNoti').append(`<li>
            <a href="{{url('user/userprofile/${data.user_id}')}}">
                                        ${data.message}
                                    </a>

                                  <div class="btn-group1">
                                        ${!check ? elementFrom : ''}
                                    </div>

            </li>`);
        }


        $('.badge')[0].innerHTML = `${parseInt(countBadge) + 1}`

        $('#snackbar').html(
            `<p>${data.message}</p>`

        )
        x.className = "show";
        setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
    }
</script>
</body>
</html>


