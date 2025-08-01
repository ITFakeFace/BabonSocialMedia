@php
    $countTicket = App\Models\Ticket::where('status', 0)->count();
    $countReport = App\Models\Report::where('status', 0)->count();
    $ticket = App\Models\Ticket::all();
    $reports = App\Models\Report::all();
@endphp

<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow" style="margin-left: 225px;">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>


    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
        <li class="nav-item dropdown no-arrow d-sm-none">
            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
            </a>
            <!-- Dropdown - Messages -->
            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                 aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                    <div class="input-group">
                        <input type="text" class="form-control bg-light border-0 small"
                               placeholder="Search for..." aria-label="Search"
                               aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li>

        <!-- Nav Item - Alerts -->
        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell "></i>
                <!-- Counter - Alerts -->
                <span class="badge badge-danger badge-counter">{{ $countTicket }}</span>
            </a>
            <!-- Dropdown - Alerts -->
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                 aria-labelledby="alertsDropdown" style="max-height:500px">
                <h6 class="dropdown-header">
                    Tickets Center
                </h6>
                @foreach ($ticket as $ticket)
                    <a class="dropdown-item d-flex align-items-center" href="{{ url('admin/dashboard/admin/ticketdetail/'.$ticket->id) }}">
                        <div class="mr-3">

                            @if($ticket->categorize == "bug")
                                <div class="icon-circle bg-warning">
                                    <i class="fas fa-file-alt text-white"></i>
                                </div>
                            @elseif($ticket->categorize == "question")
                                <div class="icon-circle bg-primary">
                                    <i class="fas fa-exclamation-triangle text-white"></i>
                                </div>
                            @elseif($ticket->categorize == "other")
                                <div class="icon-circle bg-success">
                                    <i class="fas fa-exclamation-triangle text-white"></i>
                                </div>
                            @endif

                        </div>
                        <div>
                            @if($ticket->status == "0")
                                <div class="small text-gray-500">{{ date('d M. Y', strtotime($ticket->created_at)) }}</div>
                                <span class="font-weight-bold">{{$ticket->users->username}}</span>
                                <div class="font-weight-bold">{{ $ticket->title }}</div>
                            @elseif($ticket->status == "1")
                                <div class="small text-gray-500">{{ date('d M. Y', strtotime($ticket->created_at)) }}</div>
                                <span>{{$ticket->users->username}}</span>
                                <div>{{ $ticket->title }}</div>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        </li>

        <!-- Nav Item - Messages -->
        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-envelope fa-fw"></i>
                <!-- Counter - Messages -->
                <span class="badge badge-danger badge-counter">{{ $countReport }}</span>
            </a>
            <!-- Dropdown - Messages -->
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                 aria-labelledby="messagesDropdown">
                <h6 class="dropdown-header">
                    Report Center
                </h6>
                @foreach($reports as $report)
                    <a class="dropdown-item d-flex align-items-center" href="{{ url('admin/dashboard/admin/reportdetail/'.$report->id) }}">
                        <div class="dropdown-list-image mr-3">
                            <img class="rounded-circle" src="{{asset('images/'.$report->users->avatar) }}"
                                 alt="...">
                        </div>
                        <div>
                            @if($report->status == "0")
                                <div class="small text-gray-500">{{ date('d M. Y', strtotime($report->created_at)) }}</div>
                                <span class="font-weight-bold">{{$report->users->username}}</span>
                                <div class="font-weight-bold">{{ $report->title }}</div>
                            @elseif($report->status == "1")
                                <div class="small text-gray-500">{{ date('d M. Y', strtotime($report->created_at)) }}</div>
                                <span>{{$report->users->username}}</span>
                                <div>{{ $report->title }}</div>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        </li>

        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{Auth::user()->username}} (Admin) </span>
                <img class="img-profile rounded-circle"
                     src="{{ asset('images/'.Auth::user()->avatar) }}" style="object-fit:cover">
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                 aria-labelledby="userDropdown">
                <a class="dropdown-item" href="{{ url('user/editprofile/' .Auth::user()->id) }}">
                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                    Settings
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ route('logout.perform') }}">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </li>

    </ul>

</nav>
