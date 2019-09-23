var myScope;

function init($scope, $http, $filter, timerangeDom) {
    timerangeDom.daterangepicker({
        maxDate: moment(),
        minDate: moment().subtract(90, 'days'),
        timePicker: true,
        timePickerIncrement: 1,
        startDate: moment().subtract(24, 'hours'),
        endDate: moment(),
        locale: {
            applyLabel: '确定',
            cancelLabel: '取消',
            format: 'YYYY-MM-DD HH:mm',
            customRangeLabel: '指定时间范围'
        },
        ranges: {
            '24小时内': [moment().subtract(24, 'hours'), moment()],
            '一周内': [moment().startOf('weeks'), moment()],
            '一个月内': [moment().startOf('months'), moment()]
        }
    }, function (start, end, label) {
        // start = start.subtract(1, 'days').add(1, 'days');
        $scope.search_data.StartTime = start.unix();
        $scope.search_data.EndTime = end.unix();
        // console.log(moment($scope.search_data.StartTime, 'X').format('YYYY-MM-DD HH:mm:ss'));
        // console.log(moment($scope.search_data.EndTime, 'X').format('YYYY-MM-DD HH:mm:ss'));
    });
}

var myApp = angular.module('myApp', []);

/**
 * My controller
 */
myApp.controller('myCtrl', function ($scope, $http, $filter) {
    $scope.showTable = "Computer";
    myScope = $scope;
    $scope.status_str = [{
        css: 'danger',
        label: '卸载'
    }, {
        css: 'success',
        label: '在线'
    }, {
        css: 'warning',
        label: '断线'
    }];
});

/**
 * Computer controller 
 */
myApp.controller('ComputerCtrl', function ($scope, $http, $filter) {
    $scope.search_data = {
        ComputerName: '',
        IP: '',
        StartTime: moment('00:00:00', 'HH:mm:ss').unix(),
        EndTime: moment().unix()
    };
    myScope.select = function (item) {
        myScope.selectSensor = item;
    };

    $scope.search = function () {
        // 1.	计算机名和IP必须有一项
        if ($scope.search_data.ComputerName == '' && $scope.search_data.IP == '') {
            zeroModal.error("至少输入计算机名或IP其中一项搜索条件！");
        } else {
            var loading = zeroModal.loading(4);
            $http.post('get-sensor', $scope.search_data).then(function success(rsp) {
                if (rsp.data.status == 'success') {
                    zeroModal.close(loading);
                    if (rsp.data.data.length == 0) {
                        zeroModal.error("未找到计算机！");
                        return;
                    }
                    myScope.sensorList = rsp.data.data;
                    var W = 800;
                    var H = 480;
                    zeroModal.show({
                        title: '请选择计算机！',
                        content: sensorList,
                        width: W + "px",
                        height: H + "px",
                        ok: true,
                        cancel: true,
                        okFn: function () {
                            myScope.nowSensor = myScope.selectSensor;
                            var command_data = {
                                Type: "Computer",
                                SensorID: myScope.nowSensor.SensorID,
                                StartTime: $scope.search_data.StartTime,
                                EndTime: $scope.search_data.EndTime
                            }
                            // $scope.sendCommand(command_data);
                            $scope.getComputerData($scope.search_data.StartTime, $scope.search_data.EndTime);
                        },
                        cancelFn: function () {
                            myScope.$apply();
                        },
                        onCleanup: function () {
                            hide_box.appendChild(sensorList);
                        }
                    });
                }
            }, function err(rsp) {
                zeroModal.close(loading);
            });
        }
    };
    $scope.getComputerData = function (StartTime, EndTime) {
        // 用户登录信息
        myScope.user = function (pageNow) {
            pageNow = pageNow ? pageNow : 1;
            var parmas_user = {
                "EventAction": "USER_LOGON",
                "SensorID": myScope.nowSensor.SensorID,
                "start_time": StartTime,
                "end_time": EndTime,
                "current_page": pageNow,
                "per_page_count": 10
            };
            if (pageNow > 1000) {
                zeroModal.error('数据超过一万条,请缩小搜索条件');
            } else {
                var loading_user = zeroModal.loading(4);
                $http.post('/investigate/computer', parmas_user).then(function success(rsp) {
                    zeroModal.close(loading_user);
                    if (rsp.data.status == 'success') {
                        myScope.pages_logon = {
                            data: rsp.data.data,
                            count: rsp.data.total_count,
                            maxPage: rsp.data.max_page,
                            pageNow: rsp.data.current_page,
                        }
                        $('#UserLogon_col').show();
                    }
                }, function err(rsp) {
                    zeroModal.close(loading_user);
                });
            }
        };

        // 带有网络链接的进程
        myScope.net = function (pageNow) {
            pageNow = pageNow ? pageNow : 1;
            var parmas_net = {
                "EventAction": "NETWORK_CONNECT",
                "SensorID": myScope.nowSensor.SensorID,
                "start_time": StartTime,
                "end_time": EndTime,
                "current_page": pageNow,
                "per_page_count": 10
            }
            if (pageNow > 1000) {
                zeroModal.error('数据超过一万条,请缩小搜索条件');
            } else {
                var loading_net = zeroModal.loading(4);
                $http.post('/investigate/computer', parmas_net).then(function success(rsp) {
                    zeroModal.close(loading_net);
                    if (rsp.data.status == 'success') {
                        myScope.pages_net = {
                            data: rsp.data.data,
                            count: rsp.data.total_count,
                            maxPage: rsp.data.max_page,
                            pageNow: rsp.data.current_page,
                        };
                        $('#NetProcess_col').show();
                    }
                }, function err(rsp) {
                    zeroModal.close(loading_net);
                });
            };
        };
        // 外接移动设备
        myScope.usb = function (pageNow) {
            pageNow = pageNow ? pageNow : 1;
            var parmas_UsbPlug = {
                "EventAction": "USB_PLUG_ARRIVAL",
                "SensorID": myScope.nowSensor.SensorID,
                "start_time": StartTime,
                "end_time": EndTime,
                "current_page": pageNow,
                "per_page_count": 10
            }
            if (pageNow > 1000) {
                zeroModal.error('数据超过一万条,请缩小搜索条件');
            } else {
                var loading_usb = zeroModal.loading(4);
                $http.post('/investigate/computer', parmas_UsbPlug).then(function success(rsp) {
                    zeroModal.close(loading_usb);
                    if (rsp.data.status == 'success') {
                        myScope.pages_usb = {
                            data: rsp.data.data,
                            count: rsp.data.total_count,
                            maxPage: rsp.data.max_page,
                            pageNow: rsp.data.current_page,
                        };
                        $('#UsbPlug_col').show();
                    }
                }, function err(rsp) {
                    zeroModal.close(loading_usb);
                });
            };
        };
        // 创建定时任务
        myScope.task = function (pageNow) {
            pageNow = pageNow ? pageNow : 1;
            var parmas_task = {
                "EventAction": "ADD_SCHD_TASK",
                "SensorID": myScope.nowSensor.SensorID,
                "start_time": StartTime,
                "end_time": EndTime,
                "current_page": pageNow,
                "per_page_count": 10
            }
            var loading_task = zeroModal.loading(4);
            $http.post('/investigate/computer', parmas_task).then(function success(rsp) {
                zeroModal.close(loading_task);
                console.log(rsp);
                
                if (rsp.data.status == 'success') {
                    myScope.pages_task = {
                        data: rsp.data.data,
                        count: rsp.data.total_count,
                        maxPage: rsp.data.max_page,
                        pageNow: rsp.data.current_page,
                    };
                    $('#task_col').show();
                }
            }, function err(rsp) {
                zeroModal.close(loading_task);
            });
        };
        myScope.user();
        myScope.net();
        myScope.usb();
        myScope.task();
    };
    init($scope, $http, $filter, $('#computer .timerange'));
});
/**
 * File controller
 */
myApp.controller('FileCtrl', function ($scope, $http, $filter) {
    $scope.search_data = {
        Type: "File",
        FileName: "",
        MD5OrSHA256: "",
        CommandLine: "",
        ComputerName: "",
        IgnorePath: "",
        IgnoreParentName: "",
        StartTime: moment('00:00:00', 'HH:mm:ss').unix(),
        EndTime: moment().unix()
    }
    $scope.search = function () {
        if ($scope.search_data.FileName == '' && $scope.search_data.MD5OrSHA256 == '') {
            zeroModal.error("至少输入文件名或MD5其中一项搜索条件！");
        } else {
        $scope.getFileData($scope.search_data.StartTime, $scope.search_data.EndTime);
        }
    }
    $scope.getFileData = function (StartTime, EndTime) {
        myScope.file = function (pageNow) {
            pageNow = pageNow ? pageNow : 1;
            var parmas = {
                "FileName": $scope.search_data.FileName,
                "MD5OrSHA256": $scope.search_data.MD5OrSHA256,
                "CommandLine": $scope.search_data.CommandLine,
                "ComputerName": $scope.search_data.ComputerName,
                "IgnorePath": $scope.search_data.IgnorePath,
                "IgnoreParentName": $scope.search_data.IgnoreParentName,
                "start_time": StartTime,
                "end_time": EndTime,
                "current_page": pageNow,
                "per_page_count": 10
            };
            if (pageNow > 1000) {
                zeroModal.error('数据超过一万条,请缩小搜索条件');
            } else {
                var loading_file = zeroModal.loading(4);
                $http.post('/investigate/file', parmas).then(function success(rsp) {
                    zeroModal.close(loading_file);
                    if (rsp.data.status == 'success') {
                        myScope.pages_file = {
                            data: rsp.data.data,
                            count: rsp.data.total_count,
                            maxPage: rsp.data.max_page,
                            pageNow: rsp.data.current_page,
                            computer_count: rsp.data.computer_count,
                        }
                        myScope.showTable = "File";
                        $('#FileComputer_col').show();
                    }
                }, function err(rsp) {
                    zeroModal.close(loading_file);
                });
            };
        };
        myScope.file();
    }
    init($scope, $http, $filter, $('#file .timerange'));
});
/**
 * 文件传输
 */
myApp.controller('FileTransferCtrl', function ($scope, $http, $filter) {
    $scope.search_data = {
        Type: "FileTransfer",
        ProcessName: "",
        ComputerName: "",
        StartTime: moment('00:00:00', 'HH:mm:ss').unix(),
        EndTime: moment().unix()
    }
    $scope.search = function () {
        if ($scope.search_data.ProcessName == '' || $scope.search_data.ComputerName == '') {
            zeroModal.error("进程和计算机搜索条件不能为空！");
        } else {
            $scope.getTransferData($scope.search_data.StartTime, $scope.search_data.EndTime);
        }
    }
    $scope.getTransferData = function (StartTime, EndTime) {
        myScope.transfer = function (pageNow) {
            pageNow = pageNow ? pageNow : 1;
            var parmas = {
                "ProcessName": $scope.search_data.ProcessName,
                "ComputerName": $scope.search_data.ComputerName,
                "start_time": StartTime,
                "end_time": EndTime,
                "current_page": pageNow,
                "per_page_count": 10
            };
            if (pageNow > 1000) {
                zeroModal.error('数据超过一万条,请缩小搜索条件');
            } else {
                var loading_transfer = zeroModal.loading(4);
                $http.post('/investigate/file-transfer', parmas).then(function success(rsp) {
                    zeroModal.close(loading_transfer);
                    if (rsp.data.status == 'success') {
                        myScope.pages_transfer = {
                            data: rsp.data.data,
                            count: rsp.data.total_count,
                            maxPage: rsp.data.max_page,
                            pageNow: rsp.data.current_page,
                        }
                        myScope.showTable = "FileTransfer";
                        $('#IMProcess_col').show();
                    }
                }, function err(rsp) {
                    zeroModal.close(loading_transfer);
                });
            };
        };

        myScope.transfer();
    }
    init($scope, $http, $filter, $('#fileTransfer .timerange'));
});
/**
 * 签名
 */
myApp.controller('SignerCtrl', function ($scope, $http, $filter) {
    $scope.search_data = {
        Type: "Signer",
        Signer: "",
        StartTime: moment('00:00:00', 'HH:mm:ss').unix(),
        EndTime: moment().unix()
    }
    $scope.search = function () {
        if ($scope.search_data.Signer == '') {
            zeroModal.error("签名搜索条件不能为空！");
        } else {
            $scope.getSignerData($scope.search_data.StartTime, $scope.search_data.EndTime);
        }
    }
    $scope.getSignerData = function (StartTime, EndTime) {
        myScope.signer = function (pageNow) {
            pageNow = pageNow ? pageNow : 1;
            var parmas = {
                "Signer": $scope.search_data.Signer,
                "start_time": StartTime,
                "end_time": EndTime,
                "current_page": pageNow,
                "per_page_count": 10
            };
            if (pageNow > 1000) {
                zeroModal.error('数据超过一万条,请缩小搜索条件');
            } else {
                var loading_signer = zeroModal.loading(4);
                $http.post('/investigate/signer', parmas).then(function success(rsp) {
                    zeroModal.close(loading_signer);
                    console.log(rsp);
                    
                    if (rsp.data.status == 'success') {
                        myScope.pages_signer = {
                            data: rsp.data.data,
                            count: rsp.data.total_count,
                            maxPage: rsp.data.max_page,
                            pageNow: rsp.data.current_page,
                        }
                        myScope.showTable = "Signer";
                        $('#SignerFile_col').show();
                    }
                }, function err(rsp) {
                    zeroModal.close(loading_signer);
                });
            };
        };

        myScope.signer();
    }
    init($scope, $http, $filter, $('#signer .timerange'));
});
/**
 * 域名IP
 */
myApp.controller('DomainCtrl', function ($scope, $http, $filter) {
    $scope.status_str = [{
        css: 'danger',
        label: '卸载'
    }, {
        css: 'success',
        label: '在线'
    }, {
        css: 'warning',
        label: '断线'
    }];
    $scope.search_data = {
        Type: "Domain",
        URL: "",
        IP: "",
        Port: null,
        IgnoreProcessName: "",
        StartTime: moment('00:00:00', 'HH:mm:ss').unix(),
        EndTime: moment().unix()
    }
    $scope.search = function () {
        if ($scope.search_data.URL == '' && $scope.search_data.IP == '') {
            zeroModal.error("至少输入域名或IP地址其中一项搜索条件！");
        } else {
            $scope.getDomainData($scope.search_data.StartTime, $scope.search_data.EndTime);
        }
    };
    $scope.getDomainData = function (StartTime, EndTime) {
        myScope.domain = function (pageNow) {
            pageNow = pageNow ? pageNow : 1;
            var parmas = {
                "URL": $scope.search_data.URL,
                "IP": $scope.search_data.IP,
                "Port": $scope.search_data.Port,
                "IgnoreProcessName": $scope.search_data.IgnoreProcessName,
                "start_time": StartTime,
                "end_time": EndTime,
                "current_page": pageNow,
                "per_page_count": 10
            };
            if (pageNow > 1000) {
                zeroModal.error('数据超过一万条,请缩小搜索条件');
            } else {
                var loading_domain = zeroModal.loading(4);
                $http.post('/investigate/domain', parmas).then(function success(rsp) {
                    zeroModal.close(loading_domain);
                    if (rsp.data.status == 'success') {
                        myScope.pages_domain = {
                            data: rsp.data.data,
                            count: rsp.data.total_count,
                            maxPage: rsp.data.max_page,
                            pageNow: rsp.data.current_page,
                        }
                        myScope.showTable = "Domain";
                        $('#DomainProcess_col').show();
                    }
                }, function err(rsp) {
                    zeroModal.close(loading_domain);
                });
            };
        };

        myScope.domain();
    }
    init($scope, $http, $filter, $('#domain .timerange'));
});
/**
 * 用户
 */
myApp.controller('UserCtrl', function ($scope, $http, $filter) {
    $scope.status_str = [{
        css: 'danger',
        label: '卸载'
    }, {
        css: 'success',
        label: '在线'
    }, {
        css: 'warning',
        label: '断线'
    }];
    $scope.search_data = {
        Type: "User",
        Domain: "",
        UserName: "",
        SID: "",
        StartTime: moment('00:00:00', 'HH:mm:ss').unix(),
        EndTime: moment().unix()
    }
    $scope.search = function () {
        if ($scope.search_data.UserName == '' && $scope.search_data.SID == '') {
            zeroModal.error("至少输入用户名或SID其中一项搜索条件！");
        } else {
        $scope.getUserData($scope.search_data.StartTime, $scope.search_data.EndTime);
        }
    };
    $scope.getUserData = function (StartTime, EndTime) {
        myScope.user = function (pageNow) {
            pageNow = pageNow ? pageNow : 1;
            var parmas = {
                "Domain": $scope.search_data.Domain,
                "UserName": $scope.search_data.UserName,
                "SID": $scope.search_data.SID,
                "start_time": StartTime,
                "end_time": EndTime,
                "current_page": pageNow,
                "per_page_count": 10
            };
            if (pageNow > 1000) {
                zeroModal.error('数据超过一万条,请缩小搜索条件');
            } else {
                var loading_user = zeroModal.loading(4);
                $http.post('/investigate/user', parmas).then(function success(rsp) {
                    zeroModal.close(loading_user);
                    if (rsp.data.status == 'success') {
                        myScope.pages_user = {
                            data: rsp.data.data,
                            count: rsp.data.total_count,
                            maxPage: rsp.data.max_page,
                            pageNow: rsp.data.current_page,
                        }
                        myScope.showTable = "User";
                        $('#LogonEvent_col').show();
                    }
                }, function err(rsp) {
                    zeroModal.close(loading_user);
                });
            }
        };

        myScope.user();
    }
    init($scope, $http, $filter, $('#user .timerange'));
});
/**
 * ioc扫描
 */
myApp.controller('IocCtrl', function ($scope, $http, $filter) {
    // 初始化
    $scope.init = function (params) {
        $scope.content_show = false;
        myScope.btn_disabled = true;
        myScope.upload_true = true; //初始化禁用提交按钮
        // myScope.file_choose = function () {
        // }
        $("#avatval").click(function () {
            $("#avatar").trigger('click');
            $scope.$apply(function () {
                $('#progress')[0].style = 'width:0%';
                myScope.progress_if = false;
            })
        });
        $("#avatar").change(function (target) {
            // $("#avatval").val(target.target.value);
            // console.log($(this));
            // console.log(target.target.value);
            var file = document.getElementById('avatar').files[0];
            $("#avatval").val(file.name);
            if (target.target.value) {
                if (target.target.value.split('.')[1].indexOf('txt') == -1 && target.target.value.split('.')[1].indexOf('ioc') == -1) {
                    zeroModal.error(' 请重新选择.txt或.ioc格式的文件上传');
                    $scope.$apply(function () {
                        myScope.upload_true = true;
                    })
                } else {
                    $scope.$apply(function () {
                        myScope.upload_true = false;
                    })
                }
            }
        });
        myScopeprogress_if = false;
        myScope.pages_ioc = {
            list: [],
            current_page: 0,
            maxPage: "...",
            pageNow: 1,
            total_count: 0
        };
        $scope.getPage();
    };
    //获取数据
    $scope.getPage = function (pageNow) {
        $scope.content_show = true;
        myScope.ioc = function (pageNow) {
            if (pageNow > 1000) {
                zeroModal.error('数据超过一万条,请缩小搜索条件');
            } else {
                // var loading = zeroModal.loading(4);
                myScope.index_num = (pageNow - 1) * 10;
                $scope.params_data = {
                    page: pageNow,
                    rows: 10
                };
                $http.post('/investigate/get-ioc-list', $scope.params_data).then(function success(data) {
                    $scope.status_crearte = true;
                    if (data.data.status == 'success') {
                        myScope.pages_ioc = data.data;
                        myScope.pages_ioc.pageNow = data.data.current_page;
                        myScope.pages_ioc.maxPage = data.data.max_page;
                        if (myScope.pages_ioc.list.length != 0) {
                            angular.forEach(myScope.pages_ioc.list, function (item, index) {
                                item.create_percent = item.create_percent + '%';
                            });
                        }
                        angular.forEach(myScope.pages_ioc.list, function (item) {
                            if (item.create_status == "0") {
                                $scope.status_crearte = false;
                            }
                        })
                    }
                }, function err(rsp) {
                    // zeroModal.close(loading);
                });
            }

        };
        myScope.ioc(1);
    };
    // 下载模版
    $scope.download_temp = function () {
        var tt = new Date().getTime();
        var url = '/investigate/download-ioc-template';
        var form = $("<form>"); //定义一个form表单
        form.attr("style", "display:none");
        form.attr("target", "");
        form.attr("method", "get"); //请求类型
        form.attr("action", url); //请求地址
        $("body").append(form); //将表单放置在web中
        var input1 = $("<input>");
        input1.attr("type", "hidden");
        form.append(input1);
        form.submit(); //表单提交
    };
    // 上传文件
    $scope.uploadPic = function () {
        myScope.progress_if = true;
        var form = document.getElementById('upload'),
            formData = new FormData(form);
        $.ajax({
            url: "/investigate/upload-file",
            type: "post",
            data: formData,
            xhr: function () {
                var xhr = $.ajaxSettings.xhr();
                if (xhr.upload) {
                    xhr.upload.onprogress = function (progress) {
                        if (progress.lengthComputable) {
                            $('#progress')[0].style = 'width:' + parseInt(progress.loaded / progress.total * 100) + '%';
                        }
                    };
                    xhr.upload.onloadstart = function () {
                        // console.log('started...');
                    };
                }
                return xhr;
            },
            processData: false, // 告诉jQuery不要去处理发送的数据
            contentType: false, // 告诉jQuery不要去设置Content-Type请求头
            success: function (res) {
                res = JSON.parse(res);
                if (res.status == 'success') {
                    zeroModal.success('上传成功');
                    $scope.$apply(function () {
                        myScope.btn_disabled = false;
                        myScope.upload_true = true;
                        myScope.progress_if = false;
                        $("#upload")[0].reset();
                    })
                    $scope.getPage();
                    for (var i = 0; i < 10; i++) {
                        setTimeout(function () {
                            $scope.getPage();
                        }, i * 5000);
                    }
                } else {
                    zeroModal.error(res.msg);
                }
            },
            error: function (err) {
                $('#progress')[0].style = 'width:0%';
                myScope.progress_if = false;
                console.log(err);
                alert("网络连接失败,稍后重试", err);
            }
        })
    };
    //搜索
    $scope.search = function () {
        $scope.getPage();
    };
    //下载列表文件
    $scope.download = function (item) {
        zeroModal.confirm({
            content: "确定下载吗？",
            okFn: function () {
                $http({
                    method: 'get',
                    url: '/investigate/test-download-csv',
                    params: {
                        id: item.id,
                        download_file_name: item.download_file_name
                    }
                }).then(function (data) {
                    if (data.data.status == 'success') {
                        var tt = new Date().getTime();
                        var url = '/investigate/download-csv';
                        var form = $("<form>"); //定义一个form表单
                        form.attr("style", "display:none");
                        form.attr("target", "");
                        form.attr("method", "get"); //请求类型
                        form.attr("action", url); //请求地址
                        $("body").append(form); //将表单放置在web中
                        var input1 = $("<input>");
                        input1.attr("type", "hidden");
                        input1.attr("name", "id");
                        input1.attr("name", "download_file_name");
                        input1.attr("value", item.id);
                        input1.attr("value", item.download_file_name);
                        form.append(input1);
                        form.submit(); //表单提交
                    } else {
                        zeroModal.error('正在搜索查询中，请稍后再试');
                    };
                })
            },
            cancelFn: function () {}
        });
    };
    //删除列表数据
    $scope.del = function (item) {
        zeroModal.confirm({
            content: "确定删除吗？",
            okFn: function () {
                var loading = zeroModal.loading(4);
                $http({
                    method: 'delete',
                    url: '/investigate/del-csv',
                    data: {
                        id: item.id,
                        download_file_name: item.download_file_name
                    }
                }).then(function (data) {
                    if (data.data.status == 'success') {
                        zeroModal.success('删除成功');
                        $scope.getPage();
                    } else {
                        zeroModal.error(data.msg);
                    }
                    zeroModal.close(loading);
                })
            },
            cancelFn: function () {}
        });
    };
    $scope.init();
});