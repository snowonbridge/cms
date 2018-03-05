define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'control/store/index',
                    //add_url: 'agent/manage/index/add',
                    //edit_url: 'agent/manage/index/edit',
                    //del_url: 'agent/manage/index/del',
                    //multi_url: 'agent/manage/index/multi',
                    table: 'control_index',
                },
                pageSize: 36,
                pagination: false,
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'control_store',
                //sortName: '',
                //sortOrder: null,
                showToggle:false,
                showColumns:false,
                showRefresh:false,
                search : false,
                searchFormVisible: false,
                commonSearch: false,
                showExport: false,
                columns: [
                    [
                        //{checkbox: true},
                        //{field: 'id', title: __('id'),operate: false},
                        {field: 'control_store', title: '渠道id',visible:false},
                        {field: 'control_store_text', title: '渠道id',},

                        {field: 'time_control', title: '时间段策略开关',formatter: Controller.api.formatter.time_control,
                            events: Controller.api.events.operate,},

                        {field: 'is_control_show', title: '高级玩家功能',formatter: Controller.api.formatter.is_control_show,
                            events: Controller.api.events.operate,},

                        {field: 'ddz', title: '斗地主',formatter: Controller.api.formatter.ddz,
                            events: Controller.api.events.operate,},

                        {field: 'ysz', title: '赢三张',formatter: Controller.api.formatter.ysz,
                            events: Controller.api.events.operate,},

                        {field: 'nn', title: '斗牛',formatter: Controller.api.formatter.nn,
                            events: Controller.api.events.operate,},

                        {field: 'lhd', title: '百人场',formatter: Controller.api.formatter.lhd,
                            events: Controller.api.events.operate,},
                        //{
                        //    field: 'operate',
                        //    title: __('Operate'),
                        //    table: table,
                        //    events: Table.api.events.operate,
                        //    formatter: Table.api.formatter.operate
                        //}
                    ]
                ],


            });

            // 为表格绑定事件
            Table.api.bindevent(table);
            Controller.api.bindevent();
            this.api.init();
        },
        add: function () {
            Controller.api.bindevent();
        },
        edit: function () {
            Controller.api.bindevent();
        },
        api: {
            formatter: {

                time_control: function (value, row, index) {
                    return " <a href='javascript:;' class='btn btn-" + (value==1 ? "info" : "default") + " btn-xs btn-change time_control' " +
                        ">" + (value==1 ?'开启' : '关闭') + "</a>";
                },
                is_control_show: function (value, row, index) {
                    return " <a href='javascript:;' class='btn btn-" + (value==0 ? "info" : "default") + " btn-xs btn-change is_control_show' " +
                        ">" + (value==0 ?'正常' : '关闭') + "</a>";
                },
                ddz: function (value, row, index) {
                    return " <a href='javascript:;' class='btn btn-" + (value==1 ? "info" : "default") + " btn-xs btn-change ddz' " +
                        ">" + (value==1 ?'正常' : '关闭') + "</a>";
                },
                ysz: function (value, row, index) {
                    return " <a href='javascript:;' class='btn btn-" + (value==1 ? "info" : "default") + " btn-xs btn-change ysz' " +
                        ">" + (value==1 ?'正常' : '关闭') + "</a>";
                },
                nn: function (value, row, index) {
                    return " <a href='javascript:;' class='btn btn-" + (value==1 ? "info" : "default") + " btn-xs btn-change nn' " +
                        ">" + (value==1 ?'正常' : '关闭') + "</a>";
                },
                lhd: function (value, row, index) {
                    return " <a href='javascript:;' class='btn btn-" + (value==1 ? "info" : "default") + " btn-xs btn-change lhd' " +
                        ">" + (value==1 ?'正常' : '关闭') + "</a>";
                },

            },

            // 单元格元素事件
            events: {
                operate: {
                    'click .time_control': function (e, value, row, index) {
                        var post_data = {
                            "app_id":$("#c-app_id").val(),
                            "setting": [
                                {
                                    "control_store": row['control_store'],
                                    "time_control": row['time_control']==0?1:0,
                                    "is_control_show": row['is_control_show'],
                                    "ddz": row['ddz'],
                                    "ysz": row['ysz'],
                                    "lhd": row['lhd'],
                                    "mj": row['mj'],
                                    "nn": row['nn'],
                                }
                            ]
                        };
                        $.ajax({
                            url: '/control/store/saveSetting',
                            type: 'post',
                            data: post_data,
                            cache: false,
                            dataType: 'json',
                            success: function(response) {
                                if (response.code == '1') {

                                    $("#table").bootstrapTable('refresh');

                                } else {
                                    alert(response.msg);
                                }
                            }
                        });
                    },
                    'click .is_control_show': function (e, value, row, index) {
                        var post_data = {
                            "app_id":$("#c-app_id").val(),
                            "setting": [
                                {
                                    "control_store": row['control_store'],
                                    "time_control": row['time_control'],
                                    "is_control_show": row['is_control_show']==0?1:0,
                                    "ddz": row['ddz'],
                                    "ysz": row['ysz'],
                                    "lhd": row['lhd'],
                                    "mj": row['mj'],
                                    "nn": row['nn'],
                                }
                                ]
                         };
                         $.ajax({
                            url: '/control/store/saveSetting',
                            type: 'post',
                            data: post_data,
                            cache: false,
                            dataType: 'json',
                            success: function(response) {
                                if (response.code == '1') {

                                    $("#table").bootstrapTable('refresh');

                                } else {
                                    alert(response.msg);
                                }
                            }
                        });
                    },
                    'click .ddz': function (e, value, row, index) {
                        var post_data = {
                            "app_id":$("#c-app_id").val(),
                            "setting": [
                                {
                                    "control_store": row['control_store'],
                                    "time_control": row['time_control'],
                                    "is_control_show": row['is_control_show'],
                                    "ddz": row['ddz']==0?1:0,
                                    "ysz": row['ysz'],
                                    "lhd": row['lhd'],
                                    "mj": row['mj'],
                                    "nn": row['nn'],
                                }
                            ]
                        };
                        $.ajax({
                            url: '/control/store/saveSetting',
                            type: 'post',
                            data: post_data,
                            cache: false,
                            dataType: 'json',
                            success: function(response) {
                                if (response.code == '1') {

                                    $("#table").bootstrapTable('refresh');

                                } else {
                                    alert(response.msg);
                                }
                            }
                        });

                    },
                    'click .ysz': function (e, value, row, index) {
                        var post_data = {
                            "app_id":$("#c-app_id").val(),
                            "setting": [
                                {
                                    "control_store": row['control_store'],
                                    "time_control": row['time_control'],
                                    "is_control_show": row['is_control_show'],
                                    "ddz": row['ddz'],
                                    "ysz": row['ysz']==0?1:0,
                                    "lhd": row['lhd'],
                                    "mj": row['mj'],
                                    "nn": row['nn'],
                                }
                            ]
                        };
                        $.ajax({
                            url: '/control/store/saveSetting',
                            type: 'post',
                            data: post_data,
                            cache: false,
                            dataType: 'json',
                            success: function(response) {
                                if (response.code == '1') {

                                    $("#table").bootstrapTable('refresh');

                                } else {
                                    alert(response.msg);
                                }
                            }
                        });

                    },

                    'click .nn': function (e, value, row, index) {
                        var post_data = {
                            "app_id":$("#c-app_id").val(),
                            "setting": [
                                {
                                    "control_store": row['control_store'],
                                    "time_control": row['time_control'],
                                    "is_control_show": row['is_control_show'],
                                    "ddz": row['ddz'],
                                    "ysz": row['ysz'],
                                    "lhd": row['lhd'],
                                    "mj": row['mj'],
                                    "nn": row['nn']==0?1:0,
                                }
                            ]
                        };
                        $.ajax({
                            url: '/control/store/saveSetting',
                            type: 'post',
                            data: post_data,
                            cache: false,
                            dataType: 'json',
                            success: function(response) {
                                if (response.code == '1') {

                                    $("#table").bootstrapTable('refresh');

                                } else {
                                    alert(response.msg);
                                }
                            }
                        });

                    },

                    'click .lhd': function (e, value, row, index) {
                        var post_data = {
                            "app_id":$("#c-app_id").val(),
                            "setting": [
                                {
                                    "control_store": row['control_store'],
                                    "time_control": row['time_control'],
                                    "is_control_show": row['is_control_show'],
                                    "ddz": row['ddz'],
                                    "ysz": row['ysz'],
                                    "lhd": row['lhd']==0?1:0,
                                    "mj": row['mj'],
                                    "nn": row['nn'],
                                }
                            ]
                        };
                        $.ajax({
                            url: '/control/store/saveSetting',
                            type: 'post',
                            data: post_data,
                            cache: false,
                            dataType: 'json',
                            success: function(response) {
                                if (response.code == '1') {

                                    $("#table").bootstrapTable('refresh');

                                } else {
                                    alert(response.msg);
                                }
                            }
                        });

                    },

                },
            },
            bindevent: function () {
                $(document).on("change", "#c-sid", function () {
                    $("#c-app_id option[data-type='0']").prop("selected", true);
                    $("#c-app_id option").removeClass("hide");
                    $("#c-app_id option[data-type!='" + $(this).val() + "'][data-type!='0']").addClass("hide");
                    $("#c-app_id").selectpicker("refresh");

                });
                Form.api.bindevent($("form[role=form]"));
            },
            init: function () {
                $('#search').click(function (e) {
                    var app_id = $("#c-app_id").val();
                    $("#table").bootstrapTable('refresh',{url: '/control/store/index?app_id='+app_id});
                    //return false;
                });
            }
        }
    };
    return Controller;
});