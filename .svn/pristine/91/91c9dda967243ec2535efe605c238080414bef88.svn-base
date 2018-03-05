define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'agent/settlement/agentsettlementorderlog/index',
                    add_url: 'agent/settlement/agentsettlementorderlog/add',
                    edit_url: 'agent/settlement/agentsettlementorderlog/edit',
                    del_url: 'agent/settlement/agentsettlementorderlog/del',
                    multi_url: 'agent/settlement/agentsettlementorderlog/multi',
                    table: 'agent_settlement_order_log',
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
                        {field: 'apply_no', title: __('Apply_no')},
                        {field: 'admin_id', title: __('Admin_id')},
                        {field: 'admin_name', title: __('Admin_name')},
                        {field: 'agent_id', title: __('Agent_id')},
                        {field: 'agent_name', title: __('Agent_name')},
                        {field: 'before_money', title: __('Before_money')},
                        {field: 'settlement_money', title: __('Settlement_money')},
                        {field: 'after_money', title: __('After_money')},
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