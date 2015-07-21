<html>
    <head>
        <meta charset="UTF-8">
        <title>GHS E-learning | Dashboard</title>

        <link href="<?php echo base_url("assets/css/yeti_bootstrap.min.css") ?>" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="<?php echo base_url('assets/css/font-awesome.min.css') ?>" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="<?php echo base_url('assets/css/ionicons.min.css') ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/css/jquery.toast.css') ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/css/publicstyle.css') ?>" rel="stylesheet" type="text/css" />
              <link href="<?php echo base_url('assets/css/paper-collapse.min.css') ?>" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>

        <div class="container-fluid">

            <div class="row" style="background-color: #31ba00;"> <!--top -->
                <div id="branding" class="col-lg-9 col-md-9 col-sm-12">
                    <h1 style="color: #fff; font-weight: 700;padding-left: 3em">Healthcare E-learning</h1>
                </div>
                <header class="col-lg-3 col-md-3 col-sm-12">
                    <div class="row" id="top-menu" style="margin: 1em 0;">
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <a href="#">Home</a>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <a href="#">Sign up</a>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <a href="#">Login</a>
                        </div>
                    </div>
                    <div id="search">
                        <form>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search for...">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button"><i class="glyphicon glyphicon-search"></i></button>
                                </span>
                            </div><!-- /input-group -->
                        </form>
                    </div><!-- /search -->
                </header>

            </div><!-- /top-->
        </div>
        <div id="content-wrapper" class="container-fluid">

            <div class="row">
                
                <div class="content col-lg-9 col-md-9 col-sm-12 col-xs-12">
                    <div class="row logos" style="height: 70px; ">

                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12  e-logo" id="eleaning-logo">
                        <img src="<?php echo base_url() ?>assets/img/e-learning-LOGO.png" />
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 e-logo col-xs-12" id="ghs-logo">
                        <img src="<?php echo base_url() ?>assets/img/GHS-logo.png" width="50" class="pull-right"/>
                    </div>
                </div>
                <div class="row toolbar" style="background-color: #31ba00;">
                     <div class="navbar-left">
                            <ul class="nav navbar-nav">
                                <li class="dropdown messages-menu">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                        <img src="<?php echo base_url() . "assets/img/1.png" ?>" width="30" />
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li class="header">You have 4 messages</li>
                                        <li>
                                            <ul class="menu">
                                                <li> start message 
                                                    <a href="#">
                                                        <div class="pull-left">
                                                            <img src="img/avatar3.png" class="img-circle" alt="User Image"/>
                                                        </div>
                                                        <h4>
                                                            Support Team
                                                            <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                                        </h4>
                                                        <p>Why not buy a new awesome theme?</p>
                                                    </a>
                                                </li> end message 
                                                <li>
                                                    <a href="#">
                                                        <div class="pull-left">
                                                            <img src="img/avatar2.png" class="img-circle" alt="user image"/>
                                                        </div>
                                                        <h4>
                                                            AdminLTE Design Team
                                                            <small><i class="fa fa-clock-o"></i> 2 hours</small>
                                                        </h4>
                                                        <p>Why not buy a new awesome theme?</p>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#">
                                                        <div class="pull-left">
                                                            <img src="img/avatar.png" class="img-circle" alt="user image"/>
                                                        </div>
                                                        <h4>
                                                            Developers
                                                            <small><i class="fa fa-clock-o"></i> Today</small>
                                                        </h4>
                                                        <p>Why not buy a new awesome theme?</p>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#">
                                                        <div class="pull-left">
                                                            <img src="img/avatar2.png" class="img-circle" alt="user image"/>
                                                        </div>
                                                        <h4>
                                                            Sales Department
                                                            <small><i class="fa fa-clock-o"></i> Yesterday</small>
                                                        </h4>
                                                        <p>Why not buy a new awesome theme?</p>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#">
                                                        <div class="pull-left">
                                                            <img src="img/avatar.png" class="img-circle" alt="user image"/>
                                                        </div>
                                                        <h4>
                                                            Reviewers
                                                            <small><i class="fa fa-clock-o"></i> 2 days</small>
                                                        </h4>
                                                        <p>Why not buy a new awesome theme?</p>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="footer"><a href="#">See All Messages</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown notifications-menu">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                        <i class="fa fa-warning"></i>
                                        <span class="label label-warning">10</span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li class="header">You have 10 notifications</li>
                                        <li>
                                            <ul class="menu">
                                                <li>
                                                    <a href="#">
                                                        <i class="ion ion-ios7-people info"></i> 5 new members joined today
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#">
                                                        <i class="fa fa-warning danger"></i> Very long description here that may not fit into the page and may cause design problems
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#">
                                                        <i class="fa fa-users warning"></i> 5 new members joined
                                                    </a>
                                                </li>

                                                <li>
                                                    <a href="#">
                                                        <i class="ion ion-ios7-cart success"></i> 25 sales made
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#">
                                                        <i class="ion ion-ios7-person danger"></i> You changed your username
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="footer"><a href="#">View all</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown tasks-menu">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                        <i class="fa fa-tasks"></i>
                                        <span class="label label-danger">9</span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li class="header">You have 9 tasks</li>
                                        <li>
                                            <ul class="menu">
                                                <li> Task item 
                                                    <a href="#">
                                                        <h3>
                                                            Design some buttons
                                                            <small class="pull-right">20%</small>
                                                        </h3>
                                                        <div class="progress xs">
                                                            <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                                <span class="sr-only">20% Complete</span>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </li> 
                                                <li> 
                                                    <a href="#">
                                                        <h3>
                                                            Create a nice theme
                                                            <small class="pull-right">40%</small>
                                                        </h3>
                                                        <div class="progress xs">
                                                            <div class="progress-bar progress-bar-green" style="width: 40%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                                <span class="sr-only">40% Complete</span>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#">
                                                        <h3>
                                                            Some task I need to do
                                                            <small class="pull-right">60%</small>
                                                        </h3>
                                                        <div class="progress xs">
                                                            <div class="progress-bar progress-bar-red" style="width: 60%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                                <span class="sr-only">60% Complete</span>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </li> 
                                                <li> 
                                                    <a href="#">
                                                        <h3>
                                                            Make beautiful transitions
                                                            <small class="pull-right">80%</small>
                                                        </h3>
                                                        <div class="progress xs">
                                                            <div class="progress-bar progress-bar-yellow" style="width: 80%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                                <span class="sr-only">80% Complete</span>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </li> end task item 
                                            </ul>
                                        </li>
                                        <li class="footer">
                                            <a href="#">View all tasks</a>
                                        </li>
                                    </ul>
                                </li>
                                
                                <li class="dropdown user user-menu">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                        <i class="glyphicon glyphicon-user"></i>
                                        <span>Jane Doe <i class="caret"></i></span>
                                    </a>
                                    <ul class="dropdown-menu">
                                         User image 
                                        <li class="user-header bg-light-blue">
                                            <img src="img/avatar3.png" class="img-circle" alt="User Image" />
                                            <p>
                                                Jane Doe - Web Developer
                                                <small>Member since Nov. 2012</small>
                                            </p>
                                        </li>
                                         Menu Body 
                                        <li class="user-body">
                                            <div class="col-xs-4 text-center">
                                                <a href="#">Followers</a>
                                            </div>
                                            <div class="col-xs-4 text-center">
                                                <a href="#">Sales</a>
                                            </div>
                                            <div class="col-xs-4 text-center">
                                                <a href="#">Friends</a>
                                            </div>
                                        </li>
                                         Menu Footer
                                        <li class="user-footer">
                                            <div class="pull-left">
                                                <a href="#" class="btn btn-default btn-flat">Profile</a>
                                            </div>
                                            <div class="pull-right">
                                                <a href="#" class="btn btn-default btn-flat">Sign out</a>
                                            </div>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                </div>
                    <div class="main_content">
                    <?php echo $content ?>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12" >
                    <div id="sidebar">
                      <ul class="sidebar-menu">
                        <li class="treeview">
                            <a href="#">
                                <small class="badge bg-green">10</small><span>Messages</span> 
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="pages/charts/morris.html"><i class="fa fa-angle-double-right"></i> Morris</a></li>
                                <li><a href="pages/charts/flot.html"><i class="fa fa-angle-double-right"></i> Flot</a></li>
                                <li><a href="pages/charts/inline.html"><i class="fa fa-angle-double-right"></i> Inline charts</a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <span>Quick Links</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="pages/charts/morris.html"><i class="fa fa-angle-double-right"></i> Morris</a></li>
                                <li><a href="pages/charts/flot.html"><i class="fa fa-angle-double-right"></i> Flot</a></li>
                                <li><a href="pages/charts/inline.html"><i class="fa fa-angle-double-right"></i> Inline charts</a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-laptop"></i>
                                <span>Favourite</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="#"><i class="fa fa-angle-double-right"></i> General</a></li>
                                <li><a href="#"><i class="fa fa-angle-double-right"></i> Icons</a></li>
                                <li><a href="#"><i class="fa fa-angle-double-right"></i> Buttons</a></li>
                                <li><a href="#"><i class="fa fa-angle-double-right"></i> Sliders</a></li>
                                <li><a href="#"><i class="fa fa-angle-double-right"></i> Timeline</a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-edit"></i> <span>My Community</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="pages/forms/general.html"><i class="fa fa-angle-double-right"></i> General Elements</a></li>
                                <li><a href="pages/forms/advanced.html"><i class="fa fa-angle-double-right"></i> Advanced Elements</a></li>
                                <li><a href="pages/forms/editors.html"><i class="fa fa-angle-double-right"></i> Editors</a></li>                                
                            </ul>
                        </li>
                    </ul><!--side-menu -->
                    </div>
                    <div class="alert alert-success" style="margin-top: 1.5em; color: #fff !important; font-weight: bolder">
                    <ul class="blist">
                        <li><a href="<?php echo base_url()."index.php/public/Frontier/course_list" ?>">Category Structure</a></li>
                         <li><a href="<?php echo base_url()."index.php/public/Frontier/course_list_grid" ?>">Courses Overview</a></li>
                    </ul>
                    </div>
                    
                    <div class="alert alert-success" style="min-height: 200px">&nbsp;</div>
                </div> 
                <!-- /sidebar-->
            </div>
        </div> 
        <div class="footer container-fluid alert-success" style="margin-top:1.5em">
            <div class="row">
                <div class="col-lg-4">
                    <div style="padding: 0.6em">
                    Powered and Maintain by - <a href="#">PMCONSULT</a>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div style="padding: 0.6em">
                        Supported by - <a href="#">Future Group</a>
                    </div>
                </div>
            </div>
        </div>

        <script src="<?php echo base_url('assets/js/jquery-2.1.4.min.js') ?>"></script>
        <!-- Bootstrap -->
        <script src="<?php echo base_url() ?>assets/js/bootstrap.min.js" type="text/javascript"></script>
<!--        <script src="<?php echo base_url() ?>assets/js/jquery.toast.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url() ?>assets/js/jquery.tmpl.min.js" type="application/javascript"></script>-->
        <script src="<?php echo base_url() ?>assets/js/paper-collapse.min.js" type="application/javascript"></script>
        <script src="<?php echo base_url() ?>assets/js/publicjs.js" type="text/javascript"></script>
    </body>
</html>