<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="{{ route('home') }}" class="brand-link">
    <img src="{{URL::asset('/theme/dist/images/logo.png')}}" alt="Sanfinity Logo" class="brand-image">
  </a>
  @php
  $img="Admin/no_preview.jpg";
  $tmp = Auth::user()->Image;
  $filename =  public_path('Users/'. $tmp);
  if($tmp != '' && file_exists($filename))
  {
      $img='Users/'.$tmp;
  }
  $role = Auth::user()->Role;
 @endphp
  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="{{ URL::asset($img) }}" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block">{{ ucfirst(Auth::user()->first_name).' '.ucfirst(Auth::user()->last_name) }}</a>
      </div>
    </div>

    
    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
              with font-awesome or any other icon font library -->
        <li class="nav-item">
          <a href="{{ route('home') }}" class="nav-link nav-link {{ request()->is('home*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Dashboard
            </p>
          </a>
        </li>
        @if($role == 1 || $role == 5 || $role == 4)
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-edit"></i>
            <p>
              Masters
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            @if($role == 4 || $role == 1 )
            <li class="nav-item">
              <a href="{{ route('role.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Role Master</p>
              </a>
            </li>
            <!-- <li class="nav-item">
              <a href="{{ route('Module.new.creates') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Module Master</p>
              </a>
            </li> -->
            @endif
            @if($role == 1 || $role == 5 || $role == 4)
            <li class="nav-item">
              <a href="{{ route('companies.index') }}" class="nav-link {{ request()->is('companies*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Company Master</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('unit.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Unit Master</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('departments.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Department Master</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('vendors.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Vendor Master</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('user.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>User Master</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('equipment.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Equipment Master</p>
              </a>
            </li>
            </li>
            <li class="nav-item">
              <a href="{{ route('task.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Task Master</p>
              </a>
            </li>
            @endif
          </ul>
        </li>
        @endif
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-book"></i>
            <p>
            Maintenance
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            @if($role == 3 || $role == 1|| $role == 4)
            <li class="nav-item">
              <a href="{{ route('plan.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Define Preventive Plan</p>
              </a>
            </li>
            @endif
            @if($role == 2 || $role == 4 || $role == 1)
            <li class="nav-item">
              <a href="{{ route('reactive_maintenance.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Reactive Maintenance</p>
              </a>
            </li>
            @endif
          </ul>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-columns"></i>
            <p>
              Report
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('reactivereports.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Reactive Maintenance</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('pmreports.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Preventive Maintenance</p>
              </a>
            </li>
          </ul>
        </li>
        
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>