define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'exchange/userexchangeapply/index',
                    multi_url: 'exchange/userexchangeapply/multi',
                    table: 'user_exchange_apply',
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
                        {field: 'prize_id', title: __('Prize_id')},
                        {field: 'prize_name', title: __('Prize_name')},
                        {field: 'spend', title: __('Spend')},
                        {field: 'apply_time', title: __('Apply_time'), formatter: Table.api.formatter.datetime,operate:'BETWEEN',type:'datetime',addclass:'datetimepicker', data: 'data-date-format="YYYY-MM-DD HH:mm:ss"'},
                        {field: 'reps_qty', title: __('Reps_qty')},
                        {field: 'status', title: __('Status'), formatter: Controller.api.formatter.status},
                        {field: 'opt_admin_name', title: __('Opt_admin_name')},
                        {field: 'opt_time', title: __('Opt_time'), formatter: Table.api.formatter.datetime,operate:'BETWEEN',type:'datetime',addclass:'datetimepicker', data: 'data-date-format="YYYY-MM-DD HH:mm:ss"'},
                        // {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
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
              var colorArr = {'1': 'primary', '2': 'success', '3': 'danger'};
              // value = value.toString();
              var color = value && typeof colorArr[value] !== 'undefined' ? colorArr[value] : 'primary';
              var mapArr = {'1': __('Appling'), '2': __('Accepted'),'3':__('Reject') };
              value = mapArr[value];

              //如果字段列有定义custom
              if (typeof this.custom !== 'undefined') {
                colorArr = $.extend(colorArr, this.custom);
              }

              value = value.charAt(0).toUpperCase() + value.slice(1);
              //渲染状态
              var html = '<span class="text-' + color + '"><i class="fa fa-circle"></i> ' + value + '</span>';
              return html;
            }
          }
        }
    };
    return Controller;
});