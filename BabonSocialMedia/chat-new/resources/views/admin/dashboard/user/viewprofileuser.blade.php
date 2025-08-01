@extends('admin.dashboard.layoutAdmin.layout')
@section('title', 'List user')
@section('css')
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href=" {{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">

                <!-- Profile Image -->
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img class=" rounded-circle"
                                 src="{{ asset('images/'.$user->avatar) }}"
                                 alt="User profile picture"
                                 style="width: 125px; height: 125px; border-radius: 50%; border: 3px solid #adb5bd;">
                        </div>

                        <h3 class="profile-username text-center">{{$user->username}}</h3>

                        <p class="text-muted text-center">{{ $user->description }}</p>

                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>Post</b> <a class="float-right">{{ $totalPosts }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Ticket</b> <a class="float-right">{{ $totalTickets }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Report</b> <a class="float-right">{{ $totalReports }}</a>
                            </li>
                        </ul>

                        <a href="{{ url('admin/dashboard/user/listuser/'.$user->id)  }}" class="btn btn-danger btn-block"><b>Ban</b></a>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->

            </div>
            <!-- /.col -->
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard.listuser') }}">< Back</a></li>
                            <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Activity</a></li>
                            <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Ticket support</a></li>
                            <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Report</a></li>
                        </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="active tab-pane" id="activity">
                                <!-- Post -->
                                @foreach($posts as $post)
                                    <div class="post">
                                        <div class="user-block">
                                            <img class="img-circle img-bordered-sm" src="{{ asset('images/'.$post->users->avatar) }}" alt="user image">
                                            <span class="username">
                          <a href="#">{{$post->users->username}}</a>
                        </span>
                                            <span class="description"> {{ date('H:i', strtotime($post->created_at)) }}</span>
                                        </div>
                                        <!-- /.user-block -->
                                        <p>
                                        {!! $post-> content !!}
                                        <div>
                                            @if($post->file == null)
                                                <img src="{{ asset('upload/post/'.$post->file) }}" alt="Image post" width="150px" height="150px" style="display:none">
                                            @else
                                                <img src="{{ asset('upload/post/'.$post->file) }}" alt="Image post" style="height:20%; width: 50%">
                                            @endif
                                        </div>
                                        </p>
                                    </div>
                                @endforeach
                                <!-- /.post -->
                            </div>
                            <!-- /.tab-pane -->
                            <div class="tab-pane" id="timeline">
                                <div class="timeline timeline-inverse">
                                    @foreach ($ticket as $ticket)
                                        <div class="time-label">
                                            <span class="bg-danger">{{ date('d M. Y', strtotime($ticket->created_at)) }}</span>
                                        </div>
                                        <div>
                                            <i class="fas fa-ticket-alt bg-primary"></i>

                                            <div class="timeline-item">
                                                <span class="time"><i class="far fa-clock"></i> {{ date('H:i', strtotime($ticket->created_at)) }}</span>

                                                <h3 class="timeline-header"><a href="#">{{ $ticket->users->username }}</a> created a new ticket</h3>

                                                <div class="timeline-body">
                                                    <p><strong>Title:</strong> {{ $ticket->title }}</p>
                                                    <p><strong>Priority:</strong>
                                                        @if($ticket->priority == 'high')
                                                            <label for="" class="py-2 px-3 btn btn-outline-danger">High</label>
                                                        @elseif($ticket->priority == 'normal')
                                                            <label for="" class="py-2 px-3 btn btn-outline-warning">Normal</label>
                                                        @elseif($ticket->priority == 'low')
                                                            <label for="" class="py-2 px-3 btn btn-outline-success">Low</label>
                                                        @endif</p>
                                                    <p><strong>Category:</strong> {{ $ticket->categorize }}</p>
                                                    <p><strong>Content:</strong> {{ $ticket->content }}</p>
                                                    @if ($ticket->image_bug)
                                                        <p><strong>Image:</strong></p>
                                                        <img src="{{ asset('images/error/' . $ticket->image_bug) }}" alt="Bug Image" width="150px" height="150px">
                                                    @endif
                                                </div>

                                                <div class="timeline-footer">
                                                    <a href="{{url('admin/dashboard/admin/ticketdetail/'.$ticket->id)}}" class="btn btn-primary btn-sm">View ticket</a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <!-- END timeline item -->
                            <!-- timeline item -->

                            <div class="tab-pane" id="settings">
                                <div class="timeline timeline-inverse">
                                    @foreach ($report as $report)
                                        <div class="time-label">
                                            <span class="bg-danger">{{ date('d M. Y', strtotime($report->created_at)) }}</span>
                                        </div>
                                        <div>
                                            <i class="fas fa-ticket-alt bg-primary"></i>

                                            <div class="timeline-item">
                                                <span class="time"><i class="far fa-clock"></i> {{ date('H:i', strtotime($report->created_at)) }}</span>

                                                <h3 class="timeline-header"><a href="#">{{ $report->users->username }}</a> created a new report</h3>

                                                <div class="timeline-body">
                                                    <p><strong>Title:</strong> {{ $report->title }}</p>
                                                    <p><strong>Content:</strong> {{ $report->content }}</p>
                                                </div>

                                                <div class="timeline-footer">
                                                    <a href="{{url('admin/dashboard/admin/reportdetail/'.$report->id)}}" class="btn btn-primary btn-sm">View report</a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div><!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
    @endsection

    @section('script-content')
        </script>
    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js')}}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.min.js')}}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('dist/js/demo.js')}}"></script>
@endsection
