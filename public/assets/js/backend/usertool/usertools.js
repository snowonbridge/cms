define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'usertool/usertools/index',
                    add_url: 'usertool/usertools/add',
                    edit_url: 'usertool/usertools/edit',
                    del_url: 'usertool/usertools/del',
                    multi_url: 'usertool/usertools/multi',
                    table: 'poker_usertools_view',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'ttid',
                sortName: 'ttid',
                sortOrder: 'desc',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'ttid', title: __('Ttid')},
                        {field: 'mid', title: __('Mid')},
                        {field: 'uname', title: __('Uname')},
                        {field: 'channel_name', title: __('Channel_name')},
                        {field: 'tlid', title: __('Tlid')},
                        {field: 'tool_name', title: __('Tool_name')},
                        {field: 'is_using', title: __('Is_using'),placeholder:__('Is_using')+',填0或1',searchList:{0:'否',1:'是'}},
                        {field: 'valid_duration', title: __('Valid_duration')},
                        {field: 'expire', title: __('Expire'), placeholder:'搜索大于'+__('Expire')+'的记录',formatter: Table.api.formatter.datetime,type:'datetime',addclass:'datetimepicker', data: 'data-date-format="YYYY-MM-DD HH:mm:ss"'},
                        //{field: 'usetime', title: __('Usetime'), formatter: Table.api.formatter.datetime},
                        {field: 'gettime', title:__('Gettime'),placeholder:'搜索大于'+__('Gettime')+'的记录', formatter: Table.api.formatter.datetime,type:'datetime',addclass:'datetimepicker', data: 'data-date-format="YYYY-MM-DD HH:mm:ss"'},
                       //{field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
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