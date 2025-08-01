@extends('admin.dashboard.layoutAdmin.layout')
@section('title', 'List ticket')
@section('content')
   <!-- Content Header (Page header) -->
   <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">List Ticket</h1>
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
                        <h3 class="card-title">You can see list ticket</h3>
                    </div>

                    {{--xuat status--}}
                    @if (session('status'))
                    <div class="alert alert-success">
                      {{session('status')}}
                    </div>
                    @endif
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="ticket" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>User_id</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Priority</th>
                                <th>Categorize</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($tickets as $t)
                            <tr>
                                <td>{{ $t->id }}</td>
                                <td>{{$t->user_id}}</td>
                                <td>{{$t->users->username}}</td>
                                <td>{{$t->users->email}}</td>
                                <td>@if($t->priority == 'high')
                                      <label for="" class="py-2 px-3 btn btn-outline-danger">High</label>
                                    @elseif($t->priority == 'normal')
                                       <label for="" class="py-2 px-3 btn btn-outline-warning">Normal</label>
                                    @elseif($t->priority == 'low')
                                    <label for="" class="py-2 px-3 btn btn-outline-success">Low</label>
                                    @endif</td>
                                <td>{{ $t->categorize }}</td>
                                <td>@if($t->status == '0')
                                      <label for="" class="py-2 px-3 btn-danger">Pending</label>
                                    @elseif($t->status == '1')
                                       <label for="" class="py-2 px-3 btn-success">Done</label>
                                    @endif
                                </td>
                                <td class="text-right">
                                    <a class="btn btn-primary btn-sm" href="{{ url('admin/dashboard/admin/ticketdetail/'.$t->id) }}">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                    <a class="btn btn-danger btn-sm" href="{{ url('admin/dashboard/admin/listticket/'.$t->id) }}" onclick="return confirm('Do you want to change status ticket?')">
                                        <i class="fas fa-trash"></i>Done
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>

    <!-- /.content -->
@endsection

@section('script-content')
  <script>
        $(document).ready(function(){
        $("#ticket").DataTable();
    });
  </script>
@endsection