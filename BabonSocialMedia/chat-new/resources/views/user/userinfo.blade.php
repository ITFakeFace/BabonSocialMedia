<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Document</title>

    
    <link rel="stylesheet" href="{{ URL::asset('css/userprofile.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('css/new.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://kit.fontawesome.com/9836990ba1.js" crossorigin="anonymous"></script>
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
                
                <div class="background-image" style="
                                                    background-image: url('{{asset('images/BG-newsfeed.png')}}')"></div>
                <div class="wrapper-profile">
                    <a class="back-to-dashboard" href="{{url('/user/userprofile')}}"
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
                                    @if ($user->avatar)<img src="{{URL::asset('images/'.$user->avatar)}}" alt="Default">
                                    @else <img src="{{URL::asset('images/jone-doe.jpg')}}" alt="Default">
                                    @endif
                                </div>

                                {{-- User name --}}
                                <span class="username">{{$user->username}}</span>
                                <span>Multidisciplinary Photographer focused on
                                    travel and nature content  
                                </span>

                                <div class="makeFriends">
                                    @if ($Friended->contains($userLoggedin->id))
                                        
                                       <button class="button-17 friend-button" data-status="remove" data-id="{{$user->id}}">
                                            <i class="fas fa-solid fa-user-minus friended" style="font-size: 30px"></i>
                                        </button>
                                        
                                    @else
                                       @if($userLoggedin->id == $user->id)
                                            <h1>Your are, Yes you are!!</h1>
                                            @elseif (optional($NotFriendReceveior)->contains($userLoggedin->id))
                                        <button class="button-17 friend-button" data-status="accept" data-id="{{$user->id}}" id="btnaccept">
                                            <i class="fas fa-solid fa-check friended" style="font-size: 30px"></i>
                                        </button>
                                        <button class="button-17 friend-button" data-status="reject" data-id="{{$user->id}}" id="btnreject">
                                            <i class="fas fa-solid fa-xmark friended" style="font-size: 30px"></i>
                                        </button>
                                        @elseif (optional($NotFriendReceveior)->contains($userLoggedin->id))
                                        <button class="button-17 friend-button" data-status="cancel" data-id="{{$user->id}}">
                                            <i class="fas fa-solid fa-xmark friended" style="font-size: 30px"></i>
                                        </button>
                                        @else
                                            <button class="button-17 friend-button" data-status="add" data-id="{{$user->id}}">
                                                <i class="fas fa-solid fa-user-plus friended" style="font-size: 30px"></i>
                                            </button>
                                       @endif
                                    @endif

                                    {{-- <button class="button-17 friend-button" data-status="add" data-id="{{$user->id}}">
                                        <i class="fas fa-solid fa-user-plus friended" style="font-size: 30px"></i>
                                    </button> --}}
                                </div>
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
                                                    <img src="{{URL::asset('collect_file/newsfeed/icon/search.svg')}}" alt="Search" width="25px">
                                                </div>
                                                <ul style="display: flex; flex-direction: column; list-style: none" id='listUser-inModal'>
                                                </ul>
                                            </div>
                                            </div>
                                        </div>
                                        
                                </button>
        
                                <button class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout.perform') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout.perform') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </button>
                            </div>
                            
                        </div>
                    </div>
                    <div class="profile-post">
                        <div class="create-post">
                            <label for="">Create post</label
                            ><textarea
                                placeholder="How are you today, {{$user->username}}?"
                                class="ant-input css-ed5zg0"
                                style="
                                    margin: 15px 0px;
                                    min-height: 70px;
                                    height: auto;
                                "
                                id="myTextarea"
                            ></textarea>
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
                                <button>Publish</button>
                            </div>
                        </div>
                        <div class="list-posts">
                            @foreach ($post as $p)
                            <div class="post-item">
                                <div class="post-item-header">
                                    <div class="friend-info" >
                                        <div class="avatar-friend" >
                                            @if ($user->avatar)<img src="{{URL::asset('images/'.$user->avatar)}}" alt="Default">
                                            @else <img src="{{URL::asset('images/jone-doe.jpg')}}" alt="Default">
                                            @endif
                                        </div> 
                                      
                                        <span>{{$user->username}}</span>
                                    </div>
                                    <button class="options">
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
                                    <span
                                        >{{$p->content}}</span
                                    >
                                </div>
                                <div class="post-item-footer">
                                    <div class="options">
                                        <img
                                            src="collect_file/newsfeed/icon/heart-line.svg"
                                            alt=""
                                            width="20px"
                                        />Likes
                                    </div>
                                    <div class="options">
                                        <img
                                            src="collect_file/newsfeed/icon/comment.svg"
                                            alt=""
                                            width="20px"
                                        />
                                        Comments
                                    </div>
                                    <div class="options">
                                        <img
                                            src="collect_file/newsfeed/icon/share.svg"
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
                                    <a class="avatar-friend" href="{{url('user/userprofile/'.$nofriend->id)}}">
                                        
                                        @if ($nofriend->avatar)<img src="{{URL::asset('images/'.$nofriend->avatar)}}" alt="Default">
                                        @else <img src="{{URL::asset('images/jone-doe.jpg')}}" alt="Default">
                                        @endif
                                    </a>
                                    <span class="name">{{$nofriend->username}}</span>
                                @endforeach
                            </ul>
                        </section>
                    </div>

                </div>
            </section>
        </div>
        <input type="hidden" id="loggedUserId" value="{{ $user->id }}">
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://js.pusher.com/4.3/pusher.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- Pusher display friendrequest
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
                    alert(data.message);
                            });
    </script> --}}

    {{-- Ajax request make friend --}}
    <script>
        
        $(document).on('click', '.friend-button', function(e) {
        e.preventDefault();

        var button = $('.friend-button');
        var status = button.data('status');
        var friendId = button.data('id');

        if (status === 'add') {
        
            // Thực hiện Ajax request kết bạn ở đây
            $.ajax({
                
                url: "{{url('add-friend')}}",
                method: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'friend_id': friendId
                },
                success: function(response) {
                    // Cập nhật trạng thái của nút thành 'cancel'
                    button.data('status', 'cancel');
                     button.html('<i class="fas fa-solid fa-xmark" style="font-size: 30px"></i>');
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
            } 
        else if (status === 'cancel') {
                // alert(friendId);
                // Thực hiện Ajax request hủy yêu cầu kết bạn ở đây
                $.ajax({
                    
                    url: "{{ url('cancel-friend-request') }}",
                    method: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'friend_id': friendId
                    },
                    success: function(response) {
                        // Cập nhật trạng thái của nút thành 'add'
                        button.data('status', 'add');
                        button.html(' <i class="fas fa-solid fa-user-plus friended" style="font-size: 30px"></i>');
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });
        }
        else if (status === 'accept') {
                // alert(friendId);
                // Thực hiện Ajax Accept yêu cầu kết bạn ở đây
                $.ajax({
                    
                    url: "{{ url('accept-friend-request') }}",
                    method: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'friend_id': friendId
                    },
                    success: function(response) {
                        //Remove button after change the other button
                        $('#btnreject').remove();
                        // Cập nhật trạng thái của nút thành 'add'
                        button.data('status', 'remove');
                        button.html(' <i class="fas fa-solid fa-user-minus friended" style="font-size: 30px"></i>');
                        
                      
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });
        }
        else if (status === 'reject') {
            $('#btnaccept').remove();
                // // Thực hiện Ajax Reject yêu cầu kết bạn ở đây
                // $.ajax({
                    
                //     url: "{{ url('reject-friend-request') }}",
                //     method: 'POST',
                //     data: {
                //         "_token": "{{ csrf_token() }}",
                //         'friend_id': friendId
                //     },
                //     success: function(response) {
                //         //Remove button after change the other button
                //         $('#btnaccept').remove();
                //         // Cập nhật trạng thái của nút thành 'add'
                //         button.data('status', 'add');
                //         button.html(' <i class="fas fa-solid fa-user-plus friended" style="font-size: 30px"></i>');
                        
                //     },
                //     error: function(xhr, status, error) {
                //         console.log(xhr.responseText);
                //     }
                // });
        }
        else if (status === 'remove') {
                // alert(friendId);
                // Thực hiện Ajax remove friend tai day 
             if(confirm("Are you sure?")){
                $.ajax({
                    
                    url: "{{ url('remove-friend') }}",
                    method: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'friend_id': friendId
                    },
                    success: function(response) {
                        // Cập nhật trạng thái của nút thành 'add'
                        button.data('status', 'add');
                        button.html(' <i class="fas fa-solid fa-user-plus friended" style="font-size: 30px"></i>');
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });
             }
              else {
                alert("You are still Friends!!! Congratulations");
              }  
            }
        });
    </script>
 
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
    <script>
        let listUser = JSON.parse($('#listUsers').val())
        let valueInput = '';
        let elemenLi = '';
    
        listUser.map((item) => {
            elemenLi += `<li style='display:flex; flex-direction:column;align-items: center'>
                <div>
                    <a style='text-decoration: none;' class="avatar-friend" href="${item.id}">
                        <img src="{{URL::asset('images')}}/${item.avatar ? item.avatar : 'jone-doe.jpg'}">
                    </a>
                    <span class="name">${item.username}</span>
                </div>
            </li>`;
        });
    
        $('#listUser-inModal').html(elemenLi);
    
        $("#modal-search-user").keyup(function () {
            elemenLi = '';
            valueInput = $("#modal-search-user").val();
            newListUser = listUser.filter((item) => item.username.toLowerCase().search(valueInput.toLowerCase()) !== -1);
    
            newListUser.length !== 0 ?
                newListUser.map((item) => {
                    elemenLi += `<li style='display:flex; flex-direction:column;align-items: center'>
                        <div>
                            <a style='text-decoration: none;' class="avatar-friend" href="${item.id}">
                                <img src="{{URL::asset('images')}}/${item.avatar ? item.avatar : 'jone-doe.jpg'}">                            </a>
                            <span class="name">${item.username}</span>
                        </div>
                    </li>`;
                })
                : elemenLi += `<li>No user</li>`;
    
            $('#listUser-inModal').html(elemenLi);
        });
    </script>
</html>


