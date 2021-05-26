<body class="nav-md">
  <div class="container body">
    <div class="main_container">
      <div class="col-md-3 left_col">
        <div class="left_col scroll-view">
          <div class="navbar nav_title" style="border: 0;">
            <a href="<?php echo $site_url; ?>template/production/index.html" class="site_title"><i class="fa fa-paw"></i> <span>Gentelella Alela!</span></a>
          </div>
          <div class="clearfix"></div>
          <!-- menu profile quick info -->
          <div class="profile clearfix">
            <div class="profile_pic">
              <img src="<?php echo $site_url; ?>template/production/images/img.jpg" alt="..." class="img-circle profile_img">
            </div>
            <div class="profile_info">
              <span>Welcome,</span>
              <h2>John Doe</h2>
            </div>
            <div class="clearfix"></div>
          </div>
          <!-- /menu profile quick info -->
          <br />
          <!-- sidebar menu -->
          <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
              <h3>General</h3>
              <ul class="nav side-menu">
                <li><a><i class="fa fa-rss"></i>Blog<span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <li><a href="<?php echo $site_url.'blog_cat/list/' ?>">Kategoriyalar</a></li>
                    <li><a href="<?php echo $site_url.'blog_content/list/' ?>">Meqaleler</a></li>
                  </ul>
                </li>
                <li><a><i class="fa fa-shopping-cart"></i>Shop<span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <li><a href="<?php echo $site_url.'shop_cat/list/' ?>">Kategoriyalar</a></li>
                    <li><a href="<?php echo $site_url.'shop_item/list/' ?>">Mehsullar</a></li>
                  </ul>
                </li> 
                <li><a><i class="fa fa-building"></i>Tikinti texnikasi<span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <li><a href="<?php echo $site_url.'machine_cat/list/' ?>">Kategoriyalar</a></li>
                    <li><a href="<?php echo $site_url.'machine_content/list/' ?>">Mehsullar</a></li>
                  </ul>
                </li>
                <li><a><i class="fa fa-bars"></i>Menu <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <li><a href="<?php echo $site_url.'menu/list_top/' ?>">Yuxari</a></li>
                    <li><a href="<?php echo $site_url.'menu/list_bottom/' ?>">Aşağı</a></li>
                    <li><a href="<?php echo $site_url.'menu/list_left/' ?>">Sol</a></li>
                    <li><a href="<?php echo $site_url.'menu/list_secret/' ?>">Gizli</a></li>
                  </ul>
                </li>  
                <li><a href="<?php echo $site_url.'builder/list/' ?>"><i class="fa fa-home"></i> Builder</span></a>
                </li>
                <li><a href="<?php echo $site_url.'lng/list/' ?>"><i class="fa fa-language"></i></i> Language</span></a>
                </li>  
                <li><a href="<?php echo $site_url.'general_site/list/' ?>"><i class="fa fa-cogs"></i></i> General Site</span></a>
                </li> 
                <li><a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <li><a href="<?php echo $site_url; ?>template/production/index.html">Dashboard</a></li>
                    <li><a href="<?php echo $site_url; ?>template/production/index2.html">Dashboard2</a></li>
                    <li><a href="<?php echo $site_url; ?>template/production/index3.html">Dashboard3</a></li>
                  </ul>
                </li>
                <li><a><i class="fa fa-edit"></i> Forms <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <li><a href="<?php echo $site_url; ?>template/production/form.html">General Form</a></li>
                    <li><a href="<?php echo $site_url; ?>template/production/form_advanced.html">Advanced Components</a></li>
                    <li><a href="<?php echo $site_url; ?>template/production/form_validation.html">Form Validation</a></li>
                    <li><a href="<?php echo $site_url; ?>template/production/form_wizards.html">Form Wizard</a></li>
                    <li><a href="<?php echo $site_url; ?>template/production/form_upload.html">Form Upload</a></li>
                    <li><a href="<?php echo $site_url; ?>template/production/form_buttons.html">Form Buttons</a></li>
                  </ul>
                </li>
                <li><a><i class="fa fa-desktop"></i> UI Elements <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <li><a href="<?php echo $site_url; ?>template/production/general_elements.html">General Elements</a></li>
                    <li><a href="<?php echo $site_url; ?>template/production/media_gallery.html">Media Gallery</a></li>
                    <li><a href="<?php echo $site_url; ?>template/production/typography.html">Typography</a></li>
                    <li><a href="<?php echo $site_url; ?>template/production/icons.html">Icons</a></li>
                    <li><a href="<?php echo $site_url; ?>template/production/glyphicons.html">Glyphicons</a></li>
                    <li><a href="<?php echo $site_url; ?>template/production/widgets.html">Widgets</a></li>
                    <li><a href="<?php echo $site_url; ?>template/production/invoice.html">Invoice</a></li>
                    <li><a href="<?php echo $site_url; ?>template/production/inbox.html">Inbox</a></li>
                    <li><a href="<?php echo $site_url; ?>template/production/calendar.html">Calendar</a></li>
                  </ul>
                </li>
                <li><a><i class="fa fa-table"></i> Tables <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <li><a href="<?php echo $site_url; ?>template/production/tables.html">Tables</a></li>
                    <li><a href="<?php echo $site_url; ?>template/production/tables_dynamic.html">Table Dynamic</a></li>
                  </ul>
                </li>
                <li><a><i class="fa fa-bar-chart-o"></i> Data Presentation <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <li><a href="<?php echo $site_url; ?>template/production/chartjs.html">Chart JS</a></li>
                    <li><a href="<?php echo $site_url; ?>template/production/chartjs2.html">Chart JS2</a></li>
                    <li><a href="<?php echo $site_url; ?>template/production/morisjs.html">Moris JS</a></li>
                    <li><a href="<?php echo $site_url; ?>template/production/echarts.html">ECharts</a></li>
                    <li><a href="<?php echo $site_url; ?>template/production/other_charts.html">Other Charts</a></li>
                  </ul>
                </li>
                <li><a><i class="fa fa-clone"></i>Layouts <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <li><a href="<?php echo $site_url; ?>template/production/fixed_sidebar.html">Fixed Sidebar</a></li>
                    <li><a href="<?php echo $site_url; ?>template/production/fixed_footer.html">Fixed Footer</a></li>
                  </ul>
                </li>
              </ul>
            </div>
            <div class="menu_section">
              <h3>Live On</h3>
              <ul class="nav side-menu">
                <li><a><i class="fa fa-bug"></i> Additional Pages <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <li><a href="<?php echo $site_url; ?>template/production/e_commerce.html">E-commerce</a></li>
                    <li><a href="<?php echo $site_url; ?>template/production/projects.html">Projects</a></li>
                    <li><a href="<?php echo $site_url; ?>template/production/project_detail.html">Project Detail</a></li>
                    <li><a href="<?php echo $site_url; ?>template/production/contacts.html">Contacts</a></li>
                    <li><a href="<?php echo $site_url; ?>template/production/profile.html">Profile</a></li>
                  </ul>
                </li>
                <li><a><i class="fa fa-windows"></i> Extras <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <li><a href="<?php echo $site_url; ?>template/production/page_403.html">403 Error</a></li>
                    <li><a href="<?php echo $site_url; ?>template/production/page_404.html">404 Error</a></li>
                    <li><a href="<?php echo $site_url; ?>template/production/page_500.html">500 Error</a></li>
                    <li><a href="<?php echo $site_url; ?>template/production/plain_page.html">Plain Page</a></li>
                    <li><a href="<?php echo $site_url; ?>template/production/login.html">Login Page</a></li>
                    <li><a href="<?php echo $site_url; ?>template/production/pricing_tables.html">Pricing Tables</a></li>
                  </ul>
                </li>
                <li><a><i class="fa fa-sitemap"></i> Multilevel Menu <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                      <li><a href="#level1_1">Level One</a>
                      <li><a>Level One<span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                          <li class="sub_menu"><a href="<?php echo $site_url; ?>template/production/level2.html">Level Two</a>
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
                <li><a href="javascript:void(0)"><i class="fa fa-laptop"></i> Landing Page <span class="label label-success pull-right">Coming Soon</span></a></li>
              </ul>
            </div>
          </div>
          <!-- /sidebar menu -->
          <!-- /menu footer buttons -->
          <div class="sidebar-footer hidden-small">
            <a data-toggle="tooltip" data-placement="top" title="Settings">
              <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="FullScreen">
              <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Lock">
              <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Logout" href="<?php echo $site_url; ?>template/production/login.html">
              <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
            </a>
          </div>
          <!-- /menu footer buttons -->
        </div>
      </div>
      <!-- top navigation -->
      <div class="top_nav">
        <div class="nav_menu">
          <nav>
            <div class="nav toggle">
              <a id="menu_toggle"><i class="fa fa-bars"></i></a>
            </div>
            <ul class="nav navbar-nav navbar-right">
              <li class="">
                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                  <img src="<?php echo $site_url; ?>template/production/images/img.jpg" alt="">John Doe
                  <span class=" fa fa-angle-down"></span>
                </a>
                <ul class="dropdown-menu dropdown-usermenu pull-right">
                  <li><a href="javascript:;"> Profile</a></li>
                  <li>
                    <a href="javascript:;">
                      <span class="badge bg-red pull-right">50%</span>
                      <span>Settings</span>
                    </a>
                  </li>
                  <li><a href="javascript:;">Help</a></li>
                  <li><a href="<?php echo $site_url; ?>logout/"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                </ul>
              </li>
              <li role="presentation" class="dropdown">
                <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                  <i class="fa fa-envelope-o"></i>
                  <span class="badge bg-green">6</span>
                </a>
                <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                  <li>
                    <a>
                      <span class="image"><img src="<?php echo $site_url; ?>template/production/images/img.jpg" alt="Profile Image" /></span>
                      <span>
                        <span>John Smith</span>
                        <span class="time">3 mins ago</span>
                      </span>
                      <span class="message">
                        Film festivals used to be do-or-die moments for movie makers. They were where...
                      </span>
                    </a>
                  </li>
                  <li>
                    <a>
                      <span class="image"><img src="<?php echo $site_url; ?>template/production/images/img.jpg" alt="Profile Image" /></span>
                      <span>
                        <span>John Smith</span>
                        <span class="time">3 mins ago</span>
                      </span>
                      <span class="message">
                        Film festivals used to be do-or-die moments for movie makers. They were where...
                      </span>
                    </a>
                  </li>
                  <li>
                    <a>
                      <span class="image"><img src="<?php echo $site_url; ?>template/production/images/img.jpg" alt="Profile Image" /></span>
                      <span>
                        <span>John Smith</span>
                        <span class="time">3 mins ago</span>
                      </span>
                      <span class="message">
                        Film festivals used to be do-or-die moments for movie makers. They were where...
                      </span>
                    </a>
                  </li>
                  <li>
                    <a>
                      <span class="image"><img src="<?php echo $site_url; ?>template/production/images/img.jpg" alt="Profile Image" /></span>
                      <span>
                        <span>John Smith</span>
                        <span class="time">3 mins ago</span>
                      </span>
                      <span class="message">
                        Film festivals used to be do-or-die moments for movie makers. They were where...
                      </span>
                    </a>
                  </li>
                  <li>
                    <div class="text-center">
                      <a>
                        <strong>See All Alerts</strong>
                        <i class="fa fa-angle-right"></i>
                      </a>
                    </div>
                  </li>
                </ul>
              </li>
            </ul>
          </nav>
        </div>
      </div>
      <!-- /top navigation -->