    
  <!-- Main Navbar-->
    <header class="header">
        <nav class="navbar fixed-top">
        <!-- Search Box-->
         <div class="search-box">
            <button class="dismiss"><i class="icon-close"></i></button>
            <form id="searchForm" action="#" role="search">
            <input type="search" placeholder="What are you looking for..." class="form-control">
            </form>
        </div> 
        <div class="container-fluid">
            <div class="navbar-holder d-flex align-items-center justify-content-between">
            <!-- Navbar Header-->
            <div class="navbar-header">
                <!-- Navbar Brand -->
                <a href="{{route('workcenter.workcenter')}}" class="navbar-brand">
                <div class="brand-text brand-big"><span>NeboExpress</span><strong> Workcenter</strong></div>
                <div class="brand-text brand-small"><img src="{{asset('img/nb.png')}}" width="15" height="30" class="img-fluid"></div></a>
                <!-- Toggle Button-->
                <a id="toggle-btn" href="#" class="menu-btn active"><span></span><span></span><span></span></a>
            </div>
            <!-- Navbar Menu -->
            <ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center">
                {{-- <li class="nav-item d-flex align-items-center">
                <a href="{{route('messages.create')}}" class="btn btn-danger btn-sm mr-3">COMPOSE</a>
                </li> --}}
                <!-- Search-->
                <li class="nav-item d-flex align-items-center">
                    {{-- <a id="search" href="#">
                        <i class="icon-search"></i>
                    </a> --}}
                    @role(['superadministrator', 'administrator', 'office-manager'])
                    <form action="{{route('search.index')}}" method="POST" role="search" >
                            {{ csrf_field() }}
                            <div class="input-group">
                                <input type="text" class="form-control" name="search"
                                    placeholder="Search here"> 
                                    {{-- <button type="submit" class="btn btn-default"> --}}
                                            {{-- <i class="icon-search"></i> --}}
                                    {{-- </button> --}}
                                </span>
                            </div>
                        </form>
                        @endrole
                </li>
                @role(['superadministrator', 'administrator', 'office-manager', 'manager', 'employee', 'installer', 'supervisor'])
                <!-- Notifications-->
                <li class="nav-item dropdown"> 
                    <a id="notifications" rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link">
                        <i class="fa fa-tasks"></i>
                    <span class="badge bg-red">{{count(Auth::user()->unreadNotifications)}}</span>
                    </a>
                <ul aria-labelledby="notifications" class="dropdown-menu">
                    @foreach (Auth::user()->unreadNotifications as $notification)
                    <li>
                        <a rel="nofollow" href="{{route('myaccount.mytasks', Auth::user()->id)}}" class="dropdown-item">
                            <div class="notification">
                            <div class="notification-content"><i class="fa fa fa-tasks bg-green"></i>{{$notification->data['tasklist']['tasklistname']}} </div>
                            <div class="notification-time"><small>{{$notification->created_at->diffForHumans()}}</small></div>
                            </div>
                        </a>
                    </li>
                    @endforeach
                    @if (count(Auth::user()->unreadNotifications) == 0)
                    <li><a rel="nofollow" href="#" class="dropdown-item all-notifications text-center"> <strong>no new tasks</strong></a></li>
                    @endif
                    
                </ul>
                </li>
                <!-- Messages -->
                <li class="nav-item dropdown"> 
                    <a id="messages" rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link">
                    <i class="fa fa-envelope-o"></i>
                    <span class="badge bg-orange" id="count">        
                        @foreach ($notSeenMessages as $notSeenMessage) 
                            @if(Auth::user()->id == $notSeenMessage->recipient_id)
                                {{$notSeenMessage->notSeen}}
                            @endif
                        @endforeach
                     {{-- {{(count(Auth::user()->messages->))}} --}}
                    </span>
                    </a>
                <ul aria-labelledby="notifications" class="dropdown-menu">
                        
                        @foreach ($messages as $message)
                        @if (Auth::user()->id == $message->recipient_id)
                        @if($message->seen == 1)
                        
                    <li>
                        <a rel="nofollow" href="{{route('messages.show', $message->id)}}" class="dropdown-item d-flex">
                        <div class="msg-profile"><i class="fa fa-envelope bg-green"></i></div>
                        <div class="msg-body">
                        <h3 class="h5">{{$message->sender}}</h3><span>Sent You Message - {{$message->created_at->diffForHumans()}}</span>
                        </div></a>
                    </li>
                    
                    @endif
                    @endif
                    @endforeach
                    
                   <li><a rel="nofollow" href="{{route('messages.index')}}" class="dropdown-item all-notifications text-center"> <strong>Read all messages    </strong></a></li>
                </ul>
                </li>
                @endrole
                <!-- Profile    -->
                @if (!Auth::guest())
                <li class="nav-item dropdown"> 
                    <a id="profile" rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link">
                        <i class="fa fa-user-o"></i>
                    </a>
                    <ul aria-labelledby="profile" class="dropdown-menu">
                        @role(['client'])
                        <li>
                            <a rel="nofollow" href="{{route('clients.myaccount', Auth::user()->id)}}" class="dropdown-item d-flex">
                                <div class="user-profile"><i class="fa fa-user-o"></i> </div>
                                <div class="user-profile">
                                <h3 class="h4"><span>My Account</span></h3>
                                </div>
                            </a>
                        </li>
                        @endrole
                        @role(['superadministrator', 'administrator', 'office-manager', 'manager', 'employee', 'installer', 'supervisor'])

                            <li>
                                <a rel="nofollow" href="{{route('myaccount.myperformance', Auth::user()->id)}}" class="dropdown-item d-flex">
                                    <div class="user-profile"><i class="fa fa-percent"></i> </div>
                                    <div class="user-profile">
                                    <h3 class="h4"><span>Performance Review</span></h3>
                                    </div>
                                </a>
                            </li>
                            
                            <li>
                                <a rel="nofollow" href="{{route('myaccount.mytasks', Auth::user()->id)}}" class="dropdown-item d-flex">
                                    <div class="user-profile"> <i class="fa fa-cog"></i></div>
                                    <div class="user-profile">
                                    <h3 class="h4"><span>My Tasks</span></h3>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a rel="nofollow" href="{{route('myaccount.index')}}" class="dropdown-item d-flex">
                                    <div class="user-profile"><i class="fa fa-user-o"></i> </div>
                                    <div class="user-profile">
                                    <h3 class="h4"><span>My Account</span></h3>
                                    </div>
                                </a>
                            </li>
                       @endrole
                        <li>
                            <a rel="nofollow" href="{{route('logout')}}" class="dropdown-item d-flex" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                                <div class="user-profile"><i class="fa fa-sign-out"></i> </div>
                                <div class="user-profile">
                                <h3 class="h4"><span>Logout</span></h3>
                                </div>
                            </a>
                            @include('_partials.forms.logout')
                        </li>
                {{-- <li class="nav-item">
                    <a href="#" class="nav-link logout">
                        Logout
                        <i class="fa fa-sign-out"></i>
                    </a>
                </li> --}}
                    </ul>
                </li>
                @endif
            </ul>
            </div>
        </div>
        </nav>
    </header>
    <div class="page-content d-flex align-items-stretch">
