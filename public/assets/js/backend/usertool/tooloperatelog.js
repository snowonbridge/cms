define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'usertool/tooloperatelog/index',
                    add_url: 'usertool/tooloperatelog/add',
                    edit_url: 'usertool/tooloperatelog/edit',
                    del_url: 'usertool/tooloperatelog/del',
                    multi_url: 'usertool/tooloperatelog/multi',
                    table: 'tool_operate_log',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'create_time',
                sortOrder:'desc',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
                        //{field: 'uid', title: __('Uid')},
                        {field: 'mid', title: __('Mid')},
                        {field: 'uname', title: __('Uname')},
                        {field: 'channal_id', title: __('Channal_id')},
                        {field: 'tool_id', title: __('Tool_id')},
                        {field: 'tool_name', title: __('Tool_name')},
                        {field: 'operate_type', title: __('Operate_type'),searchList:{1:'获取',2:'过期',3:'使用'}},
                        {field: 'get_type', title: __('Get_type'),searchList:{1:'购买',2:'系统赠送',3:'玩家赠送',4:'游戏获得'}},
                        {field: 'get_type_desc', title: __('Get_type_desc')},
                        {field: 'goods_id', title: __('Goods_id')},
                        {field: 'use_location', title: __('Use_location')},
                        {field: 'before_num', title: __('Before_num')},
                        {field: 'after_num', title: __('After_num')},
                        {field: 'expire_time', title: __('Expire_time'), formatter: Table.api.formatter.datetime,type:'datetime',addclass:'datetimepicker', data: 'data-date-format="YYYY-MM-DD HH:mm:ss"'},
                        {field: 'begin_time', title: '道具起始时间', formatter: Table.api.formatter.datetime,type:'datetime',addclass:'datetimepicker', data: 'data-date-format="YYYY-MM-DD HH:mm:ss"'},
                        {field: 'valid_duration', title: __('道具使用有效期')},
                        {field: 'use_time', title: __('操作时间'), formatter: Table.api.formatter.datetime,type:'datetime',addclass:'datetimepicker', data: 'data-date-format="YYYY-MM-DD HH:mm:ss"'},
                        {field: 'create_time', title: __('Create_time'), formatter: Table.api.formatter.datetime,type:'datetime',addclass:'datetimepicker', data: 'data-date-format="YYYY-MM-DD HH:mm:ss"'},
                        //{field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ]
                ]
            });

            // 为表格绑定事件
            Table.api.bindevent(table);
        },
        add: function () {
            Controller.api.bindevent();
        },
        edit: function () {
            Controller.api.bindevent();
        },
        api: {
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});