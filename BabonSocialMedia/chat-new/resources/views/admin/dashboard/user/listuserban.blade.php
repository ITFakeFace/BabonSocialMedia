@extends('admin.dashboard.layoutAdmin.layout')
@section('title', 'List user banned')
@section('content')
   <!-- Content Header (Page header) -->
   <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">List User Be Banned</h1>
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
                        <h3 class="card-title">You can see list user be banned</h3>
                    </div>
                    {{--xuat status--}}
                    @if (session('status'))
                    <div class="alert alert-success">
                      {{session('status')}}
                    </div>
                    @endif
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-bordered table-hover display" id="users" class="display">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Active/Deactive</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $u)
                            <tr>
                                <td>{{ $u->id }}</td>
                                <td>{{ $u->username }}</td>
                                <td>{{ $u->email }}</td>
                                <td>
                                    @if($u->status == '0')
                                      <label for="" class="py-2 px-3 btn-success">Active</label>
                                    @elseif($u->status == '1')
                                    <label for="" class="py-2 px-3 btn-danger">Deactive</label>
                                    @endif
                                </td>
                                <td class="text-right">
                                    <a class="btn btn-primary btn-sm" href="{{ url('admin/dashboard/user/viewuserprofile/'.$u->id) }}">
                                        <i class="fas fa-eye"></i> View profile
                                    </a>
                                    <a id="isBan" class="btn btn-danger btn-sm" href="{{ url('admin/dashboard/user/listuser/'.$u->id)  }}">
                                        <i class="fas fa-ban"></i> Ban/Unban
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
        $("#users").DataTable();
    });
  </script>
@endsection