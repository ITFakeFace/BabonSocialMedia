@extends('admin.dashboard.layoutAdmin.layout')
@section('title', 'List report')
@section('content')
   <!-- Content Header (Page header) -->
   <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">List Report</h1>
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
                        <h3 class="card-title">You can see list report</h3>
                    </div>

                    {{--xuat status--}}
                    @if (session('status'))
                    <div class="alert alert-success">
                      {{session('status')}}
                    </div>
                    @endif
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="report" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>User_id reported</th>
                                <th>Username reported</th>
                                <th>Post_id be reported</th>
                                <th>Post be reported</th>
                                <th>Title report</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($reports as $r)
                            <tr>
                                <td>{{ $r->id }}</td>
                                <td>{{$r->user_id}}</td>
                                <td>{{$r->users->username}}</td>
                                <td>{{$r->post_id}}</td>
                                <td>{!! $r->posts->content !!}</td>
                                <td>{{$r->title}}</td>
                                <td>@if($r->status == '0')
                                      <label for="" class="py-2 px-3 btn-danger">Pending</label>
                                    @elseif($r->status == '1')
                                       <label for="" class="py-2 px-3 btn-success">Done</label>
                                    @endif
                                </td>
                                <td class="text-right">
                                    <a class="btn btn-primary btn-sm" href="{{ url('admin/dashboard/admin/reportdetail/'.$r->id) }}">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                    <a class="btn btn-danger btn-sm" href="{{ url('admin/dashboard/admin/listreport/'.$r->id)}}" onclick="return confirm('Do you want to change status report?')">
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
        $("#report").DataTable();
    });
  </script>
@endsection