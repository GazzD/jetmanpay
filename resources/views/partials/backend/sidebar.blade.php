<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="{{asset('backend/dist/img/logo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Jet Man Pay</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset('backend/dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Alexander Pierce</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item has-treeview menu-open">
            <a href="{{route('dashboard')}}" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                @lang('messages.sidebar.dashboard')
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                @lang('messages.sidebar.users')
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="pages/layout/top-nav.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>@lang('messages.sidebar.operators')</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="{{route('payments')}}" class="nav-link">
              <i class="nav-icon fas fa-money-check-alt"></i>
              <p>
                @lang('messages.sidebar.payments')
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview">
            <a href="{{route('pending-payments')}}" class="nav-link">
              <i class="nav-icon fas fa-exclamation-triangle"></i>
              <p>
                @lang('messages.sidebar.pending-payments')
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-file-import"></i>
              <p>
                @lang('messages.sidebar.send-payments')
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="pages/UI/general.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>@lang('messages.sidebar.by-airline')</p>
                </a>
              </li>
              <li class="nav-item">
              <a href="{{route('manual-payments')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>@lang('messages.sidebar.manual')</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-exclamation"></i>
              <p>
                @lang('messages.sidebar.claims')
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-cog"></i>
              <p>
                @lang('messages.sidebar.settings')
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('documents')}}" class="nav-link">
              <i class="nav-icon fas fa-file-alt"></i>
              <p>
                @lang('messages.sidebar.documents')
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('load-json')}}" class="nav-link">
              <i class="nav-icon fas fa-file-alt"></i>
              <p>
                @lang('messages.upload-json.upload-file')
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
