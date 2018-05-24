define(['jquery', 'bootstrap', 'backend', 'table', 'form','upload'], function ($, undefined, Backend, Table, Form,upload) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'firstlogin/acsetting/index',
                    add_url: 'firstlogin/acsetting/add',
                    edit_url: 'firstlogin/acsetting/edit',
                    del_url: 'firstlogin/acsetting/del',
                    multi_url: 'firstlogin/acsetting/multi',
                    table: 'ac_setting',
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
                        {field: 'version', title: __('Version'),formatter: Table.api.formatter.label},
                        {field: 'name', title: __('Name')},
                        {field: 'title', title: __('Title')},
                        {field: 'type',visible:false, title: __('Type')},
                        {field: 'type_text',searchable:false, title: __('Type')},
                        {field: 'show_type',visible:false, title: __('Show_type')},
                        {field: 'show_type_text', searchable:false,title: __('Show_type')},
                        {field: 'redirect_id', visible:false,title: __('Redirect_id')},
                        {field: 'redirect_id_text',searchable:false, title: __('Redirect_id')},
                        {field: 'redirect_btn_text',searchable:false, title: __('Redirect_btn_text')},
                        {field: 'redirect_url', title: __('Redirect_url'), formatter: Table.api.formatter.url},
                        {field: 'text_args',visible:false, title: __('Text_args')},
                        {field: 'imgs', visible:false,title: __('Imgs')},
                        {field: 'status',visible:false, title: __('Status'), formatter: Table.api.formatter.status},
                        {field: 'status_text',  searchable:false,title: __('Status'), formatter: Table.api.formatter.status},
                        {field: 'start_time', title: __('Start_time'), formatter: Table.api.formatter.datetime},
                        {field: 'end_time', title: __('End_time'), formatter: Table.api.formatter.datetime},
                        {field: 'update_time', visible:false,title: __('Update_time'), formatter: Table.api.formatter.datetime},
                        {field: 'create_time', visible:false,title: __('Create_time'), formatter: Table.api.formatter.datetime},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ]
                ],
                search:false
            });

            // 为表格绑定事件
            Table.api.bindevent(table);
        },
        add: function () {
            Controller.api.bindevent();
        },
        edit: function () {
            Controller.api.bindevent();
            // upload.api.plupload($(".plupload"), function(data, ret){
            //     Toastr.success("成功");
            //     console.log(data);
            //     $("#upload").attr("src",data.data.url);
            // }, function(data, ret){
            //     Toastr.success("失败");
            // });
        },
        api: {
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        },
        events:{
            onBeforeUpload:function (up, file) {
                console.log("before upload");
            }
        }
    };
    return Controller;
});