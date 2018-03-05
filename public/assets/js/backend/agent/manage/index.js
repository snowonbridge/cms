define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'agent/manage/index/index',
                    add_url: 'agent/manage/index/add',
                    edit_url: 'agent/manage/index/edit',
                    unbind_url: 'agent/manage/index/unbind',
                    del_url: 'agent/manage/index/del',
                    multi_url: 'agent/manage/index/multi',
                    table: 'agent_manage_index',
                },
                pageSize: 15,
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'sid asc,total_profit desc',
                sortOrder: null,
                showToggle:false,
                showColumns:true,
                showRefresh:true,
                search : false,
                searchFormVisible: false,
                columns: [
                    [
                        //{checkbox: true},
                        {field: 'sid', title: __('sid'),sortable:true},
                        //{field: 'mid', title: __('mid'),formatter: Table.api.formatter.search},
                        //{field: 'mid', title: __('mid'),searchable:false},
                        {field: 'agent_id', title: __('agent_id'),formatter: Controller.api.formatter.agent_info},
                        {field: 'agent_level', title: __('agent_level'),sortable:true},
                        {field: 'parent_agent_id', title: __('parent_agent_id'),formatter: Controller.api.formatter.agent_info},
                        //{field: 'agent.truename', title: __('truename')},
                        {field: 'agentjoin.mobile', title: __('mobile')},
                        {field: 'agentjoin.total_settlement_money', title: __('total_settlement_money'),searchable:false},
                        {field: 'agentjoin.money', title: __('money'),searchable:false},

                        {field: 'player_count', title: __('player_count'),sortable:true,formatter: Controller.api.formatter.player_list,searchable:false},
                        {field: 'agent_count', title: __('agent_count'),sortable:true,formatter: Controller.api.formatter.agent_list,searchable:false},

                        {field: 'total_profit', title: __('total_profit'),sortable:true,formatter: Controller.api.formatter.profit_list,searchable:false},
                        {field: 'roomcard_profit', title: __('roomcard_profit'),sortable:true,formatter: Controller.api.formatter.roomcard_profit_list,searchable:false},
                        {field: 'diamond_profit', title: __('diamond_profit'),sortable:true,formatter: Controller.api.formatter.diamond_agent_list,searchable:false},

                        {field: 'status_text', title: __('status'),searchable:true,placeholder: '状态@0失效1正常'},
                        {field: 'agentjoin.last_settlement_time', title: __('last_settlement_time'), formatter: Table.api.formatter.datetime,operate:'BETWEEN',type:'datetime',addclass:'datetimepicker', data: 'data-date-format="YYYY-MM-DD HH:mm:ss"'},
                        {field: 'create_time', title: __('create_time'), formatter: Table.api.formatter.datetime,sortable:true,operate:'BETWEEN',type:'datetime',addclass:'datetimepicker', data: 'data-date-format="YYYY-MM-DD HH:mm:ss"'},
                        {
                            field: 'operate',
                            title: __('Operate'),
                            table: table,
                            events: Controller.api.events.operate,
                            formatter: Controller.api.formatter.operate
                        }
                    ]
                ],

                onLoadSuccess: function (data) {
                    var  ret = data || {};
                    var total_balance = (data &&  typeof ret.total_balance !== 'undefined') ? data.total_balance : 0;
                    var settlement_money = (data &&  typeof ret.settlement_money !== 'undefined') ? data.settlement_money : 0;
                    var money = (data &&  typeof ret.money !== 'undefined') ? data.money : 0;
                    var string = '，代理总收益 '+total_balance+' 元，累计提现 '+settlement_money+' 元，可用余额 '+money;
                    $('#myTabContent .pagination-info').append(string);
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

            },
            // 单元格元素事件
            events: {
                operate: {
                    'click .btn-editone': function (e, value, row, index) {
                        e.stopPropagation();
                        var options = $(this).closest('table').bootstrapTable('getOptions');
                        Fast.api.open(options.extend.edit_url + (options.extend.edit_url.match(/(\?|&)+/) ? "&ids=" : "/ids/") + row[options.pk], '更改等级', $(this).data() || {});
                    },
                    'click .btn-unbindone': function (e, value, row, index) {
                        e.stopPropagation();
                        var options = $(this).closest('table').bootstrapTable('getOptions');
                        Fast.api.open(options.extend.unbind_url + (options.extend.unbind_url.match(/(\?|&)+/) ? "&sid=" : "/sid/") + row['sid']+(options.extend.unbind_url.match(/(\?|&)+/) ? "&mid=" : "/mid/") + row['mid'], '解绑', $(this).data() || {});
                    },
                    'click .btn-delone': function (e, value, row, index) {
                        e.stopPropagation();
                        var that = this;
                        var top = $(that).offset().top - $(window).scrollTop();
                        var left = $(that).offset().left - $(window).scrollLeft() - 260;
                        if (top + 154 > $(window).height()) {
                            top = top - 154;
                        }
                        if ($(window).width() < 480) {
                            top = left = undefined;
                        }
                        var index = Layer.confirm(
                            '该操作无法恢复，确定删除代理？',
                            {icon: 3, title: __('Warning'), offset: [top, left], shadeClose: true},
                            function () {
                                var table = $(that).closest('table');
                                var options = table.bootstrapTable('getOptions');
                                Table.api.multi("del", row[options.pk], table, that);
                                Layer.close(index);
                            }
                        );
                    }
                },
            },
            formatter: {
                player_list: function (value, row, index) {
                    return '<a href="/agent/manage/playerrelation/index?agent_id=' + row['agent_id'] + '">' + value + '</a>';
                },
                agent_list: function (value, row, index) {
                    return '<a href="/agent/manage/agentrelation/index?agent_id=' + row['agent_id'] + '">' + value + '</a>';
                },
                profit_list: function (value, row, index) {
                    return '<a href="/agent/manage/profitlog/index?agent_id=' + row['agent_id'] + '">' + value + '</a>';
                },
                roomcard_profit_list: function (value, row, index) {
                    return '<a href="/agent/manage/profitlog/index?agent_id=' + row['agent_id'] + '&order_type=1'+'">' + value + '</a>';
                },
                diamond_agent_list: function (value, row, index) {
                    return '<a href="/agent/manage/profitlog/index?agent_id=' + row['agent_id'] + '&order_type=2'+ '">' + value + '</a>';
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

                    buttons.push({name: 'edit',  classname: 'btn btn-xs btn-success btn-editone',text:'等级',title:'更改等级'});

                    //buttons.push({name: 'unbind',  classname: 'btn btn-xs btn-danger btn-unbindone',text:'解绑',url:$.fn.bootstrapTable.defaults.extend.unbind_url});
                    buttons.push({name: 'unbind',  classname: 'btn btn-xs btn-danger btn-unbindone',text:'解绑'});

                    //buttons.push({name: 'del',  classname: 'btn btn-xs btn-danger btn-delone',text:'删除'});
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