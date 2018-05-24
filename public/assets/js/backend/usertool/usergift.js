define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'usertool/usergift/index',
                    add_url: 'usertool/usergift/add',
                    edit_url: 'usertool/usergift/edit',
                    del_url: 'usertool/usergift/del',
                    multi_url: 'usertool/usergift/multi',
                    table: 'poker_user_gift',
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
                        {field: 'mid', title: __('用户MID')},
                        {field: 'uname', title: __('用户昵称D')},
                        {field: 'unid', title: __('Unid')},
                        {field: 'gid', title: __('Gid')},
                        {field: 'gift_name', title: __('礼物名称')},
                        {field: 'm_type', title: __('M_type'),searchList:{1:'金币',2:'钻石',3:'房卡'}},
                        {field: 'ref', title: __('Ref'),searchList:{1 : '加好友赠送', 2: '邀请赠送', 3 : '出售商品'}},
                        {field: 'origin_value', title: __('Origin_value')},
                        {field: 'discount_rate', title: __('Discount_rate')},
                        {field: 'discount_value', title: __('Discount_value')},
                        {field: 'gettime', title: __('Gettime'), formatter: Table.api.formatter.datetime,type:'datetime',addclass:'datetimepicker', data: 'data-date-format="YYYY-MM-DD HH:mm:ss"'},
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