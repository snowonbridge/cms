define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'agent/manage/waitingdown/index',
                    //add_url: 'agent/manage/index/add',
                    edit_url: 'agent/manage/waitingdown/edit',
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
                sortName: 'profit_money_sum',
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
                        //{field: 'mid', title: __('mid')},
                        {field: 'agent_id', title: __('agent_id')},
                        {field: 'agent_level', title: __('agent_level'),operate: false},
                        {field: 'player_count', title:__('player_count'),operate: false},
                        {field: 'profit_money_sum', title:__('profit_money_sum'),operate: false},
                        {field: 'op_level', title:__('op_level'),operate: false},
                        //{field: 'create_time', title: __('create_time'), formatter: Table.api.formatter.datetime,sortable:true},
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
            },
            // 单元格元素事件
            events: {
                operate: {
                    'click .btn-editone': function (e, value, row, index) {
                        e.stopPropagation();
                        var options = $(this).closest('table').bootstrapTable('getOptions');
                        Fast.api.open(options.extend.edit_url + (options.extend.edit_url.match(/(\?|&)+/) ? "&ids=" : "/ids/") + row[options.pk], '更改等级', $(this).data() || {});
                    }
                }
            },
            formatter: {
                    operate: function (value, row, index) {
                        var table = this.table;
                        // 操作配置
                        var options = table ? table.bootstrapTable('getOptions') : {};
                        // 默认按钮组
                        var buttons = $.extend([], this.buttons || []);
                        buttons.push({name: 'dragsort', icon: 'fa fa-arrows', classname: 'btn btn-xs btn-primary btn-dragsort'});

                        buttons.push({name: 'edit',  classname: 'btn btn-xs btn-success btn-editone',text:'等级',title:'更改等级'});

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
                    }
                }
        }
    };
    return Controller;
});