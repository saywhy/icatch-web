<?php
/* @var $this yii\web\View */

$this->title = '威胁';
// $this->params['chartVersion'] = '1.1.1';
?>
<style>
.num_class{
    height:34px;
    color:#555;
    border: 1px solid #ccc;
    width:70px;
    padding:5px;
    outline:none
}
.num_class:focus{
    border: 1px solid #3c8dbc !important;
    box-shadow: none;
}
</style>
<!-- Main content -->
<section class="content" ng-app="myApp">
    <div class="row">
        <div class="col-md-6">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-camera"></i> 告警统计</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <div style="padding: 10px" class="row chart">
                        <canvas id="sensorChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-camera"></i> 威胁来源</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <div style="padding: 10px" class="row chart">
                        <canvas id="alertChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--当前告警 -->
    <div class="row">
        <div class="col-md-12" ng-controller="behCtrl">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><i class="fa fa-bell-o"></i> 当前告警</h3>
                    <div class="box-tools" ng-if="IDList.length>0">
                    </div>
                </div>
                <!-- 搜索条件 -->
                <div class="row margin search_box">

                    <div class="form-group col-md-2" style="width:200px">
                        <label>计算机</label>
                        <input type="text" class="form-control input_radius" ng-model="searchData.ComputerName" ng-keyup="myKeyup($event)">
                    </div>
                    <!-- <div class="form-group col-md-2" style="width:200px">
                        <label>告警事件</label>
                        <input type="text" class="form-control input_radius" ng-model="searchData.AlertType" ng-keyup="myKeyup($event)">
                    </div> -->
                    <div class="form-group col-md-2" style="width: 200px;">
                                <label>告警事件</label>
                                <select class="form-control input_radius" ng-init="searchData.AlertType=10"  ng-model="searchData.AlertType"
                                    ng-options="x.num as x.label for x in AlertType_select"></select>
                    </div>
                    <div class="form-group col-md-2" style="width:200px">
                        <label>告警对象</label>
                        <input type="text" class="form-control input_radius" ng-model="searchData.Label" ng-keyup="myKeyup($event)">
                    </div>
                    <div class="form-group col-md-3" style="width:300px">
                        <label>告警时间</label>
                        <input type="text" class="form-control timerange input_radius" readonly style="background-color: #fff;">
                    </div>
                    <div class="form-group col-md-2" >
                        <label>指数 (0-100)</label>
                        <div>
                        <input type="number" class=" num_class" min="0" max='100' ng-model="searchData.MinPoint" value="" ng-keyup="myKeyup_min(searchData.MinPoint)">
                        <span style="line-height:34px;margin:0 20px;">-</span>
                        <input type="number" class="num_class"min="0" max='100'  ng-model="searchData.MaxPoint" ng-keyup="myKeyup_max(searchData.MaxPoint)">
                        </div>
                    </div>
                    <div class="form-group col-md-1">
                        <label style="width: 100%;">&nbsp;</label>
                        <button class=" btn btn-primary btn_style" style="max-width: 80px;" ng-click="search()">搜 索</button>
                    </div>
                </div>
                <div class="box-body table-responsive no-padding">
                    <div class="nav-tabs-custom" style="margin-bottom: 0px">
                        <div class="tab-content" style="padding-top:0px;border-bottom:0px; ">
                            <table class="table table-hover ng-cloak">
                                <tr>
                                    <th style="padding-left: 30px;">计算机</th>
                                    <th>告警事件</th>
                                    <th>告警对象</th>
                                    <th>告警时间</th>
                                    <th>指数</th>
                                    <th>状态</th>
                                </tr>

                                <tr style="cursor: pointer;" ng-repeat="item in pages.data" ng-click="detail(item,$event)">
                                <!-- <tr style="cursor: pointer;" ng-repeat="item in pages.data" > -->
                                    <td style="padding-left: 30px;" title="{{item.SensorID+'|'+item.AlertID}}"><i class="fa fa-laptop"></i>
                                        <span ng-bind="item.ComputerName"></span></td>
                                    <td>
                                        <span class="label label-{{AlertType_str[item.AlertType].css}}" ng-bind="AlertType_str[item.AlertType].label"></span>
                                    </td>
                                    <td ng-bind="item.Label"></td>
                                    <td ng-bind="item.created_at*1000 | date:'yyyy-MM-dd HH:mm'"></td>
                                    <td ng-bind="item.Point == 100 ? 100 : 0"></td>


                                    <td>
                                        <div class="btn-group {{(ariaID == item.id)?'open':''}}">
                                            <button type="button" class="btn btn-{{status_str[item.status].css}} btn-xs dropdown-toggle"
                                                data-toggle="dropdown" aria-expanded="false" ng-click="setAriaID(item,$event);"
                                                ng-blur="delAriaID($event);" set-focus>
                                                <span ng-bind="status_str[item.status].label"></span>
                                                <?php if (Yii::$app->user->identity->role == 'admin') {?>
                                                <span class="caret"></span>
                                                <?php }?>
                                            </button>
                                            <?php if (Yii::$app->user->identity->role == 'admin') {?>
                                            <ul class="dropdown-menu" role="menu" ng-style="dropdown_menu">
                                                <li ng-if="item.AlertType>3"><a href="javascript:void(0);" ng-click="update('setOldBeh',item);$event.stopPropagation();">已解决</a></li>
                                                <li ng-if="item.AlertType>3"><a href="javascript:void(0);" ng-click="update('setWhiteBeh',item);$event.stopPropagation();">加入例外</a></li>

                                                <li ng-if="item.AlertType<4"><a href="javascript:void(0);" ng-click="update('setOld',item);$event.stopPropagation();">已解决</a></li>
                                                <li ng-if="item.AlertType<4"><a href="javascript:void(0);" ng-click="update('setWhite',item);$event.stopPropagation();">加入白名单</a></li>
                                            </ul>
                                            <?php }?>
                                        </div>
                                    </td>
                                </tr>

                            </table>

                            <!-- /.angularjs分页 -->
                            <div style="border-top: 1px solid #f4f4f4;padding: 10px;">
                                <em>共有<span ng-bind="pages.count"></span>个历史告警</em>
                                <!-- angularjs分页 -->
                                <ul class="pagination pagination-sm no-margin pull-right" ng-if="pages.count>0">
                                    <li><a href="javascript:void(0);" ng-click="getnewPage(pages.pageNow-1)" ng-if="pages.pageNow>1">上一页</a></li>
                                    <li><a href="javascript:void(0);" ng-click="getnewPage(1)" ng-if="pages.pageNow>1">1</a></li>
                                    <li><a href="javascript:void(0);" ng-if="pages.pageNow>4">...</a></li>

                                    <li><a href="javascript:void(0);" ng-click="getnewPage(pages.pageNow-2)" ng-bind="pages.pageNow-2"
                                            ng-if="pages.pageNow>3"></a></li>
                                    <li><a href="javascript:void(0);" ng-click="getnewPage(pages.pageNow-1)" ng-bind="pages.pageNow-1"
                                            ng-if="pages.pageNow>2"></a></li>

                                    <li class="active"><a href="javascript:void(0);" ng-bind="pages.pageNow"></a></li>

                                    <li><a href="javascript:void(0);" ng-click="getnewPage(pages.pageNow+1)" ng-bind="pages.pageNow+1"
                                            ng-if="pages.pageNow<pages.maxPage-1"></a></li>
                                    <li><a href="javascript:void(0);" ng-click="getnewPage(pages.pageNow+2)" ng-bind="pages.pageNow+2"
                                            ng-if="pages.pageNow<pages.maxPage-2"></a></li>


                                    <li><a href="javascript:void(0);" ng-if="pages.pageNow<pages.maxPage-3">...</a></li>

                                    <li><a href="javascript:void(0);" ng-click="getnewPage(pages.maxPage)" ng-bind="pages.maxPage"
                                            ng-if="pages.pageNow<pages.maxPage"></a></li>
                                    <li><a href="javascript:void(0);" ng-click="getnewPage(pages.pageNow+1)" ng-if="pages.pageNow<pages.maxPage">下一页</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!--历史告警 -->
    <div class="row">
        <div class="col-md-12">
            <div class="box collapsed-box">
                <div class="box-header">
                    <h3 class="box-title"><i class="fa fa-clock-o"></i> 历史告警</h3>
                    <div class="box-tools">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body table-responsive no-padding">
                    <div class="nav-tabs-custom" style="margin-bottom: 0px">
                        <ul class="nav nav-tabs" style="margin-bottom:-1px;">
                            <li class="active"><a href="#oldAlert" data-toggle="tab" aria-expanded="true">历史告警</a></li>
                            <li><a href="#by3Alert" data-toggle="tab" aria-expanded="false">现有方案检测历史</a></li>
                        </ul>
                        <div class="tab-content" style="padding-top:0px;border-bottom:0px; ">
                            <div class="tab-pane active" id="oldAlert" ng-controller="oldCtrl">
                                <table class="table table-hover" ng-show="pages.data.length>0">
                                    <tr>
                                        <th style="padding-left: 30px;">计算机名</th>
                                        <th>告警事件</th>
                                        <th>告警对象</th>
                                        <th>告警时间</th>
                                        <th>指数</th>
                                        <th>状态</th>
                                    </tr>
                                    <tr style="cursor: pointer;" ng-repeat="item in pages.data" ng-click="detail(item.id)">
                                        <td style="padding-left: 30px;" ng-bind="item.ComputerName" title="{{item.SensorID+'|'+item.AlertID}}"></td>
                                        <td>
                                            <span class="label label-{{AlertType_str[item.AlertType].css}}" ng-bind="AlertType_str[item.AlertType].label"></span>

                                        </td>
                                        <td ng-bind="item.Label"></td>
                                        <td ng-bind="item.created_at*1000 | date:'yyyy-MM-dd HH:mm'"></td>
                                        <td ng-bind="item.Point == 100 ? 100 : 0"></td>


                                        <td>
                                            <span class="label label-{{status_str[item.status].css}}" ng-bind="status_str[item.status].label"
                                                ng-if="item.status == 2"></span>
                                            <div class="btn-group {{(ariaID == item.id)?'open':''}}" ng-if="item.status > 2">
                                                <button type="button" class="btn btn-{{status_str[item.status].css}} btn-xs dropdown-toggle"
                                                    data-toggle="dropdown" aria-expanded="false" ng-click="setAriaID(item,$event);"
                                                    ng-blur="delAriaID($event);" set-focus>
                                                    <span ng-bind="status_str[item.status].label"></span>
                                                    <?php if (Yii::$app->user->identity->role == 'admin') {?>
                                                    <span class="caret"></span>
                                                    <?php }?>
                                                </button>
                                                <?php if (Yii::$app->user->identity->role == 'admin') {?>
                                                <ul class="dropdown-menu" role="menu" ng-style="dropdown_menu">
                                                    <li ng-if="item.status == 4"><a href="javascript:void(0);" ng-click="update('delWhiteBeh',item);$event.stopPropagation();">取消例外</a></li>
                                                    <li ng-if="item.status == 3"><a href="javascript:void(0);" ng-click="update('delWhite',item);$event.stopPropagation();">移出白名单</a></li>
                                                </ul>
                                                <?php }?>
                                            </div>
                                        </td>
                                    </tr>

                                </table>
                                <div style="border-top: 1px solid #f4f4f4;padding: 10px;">
                                    <em>共有<span ng-bind="pages.count"></span>个历史告警</em>
                                    <ul class="pagination pagination-sm no-margin pull-right" ng-if="pages.count>0">
                                        <li><a href="javascript:void(0);" ng-click="getPage(pages.pageNow-1)" ng-if="pages.pageNow>1">上一页</a></li>
                                        <li><a href="javascript:void(0);" ng-click="getPage(1)" ng-if="pages.pageNow>1">1</a></li>
                                        <li><a href="javascript:void(0);" ng-if="pages.pageNow>4">...</a></li>

                                        <li><a href="javascript:void(0);" ng-click="getPage(pages.pageNow-2)" ng-bind="pages.pageNow-2"
                                                ng-if="pages.pageNow>3"></a></li>
                                        <li><a href="javascript:void(0);" ng-click="getPage(pages.pageNow-1)" ng-bind="pages.pageNow-1"
                                                ng-if="pages.pageNow>2"></a></li>

                                        <li class="active"><a href="javascript:void(0);" ng-bind="pages.pageNow"></a></li>

                                        <li><a href="javascript:void(0);" ng-click="getPage(pages.pageNow+1)" ng-bind="pages.pageNow+1"
                                                ng-if="pages.pageNow<pages.maxPage-1"></a></li>
                                        <li><a href="javascript:void(0);" ng-click="getPage(pages.pageNow+2)" ng-bind="pages.pageNow+2"
                                                ng-if="pages.pageNow<pages.maxPage-2"></a></li>


                                        <li><a href="javascript:void(0);" ng-if="pages.pageNow<pages.maxPage-3">...</a></li>

                                        <li><a href="javascript:void(0);" ng-click="getPage(pages.maxPage)" ng-bind="pages.maxPage"
                                                ng-if="pages.pageNow<pages.maxPage"></a></li>
                                        <li><a href="javascript:void(0);" ng-click="getPage(pages.pageNow+1)" ng-if="pages.pageNow<pages.maxPage">下一页</a></li>
                                    </ul>
                                </div>
                            </div>

                            <!-- 现有方案检测历史 -->
                            <div class="tab-pane" id="by3Alert" ng-controller="by3Ctrl">
                                <table class="table table-hover" ng-show="pages.data.length>0">
                                    <tr>
                                        <th>计算机名</th>
                                        <th>告警事件</th>
                                        <th>告警对象</th>
                                        <th>告警时间</th>
                                        <th>指数</th>
                                        <th>状态</th>
                                    </tr>
                                    <tr style="cursor: pointer;" ng-repeat="item in pages.data" ng-click="detail(item.id)">
                                        <td ng-bind="item.ComputerName" title="{{item.SensorID+'|'+item.AlertID}}"></td>
                                        <td>
                                            <span class="label label-{{AlertType_str[item.AlertType].css}}" ng-bind="AlertType_str[item.AlertType].label"></span>
                                        </td>
                                        <td ng-bind="item.Label"></td>
                                        <td ng-bind="item.created_at*1000 | date:'yyyy-MM-dd HH:mm'"></td>
                                        <td ng-bind="item.Point == 100 ? 100 : 0"></td>
                                        <td>
                                            <span class="label label-{{status_str[item.status].css}}" ng-bind="status_str[item.status].label"></span>
                                        </td>
                                    </tr>

                                </table>

                                <!-- /.angularjs分页 -->
                                <div style="border-top: 1px solid #f4f4f4;padding: 10px;">
                                    <em>共有<span ng-bind="pages.count"></span>个历史告警</em>
                                    <!-- angularjs分页 -->
                                    <ul class="pagination pagination-sm no-margin pull-right" ng-if="pages.count>0">
                                        <li><a href="javascript:void(0);" ng-click="getPage(pages.pageNow-1)" ng-if="pages.pageNow>1">上一页</a></li>
                                        <li><a href="javascript:void(0);" ng-click="getPage(1)" ng-if="pages.pageNow>1">1</a></li>
                                        <li><a href="javascript:void(0);" ng-if="pages.pageNow>4">...</a></li>

                                        <li><a href="javascript:void(0);" ng-click="getPage(pages.pageNow-2)" ng-bind="pages.pageNow-2"
                                                ng-if="pages.pageNow>3"></a></li>
                                        <li><a href="javascript:void(0);" ng-click="getPage(pages.pageNow-1)" ng-bind="pages.pageNow-1"
                                                ng-if="pages.pageNow>2"></a></li>

                                        <li class="active"><a href="javascript:void(0);" ng-bind="pages.pageNow"></a></li>

                                        <li><a href="javascript:void(0);" ng-click="getPage(pages.pageNow+1)" ng-bind="pages.pageNow+1"
                                                ng-if="pages.pageNow<pages.maxPage-1"></a></li>
                                        <li><a href="javascript:void(0);" ng-click="getPage(pages.pageNow+2)" ng-bind="pages.pageNow+2"
                                                ng-if="pages.pageNow<pages.maxPage-2"></a></li>


                                        <li><a href="javascript:void(0);" ng-if="pages.pageNow<pages.maxPage-3">...</a></li>

                                        <li><a href="javascript:void(0);" ng-click="getPage(pages.maxPage)" ng-bind="pages.maxPage"
                                                ng-if="pages.pageNow<pages.maxPage"></a></li>
                                        <li><a href="javascript:void(0);" ng-click="getPage(pages.pageNow+1)" ng-if="pages.pageNow<pages.maxPage">下一页</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="/js/controllers/baseEX.js"></script>
<!-- <script src="/js/controllers/fileEX.js"></script>
<script src="/js/controllers/ipEX.js"></script>
<script src="/js/controllers/urlEX.js"></script> -->
<script src="/js/controllers/newEX.js"></script>
<script src="/js/controllers/oldEX.js"></script>
<script src="/js/controllers/by3EX.js"></script>