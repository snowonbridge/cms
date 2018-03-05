define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'agent/manage/agentrelation/index',
                    add_url: 'agent/manage/agentrelation/add',
                    edit_url: 'agent/manage/agentrelation/edit',
                    del_url: 'agent/manage/agentrelation/del',
                    multi_url: 'agent/manage/agentrelation/multi',
                    table: 'agent_manage_index',
                },
                pageSize: 15,
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                queryParams: function(params){
                    var url = location.search; //获取url中"?"符后的字串
                    var theRequest = new Object();
                    if (url.indexOf("?") != -1) {
                        var str = url.substr(1);
                        strs = str.split("&");
                        for (var i = 0; i < strs.length; i++) {
                            theRequest[strs[i].split("=")[0]] = (strs[i].split("=")[1]);
                        }
                    }
                    if(typeof(theRequest.day)!='undefined'){
                        params.day = theRequest.day;
                    }
                    return params;
                },
                pk: 'id',
                sortName: 'sid asc,bind_time desc',
                sortOrder: null,
                showToggle:false,
                showColumns:true,
                showRefresh:true,
                search : false,
                searchFormVisible: true,
                columns: [
                    [
                        //{checkbox: true},
                        {field: 'sid', title: __('sid'),sortable:true},
                        {field: 'mid', title: __('mid'),formatter: Controller.api.formatter.agent_info},
                        {field: 'user.uname', title: '用户昵称',searchable:false},
                        {field: 'agent_id', title: __('agent_id'),formatter: Controller.api.formatter.agent_info},
                        {field: 'agent_user.uname', title: '上级代理昵称',searchable:false},
                        {field: 'bind_level', title: __('bind_level')},
                        {field: 'bind_type_text', title: __('bind_type_text'),searchable:false},
                        {field: 'first_agent_id', title: __('first_agent_id'),sortable:true,formatter: Controller.api.formatter.agent_info},
                        {field: 'bind_time', title: __('bind_time'), formatter: Table.api.formatter.datetime,sortable:true,operate:'BETWEEN',type:'datetime',addclass:'datetimepicker', data: 'data-date-format="YYYY-MM-DD HH:mm:ss"'},
                        {
                            field: 'operate',
                            title: __('Operate'),
                            table: table,
                            events: Controller.api.events.operate,
                            formatter: Controller.api.formatter.operate
                        }
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
                //$.('')
            },
            // 单元格元素事件
            events: {
                operate: {
                    'click .btn-editone': function (e, value, row, index) {
                        e.stopPropagation();
                        var options = $(this).closest('table').bootstrapTable('getOptions');
                        Fast.api.open(options.extend.edit_url + (options.extend.edit_url.match(/(\?|&)+/) ? "&ids=" : "/ids/") + row[options.pk], __('Edit'), $(this).data() || {});
                    },
                    'click .btn-delone': function (e, value, row, index) {
                        e.stopPropagation();
                        var options = $(this).closest('table').bootstrapTable('getOptions');
                        Fast.api.open(options.extend.del_url + (options.extend.del_url.match(/(\?|&)+/) ? "&ids=" : "/ids/") + row[options.pk], '解绑', $(this).data() || {});
                    }
                }
            },
            formatter: {
                player_info: function (value, row, index) {
                    if(value.toString()!='7777'){
                        return '<a href="/agent/manage/index/playerinfo?mid=' + value +'">' + value + '</a>';
                    }else{
                        return '<a href="javascript:;">' + value + '</a>';
                    }
                },
                agent_info: function (value, row, index) {
                    if(value.toString()!='7777'){
                        return '<a href="/agent/manage/index/info?agent_id=' + value + '&sid='+ row['sid'] +'">' + value + '</a>';
                    }else{
                        return '<a href="javascript:;">' + value + '</a>';
                    }
                },
                operate: function (value, row, index) {
                    var table = this.table;
                    // 操作配置
                    var options = table ? table.bootstrapTable('getOptions') : {};
                    // 默认按钮组
                    var buttons = $.extend([], this.buttons || []);
                    buttons.push({name: 'dragsort', icon: 'fa fa-arrows', classname: 'btn btn-xs btn-primary btn-dragsort'});
                    //buttons.push({name: 'edit', icon: 'fa fa-pencil', classname: 'btn btn-xs btn-success btn-editone',title:'更改'});
                    //buttons.push({name: 'del', icon: 'fa fa-trash', classname: 'btn btn-xs btn-danger btn-delone',title:'解绑'});
                    buttons.push({name: 'edit',  classname: 'btn btn-xs btn-success btn-editone',text:'更改'});
                    buttons.push({name: 'del',  classname: 'btn btn-xs btn-danger btn-delone',text:'解绑'});
                    var html = [];
                    var url, classname, icon, text, title, extend;
                    $.each(buttons, function (i, j) {
                        if (j.name === 'dragsort' && typeof row[Table.config.dragsortfield] === 'undefined') {
                            return true;
                        }
                        if (['add', 'edit', 'del', 'multi', 'dragsort'].indexOf(j.name) > -1 && !options.extend[j.name + "_url"]) {
                            return true;
                        }
                        var attr = table.data("operate-" + j.name);
                        if (typeof attr === 'undefined' || attr) {
                            url = j.url ? j.url : '';
                            if (url.indexOf("{ids}") === -1) {
                                url = url ? url + (url.match(/(\?|&)+/) ? "&ids=" : "/ids/") + row[options.pk] : '';
                            }
                            url = Table.api.replaceurl(url, value, row, table);
                            url = url ? Fast.api.fixurl(url) : 'javascript:;';
                            classname = j.classname ? j.classname : 'btn-primary btn-' + name + 'one';
                            icon = j.icon ? j.icon : '';
                            text = j.text ? j.text : '';
                            title = j.title ? j.title : text;
                            extend = j.extend ? j.extend : '';
                            html.push('<a href="' + url + '" class="' + classname + '" ' + extend + ' title="' + title + '"><i class="' + icon + '"></i>' + (text ? '' + text : '') + '</a>');
                        }
                    });
                    return html.join(' ');
                },
            }
        }
    };
    return Controller;
});