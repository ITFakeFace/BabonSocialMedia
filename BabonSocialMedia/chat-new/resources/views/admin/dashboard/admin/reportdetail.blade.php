@extends('admin.dashboard.layoutAdmin.layout')
@section('title', 'Ticket details')
@section('content')
   <!-- Content Header (Page header) -->
   <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Report Details</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="row">
        <div class="col-6">
          <div class="post">
            <div class="post-header">
               <img src="{{ asset('images/'.$post->users->avatar) }}" alt="Profile Picture" style="object-fit:cover">
                <div class="post-info">
                <h2>{{$post->users->username}}</h2>
                <p>Posted on {{ date('d M. Y', strtotime($post->created_at)) }}</p>
                </div>
            </div>
            <div class="post-content">
               <p>{!! $post->content !!}</p>
            @if($post->file == null)
            <img src="post-image.jpg" alt="Post Image" style="display: none;">
            @else
                    <img src="{{asset('upload/post/'.$post->file)}}" alt="Post Image">
            @endif
            </div>
          </div>
          <div class="row">
            <div class="col-6">
            <a href="{{ url('admin/dashboard/admin/reportdetail/ban/'.$post->users->id)  }}" class="btn btn-danger btn-block"><b>Ban</b></a>
            </div>
            <div class="col-6">
            <a href="{{ url('admin/dashboard/admin/reportdetail/delete/'.$post->id)  }}" class="btn btn-danger btn-block"><b>Delete post</b></a>
            </div>
          </div>

        </div>

        <div class="col-6">
            <label for="reports" class="font-weight-bold">Reports:</label>
              @foreach($post->reports as $report)
               <div>User report: {{ $report->users->username }}</div>
               <div>Report Title: {{ $report->title }}</div>
               <div>Report Content: {{ $report->content }}</div>
               <hr>
              @endforeach
        </div>
        </div>
    </section>
    <style>
        .post {
  border: 1px solid #ccc;
  padding: 10px;
  margin-bottom: 20px;
}

.post-header {
  display: flex;
  align-items: center;
  margin-bottom: 10px;
}

.post-header img {
  width: 50px;
  height: 50px;
  border-radius: 50%;
  margin-right: 10px;
}

.post-info h2 {
  font-size: 18px;
  margin: 0;
}

.post-info p {
  font-size: 14px;
  margin: 0;
  color: #999;
}

.post-content img {
  max-width: 100%;
  margin-bottom: 10px;
}

.post-actions a {
  margin-right: 10px;
  color: #999;
  text-decoration: none;
}

.post-actions a:hover {
  color: #333;
}
    </style>
    <!-- /.content -->
@endsection
