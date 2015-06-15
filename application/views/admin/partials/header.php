<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>GAHDP Admin | Dashboard</title>
        <link href="<?php echo base_url("assets/css/bootstrap.min.css")?>" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="<?php echo base_url('assets/css/font-awesome.min.css')?>" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="<?php echo base_url('assets/css/ionicons.min.css')?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/css/jquery.toast.css')?>" rel="stylesheet" type="text/css" />
        <!-- Date Picker -->
        <link href="<?php echo base_url('assets/css/datepicker/datepicker3.css')?>" rel="stylesheet" type="text/css" />
        <!-- Daterange picker -->
        <link href="<?php echo base_url('assets/css/daterangepicker/daterangepicker-bs3.css')?>" rel="stylesheet" type="text/css" />
        <!-- bootstrap wysihtml5 - text editor -->
        <!--        <link href="css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />-->
        <!-- Theme style -->
        <link href="<?php echo base_url('assets/css/AdminLTE.css')?>" rel="stylesheet" type="text/css" />
       
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
            <a href="#" class="logo">
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
                GAHDP Admin
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!--Sidebar toggle button-->
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
            </nav>
            <div class="navbar-right">
                <ul class="nav navbar-nav">
                    Messages: style can be found in dropdown.less
                    <li class="dropdown messages-menu">
                        <a href="#">
                            <i class="fa fa-envelope"></i>
                            <span class="label label-success">4</span>
                        </a>
                    </li>
                </ul>
            </div>
        </header>
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <!--
                                        <div class="user-panel">
                                            <div class="pull-left image">
                                                <img src="../../img/avatar3.png" class="img-circle" alt="User Image" />
                                            </div>
                                            <div class="pull-left info">
                                                <p>Hello, Jane</p>
                    
                                                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                                            </div>
                                        </div>
                    -->
                    <!-- search form -->
                    <!--
                                        <form action="#" method="get" class="sidebar-form">
                                            <div class="input-group">
                                                <input type="text" name="q" class="form-control" placeholder="Search..."/>
                                                <span class="input-group-btn">
                                                    <button type='submit' name='seach' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                                                </span>
                                            </div>
                                        </form>
                    -->
                    <!-- /.search form -->
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                        <!--
                                                <li>
                                                    <a href="../../index">
                                                        <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                                                    </a>
                                                </li>
                        -->
                        <li>
                            <a href="/faq">
                                <i class="fa fa-th"></i> <span>FAQ</span>
                            </a>
                        </li>
                        <li >
                            <a href="/events">
                                <i class="fa fa-calendar"></i>
                                <span>Events</span>
                            </a>
                        </li>
                        <li>
                            <a href="/forum">
                                <i class="fa fa-edit"></i> <span>forum</span>

                            </a>

                        </li>
                        <li>
                            <a href="/facility">
                                <i class="fa fa-table"></i> <span>Facility</span>

                            </a>
                        </li>
                        <li>
                            <a href="/messager">
                                <i class="fa fa-calendar"></i> <span>Messanger</span>

                            </a>
                        </li>
                        <!--
                                                <li>
                                                    <a href="/userManagement">
                                                        <i class="fa fa-envelope"></i> <span>user Management</span>
                                                       
                                                    </a>
                                                </li>
                        -->
                        <li>
                            <a href="/usermanagement">
                                <i class="fa fa-envelope"></i> <span>Admin Management</span>
                            </a>
                        </li>
                        <li>
                            <a href="/logout">
                                <i class="fa fa-envelope"></i> <span>Logout</span>
                            </a>
                        </li>
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>