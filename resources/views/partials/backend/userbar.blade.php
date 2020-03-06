<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fas fa-language" style="font-size: 1.5em;"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="{{ url('locale/en') }}" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="{{asset('backend/dist/img/flag-english.png')}}" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  @lang('messages.english')
                  <span class="float-right text-sm @if(app()->getLocale() == 'en'): text-danger @else text-muted @endif"><i class="fas fa-star"></i></span>
                </h3>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="{{ url('locale/es') }}" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="{{asset('backend/dist/img/flag-spanish.png')}}" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  @lang('messages.spanish')
                  <span class="float-right text-sm @if(app()->getLocale() == 'es'): text-danger @else text-muted @endif"><i class="fas fa-star"></i></span>
                </h3>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
        </div>
      </li>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="{{route('logout')}}" onclick="event.preventDefault();
        document.getElementById('logout-form').submit();">
          <i class="fas fa-power-off" style="font-size: 1.5em;"></i>
        </a>
        <form id="logout-form" action="{{route('logout')}}" method="POST" style="display: none;">
            @csrf                                    </form>
      </li>
</ul>

    </ul>
</nav>
<!-- /.navbar -->
