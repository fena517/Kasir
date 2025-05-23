<!-- Navbar Header -->
<nav
class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom"
>
<div class="container-fluid">
  <nav
    class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex"
  >
    <div class="input-group">
      <div class="input-group-prepend">
        <button type="submit" class="btn btn-search pe-1">
          <i class="fa fa-search search-icon"></i>
        </button>
      </div>
      <input
        type="text"
        placeholder="Search ..."
        class="form-control"
      />
    </div>
  </nav>

  <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
    <li
      class="nav-item topbar-icon dropdown hidden-caret d-flex d-lg-none"
    >
      <a
        class="nav-link dropdown-toggle"
        data-bs-toggle="dropdown"
        href="#"
        role="button"
        aria-expanded="false"
        aria-haspopup="true"
      >
        <i class="fa fa-search"></i>
      </a>
      <ul class="dropdown-menu dropdown-search animated fadeIn">
        <form class="navbar-left navbar-form nav-search">
          <div class="input-group">
            <input
              type="text"
              placeholder="Search ..."
              class="form-control"
            />
          </div>
        </form>
      </ul>
    </li>
    <li class="nav-item topbar-icon dropdown hidden-caret">
      <a
        class="nav-link dropdown-toggle"
        href="#"
        id="notifDropdown"
        role="button"
        data-bs-toggle="dropdown"
        aria-haspopup="true"
        aria-expanded="false"
      >
        <i class="fa fa-bell"></i>
        <span class="notification">4</span>
      </a>
      <ul
        class="dropdown-menu notif-box animated fadeIn"
        aria-labelledby="notifDropdown"
      >
        <li>
          <div class="dropdown-title">
            You have new notification
          </div>
        </li>
        <li>
          <div class="notif-scroll scrollbar-outer">
            <div class="notif-center">
              <a href="#">
                <div class="notif-icon notif-primary">
                  <i class="fa fa-user-plus"></i>
                </div>
                <div class="notif-content">
                  <span class="block"> New user registered </span>
                  <span class="time">5 minutes ago</span>
                </div>
              </a>
            </div>
          </div>
        </li>
        <li>
          <a class="see-all" href="javascript:void(0);"
            >See all notifications<i class="fa fa-angle-right"></i>
          </a>
        </li>
      </ul>
    </li>
    <li class="nav-item topbar-icon dropdown hidden-caret">
      <a
        class="nav-link"
        data-bs-toggle="dropdown"
        href="#"
        aria-expanded="false"
      >
        <i class="fas fa-layer-group"></i>
      </a>
      <div class="dropdown-menu quick-actions animated fadeIn">
        <div class="quick-actions-header">
          <span class="title mb-1">Quick Actions</span>
          <span class="subtitle op-7">Shortcuts</span>
        </div>
        <div class="quick-actions-scroll scrollbar-outer">
          <div class="quick-actions-items">
            <div class="row m-0">
              <a class="col-6 col-md-4 p-0" href="#">
                <div class="quick-actions-item">
                  <div class="avatar-item bg-danger rounded-circle">
                    <i class="far fa-calendar-alt"></i>
                  </div>
                  <span class="text">Calendar</span>
                </div>
              </a>
              <a class="col-6 col-md-4 p-0" href="#">
                <div class="quick-actions-item">
                  <div class="avatar-item bg-info rounded-circle">
                    <i class="fas fa-file-excel"></i>
                  </div>
                  <span class="text">Reports</span>
                </div>
              </a>
              <a class="col-6 col-md-4 p-0" href="#">
                <div class="quick-actions-item">
                  <div
                    class="avatar-item bg-secondary rounded-circle"
                  >
                    <i class="fas fa-credit-card"></i>
                  </div>
                  <span class="text">Payments</span>
                </div>
              </a>
            </div>
          </div>
        </div>
      </div>
    </li>

    <li class="nav-item topbar-user dropdown hidden-caret">
      <a
        class="dropdown-toggle profile-pic"
        data-bs-toggle="dropdown"
        href="#"
        aria-expanded="false"
      >
        <div class="avatar-sm">
          <img
            src="assets/img/profile.jpg"
            alt="..."
            class="avatar-img rounded-circle"
          />
        </div>
        <span class="profile-username">
        </span>
      </a>
      <ul class="dropdown-menu dropdown-user animated fadeIn">
        <div class="dropdown-user-scroll scrollbar-outer">
          <li>
            <div class="user-box">
              <div class="avatar-lg">
                <img
                  src="assets/img/profile.jpg"
                  alt="image profile"
                  class="avatar-img rounded"
                />
              </div>
              <div class="u-text">
                <h4>{{ Auth::user()->name }}</h4>
                <p class="text-muted">{{ Auth::user()->email }}</p>
                <a
                  href="profile.html"
                  class="btn btn-xs btn-secondary btn-sm"
                  >View Profile</a
                >
              </div>
            </div>
          </li>
          <li>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="/login">Logout</a>
          </li>
        </div>
      </ul>
    </li>
  </ul>
</div>
</nav>
<!-- End Navbar -->
</div>