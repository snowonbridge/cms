define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'vip/viprecvgiftlog/index',
                    add_url: 'vip/viprecvgiftlog/add',
                    edit_url: 'vip/viprecvgiftlog/edit',
                    del_url: 'vip/viprecvgiftlog/del',
                    multi_url: 'vip/viprecvgiftlog/multi',
                    table: 'vip_recv_gift_log',
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
                        {field: 'vip', title: __('Vip')},
                        {field: 'priv_id', title: __('Priv_id')},
                        {field: 'gift_id', title: __('Gift_id')},
                        {field: 'gift_num', title: __('Gift_num')},
                        {field: 'receive_status', title: __('Receive_status'), formatter: Table.api.formatter.status},
                        {field: 'day_time', title: __('Day_time'), formatter: Table.api.formatter.datetime},
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