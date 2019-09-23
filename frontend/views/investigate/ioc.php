<!-- IOC -->
<div class="tab-pane" id="IOC" ng-controller="IocCtrl">
    <div class="row margin">
        <div style="margin:5px 20px">
            <div class="input-file">
                <form id="upload" method="post" enctype="multipart/form-data">
                    <input type="text" id="avatval" ng-click="file_choose()" placeholder="请点击此处选择文件···" readonly="readonly"
                        style="vertical-align: middle;" />
                    <input type="file" name="file" id="avatar" accept=".txt,.ioc" />
                    <button ng-click="uploadPic()" class="btn btn-success upload_button" ng-disabled="upload_true" id="avatsel1">上传文件</button>
                </form>
            </div>
            <div ng-show="progress_if" class="progress progress-striped active" style="margin: 20px 0;border-radius: 5px;width: 300px">
                <div class="progress-bar progress-bar-success" id="progress" role="progressbar" aria-valuenow="60"
                    aria-valuemin="0" aria-valuemax="100">
                </div>
            </div>
        </div>
        <div style="margin:20px">
            <span> 请选择.txt（
                <a ng-click="download_temp()"> 下载模版</a>）或者.ioc的格式文件上传。</span>
        </div>
        <div class="tab-content" style="padding-top:0px;border-bottom:0px;">
            <div class="tab-pane active" id="protect">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-solid" style="margin-top:10px;">
                            <div id="myTabContent" class="tab-content">
                                <div class="tab-pane fade in active" id="net">
                                    <div class="box-body">
                                        <table class="table table-hover  ng-cloak" style="table-layout: fixed">
                                            <tr>
                                                <th style="width:80px">序号</th>
                                                <th>搜索</th>
                                                <th style="width:120px">进度</th>
                                                <th style="width:120px">状态</th>
                                                <th style="width:120px">CSV文件</th>
                                                <th style="width:150px">创建时间</th>
                                                <th style="width:120px">操作</th>
                                            </tr>
                                            <tr ng-repeat="item in pages_ioc.list">
                                                <td style="width:80px" ng-bind="$index + 1 + index_num">1</td>
                                                <td class="td_class" title="{{item.upload_file_name}}" ng-bind="item.upload_file_name">ioc文件</td>
                                                <td style="width:120px" ng-bind="item.create_percent ">50%</td>
                                                <td style="width:120px" ng-bind="item.create_status == '0'?'创建中':'完成'">完成</td>
                                                <td style="width:120px;cursor:pointer" class="cursor">
                                                    <img src="/images/icos/download.png" ng-click="download(item)"
                                                        width="16" height="16" alt="">
                                                </td>
                                                <td style="width:150px" ng-bind="item.create_time*1000 | date: 'yyyy-MM-dd HH:mm:ss' ">2018-07-20
                                                    05:00:00</td>
                                                <td class="cursor" style="width:120px;cursor:pointer">&nbsp;&nbsp;
                                                    <img src="/images/icos/delate.png" ng-click="del(item)" width="16"
                                                        height="16" alt="">
                                                </td>
                                            </tr>
                                        </table>
                                        <div style="border-top: 1px solid #f4f4f4;padding: 10px;">
                                            <em>共有
                                                <span ng-bind="pages_ioc.total_count"></span>条</em>
                                            <ul class="pagination pagination-sm no-margin pull-right ng-cloak">
                                                <li>
                                                    <a href="javascript:void(0);" ng-click="ioc(pages_ioc.pageNow-1)"
                                                        ng-if="pages_ioc.pageNow>1">上一页</a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);" ng-click="ioc(1)" ng-if="pages_ioc.pageNow>1">1</a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);" ng-if="pages_ioc.pageNow>4">...</a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);" ng-click="ioc(pages_ioc.pageNow-2)"
                                                        ng-bind="pages_ioc.pageNow-2" ng-if="pages_ioc.pageNow>3"></a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);" ng-click="ioc(pages_ioc.pageNow-1)"
                                                        ng-bind="pages_ioc.pageNow-1" ng-if="pages_ioc.pageNow>2"></a>
                                                </li>
                                                <li class="active">
                                                    <a href="javascript:void(0);" ng-bind="pages_ioc.pageNow"></a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);" ng-click="ioc(pages_ioc.pageNow+1)"
                                                        ng-bind="pages_ioc.pageNow+1" ng-if="pages_ioc.pageNow<pages_ioc.maxPage-1"></a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);" ng-click="ioc(pages_ioc.pageNow+2)"
                                                        ng-bind="pages_ioc.pageNow+2" ng-if="pages_ioc.pageNow<pages_ioc.maxPage-2"></a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);" ng-if="pages_ioc.pageNow<pages_ioc.maxPage-3">...</a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);" ng-click="ioc(pages_ioc.maxPage)"
                                                        ng-bind="pages_ioc.maxPage" ng-if="pages_ioc.pageNow<pages_ioc.maxPage"></a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);" ng-click="ioc(pages_ioc.pageNow+1)"
                                                        ng-if="pages_ioc.pageNow<pages_ioc.maxPage">下一页</a>
                                                </li>
                                            </ul>
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
</div>