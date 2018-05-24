define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'exchange/userexchangeaddressinfo/index',
                    add_url: 'exchange/userexchangeaddressinfo/add',
                    edit_url: 'exchange/userexchangeaddressinfo/edit',
                    del_url: 'exchange/userexchangeaddressinfo/del',
                    multi_url: 'exchange/userexchangeaddressinfo/multi',
                    table: 'user_exchange_address_info',
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
                        {field: 'phone_number', title: __('Phone_number')},
                        {field: 'address', title: __('Address')},
                        {field: 'mid', title: __('Mid')},
                        {field: 'unid', title: __('Unid'),formatter:Controller.api.formatter.unids},
                        {field: 'create_time', title: __('Create_time'), formatter: Table.api.formatter.datetime},
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
        formatter: {
          unids: function (value, row, index, custom) {
            //渲染Flag
            var html = [];
            var mapArr = Config.unidsMap;

            value = value.toString();
            var arr = value.indexOf(",") > -1 ? value.split(',') : [value];
            $.each(arr, function (i, value) {
              var formatStr = mapArr[value] ? mapArr[value].unid_name + '[' + value + ']' : '全渠道[' + value + ']';
              html.push('<span class="label label-success">' + formatStr + '</span>');
            });
            return html.join(' ');
          }
        }
      }
    };
    return Controller;
});