define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'monthcard/usermonthcard/index',
                    add_url: 'monthcard/usermonthcard/add',
                    edit_url: 'monthcard/usermonthcard/edit',
                    del_url: 'monthcard/usermonthcard/del',
                    multi_url: 'monthcard/usermonthcard/multi'
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
                        {field: 'cardid', title: __('Cardid'),formatter: Controller.api.formatter.cardids},
                        {field: 'ptype_text', title: __('Ptype')},
                        {field: 'reward_times', title: __('Reward_times')},
                        {field: 'buy_time', title: __('Buy_time'), formatter: Table.api.formatter.datetime},
                        {field: 'expir_time', title: __('Expir_time'), formatter: Table.api.formatter.datetime},
                        {field: 'status', title: __('Status'), formatter: Controller.api.formatter.status},
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
            cardids: function (value, row, index) {
              //颜色状态数组,可使用red/yellow/aqua/blue/navy/teal/olive/lime/fuchsia/purple/maroon
              var colorArr = {127: 'success', 128: 'danger', 0: 'primary'};
              // value = value.toString();
              var color = value && typeof colorArr[value] !== 'undefined' ? colorArr[value] : 'primary';
              var mapArr = {127: __('NormalCard'), 128: __('GoldCard')};
              console.log(value,mapArr);
              value = mapArr[value];

              //如果字段列有定义custom
              if (typeof this.custom !== 'undefined') {
                colorArr = $.extend(colorArr, this.custom);
              }
              //渲染状态
              var html = '<span class="text-' + color + '"><i class="fa fa-circle"></i> ' + value + '</span>';
              return html;
            },
            status: function (value, row, index) {
              //颜色状态数组,可使用red/yellow/aqua/blue/navy/teal/olive/lime/fuchsia/purple/maroon
              var colorArr = {1: 'success', 2: 'danger', 3: 'primary'};
              // value = value.toString();
              var color = value && typeof colorArr[value] !== 'undefined' ? colorArr[value] : 'primary';
              var mapArr = {1: __('Active'), 2: __('Inactive')};
              value = mapArr[value];

              //如果字段列有定义custom
              if (typeof this.custom !== 'undefined') {
                colorArr = $.extend(colorArr, this.custom);
              }

              //渲染状态
              var html = '<span class="text-' + color + '"><i class="fa fa-circle"></i> ' + value + '</span>';
              return html;
            },
          }
        }
    };
    return Controller;
});