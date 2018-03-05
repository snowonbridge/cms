define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

  var Controller = {
    index: function () {
      // 初始化表格参数配置
      Table.api.init({
        extend: {
          index_url: 'userphotos/index',
          del_url: 'userphotos/del',
          multi_url: 'userphotos/multi',
          table: 'user_photos'
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
            {field: 'url', title: __('Url'), formatter: Table.api.formatter.url},
            {field: 'usermap.mid', title: __('Mid'), operate: '='},
            {field: 'optime', title: __('Optime'), formatter: Table.api.formatter.datetime},
            {field: 'apply_time', title: __('Apply_time'), formatter: Table.api.formatter.datetime},
            {field: 'status', title: __('Status'), formatter: Controller.formats.status},
            {field: 'admin_id', title: __('Admin_id')},
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
      }
    },
    formats: {
      status: function (value, row, index) {
        //颜色状态数组,可使用red/yellow/aqua/blue/navy/teal/olive/lime/fuchsia/purple/maroon
        var colorArr = {0: 'gray', 1: 'success', 2: 'danger'};
        // value = value.toString();
        var color = value && typeof colorArr[value] !== 'undefined' ? colorArr[value] : 'primary';
        var mapArr = {0: __('Ustatus 0'), 1: __('Ustatus 1'), 2: __('Ustatus 2')};
        value = mapArr[value];

        //如果字段列有定义custom
        if (typeof this.custom !== 'undefined') {
          colorArr = $.extend(colorArr, this.custom);
        }

        value = value.charAt(0).toUpperCase() + value.slice(1);
        //渲染状态
        var html = '<span class="text-' + color + '"><i class="fa fa-circle"></i> ' + __(value) + '</span>';
        return html;
      }
    }
  };
  return Controller;
});