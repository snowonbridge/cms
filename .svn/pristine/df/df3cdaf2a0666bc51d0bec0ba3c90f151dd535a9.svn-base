define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'activity/functiongift/index',
                    add_url: 'activity/functiongift/add',
                    edit_url: 'activity/functiongift/edit',
                    del_url: 'activity/functiongift/del',
                    multi_url: 'activity/functiongift/multi',
                    table: 'function_gift',
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
                        {field: 'function_list', title: __('Function_list')},
                        {field: 'frequency', title: __('Frequency')},
                        {field: 'function_gifts', title: __('Function_gifts')},
                        {field: 'gift_list', title: __('Gift_list')},
                        {field: 'img_icon', title: __('Img_icon'), formatter: Table.api.formatter.icon},
                        {field: 'redirect_id', title: __('Redirect_id')},
                        {field: 'sort', title: __('Sort')},
                        {field: 'status', title: __('Status'), formatter: Table.api.formatter.status},
                        {field: 'create_time', title: __('Create_time'), formatter: Table.api.formatter.datetime},
                        {field: 'desc', title: __('Desc')},
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