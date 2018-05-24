define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'gameentrymain/statisticsgamehallclick/index',
                    add_url: 'gameentrymain/statisticsgamehallclick/add',
                    edit_url: 'gameentrymain/statisticsgamehallclick/edit',
                    del_url: 'gameentrymain/statisticsgamehallclick/del',
                    multi_url: 'gameentrymain/statisticsgamehallclick/multi',
                    table: 'statistics_game_hall_click',
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
                        {field: 'activity_p', title: __('Activity_p')},
                        {field: 'activity_n', title: __('Activity_n')},
                        {field: 'exchange_p', title: __('Exchange_p')},
                        {field: 'exchange_n', title: __('Exchange_n')},
                        {field: 'firend_p', title: __('Firend_p')},
                        {field: 'firend_n', title: __('Firend_n')},
                        {field: 'task_p', title: __('Task_p')},
                        {field: 'task_n', title: __('Task_n')},
                        {field: 'email_p', title: __('Email_p')},
                        {field: 'email_n', title: __('Email_n')},
                        {field: 'free_p', title: __('Free_p')},
                        {field: 'free_n', title: __('Free_n')},
                        {field: 'shop_p', title: __('Shop_p')},
                        {field: 'shop_n', title: __('Shop_n')},
                        {field: 'bag_p', title: __('Bag_p')},
                        {field: 'bag_n', title: __('Bag_n')},
                        {field: 'set_p', title: __('Set_p')},
                        {field: 'set_n', title: __('Set_n')},
                        {field: 'fast_p', title: __('Fast_p')},
                        {field: 'fast_n', title: __('Fast_n')},
                        {field: 'charge_p', title: __('Charge_p')},
                        {field: 'charge_n', title: __('Charge_n')},
                        {field: 'rank_p', title: __('Rank_p')},
                        {field: 'rank_n', title: __('Rank_n')},
                        {field: 'feed_p', title: __('Feed_p')},
                        {field: 'feed_n', title: __('Feed_n')},
                        {field: 'create_time', title: __('Create_time'), formatter: Table.api.formatter.datetime},
                        {field: 'update_time', title: __('Update_time'), formatter: Table.api.formatter.datetime},
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