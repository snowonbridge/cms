define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'firstlogin/usermonthgift/index',
                    add_url: 'firstlogin/usermonthgift/add',
                    edit_url: 'firstlogin/usermonthgift/edit',
                    del_url: 'firstlogin/usermonthgift/del',
                    multi_url: 'firstlogin/usermonthgift/multi',
                    table: 'user_month_gift',
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
                        {field: 'gift_month_accum_id', title: __('Gift_month_accum_id')},
                        {field: 'user_active_value', title: __('User_active_value')},
                        {field: 'user_active_days', title: __('User_active_days')},
                        {field: 'gift_content', title: __('Gift_content')},
                        {field: 'is_received', title: __('Is_received')},
                        {field: 'gift_receive_time', title: __('Gift_receive_time'), formatter: Table.api.formatter.datetime},
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