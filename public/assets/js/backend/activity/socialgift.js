define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'activity/socialgift/index',
                    add_url: 'activity/socialgift/add',
                    edit_url: 'activity/socialgift/edit',
                    del_url: 'activity/socialgift/del',
                    multi_url: 'activity/socialgift/multi',
                    table: 'social_gift',
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
                        {field: 'activity_id', title: __('Activity_id')},
                        {field: 'action_list', title: __('Action_list')},
                        {field: 'frequency', title: __('Frequency')},
                        {field: 'img_icon', title: __('Img_icon'), formatter: Table.api.formatter.icon},
                        {field: 'gift_list', title: __('Gift_list')},
                        {field: 'redirect_id', title: __('Redirect_id')},
                        {field: 'status', title: __('Status'), formatter: Table.api.formatter.status},
                        {field: 'desc', title: __('Desc')},
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