define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

  var Controller = {
    index: function () {
      // 初始化表格参数配置
      Table.api.init({
        extend: {
          index_url: 'player/usergame/index',
          add_url: 'player/usergame/add',
          edit_url: 'player/usergame/edit',
          del_url: 'player/usergame/del',
          multi_url: 'player/usergame/multi',
          table: 'player_usergame'
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
            {field: 'chip', title: __('Chip'), sortable: true},
            {field: 'roomcard', title: __('Roomcard'), sortable: true},
            {field: 'diamond', title: __('Diamond'), sortable: true},
            {field: 'charge', title: __('Charge'), sortable: true},
            {field: 'ulevel', title: __('Ulevel'),formatter: Controller.formatter.ulevel},
            {field: 'exp', title: __('Exp'), sortable: true},
            {field: 'vip', title: __('Vip'), sortable: true},
            {field: 'activetime', title: __('Activetime'), formatter: Table.api.formatter.datetime},
            {field: 'invite', title: __('Invite'), visible:false},
            {field: 'ldays', title: __('Ldays'), sortable: true},
            {field: 'cldays', title: __('Cldays'), sortable: true},
            {field: 'prestige', title: __('Prestige'),visible:false},
            {field: 'gameid', title: __('Gameid'),visible:false},
            {field: 'prestige_level', title: __('Prestige_level'),visible:false},
            {field: 'mentercount', title: __('Mentercount'), sortable: true},
            {field: 'wincnt', title: __('Wincnt'), sortable: true},
            {field: 'losecnt', title: __('Losecnt'), sortable: true},
            {field: 'drawcnt', title: __('Drawcnt'), sortable: true},
            {field: 'lwincnt', title: __('Lwincnt'), sortable: true},
            {field: 'hlwin', title: __('Hlwin'), sortable: true},
            {field: 'subsidy_count', title: __('Subsidy_count'), sortable: true},
            {field: 'novitiate_receive_count', title: __('Novitiate_receive_count'), sortable: true},
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
    formatter:{
      ulevel: function (value, row, index) {
        //颜色状态数组,可使用red/yellow/aqua/blue/navy/teal/olive/lime/fuchsia/purple/maroon
        var colorArr = {0:'gray',1: 'success',2:'primary', 3: 'info',4: 'danger'};
        // value = value.toString();
        var color = value && typeof colorArr[value] !== 'undefined' ? colorArr[value] : 'primary';
        var mapArr = {0:__('Ulevel 0'), 1: __('Ulevel 1'), 2: __('Ulevel 2'), 3: __('Ulevel 3'), 4: __('Ulevel 4')};
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