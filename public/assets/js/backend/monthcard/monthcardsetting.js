define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'monthcard/monthcardsetting/index',
                    add_url: 'monthcard/monthcardsetting/add',
                    edit_url: 'monthcard/monthcardsetting/edit',
                    del_url: 'monthcard/monthcardsetting/del',
                    send_url: 'monthcard/monthcardsetting/send',
                    multi_url: 'monthcard/monthcardsetting/multi'
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
                        {field: 'goodid', title: __('Goodid')},
                        {field: 'name', title: __('Name')},
                        {field: 'desc', title: __('Desc')},
                        {field: 'status', title: __('Status'), formatter: Controller.api.formatter.status},
                        {field: 'diamond_price', title: __('Diamond_price')},
                        {field: 'roomcard_price', title: __('Roomcard_price')},
                        {field: 'cash_price', title: __('Cash_price')},
                        {field: 'ptypes_text', title: __('Ptypes'), operate:false},
                        {field: 'mday', title: __('Mday')},
                        {field: 'day', title: __('Day')},
                        {field: 'card_image', title: __('Card_image'), formatter: Table.api.formatter.image},
                        {field: 'total', title: __('Total')},
                        {field: 'ratio', title: __('Ratio')},
                        {field: 'order', title: __('Order')},
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
              var colorArr = {'on': 'success', 'off': 'danger', 'unknow': 'primary'};
              // value = value.toString();
              var color = value && typeof colorArr[value] !== 'undefined' ? colorArr[value] : 'primary';
              var mapArr = {'on': __('On'), 'off': __('Off')};
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