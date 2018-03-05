define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'player/user/index',
                    add_url: 'player/user/add',
                    edit_url: 'player/user/edit',
                    del_url: 'player/user/del',
                    multi_url: 'player/user/multi',
                    table: 'player_user',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'id',
                sortOrder: 'desc',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Mid')},
                        {field: 'openid', title: __('Openid')},
                        {field: 'usertype', title: __('Usertype')},
                        {field: 'unid', title: __('Unid')},
                        {field: 'usex_text', title: __('Usex'), operate:false},
                        {field: 'uname', title: __('Uname')},
                        {field: 'avartar', title: __('Avartar'),visible:false},
                        {field: 'avartar_type', title: __('Avartar_type')},
                        {field: 'gid', title: __('Gid'), visible:false},
                        {field: 'ustatus', title: __('Ustatus'), formatter: Controller.formats.status},
                        {field: 'uemail', title: __('Uemail')},
                        {field: 'devid', title: __('Devid')},
                        {field: 'regtime', title: __('Regtime'), sortable: true, formatter: Table.api.formatter.datetime},
                        {field: 'location_info', title:'归属地区', searchable:false},
                        {field: 'region_id', title: '行政区id', visible:false,sortable: true,},
                        {field: 'city_id', title: '城市id', visible:false,sortable: true,},
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
            }
        },
      formats:{
        status: function (value, row, index) {
          //颜色状态数组,可使用red/yellow/aqua/blue/navy/teal/olive/lime/fuchsia/purple/maroon
          var colorArr = {0: 'success', 1: 'danger'};
          // value = value.toString();
          var color = value && typeof colorArr[value] !== 'undefined' ? colorArr[value] : 'primary';
          var mapArr = {0: __('Ustatus 0'), 1: __('Ustatus 1')};
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