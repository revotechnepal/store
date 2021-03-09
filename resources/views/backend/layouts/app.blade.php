<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel = "icon" href = "{{asset('uploads/icon.png')}}"
        type = "image/x-icon">

    <title>RevoTech Inventory</title>

    <!-- Bootstrap -->
    <link href="{{asset('backend/vendors/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{asset('backend/vendors/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{asset('backend/vendors/nprogress/nprogress.css')}}" rel="stylesheet">
    <!-- iCheck -->
    <link href="{{asset('backend/vendors/iCheck/skins/flat/green.css')}}" rel="stylesheet">

    <!-- bootstrap-progressbar -->
    <link href="{{asset('backend/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css')}}" rel="stylesheet">
    <!-- JQVMap -->
    <link href="{{asset('backend/vendors/jqvmap/dist/jqvmap.min.css')}}" rel="stylesheet"/>
    <!-- bootstrap-daterangepicker -->
    <link href="{{asset('backend/vendors/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="{{asset('backend/build/css/custom.min.css')}}" rel="stylesheet">
    @stack('styles')
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="{{route('home')}}" class="site_title"> <span>RevoTech Inventory</span></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic">
                <img src="{{asset('backend/build/images/img.jpg')}}" alt="..." class="img-circle profile_img">

              </div>
              <div class="profile_info">
                <span>Welcome,</span>
                <h2>{{Auth::user()->name}}</h2>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>General</h3>
                <ul class="nav side-menu">
                  <li><a href="{{route('home')}}"><i class="fa fa-home"></i> Dashboard</a></li>
                  <li><a><i class="fa fa-users"></i> Staff Management<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="{{route('admin.position.index')}}">All Positions</a></li>
                      <li><a href="{{route('admin.staff.index')}}">All Staffs</a></li>
                      {{-- <li><a href="{{route('admin.staff.create')}}">Add New Staff</a></li> --}}
                      <li><a href="{{route('admin.salarypayment.create')}}">Salary Payment</a></li>
                      <li><a href="{{route('admin.attendance.create')}}">Enter Today's Attendance</a></li>
                    </ul>
                  </li>
                  {{-- <li><a href="{{route('admin.category.index')}}"><i class="fa fa-tag"></i> Project Category</a></li> --}}
                  <li><a><i class="fa fa-product-hunt"></i> Project Management <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{route('admin.project.index')}}">View Our Projects</a></li>
                      <li><a href="{{route('admin.project.create')}}">Register New Project</a></li>
                      <li><a href="{{route('admin.category.index')}}">View Project Category</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-thumbs-up" aria-hidden="true"></i> Customer Management <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{route('admin.client.index')}}">Our Clients</a></li>
                      <li><a href="{{route('admin.visitor.index')}}">Our Visitors</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-user"></i> Users & Roles <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{route('admin.user.index')}}">View All Users</a></li>
                      <li><a href="{{route('admin.rolepermission.index')}}">View Roles and Permissions</a></li>
                      {{-- <li><a href="{{route('admin.user.create')}}">Create New User</a></li> --}}
                    </ul>
                  </li>
                </ul>
              </div>
              <div class="menu_section">
                <h3>Usables</h3>
                <ul class="nav side-menu">
                      <li><a><i class="fa fa-file"></i> Monthly Report <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                           <li><a href="{{route('admin.salaryreport')}}">Salary Report</a></li>
                            <li><a href="{{route('admin.report')}}">Attendance Report</a></li>
                        </ul>
                      </li>
                        <li><a><i class="fa fa-envelope"></i> Mailings<span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <li><a href="{{route('admin.mail.index')}}">Send Mail</a></li>
                                <li><a href="{{route('admin.sentmails.index')}}">Our Sent Mails</a>
                            </ul>
                          </li>
                  <li><a><i class="fa fa-comments-o"></i> Third Party Services <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{route('admin.thirdparty.index')}}">Our Service Providers</a></li>
                      <li><a href="{{route('admin.thirdparty.create')}}">Add New Third Party</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-list"></i> Purchase Records <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{route('admin.purchaserecord.index')}}">All Purchase Records</a></li>
                      <li><a href="{{route('admin.purchaserecord.create')}}">Entry Purchase Record</a></li>
                    </ul>
                  </li>
                  {{-- <li><a><i class="fa fa-windows"></i> Extras <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="page_403.html">403 Error</a></li>
                      <li><a href="page_404.html">404 Error</a></li>
                      <li><a href="page_500.html">500 Error</a></li>
                      <li><a href="plain_page.html">Plain Page</a></li>
                      <li><a href="login.html">Login Page</a></li>
                      <li><a href="pricing_tables.html">Pricing Tables</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-sitemap"></i> Multilevel Menu <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="#level1_1">Level One</a>
                        <li><a>Level One<span class="fa fa-chevron-down"></span></a>
                          <ul class="nav child_menu">
                            <li class="sub_menu"><a href="level2.html">Level Two</a>
                            </li>
                            <li><a href="#level2_1">Level Two</a>
                            </li>
                            <li><a href="#level2_2">Level Two</a>
                            </li>
                          </ul>
                        </li>
                        <li><a href="#level1_2">Level One</a>
                        </li>
                    </ul>
                  </li>
                  <li><a href="javascript:void(0)"><i class="fa fa-laptop"></i> Landing Page <span class="label label-success pull-right">Coming Soon</span></a></li> --}}
                </ul>
              </div>

            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="Logout"  href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
                </form>
            </div>
            <!-- /menu footer buttons -->
          </div>
        </div>
        <div class="top_nav">
            <div class="nav_menu">
                <div class="nav toggle">
                  <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                </div>
                <nav class="nav navbar-nav">
                <ul class=" navbar-right">
                  <li class="nav-item dropdown open" style="padding-left: 15px;">
                    <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
                      {{-- <img src="{{asset('backend/build/images/img.jpg')}}" alt=""> --}}
                      <span style="font-size: 15px;"><i class="fa fa-user"></i> {{Auth::user()->name}}</span>
                    </a>
                    <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
                      {{-- <a class="dropdown-item"  href="javascript:;"> Profile</a>
                        <a class="dropdown-item"  href="javascript:;">
                          <span class="badge bg-red pull-right">50%</span>
                          <span>Settings</span>
                        </a>
                        <a class="dropdown-item"  href="javascript:;">Help</a> --}}
                        {{-- <a class="dropdown-item"  href="login.html"><i class="fa fa-sign-out pull-right"></i> Log Out</a> --}}


                        <br>
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fa fa-sign-out pull-right"></i> Log Out</span>
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                        </form>
                    </div>
                  </li>

                  {{-- <li role="presentation" class="nav-item dropdown open">
                    <a href="javascript:;" class="dropdown-toggle info-number" id="navbarDropdown1" data-toggle="dropdown" aria-expanded="false">
                      <i class="fa fa-envelope-o"></i>
                      <span class="badge bg-green">6</span>
                    </a>
                    <ul class="dropdown-menu list-unstyled msg_list" role="menu" aria-labelledby="navbarDropdown1">
                      <li class="nav-item">
                        <a class="dropdown-item">
                          <span class="image"><img src="{{asset('backend/build/images/img.jpg')}}" alt="Profile Image" /></span>
                          <span>
                            <span>John Smith</span>
                            <span class="time">3 mins ago</span>
                          </span>
                          <span class="message">
                            Film festivals used to be do-or-die moments for movie makers. They were where...
                          </span>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a class="dropdown-item">
                          <span class="image"><img src="{{asset('backend/build/images/img.jpg')}}" alt="Profile Image" /></span>
                          <span>
                            <span>John Smith</span>
                            <span class="time">3 mins ago</span>
                          </span>
                          <span class="message">
                            Film festivals used to be do-or-die moments for movie makers. They were where...
                          </span>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a class="dropdown-item">
                          <span class="image"><img src="{{asset('backend/build/images/img.jpg')}}" alt="Profile Image" /></span>
                          <span>
                            <span>John Smith</span>
                            <span class="time">3 mins ago</span>
                          </span>
                          <span class="message">
                            Film festivals used to be do-or-die moments for movie makers. They were where...
                          </span>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a class="dropdown-item">
                          <span class="image"><img src="{{asset('backend/build/images/img.jpg')}}" alt="Profile Image" /></span>
                          <span>
                            <span>John Smith</span>
                            <span class="time">3 mins ago</span>
                          </span>
                          <span class="message">
                            Film festivals used to be do-or-die moments for movie makers. They were where...
                          </span>
                        </a>
                      </li>
                      <li class="nav-item">
                        <div class="text-center">
                          <a class="dropdown-item">
                            <strong>See All Alerts</strong>
                            <i class="fa fa-angle-right"></i>
                          </a>
                        </div>
                      </li>
                    </ul>
                  </li> --}}
                </ul>
              </nav>
            </div>
          </div>
          <!-- /top navigation -->

        @yield('content')

        <!-- footer content -->
        <footer>
            <div class="pull-right">
               <a href="http://revonepal.com"><p style="font-size: 20px;">Revotech Nepal Pvt. Ltd.</p></a>
            </div>
            <div class="clearfix"></div>
          </footer>
          <!-- /footer content -->
        </div>
      </div>

      <!-- jQuery -->
      <script src="{{asset('backend/vendors/jquery/dist/jquery.min.js')}}"></script>
      <!-- Bootstrap -->
      <script src="{{asset('backend/vendors/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
      <!-- FastClick -->
      <script src="{{asset('backend/vendors/fastclick/lib/fastclick.js')}}"></script>
      <!-- NProgress -->
      <script src="{{asset('backend/vendors/nprogress/nprogress.js')}}"></script>
      <!-- Chart.js -->
      <script src="{{asset('backend/vendors/Chart.js/dist/Chart.min.js')}}"></script>
      <!-- gauge.js -->
      <script src="{{asset('backend/vendors/gauge.js/dist/gauge.min.js')}}"></script>
      <!-- bootstrap-progressbar -->
      <script src="{{asset('backend/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js')}}"></script>
      <!-- iCheck -->
      <script src="{{asset('backend/vendors/iCheck/icheck.min.js')}}"></script>
      <!-- Skycons -->
      <script src="{{asset('backend/vendors/skycons/skycons.js')}}"></script>
      <!-- Flot -->
      <script src="{{asset('backend/vendors/Flot/jquery.flot.js')}}"></script>
      <script src="{{asset('backend/vendors/Flot/jquery.flot.pie.js')}}"></script>
      <script src="{{asset('backend/vendors/Flot/jquery.flot.time.js')}}"></script>
      <script src="{{asset('backend/vendors/Flot/jquery.flot.stack.js')}}"></script>
      <script src="{{asset('backend/vendors/Flot/jquery.flot.resize.js')}}"></script>
      <!-- Flot plugins -->
      <script src="{{asset('backend/vendors/flot.orderbars/js/jquery.flot.orderBars.js')}}"></script>
      <script src="{{asset('backend/vendors/flot-spline/js/jquery.flot.spline.min.js')}}"></script>
      <script src="{{asset('backend/vendors/flot.curvedlines/curvedLines.js')}}"></script>
      <!-- DateJS -->
      <script src="{{asset('backend/vendors/DateJS/build/date.js')}}"></script>
      <!-- JQVMap -->
      <script src="{{asset('backend/vendors/jqvmap/dist/jquery.vmap.js')}}"></script>
      <script src="{{asset('backend/vendors/jqvmap/dist/maps/jquery.vmap.world.js')}}"></script>
      <script src="{{asset('backend/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js')}}"></script>
      <!-- bootstrap-daterangepicker -->
      <script src="{{asset('backend/vendors/moment/min/moment.min.js')}}"></script>
      <script src="{{asset('backend/vendors/bootstrap-daterangepicker/daterangepicker.js')}}"></script>

      <!-- Custom Theme Scripts -->
      <script src="{{asset('backend/build/js/custom.min.js')}}"></script>
      <script>
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 5000);
      </script>

      @stack('scripts')

    </body>
  </html>

