define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'exchange/userexchangecount/index',
                    add_url: 'exchange/userexchangecount/add',
                    edit_url: 'exchange/userexchangecount/edit',
                    del_url: 'exchange/userexchangecount/del',
                    multi_url: 'exchange/userexchangecount/multi',
                    table: 'user_exchange_count',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'date_t',
                sortName: 'date_t',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'date_t', title: __('Date_t')},
                        {field: 'open_p', title: __('Open_p')},
                        {field: 'open_n', title: __('Open_n')},
                        {field: 'tab_p', title: __('Tab_p')},
                        {field: 'tab_n', title: __('Tab_n')},
                        {field: 'exc_p', title: __('Exc_p')},
                        {field: 'exc_n', title: __('Exc_n')},
                        {field: 'suc_p', title: __('Suc_p')},
                        {field: 'suc_n', title: __('Suc_n')},
                        {field: 'bind_p', title: __('Bind_p')},
                        {field: 'bind_n', title: __('Bind_n')},
                        // {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
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