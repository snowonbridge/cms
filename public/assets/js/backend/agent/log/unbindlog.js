define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'agent/log/unbindlog/index',
                    //add_url: 'agent/manage/index/add',
                    //edit_url: 'agent/manage/index/edit',
                    //del_url: 'agent/manage/index/del',
                    //multi_url: 'agent/manage/index/multi',
                    table: 'agent_manage_index',
                },
                pageSize: 15,
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'create_time',
                sortOrder: 'desc',
                showToggle:false,
                showColumns:true,
                showRefresh:true,
                search : false,
                searchFormVisible: true,
                columns: [
                    [
                        //{checkbox: true},
                        //{field: 'id', title: __('id'),operate: false},
                        {field: 'sid', title: __('sid'),sortable:true},
                        {field: 'mid', title: __('mid')},
                        //{field: 'agent.truename', title: __('truename')},
                        {field: 'poker_user.uname', title: __('nickname'),operate:'LIKE',searchable:false},
                        {field: 'left_agent_id', title: __('left_agent_id'),searchable:false},
                        {field: 'old_agent_id', title: __('old_agent_id'),searchable:false},
                        //{field: 'change_type_text', title: __('change_type')},
                        {field: 'old_bind_type_text', title: __('old_bind_type'),searchable:false},
                        {field: 'old_bind_type', title: __('old_bind_type'),placeholder: '1直属玩家2代理',visible:false},
                        {field: 'left_agent_level', title: __('left_agent_level'),searchable:false},
                        {field: 'old_agent_level', title: __('old_agent_level'),searchable:false},
                        {field: 'admin_id', title: __('admin_id'),searchable:false},
                        {field: 'admin_name', title: __('admin_name'),searchable:false},
                        {field: 'remark', title: __('remark'),searchable:false},
                        {field: 'create_time', title: __('create_time'), formatter: Table.api.formatter.datetime,sortable:true,operate:'BETWEEN',type:'datetime',addclass:'datetimepicker', data: 'data-date-format="YYYY-MM-DD HH:mm:ss"'},
                        //{
                        //    field: 'operate',
                        //    title: __('Operate'),
                        //    table: table,
                        //    events: Table.api.events.operate,
                        //    formatter: Table.api.formatter.operate
                        //}
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