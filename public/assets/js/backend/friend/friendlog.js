define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'friend/friendlog/index',
                    add_url: 'friend/friendlog/add',
                    edit_url: 'friend/friendlog/edit',
                    del_url: 'friend/friendlog/del',
                    multi_url: 'friend/friendlog/multi',
                    table: 'friend_log',
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
                        {field: 'id', title: __('编号')},
                        //{field: 'fuid', title: __('Fuid')},
                        {field: 'fmid', title: __('Fmid')},
                        {field: 'funame', title: __('昵称')},
                        {field: 'fchannel_id', title: __('Fchannel_id'),placeholder:'渠道ID'},
                        //{field: 'tuid', title: __('Tuid')},
                        {field: 'tmid', title: __('Tmid')},
                        {field: 'tuname', title: __('好友昵称')},
                        {field: 'tchannel_id', title: __('Tchannel_id'),placeholder:'好友渠道ID'},
                        {field: 'operate_type', title: __('Operate_type'),searchList:{1:'结为好友',2:'解除好友'}},
                        {field: 'ftype', title: __('Ftype'),searchList:{1:'主动',2:'被动'}},
                        {field: 'gift_1_id', title: __('Gift_1_id')},
                        {field: 'gift_1_num', title: __('Gift_1_num')},
                        {field: 'gift_2_id', title: __('Gift_2_id')},
                        {field: 'gift_2_num', title: __('Gift_2_num')},
                        {field: 'gift_3_id', title: __('Gift_3_id')},
                        {field: 'gift_3_num', title: __('Gift_3_num')},
                        {field: 'fuid_vip', title: __('Fuid_vip')},
                        {field: 'tnd', title: __('Tnd')},
                        {field: 'operate_time', title: __('Operate_time'), formatter: Table.api.formatter.datetime,type:'datetime',addclass:'datetimepicker', data: 'data-date-format="YYYY-MM-DD HH:mm:ss"'},
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