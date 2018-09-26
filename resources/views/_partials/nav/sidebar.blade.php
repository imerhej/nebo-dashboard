<!-- Side Navbar -->
<nav class="side-navbar">
        <!-- Sidebar Header-->
        <div class="sidebar-header d-flex align-items-center">
          <div class="avatar">
              <a href="{{route('myaccount.avatar', Auth::user()->id)}}">
            <img src="{{asset ('/uploads/avatars/'.Auth::user()->avatar) }}" alt="..." class="img-fluid rounded-circle">
          </div>
          <div class="title">
            <h1 class="h6">Hi, {{ Auth::user()->firstName }} {{ Auth::user()->lastName }}</h1>
          <p><a href="{{route('myaccount.avatar', Auth::user()->id)}}">Edit</a></p>
          </div>
        </div>
        {{-- <!-- Sidebar Navidation Menus--><span class="heading">Main</span> --}}
        
        <ul class="list-unstyled">           
          {{-- <li class="{{ Request::is('workcenter/workcenter') ? "active" : " " }}">
            <a href="{{route('workcenter.workcenter')}}"> 
              <i class="icon-home"></i>Home </a>
          </li> --}}
          @role(['superadministrator', 'administrator', 'office-manager', 'manager', 'supervisor', 'installer', 'employee'])
          <li class="{{ Request::is('workcenter/messages') ? "active" : " " }}">
            <a href="{{route('messages.index')}}"> 
              <i class="fa fa-inbox"></i>Inbox </a>
          </li>
          @endrole
          @role(['client'])
          <li class="{{ Request::is('workcenter/clients') ? "active" : " " }}">
            <a href="{{route('clients.myproject', Auth::user()->id)}}"> 
              <i class="icon-page"></i>My Projects </a>
          </li>
          @endrole
          @role(['installer'])
          <li class="{{ Request::is('workcenter/myaccount') ? "active" : " " }}">
            <a href="{{route('myaccount.mytasks', Auth::user()->id)}}"> 
              <i class="icon-page"></i>My Task List </a>
          </li>
          @endrole
          <li>
              @role(['superadministrator', 'administrator', 'office-manager', 'manager', 'supervisor'])
            <a href="#projects" aria-expanded="false" data-toggle="collapse"> 
              <i class="icon-grid"></i>Project Manager 
            </a>
            <ul id="projects" class="collapse list-unstyled ">
            <li class="{{ Request::is('workcenter/projects') ? "active" : "" }}">
              <a href="{{route('projects.index')}}">Projects</a>
            </li>
            @endrole
            @role(['superadministrator', 'administrator', 'manager', 'office-manager'])
            <li class="{{ Request::is('workcenter/categories') ? "active" : "" }}">
              <a href="{{route('categories.index')}}">Categories</a>
            </li>
            
            <li class="{{ Request::is('workcenter/rates') ? "active" : "" }}">
              <a href="{{route('rates.index')}}">Project Rates</a>
            </li>

            <li class="{{ Request::is('workcenter/schedule') ? "active" : "" }}">
              <a href="{{route('schedule.index')}}">Schedule</a>
            </li>
            @endrole
              {{-- <li><a href="#">Reports</a></li>
              <li><a href="#">Progress</a></li> --}}
            </ul>
          </li>
          
          @role(['superadministrator', 'administrator', 'manager', 'office-manager'])
        <li class="{{ Request::is('workcenter/calendar') ? "active" : "" }}">
          <a href="{{route('calendar.index')}}"> <i class="fa fa-calendar"></i>Calendar </a>
        </li>
        @endrole
          @role(['superadministrator', 'administrator', 'office-manager'])
          <li>
              <a href="#hrmanagement" aria-expanded="false" data-toggle="collapse"> 
                <i class="icon-grid"></i>HR Management 
              </a>
              <ul id="hrmanagement" class="collapse list-unstyled ">
                <li class="{{ Request::is('workcenter/hrmanagement') ? "active" : "" }}">
                  <a href="{{route('hrmanagement.index')}}">Overview</a>
                </li>
                <li class="{{ Request::is('workcenter/hrmanagement/availability') ? "active" : "" }}">
                  <a href="{{route('hrmanagement.availability')}}">Availability</a>
                </li>
                <li class="{{ Request::is('workcenter/hrmanagement') ? "active" : "" }}">
                  <a href="{{route('hrmanagement.employees')}}">Employees</a>
                </li>
                <li class="{{ Request::is('workcenter/hrmanagement/departments') ? "active" : "" }}">
                  <a href="{{route('hrmanagement.departments')}}">Deparments</a>
                </li>
              </ul>
            </li>

            <li class="{{ Request::is('workcenter/inventory') ? "active" : "" }}">
              <a href="{{route('inventory.index')}}"> <i class="fa fa-truck"></i>Inventory </a>
            </li>
           
            <li><a href="#attendance" aria-expanded="false" data-toggle="collapse"> 
                <i class="icon-page"></i>Attendance 
              </a>
            <ul id="attendance" class="collapse list-unstyled ">
              <li class="{{ Request::is('workcenter/attendance') ? "active" : "" }}">
                <a href="{{route('attendance.index')}}">Timesheet</a>
              </li>
              {{-- <li><a href="#">Timesheet</a></li>
              <li><a href="#">Calendar</a></li> --}}
            </ul>
          </li>
          @endrole
          @role(['superadministrator', 'administrator', 'office-manager'])
          <li class="{{ Request::is('workcenter/clients') ? "active" : "" }}">
            <a href="{{route('clients.index')}}"> <i class="fa fa-users"></i>CRM </a>
          </li>
          
          <li><a href="#leave" aria-expanded="false" data-toggle="collapse"> 
                <i class="icon-close"></i>Request Time Off
              </a>
          <ul id="leave" class="collapse list-unstyled ">
            <li class="{{ Request::is('workcenter/rto') ? "active" : "" }}">
              <a href="{{route('rto.index')}}">Requests</a>
            </li>
            <li class="{{ Request::is('workcenter/rto/calendar') ? "active" : "" }}">  
              <a href="{{route('rto.calendar')}}">Calendar</a>
            </li>
          </ul>
          </li>
          @endrole
          @role(['superadministrator', 'administrator'])
        </ul><span class="heading">Admin area</span>
        <ul class="list-unstyled">
            <li>
                <a href="#settings" aria-expanded="false" data-toggle="collapse"> 
                  <i class="icon-grid"></i>System Settings
                </a>
                <ul id="settings" class="collapse list-unstyled ">
                  <li class="{{ Request::is('workcenter/users') ? "active" : "" }}">
                    <a href="{{route('users.index')}}">Employees / Users</a>
                  </li>
                  <li class="{{ Request::is('workcenter/roles') ? "active" : "" }}">
                    <a href="{{route('roles.index')}}">Roles</a>
                  </li>
                  <li class="{{ Request::is('workcenter/permissions') ? "active" : "" }}">
                    <a href="{{route('permissions.index')}}">Permissions</a>
                  </li>
                  {{-- <li class="{{ Request::is('workcenter/notifications') ? "active" : "" }}">
                  <a href="{{route('notifications.index')}}">Notifications</a>
                  </li> --}}
              </ul>
            </li>
           </ul>
        @endrole
      </nav>
      