define(['jquery', 'bootstrap', 'backend', 'table', 'form','jstree'], function ($, undefined, Backend, Table, Form,undefined) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'activity/activitycategory/index',
                    add_url: 'activity/activitycategory/add',
                    edit_url: 'activity/activitycategory/edit',
                    del_url: 'activity/activitycategory/del',
                    multi_url: 'activity/activitycategory/multi',
                    table: 'activity_category',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'id',
                escape: false,
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
                        {field: 'cate_name', title: __('Cate_name')},
                        //{field: 'cate_desc', title: __('Cate_desc')},
                        {field: 'status', title: __('Status'), formatter: Table.api.formatter.status},
                        {field: 'activity_id', title: __('Activity_id')},
                        //{field: 'parent_id', title: __('Parent_id')},
                        {field: 'activity_type', title: __('Activity_type')},
                        //{field: 'sort_value', title: __('Sort_value')},
                        {field: 'channel_id_str', title: __('Channel_id_str'),formatter: Table.api.formatter.label},
                        {field: 'activity_control_id', title: __('Activity_control_id')},
                        {field: 'user_level', title: __('User_level')},
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

    //var data=[
    //{text:'root',id:1,'icon':"fa fa-folder-open",'checked':true,children:[
    //    { "text" : "Child node 1",  "icon" : "fa fa-folder-open",'checked':true },
    //    { "text" : "Child node 2",  "icon" : "fa fa-folder-open" }
    //]}
    //];

    var url = location.href.substr(0,location.href.indexOf("?"));
    var arr = url.split("/");
    $('#province-container').jstree({
        'core': {

            'data': {
                "url" : "/activity/activitycategory/tree",
                "dataType" : "json", // needed only if you do not supply JSON headers
                "data":{"id":arr[arr.length-1]}
            },

            "themes": {
                "dots": true,               // no connecting dots between dots
                "responsive": false        //无响应

            },
            'multiple': true             //设置其为没有多选
        },
        //"checkbox": {
        //    "keep_selected_style": false
        //},
        'types': {                         //这里就是图片的显示格式
            "default": {
                "icon": "fa fa-folder tree-item-icon-color icon-lg"
            },
            "file": {
                "icon": "fa fa-file tree-item-icon-color icon-lg"
            }
        },
        'plugins': [                       //插件，下面是插件的功能
            'types',                      //可以设置其图标，在上面的一样。
            'wholerow',                   //
            'unique',                      //独特----防止重复。(新添加的)
            'checkbox',
        ]
    });
    //绑ready击事件  close_all
    $('#province-container').bind("ready.jstree", function (obj, e) {
            // 处理代码

        var checkedNodes = $('#province-container').jstree("get_all_checked");//获取选中节点和半选中节点
        var channel_id_str={};
        for(var i=0;i<checkedNodes.length;i++)
        {
            var tmp = checkedNodes[i].split('-');
            if(tmp.length == 2)
            {
                if(typeof channel_id_str[tmp[0]] === "undefined")
                {
                    channel_id_str[tmp[0]] = new Array;
                }
                channel_id_str[tmp[0]].push(tmp[1]);
            }

        }
        $("#c-channel_id_str").val(JSON.stringify(channel_id_str));
            // 获取当前节点
           $(this).jstree("close_all");//获取选中节点和半选中节点

        });
    $('#province-container').jstree(true).get_all_checked = function(full) {
        var tmp=new Array;
        for(var i in this._model.data){
            if(this.is_undetermined(i)||this.is_checked(i)){tmp.push(full?this._model.data[i]:i);}
        }
        return tmp;
    };
    //绑定点击事件
    $('#province-container').bind("activate_node.jstree", function (obj, e) {
        // 处理代码
        // 获取当前节点

        var checkedNodes = $('#province-container').jstree("get_all_checked");//获取选中节点和半选中节点
        var channel_id_str={};
        for(var i=0;i<checkedNodes.length;i++)
        {
            var tmp = checkedNodes[i].split('-');
            if(tmp.length == 2)
            {
                if(typeof channel_id_str[tmp[0]] === "undefined")
                {
                    channel_id_str[tmp[0]] = new Array;
                }
                channel_id_str[tmp[0]].push(tmp[1]);
            }

        }
        $("#c-channel_id_str").val(JSON.stringify(channel_id_str));
    });

    //hover_node.jstree

    //var checkedNodes = $('#gemingcao-jstree').jstree("get_all_checked"); 获取所有选中节点
    //      $('#dailogTvmTree').jstree("destroy"); 销毁
    //$('#province-container').jstree(true).refresh();  刷新全部节点
    return Controller;
});