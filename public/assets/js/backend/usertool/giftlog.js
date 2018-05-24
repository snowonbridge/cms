define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'usertool/giftlog/index',
                    add_url: 'usertool/giftlog/add',
                    edit_url: 'usertool/giftlog/edit',
                    del_url: 'usertool/giftlog/del',
                    multi_url: 'usertool/giftlog/multi',
                    table: 'gift_log',
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
                        //{field: 'uid', title: __('Uid')},
                        {field: 'mid', title: __('Mid')},
                        {field: 'uname', title: __('昵称')},
                        {field: 'channel_id', title: __('Channel_id')},
                        {field: 'gift_id', title: __('Gift_id')},
                        {field: 'gift_name', title: __('Gift_name')},
                        {field: 'operate_type', title: __('Operate_type'),searchList:{1:'变卖',2:'赠送',3:'接收'}},
                        {field: 'm_type', title: __('M_type'),searchList:{1:'金币',2:'钻石',3:'房卡'}},
                        {field: 'before_num', title: __('Before_num')},
                        {field: 'after_num', title: __('After_num')},
                        {field: 'give_mid', title: __('Give_mid')},
                        {field: 'give_uname', title: __('对方昵称')},
                        {field: 'desc', title: __('描述')},
                        {field: 'operate_time', title: __('Operate_time'), formatter: Table.api.formatter.datetime,type:'datetime',addclass:'datetimepicker', data: 'data-date-format="YYYY-MM-DD HH:mm:ss"'},
                        //{field: 'create_time', title: __('Create_time'), formatter: Table.api.formatter.datetime,type:'datetime',addclass:'datetimepicker', data: 'data-date-format="YYYY-MM-DD HH:mm:ss"'},
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