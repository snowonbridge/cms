define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'player/online/index',
                    add_url: 'player/online/add',
                    edit_url: 'player/online/edit',
                    del_url: 'player/online/del',
                    multi_url: 'player/online/multi',
                    table: 'player_online',
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
                        {field: 'olkey', title: __('Olkey')},
                        {field: 'ollogintime', title: __('Ollogintime'), formatter: Table.api.formatter.datetime},
                        {field: 'refreshtime', title: __('Refreshtime'), formatter: Table.api.formatter.datetime},
                        {field: 'area', title: __('Area')},
                        {field: 'gameid', title: __('Gameid')},
                        {field: 'tid', title: __('Tid')},
                        {field: 'svid', title: __('Svid')},
                        {field: 'usertype', title: __('Usertype')},
                        {field: 'unid', title: __('Unid')},
                        {field: 'ip', title: __('Ip')},
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