define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'agent/manage/profitlog/index',
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
                    if(typeof(theRequest.profit_type_str)!='undefined'){
                        params.profit_type_str = theRequest.profit_type_str;
                    }
                    if(typeof(theRequest.day)!='undefined'){
                        params.day = theRequest.day;
                    }
                    return params;

                },
                pk: 'id',
                sortName: 'create_time desc,order_id asc',
                sortOrder: null,
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
                        {field: 'from_mid', title: __('from_mid')},
                        {field: 'order_id', title: __('order_id'),sortable:true},

                        {field: 'order_type_text', title: __('order_type_text'),searchable:false},
                        {field: 'order_type', title: __('order_type_text'),placeholder: '1房卡2钻石',visible:false},

                        {field: 'profit_type_text', title: __('profit_type_text'),searchable:false},
                        {field: 'profit_type', title: __('profit_type_text'),visible:false,searchList:{"1":"直属玩家","2":"下级代理","3":"下级代理直属玩家","4":"隔代代理","5":"隔代直属玩家","6":"全线业绩","7":"代理自身充值"}},

                        {field: 'profit_money', title: __('profit_money'),operate: false},
                        {field: 'left_money', title: __('left_money'),operate: false},
                        {field: 'agent_rule', title: __('agent_rule'),operate: false},
                        {field: 'order_money', title: __('order_money'),operate: false},
                        {field: 'agent_level', title: __('agent_level'),operate: false},
                        {field: 'from_agent_level', title: __('from_agent_level'),operate: false},
                        {field: 'from_parent_agent_level', title: __('from_parent_agent_level'),operate: false},
                        {field: 'create_time', title: __('create_time'), formatter: Table.api.formatter.datetime,operate:'BETWEEN',type:'datetime',addclass:'datetimepicker', data: 'data-date-format="YYYY-MM-DD HH:mm:ss"',sortable:true},
                        //{
                        //    field: 'operate',
                        //    title: __('Operate'),
                        //    table: table,
                        //    events: Table.api.events.operate,
                        //    formatter: Table.api.formatter.operate
                        //}
                    ]
                ],

                onLoadSuccess: function (data) {
                    var  ret = data || {};
                    var profit_money = (data &&  typeof ret.profit_money !== 'undefined') ? data.profit_money : 0;
                    var order_money = (data &&  typeof ret.order_money !== 'undefined') ? data.order_money : 0;
                    var string = '，总提成金额 '+profit_money+' 元，总订单金额 '+order_money+' 元';
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
            }
        }
    };
    return Controller;
});