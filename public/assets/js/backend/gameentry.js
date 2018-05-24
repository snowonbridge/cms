define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'gameentry/index',
                    add_url: 'gameentry/add',
                    edit_url: 'gameentry/edit',
                    del_url: 'gameentry/del',
                    multi_url: 'gameentry/multi',
                    copy_url: 'gameentry/copy',
                    table: 'game_entry_config',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'weigh',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
                        {field: 'name', title: __('Name')},
                        // {field: 'game_cate', title: __('Game_cate')},
                        {field: 'game_cate_text', title: __('Game_cate')},
                        {field: 'game_level_text', title: __('Game_level')},
                        {field: 'weigh', title: __('Weigh')},
                        {field: 'venue', title: __('Venue')},
                        {field: 'rate', title: __('Rate')},
                        {field: 'rob_lord', title: __('Rob_lord')},
                        {field: 'own_min', title: __('Own_min')},
                        {field: 'own_max', title: __('Own_max')},
                        {field: 'base_score', title: __('Base_score')},
                        {field: 'init_multiple', title: __('Init_multiple')},
                        {field: 'bomb_one_ratio', title: __('Bomb_one_ratio')},
                        {field: 'bomb_two_ratio', title: __('Bomb_two_ratio')},
                        {field: 'bomb_three_ratio', title: __('Bomb_three_ratio')},
                        {field: 'bomb_four_ratio', title: __('Bomb_four_ratio')},
                        {field: 'bomb_five_ratio', title: __('Bomb_five_ratio')},
                        {field: 'set_card', title: __('Set_card'), formatter: Controller.api.formatters.is},
                        {field: 'robot_switch', title: __('Robot_switch'), formatter: Controller.api.formatters.is},
                        {field: 'robot_level', title: __('Robot_level')},
                        {field: 'status', title: __('Status'), formatter: Table.api.formatter.status},
                        {field: 'player_multiple', title: __('Player_multiple')},
                        {field: 'rand_min', title: __('Rand_min')},
                        {field: 'rand_max', title: __('Rand_max')},
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
          formatters:{
            is: function (value, row, index) {
              //颜色状态数组,可使用red/yellow/aqua/blue/navy/teal/olive/lime/fuchsia/purple/maroon
              var colorArr = {'yes': 'success', 'no': 'primary'};
              // value = value.toString();
              var color = value && typeof colorArr[value] !== 'undefined' ? colorArr[value] : 'primary';
              var mapArr = {'yes': __('Yes'), 'no': __('No') };
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