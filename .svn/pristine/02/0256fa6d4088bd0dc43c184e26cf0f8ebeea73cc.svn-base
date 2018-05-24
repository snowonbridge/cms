define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'exchange/redpacklogs/index',
                    add_url: 'exchange/redpacklogs/add',
                    edit_url: 'exchange/redpacklogs/edit',
                    del_url: 'exchange/redpacklogs/del',
                    multi_url: 'exchange/redpacklogs/multi',
                    table: 'red_pack_logs',
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
                        {field: 'mch_billno', title: __('Mch_billno')},
                        {field: 'send_listid', title: __('Send_listid')},
                        {field: 'rev_openid', title: __('Rev_openid')},
                        {field: 'phone', title: __('Phone')},
                        {field: 'avatar', title: __('Avatar'), formatter: Table.api.formatter.image},
                        {field: 'nickname', title: __('Nickname')},
                        {field: 'status', title: __('Status'), formatter: Controller.api.formatter.status},
                        {field: 'ip', title: __('Ip')},
                        {field: 'uid', title: __('Uid')},
                        {field: 'prize_id', title: __('Prize_id')},
                        {field: 'total_num', title: __('Total_num')},
                        {field: 'total_amount', title: __('Total_amount')},
                        {field: 'created_at', title: __('Created_at')},
                        {field: 'updated_at', title: __('Updated_at')},
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
            },
         formatter: {
           status: function (value, row, index) {
             //颜色状态数组,可使用red/yellow/aqua/blue/navy/teal/olive/lime/fuchsia/purple/maroon
             var colorArr = {'SUCCESS': 'success', 'FAIL': 'danger'};
             // value = value.toString();
             var color = value && typeof colorArr[value] !== 'undefined' ? colorArr[value] : 'primary';
             var mapArr = {'SUCCESS': __('Success'), 'FAIL': __('Fail')};
             value = mapArr[value];

             //如果字段列有定义custom
             if (typeof this.custom !== 'undefined') {
               colorArr = $.extend(colorArr, this.custom);
             }

             value = value.charAt(0).toUpperCase() + value.slice(1);
             //渲染状态
             var html = '<span class="text-' + color + '"><i class="fa fa-circle"></i> ' + value + '</span>';
             return html;
           },
         }
        }
    };
    return Controller;
});