define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'firstlogin/noticesetting/index',
                    add_url: 'firstlogin/noticesetting/add',
                    edit_url: 'firstlogin/noticesetting/edit',
                    del_url: 'firstlogin/noticesetting/del',
                    multi_url: 'firstlogin/noticesetting/multi',
                    table: 'poker_notice',
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
                        {field: 'channel_id',visible:false, title: __('Channel_id')},
                        {field: 'channel_text',searchable:false, title: __('Channel_id')},
                        {field: 'sid', visible:false,title: __('Sid')},
                        {field: 'sid_text', searchable:false,title: __('Sid'), formatter: Table.api.formatter.label},
                        {field: 'version', title: __('Version'), formatter: Table.api.formatter.label},
                        {field: 'type', visible:false, title: __('Type')},
                        {field: 'type_text',searchable:false, title: __('Type')},
                        {field: 'label_title', title: __('Label_title')},
                        {field: 'title', title: __('Title')},
                        {field: 'img', visible:false, title: __('Img')},
                        {field: 'redirect_id', visible:false,title: __('Redirect_id')},
                        {field: 'redirect_id_text',searchable:false, title: __('Redirect_id')},
                        {field: 'redirect_btn_text', title: __('Redirect_btn_text')},
                        {field: 'redirect_url', title: __('Redirect_url'), formatter: Table.api.formatter.url},
                        {field: 'show_start_time', title: __('Show_start_time'), formatter: Table.api.formatter.datetime},
                        {field: 'show_end_time', title: __('Show_end_time'), formatter: Table.api.formatter.datetime},
                        {field: 'status',visible:false, title: __('Status'), formatter: Table.api.formatter.status},
                        {field: 'status_text',  searchable:false,title: __('Status'), formatter: Table.api.formatter.status},
                        {field: 'sort', title: __('Sort')},
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
            }
        }
    };
    return Controller;
});