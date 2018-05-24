define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'friend/pokerfriendapply/index',
                    add_url: 'friend/pokerfriendapply/add',
                    edit_url: 'friend/pokerfriendapply/edit',
                    del_url: 'friend/pokerfriendapply/del',
                    multi_url: 'friend/pokerfriendapply/multi',
                    table: 'poker_friend_apply',
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
                    /**
                     *     'Fuid'  =>  '玩家ID(mid',
                     'Funame'  =>  '玩家昵称',
                     'F_Channel_id'  =>  '渠道号',
                     'Tuid'  =>  '好友ID(mid',
                     'Tuname'  =>  '好友昵称',
                     'T_Channel_id'  =>  '好友渠道号',
                     'Status'  =>  '现在关系',
                     'Is_invite_game'  =>  '是否私人房同在',
                     'Agree_time'  =>  '成为好友时间',
                     'Unbind_time'  =>  '解除好友关系时间'
                     */
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
                        {field: 'fmid', title: __('Fmid')},
                        {field: 'funame', title: __('Funame')},
                        {field: 'fchannel_id', title: __('F_Channel_id')},
                        {field: 'tmid', title: __('Tmid')},
                        {field: 'tuname', title: __('Tuname')},
                        {field: 'tchannel_id', title: __('T_Channel_id')},
                        {field: 'status', title: __('Status')},
                        {field: 'is_invite_game', title: __('Is_invite_game'), formatter: Table.api.formatter.status},
                        {field: 'agree_time', title: __('Agree_time'),placeholder:'搜索大于'+__('Agree_time')+'的记录', formatter: Table.api.formatter.datetime,type:'datetime',addclass:'datetimepicker', data: 'data-date-format="YYYY-MM-DD HH:mm:ss"'},
                        {field: 'unbind_time', title: __('Unbind_time'), placeholder:'搜索大于'+__('Unbind_time')+'的记录',formatter: Table.api.formatter.datetime,type:'datetime',addclass:'datetimepicker', data: 'data-date-format="YYYY-MM-DD HH:mm:ss"'},
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