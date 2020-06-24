<?php

/* @var $this \yii\web\View */
/* @var $content string */

use frontend\assets\AppAsset;

AppAsset::register($this);

function isActive($urls)
{
    $url = explode('/', Yii::$app->request->getUrl())[1];
    if (in_array($url, $urls)) {
        return 'active';
    } else {
        return '';
    }
}
function getPath($path)
{
    $url = explode('?', Yii::$app->request->getUrl())[0];
    $url = rtrim($url, '/');
    if ($url == $path) {
        return 'javascript:void(0);';
    } else {
        return $path;
    }

}

// $bodyClassName = empty($_COOKIE['bodyClassName']) ? 'hold-transition skin-blue sidebar-mini' : $_COOKIE['bodyClassName'];

?>
<!DOCTYPE html>
<html lang="<?=Yii::$app->language?>">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>m
        <?=$this->title?>
    </title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/plugins/font-awesome-4.7.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="/plugins/ionicons/2.0.1/css/ionicons.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="/plugins/datatables/dataTables.bootstrap.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="/dist/css/skins/_all-skins.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="/plugins/iCheck/flat/blue.css">
    <!-- Morris chart -->
    <link rel="stylesheet" href="/plugins/morris/morris.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <!-- Date Picker -->
    <link rel="stylesheet" href="/plugins/datepicker/datepicker3.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="/plugins/daterangepicker/daterangepicker.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

    <link rel="stylesheet" href="/css/zeroModal.css">
    <link rel="stylesheet" href="/css/webuploader.css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
    <link rel="stylesheet" href="/plugins/iCheck/minimal/_all.css">
    <link rel="stylesheet" href="/css/style.css">
    <script type="text/javascript" src="/js/angular.min.js"></script>
    <script src="/js/controllers/News.js"></script>
    <script src="/js/controllers/self.js"></script>
    <script src="/js/controllers/main.js"></script>
</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper" id="mainApp">
        <header class="main-header">
            <!-- Logo -->
            <a href="/" class="logo">
                <span class="logo-mini"><img src="/images/hoohoolab-logo-black.png" style="height: 36px"></span>
                <span class="logo-lg">
                    <img src="/images/hoohoolab-logo-black.png"
                        style="height: 36px;margin-right: 10px;margin-bottom: 10px;">
                </span>
            </a>
            <nav class="navbar navbar-static-top">
                <div class="navbar-custom-menu" style="float: left;">
                    <ul class="nav navbar-nav">
                        <li class="treeview <?=isActive(['site', ''])?>">
                            <a href="<?=getPath('/site/index')?>">
                                <i class="fa fa-dashboard"></i>
                                <span>总览</span>
                            </a>
                        </li>
                        <li class="treeview <?=isActive(['alert'])?>">
                            <a href="<?=getPath('/alert/index')?>">
                                <i class="fa fa-heartbeat"></i>
                                <span>威胁</span>
                            </a>
                        </li>
                        <li class="treeview <?=isActive(['investigate'])?>">
                            <a href="<?=getPath('/investigate/index')?>">
                                <i class="fa fa-search"></i>
                                <span>安全调查</span>
                            </a>
                        </li>
                        <li class="treeview <?=isActive(['sensor'])?>">
                            <a href="<?=getPath('/sensor/index')?>">
                                <i class="fa fa-laptop"></i>
                                <span>计算机</span>
                            </a>
                        </li>
                        <?php if (Yii::$app->user->identity->role == 'admin') {?>
                        <li class="treeview <?=isActive(['seting'])?>">
                            <a href="<?=getPath('/seting/index')?>">
                                <i class="fa fa-gears"></i>
                                <span>设置</span>
                                </span>
                            </a>
                        </li>
                        <?php }?>
                    </ul>
                </div>
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <?php include 'self.php';?>
                        <?php include 'news.php';?>
                        <li class="dropdown user user-menu">
                            <a href="/site/logout">
                                <i class="fa fa-sign-out"></i>
                                <span>退出</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <div class="content-wrapper">
            <section class="content-header">
                <h1>
                    <?=$this->title?>
                    <small></small>
                </h1>
                <ol class="breadcrumb">
                    <?php if ($this->title != '总览') {?>
                    <li><a href="/site/index"><i class="fa fa-dashboard"></i> 总览</a></li>
                    <?php }?>
                    <?php if ($this->title != '威胁' && isActive(['alert']) == 'active') {?>
                    <li><a href="/alert/index"><i class="fa fa-heartbeat"></i> 威胁</a></li>
                    <?php }?>
                    <?php if ($this->title != '计算机' && isActive(['sensor']) == 'active') {?>
                    <li><a href="/sensor/index"><i class="fa fa-laptop"></i> 计算机</a></li>
                    <?php }?>
                    <?php if ($this->title != '安全调查' && isActive(['investigate']) == 'active') {?>
                    <li><a href="/investigate/index"><i class="fa fa-search"></i> 安全调查</a></li>
                    <?php }?>
                    <?php if ($this->title != '设置' && isActive(['seting']) == 'active') {?>
                    <li><a href="/seting/index"><i class="fa fa-gears"></i> 设置</a></li>
                    <?php }?>
                    <li class="active">
                        <?=$this->title?>
                    </li>
                </ol>
            </section>
            <?=$content?>
            <div class="hoohoolab-footer">
                <span>&copy; 虎特信息科技(上海)有限公司 版权所有</span>
                <!-- <span>&copy; 2019 北京圣博润高新技术股份有限公司</span> -->
            </div>
        </div>
        <script src="/plugins/jQuery/jquery-2.2.3.min.js"></script>
        <!-- jQuery UI 1.11.4 -->
        <script src="/plugins/jQueryUI/jquery-ui.min.js"></script>
        <script>
            $.widget.bridge('uibutton', $.ui.button);
        </script>
        <!-- Bootstrap 3.3.6 -->
        <script src="/bootstrap/js/bootstrap.min.js"></script>

        <!-- Sparkline -->
        <script src="/plugins/sparkline/jquery.sparkline.min.js"></script>
        <!-- jvectormap -->
        <script src="/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
        <script src="/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
        <!-- jQuery Knob Chart -->
        <script src="/plugins/knob/jquery.knob.js"></script>
        <!-- Bootstrap WYSIHTML5 -->
        <script src="/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
        <!-- Slimscroll -->
        <script src="/plugins/slimScroll/jquery.slimscroll.min.js"></script>
        <!-- FastClick -->
        <script src="/plugins/fastclick/fastclick.js"></script>
        <!-- date-range-picker -->
        <script src="/plugins/daterangepicker/moment.min.js"></script>
        <script src="/plugins/daterangepicker/moment-zh.js"></script>
        <script src="/plugins/daterangepicker/daterangepicker.js"></script>
        <!-- zeroModal -->
        <script src="/js/zeroModal.min.js"></script>
        <!-- Fileupload -->
        <!-- <script src="/js/jquery-ui.min.js"></script> -->
        <script src="/js/jquery.iframe-transport.js"></script>
        <script src="/js/jquery.fileupload.js"></script>
        <script src="/js/webuploader.js"></script>
        <!-- Chart.js -->
        <script src="/plugins/chartjs/Chart.min.2.5.js"></script>
        <!-- canvasjs.js -->
        <script src="/plugins/canvasjs-1.9.8/canvasjs.min.js"></script>
        <!-- bootstrap-treeview -->
        <script src="/js/bootstrap-treeview.js"></script>
        <!-- Highcharts -->
        <script src="https://cdn.hcharts.cn/highcharts/highcharts.js"></script>
        <!-- DataTables -->
        <script src="/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="/plugins/datatables/dataTables.bootstrap.min.js"></script>
        <!-- AdminLTE App -->
        <script src="/dist/js/app.js"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="/dist/js/demo.js"></script>
</body>

</html>