define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'monthcard/monthcardcount/index',
                    add_url: 'monthcard/monthcardcount/add',
                    edit_url: 'monthcard/monthcardcount/edit',
                    del_url: 'monthcardcount/del',
                    multi_url: 'monthcardcount/multi',
                    table: 'month_card_count',
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
                        {field: 'b1_p', title: __('B1_p')},
                        {field: 'b1_n', title: __('B1_n')},
                        {field: 'b2_p', title: __('B2_p')},
                        {field: 'b2_n', title: __('B2_n')},
                        {field: 'r1_p', title: __('R1_p')},
                        {field: 'r1_n', title: __('R1_n')},
                        {field: 'r2_p', title: __('R2_p')},
                        {field: 'r2_n', title: __('R2_n')},
                        {field: 'm1_p', title: __('M1_p')},
                        {field: 'm1_n', title: __('M1_n')},
                        {field: 'm2_p', title: __('M2_p')},
                        {field: 'm2_n', title: __('M2_n')},
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