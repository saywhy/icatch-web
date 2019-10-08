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
    width:66px;
    padding:5px;
    outline:none;
}
.num_class:focus{
    border: 1px solid #3c8dbc !important;
    box-shadow: none;
}
.alert-lists > td{
    padding: 10px 8px!important;
    line-height:18px!important;
}

.choose_box{
    width: 100%;
    height: 68px;
    background: #F8F8F8;
}
.choose_box_left{
    float: left;
    line-height: 68px;
    width: 300px;
    padding-left: 8px;
}
.choose_box_right{
    float: right;
    height: 68px;
    position: relative;
    width: 316px;
}
.choose_box_mid{
    float: right;
    line-height: 68px;
}
.cursor{
   cursor:pointer;
   vertical-align:middle;
   width: 13px;
}
.choose_text{
   font-size: 14px;
   color: #999;
}

.cel_btn_false{
    border-radius: 4px;
    width: 104px;
    height: 36px;
    font-size: 14px;
    position: absolute;
    left: 48px;
    top: 50%;
    transform: translateY(-50%);
    color: #BBBBBB;
    border: 1px solid #BBBBBB;
    outline:none;
}
.cel_btn_true{
    color: #666;!important;
    background: #FFF5EE!important;
    border: 1px solid #FFF5EE;
}

.ok_btn_false{
    width: 104px;
    height: 36px;
    border: none;
    background: #F2F2F2;
    border-radius: 4px;
    color: #BBBBBB;
    position: absolute;
    right: 36px;
    top: 50%;
    transform: translateY(-50%);
    outline:none;
}
.ok_btn_true{
    color: #fff;!important;
    background: #337AB7!important;
}
.select_choose_type_false{
    width: 114px;
    height: 36px;
    border-radius: 4px;
    background-color: #F2F2F2;
    color: #bbb;
    border:1px solid #F2F2F2;
    outline:none;
}
.select_choose_type_true{
   cursor:pointer;
   background-color: #fff !important;
   color:#333;!important;
   border:1px solid #fff;
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
        <div class="col-md-12" ng-controller="behCtrl" ng-cloak>
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><i class="fa fa-bell-o"></i> 当前告警</h3>
                    <div class="box-tools" ng-if="IDList.length>0">
                    </div>
                </div>
                <!-- 搜索条件 -->
                <div class="row margin search_box">
                    <div class="form-group col-md-2" style="width:168px">
                        <label>计算机名/IP</label>
                        <input type="text" class="form-control input_radius" ng-model="searchData.ComputerName" ng-keyup="myKeyup($event)">
                    </div>
                    <!-- <div class="form-group col-md-2" style="width:150px">
                        <label>告警事件</label>
                        <input type="text" class="form-control input_radius" ng-model="searchData.AlertType" ng-keyup="myKeyup($event)">
                    </div> -->
                    <div class="form-group col-md-1" style="width: 150px;">
                        <label>告警事件</label>
                        <select class="form-control input_radius" ng-init="searchData.AlertType=10"  ng-model="searchData.AlertType"
                            ng-options="x.num as x.label for x in AlertType_select"></select>
                    </div>
                    <!-- 组下拉框 -->
                    <div class="form-group col-md-1" style="width: 150px;">
                        <label>组</label>
                        <select class="form-control input_radius" ng-model="searchData.gid">
                            <option value="" label="所有"></option>
                            <option ng-repeat="x in alertGid_select" value="{{x.text}}" label="{{x.text}}"></option>
                        </select>
                    </div>
                    <!-- 组下拉框 -->

                    <div class="form-group col-md-2" style="width:120px">
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
                                    <th><input type="checkbox" ng-checked="IDListData.length === pages.data.length && IDListData.length > 0"
                                        ng-click="selectAll()">
                                    </th>
                                    <th style="padding-left: 30px;">计算机</th>
                                    <th>告警事件</th>
                                    <th>告警对象</th>
                                    <th>告警时间</th>
                                    <th>指数</th>
                                    <th>状态</th>
                                </tr>

                                <tr class="alert-lists" style="cursor: pointer;" ng-repeat="item in pages.data" ng-click="detail(item,$event)">
                                    <td style="z-index:999;" ng-click="$event.stopPropagation();">
                                        <input type="checkbox" ng-checked="IDList.indexOf(item.id) != -1"
                                        ng-click="selectOne(item,$event)" ng-disabled="(item.status != 1)">
                                    </td>

                                    <td style="padding-left: 30px;position:relative;" title="{{item.SensorID+'|'+item.AlertID}}">
                                       <a style="position:absolute;top:1px;z-index:999;" ng-bind="item.ComputerName"  ng-click="linkToSensor(item.SensorID,$event)"></a>
                                       <span style="display:block;position:absolute;top:21px;" ng-bind="item.SensorIP"></span>
                                    </td>
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

                            <!-- 处理状态栏 -->
                            <div class="choose_box" ng-if="pages.data.length > 0">
                                <div class="choose_box_left">
                                    <p style="margin:0">
                                        <!--<img src="/images/select_false.png" class="cursor select_false" ng-click="selectAll()" alt="">-->
                                        <input type="checkbox" ng-checked="IDListData.length === pages.data.length && IDListData.length > 0" ng-click="selectAll()"/>
                                        <span>全选</span>
                                        <span class="choose_text">(已选择</span>
                                        <span class="choose_text ng-binding" ng-bind="IDListData.length"></span>
                                        <span class="choose_text">条预警)</span>
                                    </p>
                                </div>
                                <div class="choose_box_right">
                                    <button class="cel_btn_false" ng-click="celAlert();" ng-class="{'cel_btn_true':IDListData.length > 0}" ng-disabled="IDListData.length === 0">取消</button>
                                    <button class="ok_btn_false" ng-click="update('setOldBeh',IDListData)" ng-class="{'ok_btn_true':IDListData.length > 0}" ng-disabled="IDListData.length === 0">确定</button>
                                </div>
                                <div class="choose_box_mid">
                                    　<span style="margin-right:12px;">更改处理状态为</span>
                                      <select class="select_choose_type_false" ng-class="{'select_choose_type_true':IDListData.length > 0}" ng-disabled="IDListData.length === 0">
                                           <option label="已解决" value="string:2">已解决</option>
                                      </select>
                                </div>
                            </div>

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

<script type="text/javascript">
  var GroupList = <?= json_encode($GroupList) ?>;
</script>

<script src="/js/controllers/baseEX.js"></script>
<!-- <script src="/js/controllers/fileEX.js"></script>
<script src="/js/controllers/ipEX.js"></script>
<script src="/js/controllers/urlEX.js"></script> -->
<script src="/js/controllers/newEX.js"></script>
<script src="/js/controllers/oldEX.js"></script>
<script src="/js/controllers/by3EX.js"></script>