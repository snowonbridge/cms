define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'sysnotice/index',
                    add_url: 'sysnotice/add',
                    edit_url: 'sysnotice/edit',
                    del_url: 'sysnotice/del',
                    multi_url: 'sysnotice/multi',
                    send_url: 'sysnotice/send',
                    table: 'sysnotice_config',
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
                        {field: 'title', title: __('Title')},
                        {field: 'logo_image', title: __('Logo_image'), formatter: Table.api.formatter.image},
                        {field: 'tab_text', title: __('Tab'), operate:false},
                        {field: 'type_id_text', title: __('Type_id'), operate:false},
                        {field: 'maxver', title: __('Maxver')},
                        {field: 'minver', title: __('Minver')},
                        {field: 'mids', title: __('Mids')},
                        {field: 'start_time', title: __('Start_time')},
                        {field: 'end_time', title: __('End_time')},
                        {field: 'ctime', title: __('Ctime'), formatter: Table.api.formatter.datetime,visible:false},
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