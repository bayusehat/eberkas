@php
  use App\Menu;
  use App\Access;

  $menuParent = Menu::where('parent_menu','0')->orderBy('nama_menu','asc')->get();
@endphp
<body id="page-top">

    <nav class="navbar navbar-expand navbar-dark bg-red static-top">
  
      <a class="navbar-brand mr-1" href="{{ url('admin/dashboard') }}">E-Berkas</a>
  
      <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
        <i class="fas fa-bars"></i>
      </button>
  
      <!-- Navbar Search -->
      <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
        <div class="input-group">
          <input type="text" class="form-control" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
          <div class="input-group-append">
            <button class="btn btn-primary" type="button">
              <i class="fas fa-search"></i>
            </button>
          </div>
        </div>
      </form>
  
      <!-- Navbar -->
      <ul class="navbar-nav ml-auto ml-md-0">
        <li class="nav-item dropdown no-arrow mx-1">
          <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-bell fa-fw"></i>
            <span class="badge badge-danger">9+</span>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="alertsDropdown">
            <a class="dropdown-item" href="#">Action</a>
            <a class="dropdown-item" href="#">Another action</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">Something else here</a>
          </div>
        </li>
        <li class="nav-item dropdown no-arrow mx-1">
          <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-envelope fa-fw"></i>
            {{-- <span class="badge badge-danger">7</span> --}}
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="messagesDropdown">
            <a class="dropdown-item" href="#">Action</a>
            <a class="dropdown-item" href="#">Another action</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">Something else here</a>
          </div>
        </li>
        <li class="nav-item dropdown no-arrow">
          <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-user-circle fa-fw"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
            <a class="dropdown-item" href="{{ url('user/change/password') }}">Ganti Password</a>
            {{-- <a class="dropdown-item" href="#">Activity Log</a> --}}
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Logout</a>
          </div>
        </li>
      </ul>
  
    </nav>
  
    <div id="wrapper">
  
      <!-- Sidebar -->
      <ul class="sidebar navbar-nav">
        <li class="nav-item @if($data['parentActive'] == 'home') {{ 'active' }} @else {{ '' }} @endif">
          <a class="nav-link" href="{{ url('/admin/dashboard') }} ">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
          </a>
        </li>
        @foreach ($menuParent as $mp)
            @php
                $checkAccess = Access::where(['id_menu' => $mp->id_menu,'id_role' => session('id_role')])->first();
            @endphp
            @if ($checkAccess)
            <li class="nav-item dropdown @if($data['parentActive'] == $mp->parent_active_menu) {{ 'active show' }} @else {{ '' }} @endif">
            <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="@if($data['parentActive'] == $mp->parent_active_menu) {{ 'true' }} @else {{ 'false' }} @endif">
              <i class="{{ $mp->icon_menu }} fa-fw"></i>
              <span>{{ $mp->nama_menu }}</span>
            </a>
            @php
                $subMenu = Menu::where('parent_menu',$mp->id_menu)->orderBy('nama_menu','asc')->get();
            @endphp
            <div class="dropdown-menu @if($data['parentActive'] == $mp->parent_active_menu) {{ 'show' }} @else {{ '' }} @endif" aria-labelledby="pagesDropdown">
              @foreach ($subMenu as $sm)
                @php
                    $checkAccessSub = Access::where(['id_menu' => $sm->id_menu,'id_role' => session('id_role')])->first();
                @endphp
                @if ($checkAccessSub)
                    <a class="dropdown-item @if($data['urlActive'] == $sm->url_active_menu) {{ 'active' }} @else {{ '' }} @endif" href="{{ url($sm->url_menu) }}">{{ $sm->nama_menu }}</a>
                @endif
              @endforeach
            </div>
          </li>
          @endif
        @endforeach
        
        {{-- <li class="nav-item">
          <a class="nav-link" href="charts.html">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Charts</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="tables.html">
            <i class="fas fa-fw fa-table"></i>
            <span>Tables</span></a>
        </li> --}}
      </ul>
  
      <div id="content-wrapper">
  
        <div class="container-fluid">