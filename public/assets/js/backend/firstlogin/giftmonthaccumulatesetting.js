define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'firstlogin/giftmonthaccumulatesetting/index',
                    add_url: 'firstlogin/giftmonthaccumulatesetting/add',
                    edit_url: 'firstlogin/giftmonthaccumulatesetting/edit',
                    del_url: 'firstlogin/giftmonthaccumulatesetting/del',
                    multi_url: 'firstlogin/giftmonthaccumulatesetting/multi',
                    table: 'gift_month_accumulate_setting',
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
                        {field: 'name', title: __('Name')},
                        {field: 'total_days', title: __('Total_days')},
                        {field: 'active_value', title: __('Active_value')},
                        {field: 'status', title: __('Status'), formatter: Table.api.formatter.status},
                        {field: 'gift_content', title: __('Gift_content')},
                        {field: 'create_time', title: __('Create_time'), formatter: Table.api.formatter.datetime},
                        {field: 'ext_json', title: __('Ext_json')},
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