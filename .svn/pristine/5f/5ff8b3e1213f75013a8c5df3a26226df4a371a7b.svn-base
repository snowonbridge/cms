define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'activity/consumptiongift/index',
                    add_url: 'activity/consumptiongift/add',
                    edit_url: 'activity/consumptiongift/edit',
                    del_url: 'activity/consumptiongift/del',
                    multi_url: 'activity/consumptiongift/multi',
                    table: 'consumption_gift',
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
                        {field: 'activity_id', title: __('Activity_id')},
                        {field: 'actions_list', title: __('Actions_list')},
                        {field: 'img_icon', title: __('Img_icon'), formatter: Table.api.formatter.icon},
                        {field: 'desc', title: __('Desc')},
                        {field: 'tab_id', title: __('Tab_id')},
                        {field: 'base_activity_id', title: __('Base_activity_id')},
                        {field: 'sort', title: __('Sort')},
                        {field: 'redirect_id', title: __('Redirect_id')},
                        {field: 'start_time', title: __('Start_time'), formatter: Table.api.formatter.datetime},
                        {field: 'end_time', title: __('End_time'), formatter: Table.api.formatter.datetime},
                        {field: 'create_time', title: __('Create_time'), formatter: Table.api.formatter.datetime},
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