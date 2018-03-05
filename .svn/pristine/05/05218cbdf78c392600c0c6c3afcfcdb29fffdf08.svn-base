define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'activity/crosschallegeconfig/index',
                    add_url: 'activity/crosschallegeconfig/add',
                    edit_url: 'activity/crosschallegeconfig/edit',
                    del_url: 'activity/crosschallegeconfig/del',
                    multi_url: 'activity/crosschallegeconfig/multi',
                    table: 'cross_challege_config',
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
                        {field: 'game_list', title: __('Game_list')},
                        {field: 'game_num', title: __('Game_num')},
                        {field: 'name', title: __('Name')},
                        {field: 'own_open_room', title: __('Own_open_room')},
                        {field: 'friends_num', title: __('Friends_num')},
                        {field: 'win_result', title: __('Win_result')},
                        {field: 'create_time', title: __('Create_time'), formatter: Table.api.formatter.datetime},
                        {field: 'status', title: __('Status'), formatter: Table.api.formatter.status},
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