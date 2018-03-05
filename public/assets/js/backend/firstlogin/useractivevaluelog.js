define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'firstlogin/useractivevaluelog/index',
                    add_url: 'firstlogin/useractivevaluelog/add',
                    edit_url: 'firstlogin/useractivevaluelog/edit',
                    del_url: 'firstlogin/useractivevaluelog/del',
                    multi_url: 'firstlogin/useractivevaluelog/multi',
                    table: 'user_active_value_log',
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
                        {field: 'title_counts', title: __('Title_counts')},
                        {field: 'active_value_id', title: __('Active_value_id')},
                        {field: 'active_level', title: __('Active_level')},
                        {field: 'active_value', title: __('Active_value')},
                        {field: 'add_day_time', title: __('Add_day_time'), formatter: Table.api.formatter.datetime},
                        {field: 'add_time', title: __('Add_time'), formatter: Table.api.formatter.datetime},
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