define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'turn/gift/rate/log/index',
                    add_url: 'turn/gift/rate/log/add',
                    edit_url: 'turn/gift/rate/log/edit',
                    del_url: 'turn/gift/rate/log/del',
                    multi_url: 'turn/gift/rate/log/multi',
                    table: 'turn_gift_rate_log',
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
                        {field: 'exchange_id', title: __('Exchange_id')},
                        {field: 'gift_setting_id', title: __('Gift_setting_id')},
                        {field: 'gift_content_id', title: __('Gift_content_id')},
                        {field: 'lucky_value', title: __('Lucky_value')},
                        {field: 'rate', title: __('Rate')},
                        {field: 'turn_counts', title: __('Turn_counts')},
                        {field: 'gift_num', title: __('Gift_num')},
                        {field: 'expect_min_value', title: __('Expect_min_value')},
                        {field: 'expect_max_value', title: __('Expect_max_value')},
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