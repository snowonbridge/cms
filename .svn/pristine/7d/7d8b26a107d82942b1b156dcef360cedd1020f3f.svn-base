define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'gameentrymain/statisticsgameentry/index',
                    add_url: 'gameentrymain/statisticsgameentry/add',
                    edit_url: 'gameentrymain/statisticsgameentry/edit',
                    del_url: 'gameentrymain/statisticsgameentry/del',
                    multi_url: 'gameentrymain/statisticsgameentry/multi',
                    table: 'statistics_game_entry',
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
                        {field: 'date_t', title: __('Date_t')},
                        {field: 'gameid', title: __('Gameid')},
                        {field: 'level', title: __('Level'),visible:false,placeholder:'1初2中3高'},
                        {field: 'level_text', title: __('Level'),searchable:false},
                        {field: 'flag', title: __('Flag'), formatter: Table.api.formatter.flag},
                        {field: 'times', title: __('Times')},
                        {field: 'cnt', title: __('Cnt')},
                        {field: 'create_time', title: __('Create_time')},
                        {field: 'update_time', title: __('Update_time')},
                        {field: 'quarter', title: __('Quarter'),visible:false,searchable:true,formatter: Table.api.formatter.datetime,type:'datetime',data: 'data-date-format="YYYY Q"',addclass:'datetimepicker'},
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