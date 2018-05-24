define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'exchange/exchangeconfig/index',
                    add_url: 'exchange/exchangeconfig/add',
                    edit_url: 'exchange/exchangeconfig/edit',
                    copy_url: 'exchange/exchangeconfig/copy',
                    del_url: 'exchange/exchangeconfig/del',
                    dragsort_url: 'ajax/pweigh',
                    multi_url: 'exchange/exchangeconfig/multi',
                    table: 'exchange_config',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'weigh',
                sortOrder: 'asc',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
                        {field: 'name', title: __('Name')},
                        {field: 'desc', title: __('Desc')},
                        {field: 'image', title: __('Image'), formatter: Table.api.formatter.image},
                        {field: 'day_limit', title: __('Day_limit')},
                        {field: 'stock_quantity', title: __('Stock_quantity')},
                        {field: 'prepare_quantity', title: __('Prepare_quantity')},
                        {field: 'loop', title: __('Loop'),formatter: Controller.api.formatter.loop},
                        {field: 'start_time', title: __('Start_time'), formatter: Table.api.formatter.datetime},
                        {field: 'end_time', title: __('End_time'), formatter: Table.api.formatter.datetime},
                        {field: 'type_text', title: __('Type'), operate:false},
                        {field: 'val', title: __('Val')},
                        {field: 'spend', title: __('Spend')},
                        {field: 'status', title: __('Status'), formatter: Controller.api.formatter.status},
                        {field: 'broadscast_text', title: __('Broadscast'), operate:false},
                        {field: 'weigh', title: __('Order')},
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
          formatter:{
            status: function (value, row, index) {
              //颜色状态数组,可使用red/yellow/aqua/blue/navy/teal/olive/lime/fuchsia/purple/maroon
              var colorArr = {'off': 'primary', 'on': 'success'};
              // value = value.toString();
              var color = value && typeof colorArr[value] !== 'undefined' ? colorArr[value] : 'primary';
              var mapArr = {'on': __('On'), 'off': __('Off') };
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
            loop: function (value, row, index) {
              //颜色状态数组,可使用red/yellow/aqua/blue/navy/teal/olive/lime/fuchsia/purple/maroon
              var colorArr = {'0': 'primary', '1': 'success'};
              // value = value.toString();
              var color = value && typeof colorArr[value] !== 'undefined' ? colorArr[value] : 'primary';
              var mapArr = {'0': __('No'), '1': __('Yes') };
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