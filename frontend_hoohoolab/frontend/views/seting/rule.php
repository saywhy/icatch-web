<?php
/* @var $this yii\web\View */

$this->title = '规则库更新';
?>
<style>
    .upload_button {
        height: 34px !important;
        font-size: 14px !important;
        line-height: 4px !important;
        padding: 0;
        width: 80px;
    }




    button,
    input {
        margin: 0;
        font: inherit;
        color: inherit
    }

    button::-moz-focus-inner,
    input::-moz-focus-inner {
        padding: 0;
        border: 0
    }

    table {
        border-spacing: 0;
        border-collapse: collapse
    }

    td,
    th {
        padding: 0
    }

    .progress {
        height: 20px;
        margin-bottom: 20px;
        overflow: hidden;
        background-color: #f5f5f5;
        border-radius: 4px;
        -webkit-box-shadow: inset 0 1px 2px rgba(0, 0, 0, .1);
        box-shadow: inset 0 1px 2px rgba(0, 0, 0, .1)
    }

    .progress-bar {
        float: left;
        width: 0;
        height: 100%;
        font-size: 12px;
        line-height: 20px;
        color: #fff;
        text-align: center;
        background-color: #337ab7;
        -webkit-box-shadow: inset 0 -1px 0 rgba(0, 0, 0, .15);
        box-shadow: inset 0 -1px 0 rgba(0, 0, 0, .15);
        -webkit-transition: width .6s ease;
        -o-transition: width .6s ease;
        transition: width .6s ease
    }

    .progress-bar-striped,
    .progress-striped .progress-bar {
        background-image: -webkit-linear-gradient(45deg, rgba(255, 255, 255, .15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, .15) 50%, rgba(255, 255, 255, .15) 75%, transparent 75%, transparent);
        background-image: -o-linear-gradient(45deg, rgba(255, 255, 255, .15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, .15) 50%, rgba(255, 255, 255, .15) 75%, transparent 75%, transparent);
        background-image: linear-gradient(45deg, rgba(255, 255, 255, .15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, .15) 50%, rgba(255, 255, 255, .15) 75%, transparent 75%, transparent);
        -webkit-background-size: 40px 40px;
        background-size: 40px 40px
    }

    .progress-bar.active,
    .progress.active .progress-bar {
        -webkit-animation: progress-bar-stripes 2s linear infinite;
        -o-animation: progress-bar-stripes 2s linear infinite;
        animation: progress-bar-stripes 2s linear infinite
    }

    .progress-bar-success {
        background-color: #5cb85c
    }

    .progress-striped .progress-bar-success {
        background-image: -webkit-linear-gradient(45deg, rgba(255, 255, 255, .15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, .15) 50%, rgba(255, 255, 255, .15) 75%, transparent 75%, transparent);
        background-image: -o-linear-gradient(45deg, rgba(255, 255, 255, .15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, .15) 50%, rgba(255, 255, 255, .15) 75%, transparent 75%, transparent);
        background-image: linear-gradient(45deg, rgba(255, 255, 255, .15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, .15) 50%, rgba(255, 255, 255, .15) 75%, transparent 75%, transparent)
    }

    .progress-bar-info {
        background-color: #5bc0de
    }

    .progress-striped .progress-bar-info {
        background-image: -webkit-linear-gradient(45deg, rgba(255, 255, 255, .15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, .15) 50%, rgba(255, 255, 255, .15) 75%, transparent 75%, transparent);
        background-image: -o-linear-gradient(45deg, rgba(255, 255, 255, .15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, .15) 50%, rgba(255, 255, 255, .15) 75%, transparent 75%, transparent);
        background-image: linear-gradient(45deg, rgba(255, 255, 255, .15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, .15) 50%, rgba(255, 255, 255, .15) 75%, transparent 75%, transparent)
    }

    .progress-bar-warning {
        background-color: #f0ad4e
    }

    .progress-striped .progress-bar-warning {
        background-image: -webkit-linear-gradient(45deg, rgba(255, 255, 255, .15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, .15) 50%, rgba(255, 255, 255, .15) 75%, transparent 75%, transparent);
        background-image: -o-linear-gradient(45deg, rgba(255, 255, 255, .15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, .15) 50%, rgba(255, 255, 255, .15) 75%, transparent 75%, transparent);
        background-image: linear-gradient(45deg, rgba(255, 255, 255, .15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, .15) 50%, rgba(255, 255, 255, .15) 75%, transparent 75%, transparent)
    }

    .progress-bar-danger {
        background-color: #d9534f
    }

    .progress-striped .progress-bar-danger {
        background-image: -webkit-linear-gradient(45deg, rgba(255, 255, 255, .15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, .15) 50%, rgba(255, 255, 255, .15) 75%, transparent 75%, transparent);
        background-image: -o-linear-gradient(45deg, rgba(255, 255, 255, .15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, .15) 50%, rgba(255, 255, 255, .15) 75%, transparent 75%, transparent);
        background-image: linear-gradient(45deg, rgba(255, 255, 255, .15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, .15) 50%, rgba(255, 255, 255, .15) 75%, transparent 75%, transparent)
    }

    td,
    th {
        border: 0 !important;
    }
</style>
<!-- Main content -->
<section class="content" ng-app="myApp" ng-controller="RuleCtrl">
    <div class="row">
        <div class="col-xs-12">
            <div class="nav-tabs-custom">
                <?php include 'nav.php';?>
                <div class="tab-content">
                    <!-- 规则库更新-->
                    <div class="tab-pane active" id="userlog">
                        <div class="row margin">
                            <div class="col-md-12 ">
                                <div class="set_content">
                                    <div class="rule_item">
                                        <div class="rule_item_header row">
                                            <h4 class="col-md-1" style="min-width:150px">实时更新</h4>
                                        </div>
                                        <div style="margin: 10px 10px 0px 10px">
                                            <table class="table " ng-cloak cellspacing="0" cellpadding="0" border='0'
                                                style="width: auto;margin: 0">
                                                <tr ng-if="online_status.RegOnlineUpdateStatus.length!=0">
                                                    <td style="width: 80px;">
                                                        <span>Reg</span>
                                                    </td>
                                                    <td style="width: 260px;">
                                                        <p ng-if="online_status.RegOnlineUpdateStatus[1] == '0'">
                                                            <span>开始更新时间：</span>
                                                            <span
                                                                ng-bind="online_status.RegOnlineUpdateStatus[3]*1000 | date:'yyyy-MM-dd HH:mm:ss'"></span>
                                                        </p>
                                                        <p ng-if="online_status.RegOnlineUpdateStatus[1] == '1'">
                                                            <span>上次更新时间：</span>
                                                            <span
                                                                ng-bind="online_status.RegOnlineUpdateStatus[3]*1000 | date:'yyyy-MM-dd HH:mm:ss'"></span>
                                                        </p>
                                                        <p ng-if="online_status.RegOnlineUpdateStatus[1] == '2'">
                                                            <span>更新失败时间：</span>
                                                            <span
                                                                ng-bind="online_status.RegOnlineUpdateStatus[3]*1000 | date:'yyyy-MM-dd HH:mm:ss'"></span>
                                                        </p>
                                                    </td>
                                                    <td style="width: 60px;">
                                                        <p ng-if="online_status.RegOnlineUpdateStatus[1] == '0'">
                                                            <span>更新中</span>
                                                        </p>
                                                        <p ng-if="online_status.RegOnlineUpdateStatus[1] == '1'">
                                                            <span>成功</span>
                                                        </p>
                                                        <p ng-if="online_status.RegOnlineUpdateStatus[1] == '2'">
                                                            <span>失败</span>
                                                        </p>
                                                    </td>
                                                </tr>
                                                <!-- VirOnlineUpdateStatus -->
                                                <tr ng-if="online_status.VirOnlineUpdateStatus.length!=0">
                                                    <td style="width: 80px;">
                                                        <span>Vir</span>
                                                    </td>
                                                    <td style="width: 260px;">
                                                        <p ng-if="online_status.VirOnlineUpdateStatus[1] == '0'">
                                                            <span>开始更新时间：</span>
                                                            <span
                                                                ng-bind="online_status.VirOnlineUpdateStatus[3]*1000 | date:'yyyy-MM-dd HH:mm:ss'"></span>
                                                        </p>
                                                        <p ng-if="online_status.VirOnlineUpdateStatus[1] == '2'">
                                                            <span>上次更新时间：</span>
                                                            <span
                                                                ng-bind="online_status.VirOnlineUpdateStatus[3]*1000 | date:'yyyy-MM-dd HH:mm:ss'"></span>
                                                        </p>
                                                        <p ng-if="online_status.VirOnlineUpdateStatus[1] == '2'">
                                                            <span>更新失败时间：</span>
                                                            <span
                                                                ng-bind="online_status.VirOnlineUpdateStatus[3]*1000 | date:'yyyy-MM-dd HH:mm:ss'"></span>
                                                        </p>
                                                    </td>
                                                    <td style="width: 60px;">
                                                        <p ng-if="online_status.VirOnlineUpdateStatus[1] == '0'">
                                                            <span>更新中</span>
                                                        </p>
                                                        <p ng-if="online_status.VirOnlineUpdateStatus[1] == '1'">
                                                            <span>成功</span>
                                                        </p>
                                                        <p ng-if="online_status.VirOnlineUpdateStatus[1] == '2'">
                                                            <span>失败</span>
                                                        </p>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-1 col-md-offset-5">
                                                <label style="width: 100%;">&nbsp;</label>
                                                <button class="btn btn-primary btn_style" style="max-width: 80px;"
                                                    ng-click="real_time_update()">更新</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="rule_item">
                                        <div class="rule_item_header row">
                                            <h4 class="col-md-1" style="min-width:150px">离线更新</h4>
                                        </div>
                                        <div style="margin: 20px 20px 0px 20px">
                                            <span>上传文件成功后，点击更新按钮，离线更新规则库。</span>
                                        </div>
                                        <div style="margin: 10px 10px 0px 10px">
                                            <table class="table " ng-cloak cellspacing="0" cellpadding="0" border='0'
                                                style="width: auto;margin: 0">
                                                <tr ng-if="offline_status.RegOfflineUpdateStatus.length!=0">
                                                    <td style="width: 80px;">
                                                        <span>Reg</span>
                                                    </td>
                                                    <td style="width: 260px;">
                                                        <p ng-if="offline_status.RegOfflineUpdateStatus[1] == '0'">
                                                            <span>开始更新时间：</span>
                                                            <span
                                                                ng-bind="offline_status.RegOfflineUpdateStatus[3]*1000 | date:'yyyy-MM-dd HH:mm:ss'"></span>
                                                        </p>
                                                        <p ng-if="offline_status.RegOfflineUpdateStatus[1] == '1'">
                                                            <span>上次更新时间：</span>
                                                            <span
                                                                ng-bind="offline_status.RegOfflineUpdateStatus[3]*1000 | date:'yyyy-MM-dd HH:mm:ss'"></span>
                                                        </p>
                                                        <p ng-if="offline_status.RegOfflineUpdateStatus[1] == '2'">
                                                            <span>更新失败时间：</span>
                                                            <span
                                                                ng-bind="offline_status.RegOfflineUpdateStatus[3]*1000 | date:'yyyy-MM-dd HH:mm:ss'"></span>
                                                        </p>
                                                    </td>
                                                    <td style="width: 60px;">
                                                        <p ng-if="offline_status.RegOfflineUpdateStatus[1] == '0'">
                                                            <span>更新中</span>
                                                        </p>
                                                        <p ng-if="offline_status.RegOfflineUpdateStatus[1] == '1'">
                                                            <span>成功</span>
                                                        </p>
                                                        <p ng-if="offline_status.RegOfflineUpdateStatus[1] == '2'">
                                                            <span>失败</span>
                                                        </p>
                                                    </td>
                                                </tr>
                                                <!-- VirOnlineUpdateStatus -->
                                                <tr ng-if="offline_status.VirOfflineUpdateStatus.length!=0">
                                                    <td style="width: 80px;">
                                                        <span>Vir</span>
                                                    </td>
                                                    <td style="width: 260px;">
                                                        <p ng-if="offline_status.VirOfflineUpdateStatus[1] == '0'">
                                                            <span>开始更新时间：</span>
                                                            <span
                                                                ng-bind="offline_status.VirOfflineUpdateStatus[3]*1000 | date:'yyyy-MM-dd HH:mm:ss'"></span>
                                                        </p>
                                                        <p ng-if="offline_status.VirOfflineUpdateStatus[1] == '1'">
                                                            <span>上次更新时间：</span>
                                                            <span
                                                                ng-bind="offline_status.VirOfflineUpdateStatus[3]*1000 | date:'yyyy-MM-dd HH:mm:ss'"></span>
                                                        </p>
                                                        <p ng-if="offline_status.VirOfflineUpdateStatus[1] == '2'">
                                                            <span>更新失败时间：</span>
                                                            <span
                                                                ng-bind="offline_status.VirOfflineUpdateStatus[3]*1000 | date:'yyyy-MM-dd HH:mm:ss'"></span>
                                                        </p>
                                                    </td>
                                                    <td style="width: 60px;">
                                                        <p ng-if="offline_status.VirOfflineUpdateStatus[1] == '0'">
                                                            <span>更新中</span>
                                                        </p>
                                                        <p ng-if="offline_status.VirOfflineUpdateStatus[1] == '1'">
                                                            <span>成功</span>
                                                        </p>
                                                        <p ng-if="offline_status.VirOfflineUpdateStatus[1] == '2'">
                                                            <span>失败</span>
                                                        </p>
                                                    </td>
                                                </tr>
                                                <!-- DfOfflineUpdateStatus -->
                                                <tr ng-if="offline_status.DfOfflineUpdateStatus.length!=0">
                                                    <td style="width: 80px;">
                                                        <span>Df</span>
                                                    </td>
                                                    <td style="width: 260px;">
                                                        <p ng-if="offline_status.DfOfflineUpdateStatus[1] == '0'">
                                                            <span>开始更新时间：</span>
                                                            <span
                                                                ng-bind="offline_status.DfOfflineUpdateStatus[3]*1000 | date:'yyyy-MM-dd HH:mm:ss'"></span>
                                                        </p>
                                                        <p ng-if="offline_status.DfOfflineUpdateStatus[1] == '1'">
                                                            <span>上次更新时间：</span>
                                                            <span
                                                                ng-bind="offline_status.DfOfflineUpdateStatus[3]*1000 | date:'yyyy-MM-dd HH:mm:ss'"></span>
                                                        </p>
                                                        <p ng-if="offline_status.DfOfflineUpdateStatus[1] == '2'">
                                                            <span>更新失败时间：</span>
                                                            <span
                                                                ng-bind="offline_status.DfOfflineUpdateStatus[3]*1000 | date:'yyyy-MM-dd HH:mm:ss'"></span>
                                                        </p>
                                                    </td>
                                                    <td style="width: 60px;">
                                                        <p ng-if="offline_status.DfOfflineUpdateStatus[1] == '0'">
                                                            <span>更新中</span>
                                                        </p>
                                                        <p ng-if="offline_status.DfOfflineUpdateStatus[1] == '1'">
                                                            <span>成功</span>
                                                        </p>
                                                        <p ng-if="offline_status.DfOfflineUpdateStatus[1] == '2'">
                                                            <span>失败</span>
                                                        </p>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div style="margin:20px">
                                            <div>
                                                <div id="thelist" class="uploader-list"></div>
                                                <div id="picker" style="display: inline;">选择文件</div>
                                                <button id="ctlBtn" class="btn btn-primary upload_button"
                                                    ng-disabled="upload"
                                                    style="margin-left: 20px; margin-bottom: 26px;">开始上传</button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-1 col-md-offset-5">
                                                <label style="width: 100%;">&nbsp;</label>
                                                <!-- <button class="btn btn-primary btn_style" style="max-width: 80px;"
                                                    ng-click="offline_update()" ng-disabled="update">更新</button> -->
                                                <button class="btn btn-primary btn_style" style="max-width: 80px;"
                                                    ng-click="offline_update()">更新</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
<script type="text/javascript" src="/js/controllers/rule.js"></script>