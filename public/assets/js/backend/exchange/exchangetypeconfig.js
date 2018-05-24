define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'exchange/exchangetypeconfig/index',
                    add_url: 'exchange/exchangetypeconfig/add',
                    edit_url: 'exchange/exchangetypeconfig/edit',
                    copy_url: 'exchange/exchangetypeconfig/copy',
                    del_url: 'exchange/exchangetypeconfig/del',
                    multi_url: 'exchange/exchangetypeconfig/multi',
                    table: 'exchange_type_config',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'id',
                sortOrder: 'asc',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
                        {field: 'name', title: __('Name')},
                        {field: 'type_text', title: __('Type'), operate:false},
                        {field: 'order', title: __('Order')},
                        {field: 'status', title: __('Status'), formatter: Controller.api.formatter.status},
                        {field: 'unids', title: __('Unids'),formatter: Table.api.formatter.unids},
                        {field: 'version', title: __('Version')},
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
            }
          }
        }
    };
    return Controller;
});