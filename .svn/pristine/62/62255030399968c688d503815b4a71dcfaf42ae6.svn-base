define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

  var Controller = {
    index: function () {
      // 初始化表格参数配置
      Table.api.init({
        extend: {
          index_url: 'exchange/userexchangerecord/index',
          add_url: 'exchange/userexchangerecord/add',
          edit_url: 'exchange/userexchangerecord/edit',
          del_url: 'exchange/userexchangerecord/del',
          multi_url: 'exchange/userexchangerecord/multi',
          table: 'user_exchange_record'
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
            {field: 'name', title: __('Name')},
            {field: 'uid', title: __('Uid')},
            {field: 'prize_id', title: __('Prize_id')},
            {field: 'log_time', title: __('Log_time'), formatter: Table.api.formatter.datetime},
            {field: 'spend', title: __('Spend')},
            {field: 'status', title: __('Status'), formatter: Controller.api.formatter.status},
            {
              field: 'operate',
              title: __('Operate'),
              table: table,
              events: Table.api.events.operate,
              formatter: Table.api.formatter.operate
            }
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
          var colorArr = {'incomplete': 'primary', 'inprogress': 'danger', 'completed': 'success'};
          // value = value.toString();
          var color = value && typeof colorArr[value] !== 'undefined' ? colorArr[value] : 'primary';
          var mapArr = {'incomplete': __('Incomplete'), 'inprogress': __('Inprogress'),'completed':__('Completed') };
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