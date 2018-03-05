define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {
    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'activity/crosschallegegift/index',
                    add_url: 'activity/crosschallegegift/add',
                    edit_url: 'activity/crosschallegegift/edit',
                    del_url: 'activity/crosschallegegift/del',
                    multi_url: 'activity/crosschallegegift/multi',
                    table: 'cross_challege_gift',
                }
            });
            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'id',
                sortOrder: 'asc',

                queryParams:function(param){

                    return param;
                },
//                showPaginationSwitch:true,
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
                        {field: 'activity_id', title: __('Activity_id')},
                        {field: 'challege_list', title: __('Challege_list')},
                        {field: 'frequency', title: __('Frequency')},
                        {field: 'gift_list', title: __('Gift_list')},
                        {field: 'img_icon', title: __('Img_icon'), formatter: Table.api.formatter.icon},
                        {field: 'desc', title: __('Desc')},
                        {field: 'tab_id', title: __('Tab_id')},
                        {field: 'base_activity_id', title: __('Base_activity_id')},
                        {field: 'sort', title: __('Sort')},
                        {field: 'redirect_id', title: __('Redirect_id')},
                        {field: 'start_time', title: __('Start_time'), formatter: Table.api.formatter.datetime},
                        {field: 'end_time', title: __('End_time'), formatter: Table.api.formatter.datetime},
                        {field: 'create_time', title: __('Create_time'), formatter: Table.api.formatter.datetime},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ]

                ],
                onClickRow:function(row,ele,field)
                {
                    console.log(field);
                }
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