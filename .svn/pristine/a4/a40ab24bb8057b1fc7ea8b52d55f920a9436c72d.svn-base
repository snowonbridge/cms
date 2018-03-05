define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'activity/consumptionconfig/index',
                    add_url: 'activity/consumptionconfig/add',
                    edit_url: 'activity/consumptionconfig/edit',
                    del_url: 'activity/consumptionconfig/del',
                    multi_url: 'activity/consumptionconfig/multi',
                    table: 'consumption_config',
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
                        {field: 'from_gift_id', title: __('From_gift_id')},
                        {field: 'action_id', title: __('Action_id')},
                        {field: 'from_num', title: __('From_num')},
                        {field: 'target_gift_id', title: __('Target_gift_id')},
                        {field: 'user_level', title: __('User_level')},
                        {field: 'magic', title: __('Magic')},
                        {field: 'frequency', title: __('Frequency')},
                        {field: 'gift_list', title: __('Gift_list')},
                        {field: 'login_check', title: __('Login_check')},
                        {field: 'remark', title: __('Remark')},
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