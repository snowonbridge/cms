define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'turn/gift/setting/index',
                    add_url: 'turn/gift/setting/add',
                    edit_url: 'turn/gift/setting/edit',
                    del_url: 'turn/gift/setting/del',
                    multi_url: 'turn/gift/setting/multi',
                    table: 'turn_gift_setting',
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
                        {field: 'gift_content_id', title: __('Gift_content_id')},
                        {field: 'num', title: __('Num')},
                        {field: 'level_text', title: __('Level'), operate:false},
                        {field: 'sort', title: __('Sort')},
                        {field: 'base_rate', title: __('Base_rate')},
                        {field: 'lucky_value', title: __('Lucky_value')},
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