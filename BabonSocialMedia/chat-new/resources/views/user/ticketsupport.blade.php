<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Ticket</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
</head>
<body class="hold-transition" style="background-image: url('{{asset('images/BG.png')}}');">
<!-- Site wrapper -->
<div class="content-wrapper" style=" position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); margin: auto; width: 70%">
  <!-- Content Wrapper. Contains page content -->
  <div>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card" style="margin: 0 auto;">
        <div class="card-body row">
          <div class="col-5 text-center d-flex align-items-center justify-content-center">
            <div class="">
                <img src="{{ asset('images/logo-gradient.svg') }}" alt="">
              <h2>Hello {{$user->username}}</h2>
              <p class="lead mb-5">Can we help you ?</p>
            </div>
          </div>
          <div class="col-7">
          <div class="text-center">
            <h1>Ticket support</h1>
            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
            @endif
          </div>
          <form action="{{ route('user.sendTicket') }}" method="post" enctype="multipart/form-data" >
            @csrf
          <div class="form-group">
              <label for="inputName">Title</label>
              <input type="text" id="inputName" class="form-control" name="title"/>
              <input type="text" name="user_id" value="{{$user->id}}" style="display:none">
            </div>
            <div class="form-group">
            <div class="input-group mb-3">
              <label class="input-group-text" for="inputGroupPriority">Priority</label>
                <select class="form-select" id="inputGroupPriority" name="priority">
                  <option selected>Choose...</option>
                  <option value="high">High</option>
                  <option value="normal">Normal</option>
                  <option value="low">Low</option>
                </select>
            </div>
            <div class="form-group">
              <label for="inputSubject">Subject</label><br>
              <input type="checkbox" id="question" name="categorize" value="question">
              <label for="question"> Questions</label><br>
              <input type="checkbox" id="bug" name="categorize" value="bug">
              <label for="bug"> Bug </label><br>
              <input type="checkbox" id="other" name="categorize" value="other">
              <label for="other"> Other</label><br>
            </div>
            <div class="form-group">
              <label for="inputMessage">Images about problem</label>
              <input type="file" name="image_bug">
            </div>
            <div class="form-group">
              <label for="inputMessage">Descriptions about ....</label>
              <textarea id="inputMessage" class="form-control" rows="4" name="content"></textarea>
            </div>
            <div class="form-group">
              <input type="submit" class="btn btn-primary" value="Send ticket">
              <button type="button" class="btn btn-alert"><a href="/">Back</a></button>
            </div>
          </div>
          </form>
        </div>
      </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
</body>
</html>
