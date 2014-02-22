<!DOCTYPE html>
<!--[if lt IE 7]> <html ng-app="freak" class="lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html ng-app="freak" class="lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html ng-app="freak" class="lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--><html ng-app="freak" lang="en"><!--<![endif]-->

<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Advanced ControlPanel V3 | AngularJS Supported">
    <meta name="author" content="Kareem Mohamed">

    <!-- Bootstrap Stylesheet -->
    <link rel="stylesheet" href="<?php echo URL::to('/packages/kareem3d/freak/bootstrap/css/bootstrap.min.css') ?>" media="all">

    <!-- jquery-ui Stylesheets -->
    <link rel="stylesheet" href="<?php echo URL::to('/packages/kareem3d/freak/assets/jui/css/jquery-ui.css') ?>" media="screen">
    <link rel="stylesheet" href="<?php echo URL::to('/packages/kareem3d/freak/assets/jui/jquery-ui.custom.css') ?>" media="screen">
    <link rel="stylesheet" href="<?php echo URL::to('/packages/kareem3d/freak/assets/jui/timepicker/jquery-ui-timepicker.css') ?>" media="screen">

    <!-- Uniform Stylesheet -->
    <link rel="stylesheet" href="<?php echo URL::to('/packages/kareem3d/freak/plugins/uniform/css/uniform.default.css') ?>" media="screen">

    <!-- pnotify -->
    <link rel="stylesheet" href="<?php echo URL::to('/packages/kareem3d/freak/plugins/pnotify/jquery.pnotify.css') ?>" media="screen">

    <!-- Zebra Datepicker -->
    <link rel="stylesheet" href="<?php echo URL::to('/packages/kareem3d/freak/plugins/zebradp/css/mooncake/zebra_datepicker.css') ?>" media="screen">

    <!-- End Plugin Stylesheets -->

    <!-- Main Layout Stylesheet -->
    <link rel="stylesheet" href="<?php echo URL::to('/packages/kareem3d/freak/assets/css/fonts/icomoon/style.css') ?>" media="screen">
    <link rel="stylesheet" href="<?php echo URL::to('/packages/kareem3d/freak/assets/css/main-style.css') ?>" media="screen">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <title>Advanced ControlPanel V3</title>

</head>

<body data-show-sidebar-toggle-button="true" data-fixed-sidebar="false" ng-controller="BodyCtrl">

<div id="wrapper" class="full">
    <header id="header" class="navbar navbar-inverse" ng-controller="HeaderCtrl">
        <div class="navbar-inner">
            <div class="container">
                <div class="brand-wrap pull-left">
                    <div class="brand-img">
                        <a class="brand" href="#">
                        </a>
                    </div>
                </div>

                <div id="header-right" class="clearfix">
                    <div id="nav-toggle" data-toggle="collapse" data-target="#navigation" class="collapsed">
                        <i class="icon-caret-down"></i>
                    </div>

                    <div id="header-functions" class="pull-right">
                        <div id="user-info" class="clearfix">
                                <span class="info">
                                	Welcome
                                    <span class="name"><?php echo $authUser->name ?></span>
                                </span>
                            <div class="avatar">
                                <a class="dropdown-toggle" href="#" data-toggle="dropdown">
                                    <img src="<?php echo $authUser->getImage('profile')->getLargest() ?>" alt="Avatar">
                                </a>
                            </div>
                        </div>
                        <div id="logout-ribbon">
                            <a href="index.html"><i class="icon-off"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div id="content-wrap" ng-controller="ContentCtrl">
        <div id="content">
            <div id="content-outer">
                <div id="content-inner">




                    <!-- Sidebar dude -->

                    <aside id="sidebar" ng-controller="SidebarCtrl">
                        <nav id="navigation" class="collapse">
                            <ul>
                                <li ng-click="makeParentActive(parentItem)" ng-class="{'active' : parentItem.active}" ng-repeat="parentItem in menu">
                                    	<span title="General">
                                    		<i class="{{ parentItem.icon ? parentItem.icon : 'icon-archive' }}"></i>
											<span class="nav-title">{{ parentItem.title }}</span>
                                        </span>
                                    <ul class="inner-nav">
                                        <li ng-click="makeChildActive(childItem)" ng-class="{'active' : childItem.active}" ng-repeat="childItem in parentItem.children">
                                            <a href="{{ childItem.uri }}">
                                                <i class="{{ childItem.icon ? childItem.icon : 'icol-drawer' }}"></i> {{ childItem.title }}
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </nav>
                    </aside>






                    <div id="sidebar-separator"></div>

                    <section id="main" class="clearfix" ng-controller="MainCtrl">
                        <div id="main-header" class="page-header">
                            <ul class="breadcrumb">
                                <li>
                                    <i class="icon-archive"></i>History
                                    <span class="divider">&raquo;</span>
                                </li>
                                <li ng-repeat="item in historyItems track by item.title">
                                    <a ng-href="{{ item.uri ? item.uri : '#' }}">{{ item.title }}</a>
                                    <span ng-hide="$last" class="divider">&raquo;</span>
                                </li>
                            </ul>
                        </div>

                        <div id="main-content">
                            <div ng-view ng-show="viewOptions.show"></div>

                            <div ng-hide="viewOptions.show">Loading view....</div>
                        </div>

                    </section>
                </div>
            </div>
        </div>
    </div>

    <footer id="footer" ng-controller="FooterCtrl">
        <div class="footer-left">Advanced ControlPanel</div>
        <div class="footer-right"><p>Copyright 2013. All Rights Reserved. <a href="http://www.kareemphp.com/website-services.html">KareemPHP</a></p></div>
    </footer>

</div>

<!-- url scripts -->
<script src="<?php echo URL::to('/packages/kareem3d/freak/url.js') ?>"></script>
<script type="text/javascript">
    var freakUrl = new url('<?php echo freakUrl("") ?>');
</script>



<!-- Core Scripts -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="<?php echo URL::to('/packages/kareem3d/freak/bootstrap/js/bootstrap.min.js') ?>"></script>
<script src="<?php echo URL::to('/packages/kareem3d/freak/assets/js/libs/jquery.placeholder.min.js') ?>"></script>
<script src="<?php echo URL::to('/packages/kareem3d/freak/assets/js/libs/jquery.mousewheel.min.js') ?>"></script>

<!-- Template Script -->
<script src="<?php echo URL::to('/packages/kareem3d/freak/assets/js/template.js') ?>"></script>
<script src="<?php echo URL::to('/packages/kareem3d/freak/assets/js/setup.js') ?>"></script>


<!-- Customizer, remove if not needed -->
<script src="<?php echo URL::to('/packages/kareem3d/freak/assets/js/customizer.js') ?>"></script>

<!-- Uniform Script -->
<script src="<?php echo URL::to('/packages/kareem3d/freak/plugins/uniform/jquery.uniform.min.js') ?>"></script>

<!-- jquery-ui Scripts -->
<script src="<?php echo URL::to('/packages/kareem3d/freak/assets/jui/js/jquery-ui-1.9.2.min.js') ?>"></script>
<script src="<?php echo URL::to('/packages/kareem3d/freak/assets/jui/jquery-ui.custom.min.js') ?>"></script>
<script src="<?php echo URL::to('/packages/kareem3d/freak/assets/jui/timepicker/jquery-ui-timepicker.min.js') ?>"></script>
<script src="<?php echo URL::to('/packages/kareem3d/freak/assets/jui/jquery.ui.touch-punch.min.js') ?>"></script>

<!-- pnotify -->
<script src="<?php echo URL::to('/packages/kareem3d/freak/plugins/pnotify/jquery.pnotify.min.js') ?>"></script>

<!-- DataTables -->
<script src="<?php echo URL::to('/packages/kareem3d/freak/plugins/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo URL::to('/packages/kareem3d/freak/plugins/datatables/TableTools/js/TableTools.min.js') ?>"></script>
<script src="<?php echo URL::to('/packages/kareem3d/freak/plugins/datatables/FixedColumns/FixedColumns.min.js') ?>"></script>
<script src="<?php echo URL::to('/packages/kareem3d/freak/plugins/datatables/dataTables.bootstrap.js') ?>"></script>
<script src="<?php echo URL::to('/packages/kareem3d/freak/plugins/datatables/jquery.dataTables.columnFilter.js') ?>"></script>

<!-- Demo Scripts -->
<script src="<?php echo URL::to('/packages/kareem3d/freak/assets/js/demo/dataTables.js') ?>"></script>

<!-- Zebra Datepicker -->
<script src="<?php echo URL::to('/packages/kareem3d/freak/plugins/zebradp/zebra_datepicker.min.js') ?>"></script>




<!-- AngularJS Scripts -->
<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.2.12/angular.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.2.12/angular-resource.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.2.12/angular-route.min.js"></script>

<script src="<?php echo URL::to('/packages/kareem3d/freak/fr_aa/app.js') ?>"></script>
<script src="<?php echo URL::to('/packages/kareem3d/freak/fr_aa/controllers.js') ?>"></script>
<script src="<?php echo URL::to('/packages/kareem3d/freak/fr_aa/directives.js') ?>"></script>
<script src="<?php echo URL::to('/packages/kareem3d/freak/fr_aa/filters.js') ?>"></script>
<script src="<?php echo URL::to('/packages/kareem3d/freak/fr_aa/services.js') ?>"></script>



<!-- Packages javascript files -->
<script src="<?php echo URL::to('/packages/kareem3d/freak-images/angular-file-upload.js') ?>"></script>


</body>

</html>