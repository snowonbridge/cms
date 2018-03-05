define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'activity/userpurchasediamandlog/index',
                    add_url: 'activity/userpurchasediamandlog/add',
                    edit_url: 'activity/userpurchasediamandlog/edit',
                    del_url: 'activity/userpurchasediamandlog/del',
                    multi_url: 'activity/userpurchasediamandlog/multi',
                    table: 'user_purchase_diamand_log',
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
                        {field: 'num', title: __('Num')},
                        {field: 'add_month_time', title: __('Add_month_time'), formatter: Table.api.formatter.datetime},
                        {field: 'add_day_time', title: __('Add_day_time'), formatter: Table.api.formatter.datetime},
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