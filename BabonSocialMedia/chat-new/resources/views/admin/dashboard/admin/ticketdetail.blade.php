@extends('admin.dashboard.layoutAdmin.layout')
@section('title', 'Ticket details')
@section('content')
   <!-- Content Header (Page header) -->
   <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Ticket Details</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                    @if (session('status'))
                    <div class="alert alert-success">
                      {{session('status')}}
                    </div>
                    @endif
                        <h5 class="card-title"><span class="font-weight-bold">Title: </span>{{$ticket->title}}</h5>
                        <p><span class="font-weight-bold">From:</span>{{$ticket->users->username}}</p>
                        <p><span class="font-weight-bold">Email:</span>{{$ticket->users->email}}</p>
                        <div class="row">
                        <p class="col-6"><span class="font-weight-bold">Priority:</span>@if($ticket->priority == 'high')
                                      <label for="" class="py-2 px-3 btn btn-outline-danger">High</label>
                                    @elseif($ticket->priority == 'normal')
                                       <label for="" class="py-2 px-3 btn btn-outline-warning">Normal</label>
                                    @elseif($ticket->priority == 'low')
                                    <label for="" class="py-2 px-3 btn btn-outline-success">Low</label>
                                    @endif
                        </p>
                        <p class="col-6"><span class="font-weight-bold">Categorize: </span>{{$ticket->categorize}}</p>
                        </div>
                        <span class="font-weight-bold">Content:</span><p>{{$ticket->content}}</p>
                        <div>
                            @if ($ticket->image_bug)
                            <p><strong>Image:</strong></p>
                            <img src="{{ asset('images/error/' . $ticket->image_bug) }}" alt="Bug Image" width="150px" height="150px">
                            @endif
                        </div>
                        <span class="font-weight-bold">Answer:</span>@if($ticket->answer == '')
                                      <div for=""></div>
                                    @else
                                     <div for="">{{$ticket->answer}}</div>
                                    @endif
                    </div>
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <div class="ml-3">
    <h3 class="m-0">Solve problem</h3>
    <form action="{{ route('admin.answerTicket') }}" method="post" enctype="multipart/form-data" >
            @csrf
            <div class="form-group">
              <label for="inputMessage">Answer:</label>
              <textarea id="inputMessage" class="form-control" rows="4" name="answer"></textarea>
              <input type="text" value="{{ $ticket->id }}" style="display:none" name="id">
            </div>
            <div class="form-group">
              <input type="submit" class="btn btn-primary" value="Send answer">
              <button type="button" class="btn btn-alert"><a href="{{ route('admin.dashboard.listticket') }}">Back</a></button>
            </div>
          </div>
          </form>
    </div>

    <!-- /.content -->
@endsection