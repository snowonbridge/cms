define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'firstlogin/giftdailysetting/index',
                    add_url: 'firstlogin/giftdailysetting/add',
                    edit_url: 'firstlogin/giftdailysetting/edit',
                    del_url: 'firstlogin/giftdailysetting/del',
                    multi_url: 'firstlogin/giftdailysetting/multi',
                    table: 'gift_daily_setting',
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
                        {field: 'gift_name', title: __('Gift_name')},
                        {field: 'gift_num', title: __('Gift_num')},
                        {field: 'gift_content_id', title: __('Gift_content_id')},
                        {field: 'vip_crit', title: __('Vip_crit')},
                        {field: 'gift_desc', title: __('Gift_desc')},
                        {field: 'status', title: __('Status'), formatter: Table.api.formatter.status},
                        {field: 'user_role', title: __('User_role')},
                        {field: 'day_nd', title: __('Day_nd')},
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