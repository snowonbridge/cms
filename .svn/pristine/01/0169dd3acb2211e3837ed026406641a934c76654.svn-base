define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

  var Controller = {
    index: function () {
      // 初始化表格参数配置
      Table.api.init({
        extend: {
          index_url: 'hundredwartotalstat/index',
          table: 'hundred_war_total_stat'
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
            {checkbox: false},
            {field: 'id', title: __('Id')},
            {field: 'k', title: __('K')},
            {field: 'robot_banker_cnt', title: __('Robot_banker_cnt')},
            {field: 'player_banker_cnt', title: __('Player_banker_cnt')},
            {field: 'system_banker_cnt', title: __('System_banker_cnt')},
            {field: 'player_in_chips', title: __('Player_in_chips')},
            {field: 'robot_in_chips', title: __('Robot_in_chips')},
            {field: 'robot_banker_in_chips', title: __('Robot_banker_in_chips')},
            {field: 'system_banker_in_chips', title: __('System_banker_in_chips')},
            {field: 'player_banker_in_chips', title: __('Player_banker_in_chips')},
            {field: 'robot_on_seats_cnt', title: __('Robot_on_seats_cnt')},
            {field: 'player_on_seats_cnt', title: __('Player_on_seats_cnt')},
            {field: 'update_time', title: __('Update_time'), formatter: Table.api.formatter.datetime}
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