var rootScope = null;
var Groups = {
    '*': {
        text: '所有',
        type: '*'
    }
};
var app = angular.module('myApp', []);

function baseController($scope, $http, ajaxURL, pageNowName) {
    rootScope = $scope;
    rootScope.Groups = Groups;
    $scope.pages = {
        data: [],
        count: 0,
        maxPage: "...",
        pageNow: 1,
    };
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

    /*
    * 0：卸载
    * 1：在线
    * 2：断线
    * */

    //卸载数组
    $scope.sensorDangerList = [];

    //在线数组
    $scope.sensorsuccessList = [];

    //下拉框条数
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
    ];
    $scope.select = {
        model: '10'
    }

    $scope.isolate_str = ['text-blue', 'text-gray'];
    $scope.pause_str = ['glyphicon-play text-green', 'glyphicon-pause text-yellow'];
    $scope.work_str = ['', 'glyphicon-hourglass text-yellow', 'glyphicon-ok text-green', 'glyphicon-remove text-red'];
    $scope.scan_str = ['text-gray', 'text-blue'];
    $scope.SensorIDList = [];
    $scope.SensorList = {};
    $scope.WhiteList = {};

    $scope.setPage = function (rsp) {
        if (rsp.data.status != "success") {
            return;
        }
        $scope.pages = rsp.data;
        // console.log($scope.pages);
        // angular.forEach($scope.pages.data,function(item){
        //     console.log(item.status);
        // });

        var ID4NewPage = [];
        for (var i in $scope.pages.data) {
            var sensor = $scope.pages.data[i];
            $scope.SensorList[sensor.SensorID] = sensor;
            ID4NewPage.push(sensor.SensorID);
        }
        for (var i = $scope.SensorIDList.length - 1; i >= 0; i--) {
            var SensorID = $scope.SensorIDList[i]
            if (ID4NewPage.indexOf(SensorID) == -1) {
                $scope.SensorIDList.splice(i, 1);
            }
        }
        if ($scope.postType) {
            $scope.rsqType = $scope.postType;
        }
        sessionStorage.setItem(pageNowName, $scope.pages.pageNow);
    }

    $scope.getPage = function (pageNow) {

        pageNow = pageNow ? pageNow : sessionStorage.getItem(pageNowName);

        $scope.pageGeting = true;
        var postData = {};
        if ($scope.postData) {
            postData = angular.copy($scope.postData);
        }
        console.log(postData);
        postData['page'] = pageNow;
        postData['rows'] = $scope.select.model;
        console.log(postData);

        $http.post(ajaxURL.getPage, postData).then(function success(rsp) {

            //console.log('*********')
            $scope.pageGeting = false;
            $scope.setPage(rsp);

        }, function err(rsp) {
            $scope.pageGeting = false;
        });
    }

    $scope.selectAll = function () {
        if ($scope.SensorIDList.length == $scope.pages.data.length) {
            $scope.SensorIDList = [];
            $scope.sensorsuccessList = [];
            $scope.sensorDangerList = [];
        } else {
            $scope.SensorIDList = [];
            $scope.sensorsuccessList = [];
            $scope.sensorDangerList = [];

            for (var i in $scope.pages.data) {
                var sensor = $scope.pages.data[i];
                $scope.SensorIDList.push(sensor.SensorID);
                ///
                let status = sensor.status;
                if(status == 0){
                    $scope.sensorDangerList.push(sensor.SensorID);
                }else if(status == 1){
                    $scope.sensorsuccessList.push(sensor.SensorID);
                }
            }
        }
    }

    $scope.selectOne = function (sensor, $event) {
        $event.stopPropagation();
        var index = $scope.SensorIDList.indexOf(sensor.SensorID);
        if (index == -1) {
            $scope.SensorIDList.push(sensor.SensorID);
        } else {
            $scope.SensorIDList.splice(index, 1);
        }
        ///
        let status = sensor.status;

        if(status == 0){
            let idx = $scope.sensorDangerList.indexOf(sensor.SensorID);
            if (idx == -1) {
                $scope.sensorDangerList.push(sensor.SensorID);
            } else {
                $scope.sensorDangerList.splice(idx, 1);
            }

        }else if(status == 1){
            let idx = $scope.sensorsuccessList.indexOf(sensor.SensorID);
            if (idx == -1) {
                $scope.sensorsuccessList.push(sensor.SensorID);
            } else {
                $scope.sensorsuccessList.splice(idx, 1);
            }
        }
    }

    $scope.detail = function (SensorID) {
        // var Sensor = $scope.SensorList[SensorID];

        // var W = $(".content").width();
        // var H = (W/16)*9;
        // zeroModal.show({
        //     title: Sensor.ComputerName,
        //     content: "<pre>"+JSON.stringify(Sensor, null, 2)+"</pre>",
        //     width: W+"px",
        //     height: H+"px",
        //     cancel: true,
        //     overlayClose: true,
        //     onCleanup: function() {
        //     }
        // });
        location.href = "detail?sid=" + SensorID;
    }

    function SensorIDValidate(callback) {
        var haveWorking = false;
        for (var i = $scope.SensorIDList.length - 1; i >= 0; i--) {
            var SensorID = $scope.SensorIDList[i];
            if ($scope.SensorList[SensorID].work == 1 || $scope.SensorList[SensorID].status != 1) {
                haveWorking = true;
                $scope.SensorIDList.splice(i, 1);
            }
        }
        if ($scope.SensorIDList.length == 0) {
            zeroModal.error({
                content: '操作失败',
                contentDetail: '请选择计算机！'
            });
            return;
        }

        if (haveWorking) {
            zeroModal.confirm({
                content: '操作提示',
                contentDetail: '当前正在执行命令的计算机无法执行此命令，<br>是否忽略这些计算机继续执行？',
                okFn: function () {
                    callback();
                },
                cancelFn: function () {}
            });
        } else {
            callback();
        }
    }

    function setWorking() {
        for (var i = $scope.SensorIDList.length - 1; i >= 0; i--) {
            var Sensor = $scope.SensorList[$scope.SensorIDList[i]].work = 1;
        }
    }

    $scope.sendBase = function (type) {
        SensorIDValidate(function () {
            rqs_data = {
                type: type,
                SensorIDList: $scope.sensorsuccessList
            };
            var loading = zeroModal.loading(4);
            $http.post("sendbase", rqs_data).then(function success(rsp) {
                setWorking();
                zeroModal.close(loading);

                $scope.sensorsuccessList = [];
                $scope.SensorIDList = [];

            }, function err(rsp) {
                zeroModal.close(loading);
            });
        });
    }

    $scope.sendUpdate = function () {
        SensorIDValidate(function () {
            var W = 480;
            var H = 360;
            zeroModal.show({
                title: '请选择探针文件！',
                content: update_list,
                width: W + "px",
                height: H + "px",
                ok: true,
                cancel: true,
                okFn: function () {
                    if (!updateNode) {
                        zeroModal.error('请选择探针文件！');
                        return false;
                    }
                    rqs_data = {
                        type: 'UPDATE',
                        SensorFile: updateNode,
                        SensorIDList: $scope.sensorsuccessList
                    };
                    var loading = zeroModal.loading(4);
                    $http.post("sendbase", rqs_data).then(function success(rsp) {
                        setWorking();
                        zeroModal.close(loading);

                        $scope.sensorsuccessList = [];
                        $scope.SensorIDList = [];

                    }, function err(rsp) {
                        zeroModal.close(loading);
                    });
                },
                onCleanup: function () {
                    hide_box.appendChild(update_list);
                }
            });
        });
    }

    $scope.sendUpdateProfile = function () {

        SensorIDValidate(function () {
            var W = 480;
            var H = 360;

            zeroModal.show({
                title: '请选择配置文件！',
                content: profile_list,
                width: W + "px",
                height: H + "px",
                ok: true,
                cancel: true,
                okFn: function () {
                    if (!updateProfile) {
                        zeroModal.error('请选择配置文件！');
                        return false;
                    }
                    rqs_data = {
                        type: 'UPDATE_PROFILE',
                        ProFile: updateProfile,
                        SensorIDList: $scope.sensorsuccessList
                    };

                    var loading = zeroModal.loading(4);
                    $http.post("sendbase", rqs_data).then(function success(rsp) {
                        setWorking();
                        zeroModal.close(loading);

                        $scope.sensorsuccessList = [];
                        $scope.SensorIDList = [];

                    }, function err(rsp) {
                        zeroModal.close(loading);
                    });
                },
                onCleanup: function () {
                    hide_box.appendChild(profile_list);
                }
            });
        });
    }

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
                    zeroModal.error('请选择计算机分组！');
                    return false;
                }
                $scope.searchData.group = nowGroup.id;
                $scope.$apply();
                $scope.searchDataChange('group');
                $scope.groupText = nowGroup.text;
            },
            onCleanup: function () {
                hide_box.appendChild(groupTree);
                $scope.option = 'show';
            }
        });
    }

    $scope.addGroups = function () {
        var W = 480;
        var H = 360;
        zeroModal.show({
            title: '请选择计算机分组！',
            content: groupTree,
            width: W + "px",
            height: H + "px",
            ok: true,
            cancel: true,
            okFn: function () {
                if (!nowGroup) {
                    zeroModal.error('请选择计算机分组！');
                    return false;
                }
                if (nowGroup.type == 1) {
                    zeroModal.error('不能加入自动分组！');
                    return false;
                }
                var sidList = [];
                for (var i = $scope.sensorsuccessList.length - 1; i >= 0; i--) {
                    var SensorID = $scope.sensorsuccessList[i];
                    var sensor = $scope.SensorList[SensorID];
                    sidList.push(sensor.id);
                }
                rqs_data = {
                    gid: nowGroup.id,
                    sidList: sidList
                };
                var loading = zeroModal.loading(4);
                $http.post("addgroups", rqs_data).then(function success(rsp) {
                    if (rsp.data.status == 'success') {
                        zeroModal.success({
                            content: '完成',
                            contentDetail: '成功加入' + rsp.data.success + '台计算机！<br/>' + rsp.data.fail + '台计算机已经在此分组中。',
                        });
                    } else {
                        zeroModal.error('加入计算机分组失败！');
                    }
                    zeroModal.close(loading);

                    $scope.sensorsuccessList = [];
                    $scope.SensorIDList = [];

                }, function err(rsp) {
                    zeroModal.error('加入计算机分组失败！');
                    zeroModal.close(loading);
                });
            },
            onCleanup: function () {
                hide_box.appendChild(groupTree);
            }
        });
    }

    //删除Sensor
    $scope.sendDelete = function () {
        var W = 480;
        var H = 360;

        zeroModal.confirm({
            content: '确定要删除吗？',
            width: W + "px",
            height: H + "px",
            okFn: function() {
                var rqs_data = {
                    sid: $scope.sensorDangerList
                };
                var loading = zeroModal.loading(4);

                $http.delete("/sensor/del-sensor", {data: rqs_data})
                    .then(function success(rsp) {
                        //$scope.$apply();
                        $scope.getPage();
                        zeroModal.close(loading);

                    }, function err(rsp) {
                        zeroModal.close(loading);
                        zeroModal.error('删除计算机失败！');
                    });
            },
            cancelFn: function() {}
        });
    }

    $scope.myKeyup = function (e) {
        var keycode = window.event ? e.keyCode : e.which;
        if (keycode == 13) {
            e.target.blur();
            $scope.search();
        }
    };

    $scope.getPage();

    $scope.pageGeting = false;

    setInterval(function () {
        if (!$scope.pageGeting) {
            $scope.getPage();
        }
    }, 5000);


    // 选择页面数据条数,更新数据
    $scope.select_change = function () {
        $scope.getPage();
    }
}

app.controller('protectCtrl', function ($scope, $http, $filter) {
    baseController($scope, $http, {
        getPage: "protect",
        update: "update"
    }, "protectNow");

    $scope.searchData = {
        ComputerName: '*',
        ProfileVersion: '*',
        group: '*',
        SensorVersion: '*',
        status: '*'
    };

    $scope.searchType = "";
    $scope.postType = "";
    $scope.rsqType = "";
    $scope.postData = {};

    $scope.searchDataChange = function (key_change) {
        for (var key in $scope.searchData) {
            if (key != key_change) {
                $scope.searchData[key] = '*';
            } else {
                $scope.searchType = key;
            }
        }
    }

    $scope.search = function (key_change) {
        $scope.postData = angular.copy($scope.searchData);
        if ($scope.searchType) {
            $scope.postType = $scope.searchType
        }
        $scope.getPage();
    }
});

var updateNode = null;
var updateProfile = null;
var nowGroup = null;

app.controller('quarantineCtrl', function ($scope, $http, $filter) {
    baseController($scope, $http, {
        getPage: "quarantine",
        update: "update"
    }, "quarantineNow");

    window.onload = function () {
        var SensorVersionTree = $('#update_list').treeview({
            // showBorder: false,
            color: "#428bca",
            data: SensorFileList,
            onNodeSelected: function (event, node) {
                updateNode = node;
            },
            onNodeUnselected: function (event, node) {
                updateNode = null;
            }
        });
        var ProFileTree = $('#profile_list').treeview({
            // showBorder: false,
            color: "#428bca",
            data: ProFileList,
            onNodeSelected: function (event, node) {
                updateProfile = node;
                console.log(updateProfile);
            },
            onNodeUnselected: function (event, node) {
                updateProfile = null;
            }
        });

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
    };

});