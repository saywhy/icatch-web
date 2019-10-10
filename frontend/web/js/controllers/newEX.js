if (!myApp) {
    var myApp = angular.module("myApp", []);
}

var Groups = {
    '*': {
        text: '所有',
        type: '*'
    }
};

var nowGroup = null;

//当前告警控制器
myApp.controller("behCtrl", function ($scope, $http, $filter) {
    let listTimer = null;
    let autoplay = false;

    $scope.Groups = Groups;

    $scope.pages = {
        data: [],
        count: 0,
        maxPage: "...",
        pageNow: 1
    };

    $scope.IDList = [];
    $scope.ItemList = {};

    $scope.select_model = [{
            num: '10',
            type: "10条/页"
        },
        {
            num: '20',
            type: "20条/页"
        },
        {
            num: '50',
            type: "50条/页"
        },
        {
            num: '100',
            type: "100条/页"
        },
    ]
    $scope.select = {
        model: '10'
    }
    //批量选取数据
    $scope.IDListData = [];

    //设置默认参数
    $scope.searchData = {
        startTime: moment()
            .subtract(365, "days")
            .unix(),
        endTime: moment().unix(),
        ComputerName: "",
        AlertType: 10,
        Label: "",
        gid: "*",
        MinPoint: 0,
        MaxPoint: 100
    };

    if (location.search) {
        var ComputerName = localStorage.getItem("parmas");
        $scope.searchData.ComputerName = ComputerName;
    }

    /* $scope.SrcType_str = [
        {
          css: "warning",
          label: "未知"
        },
        {
          css: "danger",
          label: "邮件"
        },
        {
          css: "danger",
          label: "网页"
        },
        {
          css: "danger",
          label: "USB"
        },
        {
          css: "danger",
          label: "内网"
        },
        {
          css: "warning",
          label: "其他"
        }
      ];*/

    //告警事件
    $scope.AlertType_select = [{
            label: "可疑行为",
            num: 4
        },
        {
            label: "可疑文件",
            num: 1
        },
        {
            label: "可疑IP",
            num: 2
        },
        {
            label: "可疑URL",
            num: 3
        },
        {
            css: "danger",
            label: "漏洞利用",
            num: 6
        },
        {
            label: "勒索软件",
            num: 7
        },
        {
            label: "所有",
            num: 10
        }
    ];

    //告警组下拉框
    $scope.alertGid_select = GroupList;

    $scope.AlertType_str = [{
            css: "warning",
            label: "可疑行为",
            num: 0
        },
        {
            css: "danger",
            label: "可疑文件",
            num: 1
        },
        {
            css: "danger",
            label: "可疑IP",
            num: 2
        },
        {
            css: "danger",
            label: "可疑URL",
            num: 3
        },
        {
            css: "warning",
            label: "可疑行为",
            num: 4
        },
        {
            css: "warning",
            label: "可疑行为",
            num: 5
        },
        {
            css: "danger",
            label: "漏洞利用",
            num: 6
        },
        {
            css: "danger",
            label: "勒索软件",
            num: 7
        }
    ];

    $scope.status_str = [{
            css: "success",
            label: "新告警"
        },
        {
            css: "danger",
            label: "未解决"
        },
        {
            css: "default",
            label: "已解决"
        },
        {
            css: "primary",
            label: "白名单"
        },
        {
            css: "primary",
            label: "例外"
        }
    ];

    $scope.OldType_str = {
        IP: {
            label: "可疑IP",
            css: "warning"
        },
        URL: {
            label: "可疑URL",
            css: "warning"
        },
        Beh: {
            label: "可疑行为",
            css: "warning"
        },
        File: {
            label: "可疑文件",
            css: "danger"
        },
        Loophole: {
            label: "漏洞利用",
            css: "danger"
        },
        extortion: {
            css: "danger",
            label: "勒索软件"
        }
    };

    //警告列表跳转
    $scope.detail = function (item, $event) {
        if ($event.target.nodeName == "BUTTON") {
            return;
        } else {
            switch (item.Type) {
                case "File":
                    location.href = "file?id=" + item.rid;
                    break;
                case "IP":
                    location.href = "ip?id=" + item.rid;
                    break;
                case "URL":
                    location.href = "url?id=" + item.rid;
                    break;
                case "Beh":
                    if (item.AlertType == 6) {
                        location.href = "loophole?id=" + item.rid;
                    } else if (item.AlertType == 7) {
                        location.href = "extortion?id=" + item.rid;
                    } else {
                        location.href = "beh?id=" + item.rid;
                    }
                    break;
            }
        }
    };

    function IDValidate(callback) {
        if ($scope.IDList.length == 0) {
            zeroModal.error({
                content: "操作失败",
                contentDetail: "请选择计算机！"
            });
            return;
        }
        callback();
    }

    //获取告警数据列表数据
    $scope.getnewPage = function (pageNow) {

        $scope.IDList = [];
        $scope.IDListData = [];

        $scope.searchObj = $scope.searchData;
        pageNow = pageNow ? pageNow : $scope.pages.pageNow;
        var params = {
            stime: $scope.searchObj.startTime,
            etime: $scope.searchObj.endTime,
            ComputerName: $scope.searchObj.ComputerName,
            AlertType: $scope.searchObj.AlertType,
            Label: $scope.searchObj.Label,
            MinPoint: $scope.searchObj.MinPoint,
            MaxPoint: $scope.searchObj.MaxPoint,
            page: pageNow,
            rows: $scope.select.model,
            gid: $scope.searchObj.gid
        };


        if (!autoplay) {
            params.stime = '';
            params.etime = '';
        }

        //console.log(params)
        $scope.pageGeting = true;
        $http.post("newpage", params).then(
            function success(rsp) {

                $scope.pageGeting = false;
                $scope.pages = rsp.data;
                angular.forEach($scope.pages.data, function (item) {
                    $scope.labelArry = item.Label.split("\\");
                    item.Label = $scope.labelArry[$scope.labelArry.length - 1];
                });
                $scope.ItemList = $scope.pages.data;
            },
            function err(rsp) {
                $scope.pageGeting = false;
            }
        );
    };

    $scope.getnewPage();

    // 选择页面数据条数,更新数据
    $scope.select_change = function () {
        $scope.getnewPage();
    }


    //搜索按钮点击事件
    $scope.search = function () {
        clearInterval(listTimer);
        autoplay = true;
        $scope.searchNew = JSON.stringify($scope.searchData);
        $scope.getnewPage();
    };

    $scope.getChart = function () {
        $http.post("chart-data", {}).then(
            function success(rsp) {
                updateChart(rsp.data);
            },
            function err(rsp) {}
        );
    };

    function updateChart(data) {
        if (data.chartData) {
            if (data.chartData.AlertSensor && updateSensorChart != null) {
                updateSensorChart(data.chartData.AlertSensor);
            }
            if (data.chartData.AlertSrcType && updateAlertChart != null) {
                updateAlertChart(data.chartData.AlertSrcType);
            }
        }
    }

    $scope.setAriaID = function (item, $event) {
        $event.stopPropagation();
        if ($scope.ariaID == item.id) {
            $scope.ariaID = null;
        } else {
            $scope.ariaID = item.id;
        }
    };

    $scope.delAriaID = function ($event) {
        $event.stopPropagation();
        setTimeout(function () {
            $scope.ariaID = null;
        }, 10);
    };

    $scope.update = function (type, item) {
        var rqs_data = {
            type: type,
            List: []
        };
        // 已解决
        if (type == "setOld") {}
        var send = function () {
            var loading = zeroModal.loading(4);
            $http.post("update", rqs_data).then(
                function success(rsp) {
                    $scope.getnewPage();
                    zeroModal.close(loading);
                },
                function err(rsp) {
                    zeroModal.close(loading);
                }
            );
        };

        let flag = Object.prototype.toString.call(item);

        if (flag === '[object Object]') {
            rqs_data.List.push(item);
            send();
        } else if (flag === '[object Array]') {
            rqs_data = {
                type: type,
                List: item
            };
            $scope.IDList = [];
            $scope.IDListData = [];
            send();
        } else {
            IDValidate(function () {
                for (var i = $scope.IDList.length - 1; i >= 0; i--) {
                    rqs_data.List.push($scope.ItemList[$scope.IDList[i]]);
                }
                send();
            });
        }
    };

    $scope.getChart();

    listTimer = setInterval(function () {
        //$scope.searchData.startTime = moment().subtract(365, 'days').unix();
        //$scope.searchData.endTime = moment().unix();
        $scope.getnewPage();
    }, 5000);

    setInterval(function () {
        $scope.getChart();
    }, 10000);
    // setInterval(function () {
    //     $scope.searchData.startTime = moment().subtract(365, 'days').unix();
    //     $scope.searchData.endTime = moment().unix();
    //     $scope.timepicker();
    //     $scope.getnewPage($scope.pages.pageNow);
    // }, 5000);
    // 时间插件初始化
    $scope.timepicker = function (params) {
        $(".timerange").daterangepicker({
                timePicker: true,
                // timePickerIncrement: 10,
                startDate: moment().subtract(365, "days"),
                endDate: moment(),
                locale: {
                    applyLabel: "确定",
                    cancelLabel: "取消",
                    format: "YYYY-MM-DD HH:mm",
                    customRangeLabel: "指定时间范围"
                },
                ranges: {
                    今天: [moment().startOf("day"), moment().endOf("day")],
                    "7日内": [
                        moment()
                        .startOf("day")
                        .subtract(7, "days"),
                        moment().endOf("day")
                    ],
                    本月: [moment().startOf("month"), moment().endOf("day")],
                    今年: [moment().startOf("year"), moment().endOf("day")]
                }
            },
            function (start, end, label) {
                $scope.searchData.startTime = start.unix();
                $scope.searchData.endTime = end.unix();
            }
        );
    };
    $scope.timepicker();
    $scope.myKeyup_min = function (item) {
        if (item < 0) {
            $scope.searchData.MinPoint = 0;
        } else if (item > 100) {
            $scope.searchData.MinPoint = 100;
        }
    };
    $scope.myKeyup_max = function (item) {
        if (item < 0) {
            $scope.searchData.MaxPoint = 0;
        } else if (item > 100) {
            $scope.searchData.MaxPoint = 100;
        }
    };

    //计算机名点击链接计算机卡片
    $scope.linkToSensor = function (SensorID, $event) {
        $event.stopPropagation();
        location.href = "/sensor/detail?sid=" + SensorID;
    }

    //当前告警checkbox单选
    $scope.selectOne = function (item, $event) {
        $event.stopPropagation();
        //停掉自动刷新状态
        clearInterval(listTimer);
        var index = $scope.IDList.indexOf(item.id);

        if (index == -1) {
            $scope.IDList.push(item.id);
            $scope.IDListData.push(item);
        } else {
            $scope.IDList.splice(index, 1);
            $scope.IDListData.splice(index, 1);
        }
    }

    //当前告警checkbox全选
    $scope.selectAll = function () {
        //停掉自动刷新状态
        clearInterval(listTimer);
        if ($scope.IDList.length === $scope.pages.data.length) {
            $scope.IDList = [];
            $scope.IDListData = [];
        } else {
            $scope.IDList = [];
            $scope.IDListData = [];
            for (var i in $scope.pages.data) {
                var data = $scope.pages.data[i];
                $scope.IDList.push(data.id);
                $scope.IDListData.push(data);
            }
        }
    }

    //批量处理取消点击事件
    $scope.celAlert = function () {
        $scope.IDList = [];
        $scope.IDListData = [];
    }


    //告警组点击事件
    $scope.searchGroups = function () {
        var W = 480;
        var H = 360;
        $scope.option = 'hide';
        // $scope.$apply();

        zeroModal.show({
            title: '请选择计算机分组！',
            content: groupTree,
            width: W + "px",
            height: H + "px",
            ok: true,
            cancel: true,
            okFn: function () {
                if (!nowGroup) {
                    // zeroModal.error('请选择计算机分组！');
                    $scope.searchData.gid = '*';
                    hide_box.appendChild(groupTree);
                    $scope.$apply();
                    zeroModal.closeAll();
                    return false;
                }
                $scope.searchData.gid = nowGroup.id;
                $scope.$apply();
                //$scope.searchDataChange('group');
                $scope.groupText = nowGroup.text;
            },
            onCleanup: function () {
                hide_box.appendChild(groupTree);
                $scope.option = 'show';
            }
        });
    }


    var GroupTree = [];

    for (var i = 0; i < GroupList.length; i++) {
        var group = GroupList[i];
        Groups[group.id] = group;
        group.type = '' + group.type;
        if (group.pid == 0) {
            GroupTree.push(group);
        } else {
            if (!Groups[group.pid].nodes) {
                Groups[group.pid].nodes = [];
            }
            Groups[group.pid].nodes.push(group);
        }
    }

    var treeDom;
    function updateTree() {
        treeDom = $('#groupTree').treeview({
            color: "#428bca",
            data: GroupTree,
            onNodeSelected: function (event, node) {
                nowGroup = node;
            },
            onNodeUnselected: function (event, node) {
                nowGroup = null;
            }
        });
    }
    updateTree();
});