<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>E-Learning | Dashboard</title>
        
        <link href="<?php echo base_url("assets/css/bootstrap.min.css")?>" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="<?php echo base_url('assets/css/font-awesome.min.css')?>" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="<?php echo base_url('assets/css/ionicons.min.css')?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/css/jquery.toast.css')?>" rel="stylesheet" type="text/css" />
       
        <!-- bootstrap wysihtml5 - text editor -->
        <!--        <link href="css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />-->
        <!-- Theme style -->
        <link href="<?php echo base_url()?>assets/css/AdminLTE.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="skin-blue">
        <!-- header logo: style can be found in header.less -->
        <header class="header">
            <a href="index.html" class="logo">
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
                GHS E-learning 
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
               
            </nav>
        </header>
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas">                
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                   
                    <!-- search form -->
                    <form action="#" method="get" class="sidebar-form">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control" placeholder="Search..."/>
                            <span class="input-group-btn">
                                <button type='submit' name='seach' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </form>
                    <!-- /.search form -->
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                        <li class="active">
                            <a href="<?php echo base_url('index.php/admin/Dashboard/') ?>">
                                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('index.php/admin/Dashboard/categories') ?>">
                                <i class="fa fa-th"></i> <span>Categories</span> <small class="badge pull-right bg-green">new</small>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('index.php/admin/Dashboard/courses') ?>">
                                <i class="fa fa-bar-chart-o"></i>
                                <span>Courses</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('index.php/admin/Dashboard/subjects') ?>">
                                <i class="fa fa-laptop"></i>
                                <span>Subjects</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('index.php/admin/Dashboard/forum') ?>">
                                <i class="fa fa-edit"></i> <span>Forum</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('index.php/admin/Dashboard/messages') ?>">
                                <i class="fa fa-table"></i> <span>Messages</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('index.php/admin/Dashboard/member') ?>">
                                <i class="fa fa-calendar"></i> <span>Member</span>
<!--                                <small class="badge pull-right bg-red">3</small>-->
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('index.php/admin/Dashboard/events') ?>">
                                <i class="fa fa-calendar"></i> <span>Events</span>
<!--                                <small class="badge pull-right bg-red">3</small>-->
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('index.php/admin/Dashboard/news') ?>">
                                <i class="fa fa-calendar"></i> <span>News</span>
<!--                                <small class="badge pull-right bg-red">3</small>-->
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('index.php/admin/Dashboard/mailer') ?>">
                                <i class="fa fa-envelope"></i> <span>Mailer/Newsletter</span>
<!--                                <small class="badge pull-right bg-yellow">12</small>-->
                            </a>
                        </li>
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">                
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        <?php echo $page ?>
                        <small>Control panel</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active"><?php echo $page ?></li>
                    </ol>
                </section>
                   
                <!-- Main content -->
                <section class="content">
                     <?php echo $content ?>
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->
         <!-- jQuery 2.0.2 -->
        <script src="<?php echo base_url('assets/js/jquery-1.11.1.min.js')?>"></script>
        <!-- jQuery UI 1.10.3 -->
        <script src="<?php echo base_url('assets/js/jquery-ui-1.10.3.min.js')?>" type="text/javascript"></script>
        <!-- Bootstrap -->
        <script src="<?php echo base_url('assets/js/bootstrap.min.js')?>" type="text/javascript"></script>
        
        <!-- Bootstrap WYSIHTML5 -->
<!--        <script src="js/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>-->
        <!-- iCheck -->
        <script src="<?php echo base_url()?>assets/js/icheck.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url()?>assets/js/jquery.toast.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url()?>assets/js/jquery.tmpl.min.js" type="application/javascript"></script>
        <script src="<?php echo base_url()?>assets/video-js/video.js" type="application/javascript"></script>
         <script src="<?php echo base_url()?>assets/video-js/youtube.js" type="application/javascript"></script>
        <script>
            videojs.options.flash.swf = <?php echo base_url("assets/video-js/video-js.swf")?>;
        </script>
        <!-- Admin -->
        <script src="<?php echo base_url()?>assets/js/Admin/app.js" type="text/javascript"></script>

    </body>
</html>