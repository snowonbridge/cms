define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'firstlogin/giftcritratesetting/index',
                    add_url: 'firstlogin/giftcritratesetting/add',
                    edit_url: 'firstlogin/giftcritratesetting/edit',
                    del_url: 'firstlogin/giftcritratesetting/del',
                    multi_url: 'firstlogin/giftcritratesetting/multi',
                    table: 'gift_crit_rate_setting',
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
                        {field: 'gift_crit_rate', title: __('Gift_crit_rate')},
                        {field: 'multiplying_power', title: __('Multiplying_power')},
                        {field: 'user_role', title: __('User_role')},
                        {field: 'status', title: __('Status'), formatter: Table.api.formatter.status},
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