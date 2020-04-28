<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('dashboard')}}" class="brand-link">
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
          @if(isset(Auth::user()->client))
            <a href="#" class="d-block">{{Auth::user()->client->name}}</a>
            <a href="#" class="d-block">{{Auth::user()->name}}</a>
            <a href="#" class="d-block">@lang('messages.sidebar.balance') ({{Currency::getSymbol(Auth::user()->client->currency)}})</a>
            <a href="#" class="d-block"> {{Auth::user()->client->balance}}</a>
          @else
            <a href="#" class="d-block">{{Auth::user()->name}}</a>
          @endif
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item has-treeview menu-open">
            <a href="{{route('dashboard')}}" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                @lang('messages.sidebar.dashboard')
              </p>
            </a>
          </li>
          @can('admin-planes')
          <li class="nav-item">
            <a href="{{route('planes')}}" class="nav-link">
              <i class="nav-icon fas fa-plane"></i>
              <p>
                @lang('messages.sidebar.planes')
              </p>
            </a>
         </li>
         @endcan
         @can('admin-recharges')
         <li class="nav-item">
            <a href="{{route('recharges')}}" class="nav-link">
              <i class="nav-icon fas fa-wallet"></i>
              <p>
                @lang('messages.recharges.recharges')
              </p>
            </a>
         </li>
         @endcan
         @can('admin-dosas')
           <li class="nav-item">
             <a href="{{route('dosas/plane')}}" class="nav-link">
               <i class="nav-icon fas fa-money-check-alt"></i>
               <p>
                 @lang('messages.sidebar.dosas')
               </p>
             </a>
           </li>
         @endcan
         {{-- @can('get-approved-dosas') --}}
           <li class="nav-item">
             <a href="{{route('dosas/approved')}}" class="nav-link">
               <i class="nav-icon fas fa-check"></i>
               <p>
                 @lang('messages.sidebar.approved_dosas')
               </p>
             </a>
           </li>
         {{-- @endcan --}}
         @can('admin-users')
           <li class="nav-item">
              <a href="{{route('users')}}" class="nav-link">
                <i class="nav-icon fas fa-users"></i>
                <p>
                  @lang('messages.sidebar.users')
                </p>
              </a>
            </li>
          @endcan
          @can('admin-payments')
            <li class="nav-item">
              <a href="{{route('payments')}}" class="nav-link">
                <i class="nav-icon fas fa-money-check-alt"></i>
                <p>
                  @lang('messages.sidebar.payments')
                </p>
              </a>
            </li>
          @endcan
          @can('admin-pending-payments')
            <li class="nav-item has-treeview">
              <a href="{{route('pending-payments')}}" class="nav-link">
                <i class="nav-icon fas fa-exclamation-triangle"></i>
                <p>
                  @lang('messages.sidebar.pending-payments')
                </p>
              </a>
            </li>
          @endcan
          @can('admin-send-payments')
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-file-import"></i>
                <p>
                  @lang('messages.sidebar.send-payments')
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                @can('admin-payments-by-airline')
                <li class="nav-item">
                  <a href="{{route('payments/filter/plane')}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>@lang('messages.sidebar.by-airline')</p>
                  </a>
                </li>
                @endcan
                @can('admin-payments-manual')
                <li class="nav-item">
                  <a href="{{route('manual-payments')}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>@lang('messages.sidebar.manual')</p>
                  </a>
                </li>
                @endcan
              </ul>
            </li>
          @endcan
          @can('admin-claims')
            <li class="nav-item has-treeview">
              <a href="{{route('claims')}}" class="nav-link">
                <i class="nav-icon fas fa-exclamation"></i>
                <p>
                  @lang('messages.sidebar.claims')
                </p>
              </a>
            </li>
          @endcan
          @can('admin-settings')
            <li class="nav-item has-treeview">
              <a href="{{route('users/profile')}}" class="nav-link">
                <i class="nav-icon fas fa-cog"></i>
                <p>
                  @lang('messages.sidebar.settings')
                </p>
              </a>
            </li>
          @endcan
          @can('admin-documents')
            <li class="nav-item">
              <a href="{{route('documents')}}" class="nav-link">
                <i class="nav-icon fas fa-file-alt"></i>
                <p>
                  @lang('messages.sidebar.documents')
                </p>
              </a>
            </li>
          @endcan
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
