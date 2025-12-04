<div class="az-header">
  <div class="container">
    <div class="az-header-left">
      <a href="index.html" class="az-logo"><img src="{{ asset('assets/img/logo/atpr.png')}}" alt="" height="50px" /></a>
      <a href="#" id="azMenuShow" class="az-header-menu-icon d-lg-none"><span></span></a>
    </div><!-- az-header-left -->
    <div class="az-header-menu">
      <div class="az-header-menu-header">
        <a href="index.html" class="az-logo"><img src="{{ asset('assets/img/logo/atpr.png')}}" alt="" height="50px" /></a>
        <a href="#" class="close">&times;</a>
      </div><!-- az-header-menu-header -->
      <ul class="nav">
        @if(auth()->user()->type == 'admin')
        <li class="nav-item">
          <a href="{{ route('admin.home') }}" class="nav-link">Dashboard</a>
        </li>
        @elseif(auth()->user()->type == 'manager')
        <li class="nav-item">
          <a href="{{ route('manager.home') }}" class="nav-link">Dashboard</a>
        </li>
        @else
        <li class="nav-item">
          <a href="{{ route('driver.index') }}" class="nav-link">Dashboard</a>
        </li>
        @endif
        <li class="nav-item">
          <a href="{{ route('member.index')}}" class="nav-link"><span>Members List</span></a>
        </li>
        <li class="nav-item">
          <a href="{{ route('admin.users')}}" class="nav-link"><span>Staff users</span></a>
        </li>
        <li class="nav-item">
          <a href="{{ route('admin.create')}}" class="nav-link"><span>Add Driver</span></a>
        </li>
        <li class="nav-item">
          <a href="{{ route('admin.index')}}" class="nav-link"><span>Driver</span></a>
        </li>
        <li class="nav-item">
          <a href="{{ route('member.report')}}" class="nav-link"><span>Members Report</span></a>
        </li>
      </ul>
    </div><!-- az-header-menu -->
    <div class="az-header-right">
      <div class="az-header-message">
        <a href="app-chat.html"><i class="typcn typcn-messages"></i></a>
      </div><!-- az-header-message -->
      <div class="dropdown az-header-notification">
        <a href="#" class="new"><i class="typcn typcn-bell"></i></a>
        <div class="dropdown-menu">
          <div class="az-dropdown-header mg-b-20 d-sm-none">
            <a href="#" class="az-header-arrow"><i class="icon ion-md-arrow-back"></i></a>
          </div>
          <h6 class="az-notification-title">Notifications</h6>
          <p class="az-notification-text">You have 2 unread notification</p>
          <div class="az-notification-list">
            <div class="media new">
              <div class="az-img-user"><img src="../img/faces/face2.jpg" alt=""></div>
              <div class="media-body">
                <p>Congratulate <strong>Socrates Itumay</strong> for work anniversaries</p>
                <span>Mar 15 12:32pm</span>
              </div><!-- media-body -->
            </div><!-- media -->
            <div class="media new">
              <div class="az-img-user online"><img src="../img/faces/face3.jpg" alt=""></div>
              <div class="media-body">
                <p><strong>Joyce Chua</strong> just created a new blog post</p>
                <span>Mar 13 04:16am</span>
              </div><!-- media-body -->
            </div><!-- media -->
            <div class="media">
              <div class="az-img-user"><img src="../img/faces/face4.jpg" alt=""></div>
              <div class="media-body">
                <p><strong>Althea Cabardo</strong> just created a new blog post</p>
                <span>Mar 13 02:56am</span>
              </div><!-- media-body -->
            </div><!-- media -->
            <div class="media">
              <div class="az-img-user"><img src="../img/faces/face5.jpg" alt=""></div>
              <div class="media-body">
                <p><strong>Adrian Monino</strong> added new comment on your photo</p>
                <span>Mar 12 10:40pm</span>
              </div><!-- media-body -->
            </div><!-- media -->
          </div><!-- az-notification-list -->
          <div class="dropdown-footer"><a href="#">View All Notifications</a></div>
        </div><!-- dropdown-menu -->
      </div><!-- az-header-notification -->
      <div class="dropdown az-profile-menu">
        <a href="#" class="az-img-user"><img src="{{ asset('assets/src/img/faces/face1.jpg') }}" alt=""></a>
        <div class="dropdown-menu">
          <div class="az-dropdown-header d-sm-none">
            <a href="#" class="az-header-arrow"><i class="icon ion-md-arrow-back"></i></a>
          </div>
          <div class="az-header-profile">
            <div class="az-img-user">
              <img src="{{ asset('assets/src/img/faces/face1.jpg') }}" alt="">
            </div><!-- az-img-user -->
            <h6>{{ Auth::user()->name }}</h6>
            <span>{{ Auth::user()->type }}</span>
          </div><!-- az-header-profile -->
          <a href="#" class="dropdown-item"><i class="typcn typcn-cog-outline"></i> Account Settings</a>
          <a href="#" class="dropdown-item"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="typcn typcn-power-outline"></i> Sign Out
          </a>

          <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
          </form>

        </div><!-- dropdown-menu -->
      </div>
    </div><!-- az-header-right -->
  </div><!-- container -->
</div><!-- az-header -->