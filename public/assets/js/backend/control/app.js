define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'control/app/index',
                    add_url: 'control/app/add',
                    edit_url: 'control/app/edit',
                    del_url: 'control/app/del',
                    multi_url: 'control/app/multi',
                    table: 'app_list',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'sid',
                columns: [
                    [
                        //{checkbox: true},
                        {field: 'id', title:'游戏app_id'},
                        {field: 'sid', title: '游戏平台标识'},
                        {field: 'sid_text', title: '游戏平台'},
                        {field: 'version', title: '游戏版本'},
                        {field: 'create_time', title:'创建时间', sortable: true, formatter: Table.api.formatter.datetime},
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
        },
      formats:{

      }
    };
    return Controller;
});