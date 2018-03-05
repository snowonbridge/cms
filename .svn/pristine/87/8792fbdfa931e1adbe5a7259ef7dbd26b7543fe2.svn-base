define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'activity/userconsumptionlog/index',
                    add_url: 'activity/userconsumptionlog/add',
                    edit_url: 'activity/userconsumptionlog/edit',
                    del_url: 'activity/userconsumptionlog/del',
                    multi_url: 'activity/userconsumptionlog/multi',
                    table: 'user_consumption_log',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'id',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
                        {field: 'uid', title: __('Uid')},
                        {field: 'activity_id', title: __('Activity_id')},
                        {field: 'challege_list', title: __('Challege_list')},
                        {field: 'achieve_list', title: __('Achieve_list')},
                        {field: 'gift_list', title: __('Gift_list')},
                        {field: 'is_receive', title: __('Is_receive')},
                        {field: 'frequency', title: __('Frequency')},
                        {field: 'current_frequency', title: __('Current_frequency')},
                        {field: 'img_icon', title: __('Img_icon'), formatter: Table.api.formatter.icon},
                        {field: 'add_time', title: __('Add_time'), formatter: Table.api.formatter.datetime},
                        {field: 'create_time', title: __('Create_time'), formatter: Table.api.formatter.datetime},
                        {field: 'update_time', title: __('Update_time'), formatter: Table.api.formatter.datetime},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
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