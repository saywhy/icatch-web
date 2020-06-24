 <!-- 计算机 -->
<div class="row ng-cloak" ng-show="showTable == 'Computer'">
    <div class="col-md-12 ng-scope" id="ComputerDetails_col" ng-show="nowSensor">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">
                    <i class="fa fa-laptop"></i>
                    <span ng-bind="nowSensor.ComputerName"></span>
                </h3>
            </div>
            <div class="box-body table-responsive no-padding">
                <div class="col-md-6 border-right">
                    <ul class="nav nav-stacked sensor-detail">
                        <li>
                            <span class="sensor-detail-title">操作系统</span>
                            <span ng-bind="nowSensor.OSType"></span>
                        </li>
                        <li>
                            <span class="sensor-detail-title">所在域</span>
                            <span ng-bind="nowSensor.Domain"></span>
                        </li>
                        <li>
                            <span class="sensor-detail-title">IP地址</span>
                            <span ng-bind="nowSensor.IP"></span>
                        </li>
                    </ul>
                </div>
                <div class="col-md-6 border-right">
                    <ul class="nav nav-stacked sensor-detail">
                        <li>
                            <span class="sensor-detail-title-long">状态</span>
                            <span class="label label-{{status_str[nowSensor.status].css}}" ng-bind="status_str[nowSensor.status].label"></span>
                        </li>
                        <li>
                            <span class="sensor-detail-title-long">Sensor版本</span>
                            <span ng-bind="nowSensor.SensorVersion"></span>
                        </li>
                        <li>
                            <span class="sensor-detail-title-long">最近一次通讯</span>
                            <span ng-bind="nowSensor.updated_at*1000 | date:'yyyy-MM-dd HH:mm'"></span>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
        <div id="hide_box" style="display: none;">
            <table id="sensorList" class="table table-hover selectSensor">
                <thead>
                    <tr>
                        <th>计算机名</th>
                        <th>IP地址</th>
                        <th>最近一次通讯</th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="item in sensorList" ng-class="item.SensorID == selectSensor.SensorID ? 'focus' : ''"
                        ng-click='select(item)'>
                        <td ng-bind="item.ComputerName"></td>
                        <td ng-bind="item.IP"></td>
                        <td ng-bind="item.updated_at*1000 | date:'yyyy-MM-dd HH:mm'"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="col-md-12 ng-scope col-data" id="UserLogon_col">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">
                    <i class="fa fa-user-circle-o"></i> 用户登录信息
                </h3>
            </div>
            <div class="box-body table-responsive no-padding">
                <div class="nav-tabs-custom" style="margin-bottom: 0px">
                    <div class="tab-content">
                        <table id="UserLogon" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <!-- <th>用户名</th> -->
                                    <th>计算机名</th>
                                    <th>登录类型</th>
                                    <!-- <th>次数</th> -->
                                    <th>登录时间</th>
                                </tr>
                            </thead>
                            
                            <tr ng-repeat="item in pages_logon.data">
                                <!-- <td ng-bind="item.UserName"></td> -->
                                <td ng-bind="item.ComputerName "></td>
                                <td ng-bind="item.LogonType "></td>
                                <!-- <td ng-bind="item.LogonType "></td> -->
                                <td ng-bind="item.Time "></td>
                            </tr>
                        </table>
                         <div style="border-top: 1px solid #f4f4f4;padding: 10px;">
                            <em>共有
                                <span ng-bind="pages_logon.count"></span>条</em>
                            <ul class="pagination pagination-sm no-margin pull-right ">
                                <li>
                                    <a href="javascript:void(0);" ng-click="user(pages_logon.pageNow-1)" ng-if="pages_logon.pageNow>1">上一页</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" ng-click="user(1)" ng-if="pages_logon.pageNow>1">1</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" ng-if="pages_logon.pageNow>4">...</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" ng-click="user(pages_logon.pageNow-2)" ng-bind="pages_logon.pageNow-2"
                                        ng-if="pages_logon.pageNow>3"></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" ng-click="user(pages_logon.pageNow-1)" ng-bind="pages_logon.pageNow-1"
                                        ng-if="pages_logon.pageNow>2"></a>
                                </li>
                                <li class="active">
                                    <a href="javascript:void(0);" ng-bind="pages_logon.pageNow"></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" ng-click="user(pages_logon.pageNow+1)" ng-bind="pages_logon.pageNow+1"
                                        ng-if="pages_logon.pageNow<pages_logon.maxPage-1"></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" ng-click="user(pages_logon.pageNow+2)" ng-bind="pages_logon.pageNow+2"
                                        ng-if="pages_logon.pageNow<pages_logon.maxPage-2"></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" ng-if="pages_logon.pageNow<pages_logon.maxPage-3">...</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" ng-click="user(pages_logon.maxPage)" ng-bind="pages_logon.maxPage"
                                        ng-if="pages_logon.pageNow<pages_logon.maxPage"></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" ng-click="user(pages_logon.pageNow+1)" ng-if="pages_logon.pageNow<pages_logon.maxPage">下一页</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12 ng-scope col-data" id="NetProcess_col">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">
                    <i class="fa fa-globe"></i> 带有网络链接的进程
                </h3>
            </div>
            <div class="box-body table-responsive no-padding">
                <div class="nav-tabs-custom" style="margin-bottom: 0px">
                    <div class="tab-content">
                        <table id="NetProcess" class="table table-bordered table-hover" style="table-layout: fixed">
                            <thead>
                                <tr>
                                    <th style="width:150px;" class="td_class">用户名</th>
                                    <th style="width:150px;" class="td_class">计算机名</th>
                                    <th class="td_class" >进程</th>
                                    <th style="width:100px;">PID</th>
                                    <th class="td_class" >命令</th>
                                    <th style="width:100px;">本地端口</th>
                                    <th style="width:120px;">远端IP</th>
                                    <th style="width:100px;">远端端口</th>
                                    <th style="width:150px;">时间</th>
                                </tr>
                            </thead>
                            <tr ng-repeat="item in pages_net.data">
                                <td ng-bind="item.UserName"></td>
                                <td ng-bind="item.ComputerName "></td>
                                <td ng-bind="item.ProcessName" title="{{item.ProcessName}}"  class="td_class"></td>
                                <td ng-bind="item.PID"></td>
                                <td ng-bind="item.CommandLine" title="{{item.CommandLine}}"  class="td_class"></td>
                                <td ng-bind="item.LocalPort"></td>
                                <td ng-bind="item.RemoteIP"></td>
                                <td ng-bind="item.RemotePort"></td>
                                <td ng-bind="item.Time"></td>
                            </tr>
                        </table>
                        <div style="border-top: 1px solid #f4f4f4;padding: 10px;">
                            <em>共有
                                <span ng-bind="pages_net.count"></span>条</em>
                            <ul class="pagination pagination-sm no-margin pull-right ">
                                <li>
                                    <a href="javascript:void(0);" ng-click="net(pages_net.pageNow-1)" ng-if="pages_net.pageNow>1">上一页</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" ng-click="net(1)" ng-if="pages_net.pageNow>1">1</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" ng-if="pages_net.pageNow>4">...</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" ng-click="net(pages_net.pageNow-2)" ng-bind="pages_net.pageNow-2"
                                        ng-if="pages_net.pageNow>3"></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" ng-click="net(pages_net.pageNow-1)" ng-bind="pages_net.pageNow-1"
                                        ng-if="pages_net.pageNow>2"></a>
                                </li>
                                <li class="active">
                                    <a href="javascript:void(0);" ng-bind="pages_net.pageNow"></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" ng-click="net(pages_net.pageNow+1)" ng-bind="pages_net.pageNow+1"
                                        ng-if="pages_net.pageNow<pages_net.maxPage-1"></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" ng-click="net(pages_net.pageNow+2)" ng-bind="pages_net.pageNow+2"
                                        ng-if="pages_net.pageNow<pages_net.maxPage-2"></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" ng-if="pages_net.pageNow<pages_net.maxPage-3">...</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" ng-click="net(pages_net.maxPage)" ng-bind="pages_net.maxPage"
                                        ng-if="pages_net.pageNow<pages_net.maxPage"></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" ng-click="net(pages_net.pageNow+1)" ng-if="pages_net.pageNow<pages_net.maxPage">下一页</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12 ng-scope col-data" id="UsbPlug_col">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">
                    <i class="fa fa-usb"></i> 外接移动设备
                </h3>
            </div>
            <div class="box-body table-responsive no-padding">
                <div class="nav-tabs-custom" style="margin-bottom: 0px">
                    <div class="tab-content">
                        <table id="UsbPlug" class="table table-bordered table-hover"  style="table-layout: fixed">
                            <thead>
                                <tr>
                                    <th>用户名</th>
                                    <th>计算机名</th>
                                    <th>外接设备名称</th>
                                    <th>盘符</th>
                                    <th>时间</th>
                                </tr>
                            </thead>
                            <tr ng-repeat="item in pages_usb.data">
                                <td ng-bind="item.UserName"></td>
                                <td ng-bind="item.ComputerName "></td>
                                <td ng-bind="item.VolName"></td>
                                <td ng-bind="item.DriverLetter"></td>
                                <td ng-bind="item.Time"></td>
                            </tr>
                        </table>
                          <div style="border-top: 1px solid #f4f4f4;padding: 10px;">
                            <em>共有
                                <span ng-bind="pages_usb.count"></span>条</em>
                            <ul class="pagination pagination-sm no-margin pull-right ">
                                <li>
                                    <a href="javascript:void(0);" ng-click="usb(pages_usb.pageNow-1)" ng-if="pages_usb.pageNow>1">上一页</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" ng-click="usb(1)" ng-if="pages_usb.pageNow>1">1</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" ng-if="pages_usb.pageNow>4">...</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" ng-click="usb(pages_usb.pageNow-2)" ng-bind="pages_usb.pageNow-2"
                                        ng-if="pages_usb.pageNow>3"></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" ng-click="usb(pages_usb.pageNow-1)" ng-bind="pages_usb.pageNow-1"
                                        ng-if="pages_usb.pageNow>2"></a>
                                </li>
                                <li class="active">
                                    <a href="javascript:void(0);" ng-bind="pages_usb.pageNow"></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" ng-click="usb(pages_usb.pageNow+1)" ng-bind="pages_usb.pageNow+1"
                                        ng-if="pages_usb.pageNow<pages_usb.maxPage-1"></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" ng-click="usb(pages_usb.pageNow+2)" ng-bind="pages_usb.pageNow+2"
                                        ng-if="pages_usb.pageNow<pages_usb.maxPage-2"></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" ng-if="pages_usb.pageNow<pages_usb.maxPage-3">...</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" ng-click="usb(pages_usb.maxPage)" ng-bind="pages_usb.maxPage"
                                        ng-if="pages_usb.pageNow<pages_usb.maxPage"></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" ng-click="usb(pages_usb.pageNow+1)" ng-if="pages_usb.pageNow<pages_usb.maxPage">下一页</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 ng-scope col-data" id="task_col">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">
                    <i class="fa fa-clock-o"></i> 创建定时任务
                </h3>
            </div>
            <div class="box-body table-responsive no-padding">
                <div class="nav-tabs-custom" style="margin-bottom: 0px">
                    <div class="tab-content">
                        <table id="task" class="table table-bordered table-hover"  style="table-layout: fixed">
                            <thead>
                                <tr>
                                    <th>时间</th>
                                    <th>定时任务</th>
                                </tr>
                            </thead>
                            <tr ng-repeat="item in pages_task.data">
                                <td ng-bind="item.Time"></td>
                                <td ng-bind="item.CommandLine"></td>
                            </tr>
                        </table>
                          <div style="border-top: 1px solid #f4f4f4;padding: 10px;">
                            <em>共有
                                <span ng-bind="pages_task.count"></span>条</em>
                            <ul class="pagination pagination-sm no-margin pull-right ">
                                <li>
                                    <a href="javascript:void(0);" ng-click="task(pages_task.pageNow-1)" ng-if="pages_task.pageNow>1">上一页</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" ng-click="task(1)" ng-if="pages_task.pageNow>1">1</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" ng-if="pages_task.pageNow>4">...</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" ng-click="task(pages_task.pageNow-2)" ng-bind="pages_task.pageNow-2"
                                        ng-if="pages_task.pageNow>3"></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" ng-click="task(pages_task.pageNow-1)" ng-bind="pages_task.pageNow-1"
                                        ng-if="pages_task.pageNow>2"></a>
                                </li>
                                <li class="active">
                                    <a href="javascript:void(0);" ng-bind="pages_task.pageNow"></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" ng-click="task(pages_task.pageNow+1)" ng-bind="pages_task.pageNow+1"
                                        ng-if="pages_task.pageNow<pages_task.maxPage-1"></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" ng-click="task(pages_task.pageNow+2)" ng-bind="pages_task.pageNow+2"
                                        ng-if="pages_task.pageNow<pages_task.maxPage-2"></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" ng-if="pages_task.pageNow<pages_task.maxPage-3">...</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" ng-click="task(pages_task.maxPage)" ng-bind="pages_task.maxPage"
                                        ng-if="pages_task.pageNow<pages_task.maxPage"></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" ng-click="task(pages_task.pageNow+1)" ng-if="pages_task.pageNow<pages_task.maxPage">下一页</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- <div class="col-md-12 ng-scope col-data" id="ConnectedComputer_col">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">
                    <i class="fa fa-link"></i> 与这台计算机通讯过的机器
                </h3>
            </div>
            <div class="box-body table-responsive no-padding">
                <div class="nav-tabs-custom" style="margin-bottom: 0px">
                    <div class="tab-content">
                        <table id="ConnectedComputer" class="table table-bordered table-hover" >
                            <thead>
                                <tr>
                                    <th>计算机名</th>
                                    <th>IP地址</th>
                                    <th>本地端口</th>
                                    <th>远端计算机端口</th>
                                    <th>时间</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
</div>

<!-- 文件 -->
<div class="row ng-cloak" ng-show="showTable == 'File'">
    <div class="col-md-12 ng-scope" id="FileDetails_col" ng-show="pages_file.data">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">
                    <i class="fa fa-file-o"></i>
                    <span ng-bind="pages_file.data.FileName"></span> 
                </h3>
            </div>
            <div class="box-body table-responsive no-padding">
                <div class="col-md-6 border-right">
                    <ul class="nav nav-stacked sensor-detail">
                        <li>
                            <span class="sensor-detail-title-Long">MD5</span>
                            <span ng-bind="pages_file.data.MD5"></span>
                        </li>
                        <li>
                            <span class="sensor-detail-title-Long">首次出现的计算机</span>
                            <span ng-bind="pages_file.data.FristComputerName"></span>
                        </li>
                        <li>
                            <span class="sensor-detail-title-Long">最近出现的计算机</span>
                            <span ng-bind="pages_file.data.LastComputerName"></span>
                        </li>
                    </ul>
                </div>
                <div class="col-md-6 border-right">
                    <ul class="nav nav-stacked sensor-detail">
                        <li>
                            <span class="sensor-detail-title-Long">计算机数量</span>
                            <span ng-bind="pages_file.computer_count"></span>
                        </li>
                        <li>
                            <span class="sensor-detail-title-Long">首次出现的日期</span>
                            <span ng-bind="pages_file.data.FristTime"></span>
                        </li>
                        <li>
                            <span class="sensor-detail-title-Long">最近出现的日期</span>
                            <span ng-bind="pages_file.data.LastTime"></span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 ng-scope col-data" id="FileComputer_col">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">
                    <i class="fa fa-user-circle-o"></i> 出现过该文件的计算机
                </h3>
            </div>
            <div class="box-body table-responsive no-padding">
                <div class="nav-tabs-custom" style="margin-bottom: 0px">
                    <div class="tab-content">
                        <table id="FileComputer" class="table table-bordered table-hover"  style="table-layout: fixed">
                            <thead>
                                <tr>
                                    <th style="width:100px;" class="td_class" >用户</th>
                                    <th style="width:100px;" class="td_class" >计算机名</th>
                                    <th style="width:120px;">IP地址</th>
                                    <th class="td_class"  >文件名</th>
                                    <th class="td_class" >进程名</th>
                                    <th style="width:100px;">PID</th>
                                    <th style="width:100px;" class="td_class" >MD5</th>
                                    <th style="width:100px;" class="td_class" >子进程</th>
                                    <th style="width:100px;" class="td_class" >父进程</th>
                                    <th class="td_class" >CommandLine</th>
                                    <th style="width:100px;">动作</th>
                                    <th style="width:150px;">时间</th>
                                </tr>
                            </thead>
                            <tr ng-repeat="item in pages_file.data.FileComputer track by $index">
                                <td ng-bind="item.UserName" style="width:100px;" class="td_class" title="{{item.UserName}}"></td>
                                <td ng-bind="item.ComputerName " style="width:100px;" class="td_class" title="{{item.ComputerName}}"></td>
                                <td ng-bind="item.IP " style="width:120px;"></td>
                                <td ng-bind="item.FileName " class="td_class"  title="{{item.FileName}}"></td>
                                <td ng-bind="item.ProcessName " class="td_class"   title="{{item.ProcessName}}"></td>
                                <td ng-bind="item.PID " style="width:100px;"></td>
                                <td ng-bind="item.MD5" style="width:100px;" class="td_class" title="{{item.MD5}}"></td>
                                <td  ng-bind="item.ChildProcessNameList" style="width:100px;" class="td_class" title="{{item.ChildProcessNameList}}">
                                </td>
                                <td ng-bind="item.ParentName " style="width:100px;" class="td_class" title="{{item.ParentName}}"></td>
                                <td ng-bind="item.CommandLine " class="td_class" title="{{item.CommandLine}}"></td>
                                <td ng-bind="item.EventAction" class="td_class" title="{{item.EventAction}}"></td>
                                <td ng-bind="item.Time " style="width:150px;"></td>
                            </tr>  
                        </table>

                          <div style="border-top: 1px solid #f4f4f4;padding: 10px;">
                            <em>共有
                                <span ng-bind="pages_file.count"></span>条</em>
                            <ul class="pagination pagination-sm no-margin pull-right ">
                                <li>
                                    <a href="javascript:void(0);" ng-click="file(pages_file.pageNow-1)" ng-if="pages_file.pageNow>1">上一页</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" ng-click="file(1)" ng-if="pages_file.pageNow>1">1</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" ng-if="pages_file.pageNow>4">...</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" ng-click="file(pages_file.pageNow-2)" ng-bind="pages_file.pageNow-2"
                                        ng-if="pages_file.pageNow>3"></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" ng-click="file(pages_file.pageNow-1)" ng-bind="pages_file.pageNow-1"
                                        ng-if="pages_file.pageNow>2"></a>
                                </li>
                                <li class="active">
                                    <a href="javascript:void(0);" ng-bind="pages_file.pageNow"></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" ng-click="file(pages_file.pageNow+1)" ng-bind="pages_file.pageNow+1"
                                        ng-if="pages_file.pageNow<pages_file.maxPage-1"></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" ng-click="file(pages_file.pageNow+2)" ng-bind="pages_file.pageNow+2"
                                        ng-if="pages_file.pageNow<pages_file.maxPage-2"></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" ng-if="pages_file.pageNow<pages_file.maxPage-3">...</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" ng-click="file(pages_file.maxPage)" ng-bind="pages_file.maxPage"
                                        ng-if="pages_file.pageNow<pages_file.maxPage"></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" ng-click="file(pages_file.pageNow+1)" ng-if="pages_file.pageNow<pages_file.maxPage">下一页</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- 文件传输 -->
<div class="row ng-cloak" ng-show="showTable == 'FileTransfer'">
    <div class="col-md-12 ng-scope col-data" id="IMProcess_col">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">
                    <i class="fa fa-share-alt"></i> 文件传输
                </h3>
            </div>
            <div class="box-body table-responsive no-padding">
                <div class="nav-tabs-custom" style="margin-bottom: 0px">
                    <div class="tab-content">
                        <table id="IMProcess" class="table table-bordered table-hover"style="table-layout: fixed">
                            <thead>
                                <tr>
                                    <th style="width:120px;">计算机名</th>
                                    <th style="width:120px;">IP地址</th>
                                    <th>文件名</th>
                                    <th style="width:200px;">进程名</th>
                                    <th style="width:100px;">PID</th>
                                    <th >MD5</th>
                                    <th >动作</th>
                                    <th style="width:150px;">时间</th>
                                </tr>
                            </thead>
                            <tr ng-repeat="item in pages_transfer.data">
                                <td ng-bind="item.ComputerName" style="width:120px;" class="td_class" title="{{item.ComputerName}}"></td>
                                <td ng-bind="item.IP " style="width:120px;" class="td_class" title="{{item.ComputerName}}"></td>
                                <td ng-bind="item.FileName " class="td_class" title="{{item.FileName}}"></td>
                                <td ng-bind="item.ProcessName " style="width:200px;" class="td_class"  title="{{item.ProcessName}}"></td>
                                <td ng-bind="item.PID " style="width:100px;"></td>
                                <td  class="td_class"  ng-bind="item.FileHashList.MD5" title="{{item.FileHashList.MD5}}"></td>
                                <td  class="td_class"  ng-bind="item.EventAction" title="{{item.EventAction}}"></td>
                                <td ng-bind="item.Time " style="width:150px;"></td>
                            </tr>  
                        </table>
                           <div style="border-top: 1px solid #f4f4f4;padding: 10px;">
                            <em>共有
                                <span ng-bind="pages_transfer.count"></span>条</em>
                            <ul class="pagination pagination-sm no-margin pull-right ">
                                <li>
                                    <a href="javascript:void(0);" ng-click="transfer(pages_transfer.pageNow-1)" ng-if="pages_transfer.pageNow>1">上一页</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" ng-click="transfer(1)" ng-if="pages_transfer.pageNow>1">1</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" ng-if="pages_transfer.pageNow>4">...</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" ng-click="transfer(pages_transfer.pageNow-2)" ng-bind="pages_transfer.pageNow-2"
                                        ng-if="pages_transfer.pageNow>3"></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" ng-click="transfer(pages_transfer.pageNow-1)" ng-bind="pages_transfer.pageNow-1"
                                        ng-if="pages_transfer.pageNow>2"></a>
                                </li>
                                <li class="active">
                                    <a href="javascript:void(0);" ng-bind="pages_transfer.pageNow"></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" ng-click="transfer(pages_transfer.pageNow+1)" ng-bind="pages_transfer.pageNow+1"
                                        ng-if="pages_transfer.pageNow<pages_transfer.maxPage-1"></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" ng-click="transfer(pages_transfer.pageNow+2)" ng-bind="pages_transfer.pageNow+2"
                                        ng-if="pages_transfer.pageNow<pages_transfer.maxPage-2"></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" ng-if="pages_transfer.pageNow<pages_transfer.maxPage-3">...</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" ng-click="transfer(pages_transfer.maxPage)" ng-bind="pages_transfer.maxPage"
                                        ng-if="pages_transfer.pageNow<pages_transfer.maxPage"></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" ng-click="transfer(pages_transfer.pageNow+1)" ng-if="pages_transfer.pageNow<pages_transfer.maxPage">下一页</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- 签名 -->
<div class="row ng-cloak" ng-show="showTable == 'Signer'">
    <div class="col-md-12 ng-scope col-data" id="SignerFile_col">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">
                    <i class="fa fa-pencil-square-o"></i> 文件签名
                </h3>
            </div>
            <div class="box-body table-responsive no-padding">
                <div class="nav-tabs-custom" style="margin-bottom: 0px">
                    <div class="tab-content">
                        <table id="SignerFile" class="table table-bordered table-hover" style="table-layout: fixed">
                            <thead>
                                <tr>
                                    <th>文件名</th>
                                    <th>MD5</th>
                                    <!-- <th>SHA256</th> -->
                                    <th>签名</th>
                                    <th>动作</th>
                                </tr>
                            </thead>
                            <tr ng-repeat="item in pages_signer.data track by $index">
                                <td ng-bind="item.FileName" class="td_class" title="{{item.FileName}}"></td>
                                <td ng-bind="item.MD5 "  class="td_class" title="{{item.MD5}}"></td>
                                <!-- <td ng-bind="item.SHA256 "  class="td_class" title="{{item.SHA256}}"></td> -->
                                <td ng-bind="item.Signer " class="td_class"  title="{{item.Signer}}"></td>
                                <td ng-bind="item.EventAction " class="td_class"  title="{{item.EventAction}}"></td>
                            </tr>  
                        </table>
                           <div style="border-top: 1px solid #f4f4f4;padding: 10px;">
                            <em>共有
                                <span ng-bind="pages_signer.count"></span>条</em>
                            <ul class="pagination pagination-sm no-margin pull-right ">
                                <li>
                                    <a href="javascript:void(0);" ng-click="signer(pages_signer.pageNow-1)" ng-if="pages_signer.pageNow>1">上一页</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" ng-click="signer(1)" ng-if="pages_signer.pageNow>1">1</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" ng-if="pages_signer.pageNow>4">...</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" ng-click="signer(pages_signer.pageNow-2)" ng-bind="pages_signer.pageNow-2"
                                        ng-if="pages_signer.pageNow>3"></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" ng-click="signer(pages_signer.pageNow-1)" ng-bind="pages_signer.pageNow-1"
                                        ng-if="pages_signer.pageNow>2"></a>
                                </li>
                                <li class="active">
                                    <a href="javascript:void(0);" ng-bind="pages_signer.pageNow"></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" ng-click="signer(pages_signer.pageNow+1)" ng-bind="pages_signer.pageNow+1"
                                        ng-if="pages_signer.pageNow<pages_signer.maxPage-1"></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" ng-click="signer(pages_signer.pageNow+2)" ng-bind="pages_signer.pageNow+2"
                                        ng-if="pages_signer.pageNow<pages_signer.maxPage-2"></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" ng-if="pages_signer.pageNow<pages_signer.maxPage-3">...</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" ng-click="signer(pages_signer.maxPage)" ng-bind="pages_signer.maxPage"
                                        ng-if="pages_signer.pageNow<pages_signer.maxPage"></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" ng-click="signer(pages_signer.pageNow+1)" ng-if="pages_signer.pageNow<pages_signer.maxPage">下一页</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- 域名IP -->
<div class="row ng-cloak" ng-show="showTable == 'Domain'">
    <div class="col-md-12 ng-scope col-data" id="DomainProcess_col">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">
                    <i class="fa fa-internet-explorer"></i> 域名查询
                </h3>
            </div>
            <div class="box-body table-responsive no-padding">
                <div class="nav-tabs-custom" style="margin-bottom: 0px">
                    <div class="tab-content">
                        <table id="DomainProcess" class="table table-bordered table-hover" style="table-layout: fixed">
                            <thead>
                                <tr style="text-align: center" >
                                    <th>计算机名</th>
                                    <th>计算机IP地址</th>
                                    <th style="width:80px">状态</th>
                                    <th>OS</th>
                                    <th>进程名</th>
                                    <th style="width:80px">PID</th>
                                    <th>文件路径</th>
                                    <th>时间</th>
                                    <th>域名(IP、端口)</th>
                                    <th>动作</th>
                                </tr>
                            </thead>
                            <tr ng-repeat="item in pages_domain.data">
                                <td ng-bind="item.ComputerName" class="td_class" title="{{item.ComputerName}}"></td>
                                <td ng-bind="item.IP "  class="td_class" title="{{item.IP}}"></td>
                                <td style="width:80px;text-align: center">
                                <span class="label label-{{status_str[item.status].css}}" ng-bind="status_str[item.status].label"></span>
                                </td>
                                <td ng-bind="item.OSType "  class="td_class" title="{{item.OSType}}"></td>
                                <td ng-bind="item.ProcessName "  class="td_class" title="{{item.ProcessName}}"></td>
                                <td style="width:80px;text-align: center" ng-bind="item.PID "  class="td_class" title="{{item.PID}}"></td>
                                <td ng-bind="item.ImagePath "  class="td_class" title="{{item.ImagePath}}"></td>
                                <td ng-bind="item.Time " style="width:150px" class="td_class" title="{{item.Time}}"></td>
                                <td ng-bind="item.search "style="width:150px"  class="td_class"  title="{{item.search}}"></td>
                                <td ng-bind="item.EventAction "  class="td_class" title="{{item.EventAction}}"></td>
                            </tr>  
                        </table>
                          <div style="border-top: 1px solid #f4f4f4;padding: 10px;">
                            <em>共有
                                <span ng-bind="pages_domain.count"></span>条</em>
                            <ul class="pagination pagination-sm no-margin pull-right ">
                                <li>
                                    <a href="javascript:void(0);" ng-click="domain(pages_domain.pageNow-1)" ng-if="pages_domain.pageNow>1">上一页</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" ng-click="domain(1)" ng-if="pages_domain.pageNow>1">1</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" ng-if="pages_domain.pageNow>4">...</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" ng-click="domain(pages_domain.pageNow-2)" ng-bind="pages_domain.pageNow-2"
                                        ng-if="pages_domain.pageNow>3"></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" ng-click="domain(pages_domain.pageNow-1)" ng-bind="pages_domain.pageNow-1"
                                        ng-if="pages_domain.pageNow>2"></a>
                                </li>
                                <li class="active">
                                    <a href="javascript:void(0);" ng-bind="pages_domain.pageNow"></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" ng-click="domain(pages_domain.pageNow+1)" ng-bind="pages_domain.pageNow+1"
                                        ng-if="pages_domain.pageNow<pages_domain.maxPage-1"></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" ng-click="domain(pages_domain.pageNow+2)" ng-bind="pages_domain.pageNow+2"
                                        ng-if="pages_domain.pageNow<pages_domain.maxPage-2"></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" ng-if="pages_domain.pageNow<pages_domain.maxPage-3">...</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" ng-click="domain(pages_domain.maxPage)" ng-bind="pages_domain.maxPage"
                                        ng-if="pages_domain.pageNow<pages_domain.maxPage"></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" ng-click="domain(pages_domain.pageNow+1)" ng-if="pages_domain.pageNow<pages_domain.maxPage">下一页</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 用户 -->
<div class="row ng-cloak" ng-show="showTable == 'User'">
    <div class="col-md-12 ng-scope col-data" id="LogonEvent_col">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">
                    <i class="fa fa-user-circle-o"></i> 用户调查
                </h3>
            </div>
            <div class="box-body table-responsive no-padding">
                <div class="nav-tabs-custom" style="margin-bottom: 0px">
                    <div class="tab-content">
                        <table id="LogonEvent" class="table table-bordered table-hover" style="table-layout: fixed">
                            <thead>
                                <tr>
                                    <th>用户名</th>
                                    <th>计算机名</th>
                                    <th style="width:80px;">状态</th>
                                    <th>IP地址</th>
                                    <th>域名</th>
                                    <th style="width:80px;">登录</th>
                                    <th>动作</th>
                                    <th>时间</th>
                                </tr>
                            </thead>
                            <tr ng-repeat="item in pages_user.data">
                                <td ng-bind="item.UserName" class="td_class" title="{{item.UserName}}"></td>
                                <td ng-bind="item.ComputerName "  class="td_class" title="{{item.ComputerName}}"></td>
                                <td style="width:80px;text-align: center">
                                <span class="label label-{{status_str[item.status].css}}" ng-bind="status_str[item.status].label"></span>
                                </td>
                                <td ng-bind="item.IP "  class="td_class" title="{{item.IP}}"></td>
                                <td ng-bind="item.Domain " class="td_class"  title="{{item.Domain}}"></td>
                                <td ng-bind="item.LogonStatus==0?'失败':'成功'" style="width:80px"></td>
                                <td ng-bind="item.EventAction" title="{{item.EventAction}}"></td>
                                <td ng-bind="item.Time " class="td_class" style="width:150px" title="{{item.Time}}"></td>
                            </tr>  
                        </table>
                         <div style="border-top: 1px solid #f4f4f4;padding: 10px;">
                            <em>共有
                                <span ng-bind="pages_user.count"></span>条</em>
                            <ul class="pagination pagination-sm no-margin pull-right ">
                                <li>
                                    <a href="javascript:void(0);" ng-click="user(pages_user.pageNow-1)" ng-if="pages_user.pageNow>1">上一页</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" ng-click="user(1)" ng-if="pages_user.pageNow>1">1</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" ng-if="pages_user.pageNow>4">...</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" ng-click="user(pages_user.pageNow-2)" ng-bind="pages_user.pageNow-2"
                                        ng-if="pages_user.pageNow>3"></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" ng-click="user(pages_user.pageNow-1)" ng-bind="pages_user.pageNow-1"
                                        ng-if="pages_user.pageNow>2"></a>
                                </li>
                                <li class="active">
                                    <a href="javascript:void(0);" ng-bind="pages_user.pageNow"></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" ng-click="user(pages_user.pageNow+1)" ng-bind="pages_user.pageNow+1"
                                        ng-if="pages_user.pageNow<pages_user.maxPage-1"></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" ng-click="user(pages_user.pageNow+2)" ng-bind="pages_user.pageNow+2"
                                        ng-if="pages_user.pageNow<pages_user.maxPage-2"></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" ng-if="pages_user.pageNow<pages_user.maxPage-3">...</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" ng-click="user(pages_user.maxPage)" ng-bind="pages_user.maxPage"
                                        ng-if="pages_user.pageNow<pages_user.maxPage"></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" ng-click="user(pages_user.pageNow+1)" ng-if="pages_user.pageNow<pages_user.maxPage">下一页</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>