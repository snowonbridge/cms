define(['jquery', 'bootstrap', 'backend', 'table', 'form','bootstrap-editable'], function ($, undefined, Backend, Table, Form,editable) {
    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'firstlogin/checkinsetting/index',
                    add_url: 'firstlogin/checkinsetting/add',
                    edit_url: 'firstlogin/checkinsetting/edit',
                    del_url: 'firstlogin/checkinsetting/del',
                    multi_url: 'firstlogin/checkinsetting/multi',
                    table: 'checkin_setting',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'id',
                // clickToSelect: false,
                columns: [
                    [
                        {checkbox: true},
                        // {field: 'id', title: __('Id')},
                        {field: 'channel_id', title: __('Channel_id'),visible:false,searchList:function () {
                                var searchList=[];
                                $.ajax({
                                    url:"/general/switchsetting/getChannelList",
                                    type:'get',
                                    dataType:'json',
                                    async:false,
                                    success:function (data) {
                                        searchList = data;
                                    },
                                    error:function (XMLHttpRequest, textStatus, errorThrown) {
                                        console.log("textStatus:"+textStatus);
                                    }
                                });
                                var list = [],result;
                                var sprintf = $.fn.bootstrapTable.utils.sprintf;

                                list.push(sprintf('<option value="">%s</option>', '请选择渠道'));
                                $.each(searchList, function (key, value) {
                                    var isSelect = '';
                                    list.push(sprintf("<option value='" + key + "' %s>" + value + "</option>", isSelect));
                                });
                                var result = sprintf('<select  class="form-control" name="%s" %s>%s</select>', 'channel_id', '', list.join(''));
                                return result;
                            }},
                        {field: 'channel_text',searchable:false, title: __('Channel_id')},
                        {field: 'rule_text',searchable:false,  title: __('Rule_id')},
                        {field: 'rule_id', title: __('Rule_id'),visible:false,searchList:{"1":"连续制","2":"非连续制"}},
                        {field: 'register_way_id',visible:false, title: __('Register_way_id'),operate:"LIKE %...%", formatter: Table.api.formatter.label,searchList:{"1":"游客","2":"手机","3":"微信","4":"QQ","5":"灵游"}},
                        {field: 'register_text', searchable:false,title: __('Register_way_id'), formatter: Table.api.formatter.label},
                        {field: 'system_text',searchable:false, title: __('Platform_id'), formatter: Table.api.formatter.label},
                        {field: 'platform_id',visible:false, title: __('Platform_id'), formatter: Table.api.formatter.label,operate:"LIKE %...%",searchList:{"1":"android","2":"IOS","3":"PC"}},
                        {field: 'days', title: __('Days')},
                        {field: 'gift_content',searchable:false, title: __('Gift_content'),formatter: Controller.giftListformatter},
                        {field: 'update_time', title: __('Update_time'), formatter: Table.api.formatter.datetime,type:'datetime',addclass:'datetimepicker', data: 'data-date-format="YYYY-MM-DD HH:mm:ss"'},
                        {field: 'create_time', title: __('Create_time'), formatter: Table.api.formatter.datetime,type:'datetime',addclass:'datetimepicker', data: 'data-date-format="YYYY-MM-DD HH:mm:ss"'},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ]
                ]
            });

            // 为表格绑定事件
            Table.api.bindevent(table);
            console.log($('.editable1').length);
            $('.editable1').editable({
                field: "gift_id",
                url: '/firstlogin/checkinsetting/changeName',
                ajaxOptions: {
                    type:'post',
                    dataType: 'json', //assuming json response
                },
                send:'always',
                params: function(params) {
                    //originally params contain pk, name and value
                    params.id = $(this).parent('.list-group-item').attr('data-id');
                    params.day_nd =$(this).parent('.list-group-item').attr('data-day_nd');
                    params.gift_id =params.value;
                    return params;
                },
                success: function(response, newValue) {
                    if(response.data)
                    {
                        console.log(response.data);
                    }else{
                        console.log(response);
                    }
                },
                type: "select",
                source: function () {
                    var result = [];
                    $.ajax({
                        url: '/firstlogin/checkinsetting/getGiftList',
                        async: false,
                        type: "get",
                        data: {},
                        dataType:'json',
                        success: function (data, status) {
                            $.each(data, function (key, value) {
                                result.push({ value: value.id, text: value.name });
                            });
                        }
                    });
                    return result;
                }
            });
            $('.editable2').editable({
                field: "gift_num",
                type: "text",
                url: '/firstlogin/checkinsetting/changeNum',
                ajaxOptions: {
                    type:'post',
                    dataType: 'json', //assuming json response
                },
                send:'always',
                params: function(params) {
                    //originally params contain pk, name and value
                    params.id = $(this).parent('.list-group-item').attr('data-id');
                    params.day_nd =$(this).parent('.list-group-item').attr('data-day_nd');
                    params.gift_num =params.value;
                    return params;
                },
                success: function(response, newValue) {
                    if(response.data)
                    {
                        console.log(response.data);
                    }else{
                        console.log(response);
                    }
                },
            });
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
        },
        giftListformatter:function (value,row,index) {
            var data = JSON.parse(row.gift_content);
            if(!data)
                return value;
            var html='';
            html += '<ul class="list-group">';
            for(var i=0;i<data.length;i++)
            {
                var day = "第"+data[i].day_nd+"天 ";
                var gift = data[i]['list'][0].name;
                var num =  "   "+data[i]['list'][0].num;
                html += '<li class="list-group-item" data-id="'+row.id+'"  data-day_nd="'+data[i].day_nd+'">'+day +'<a  href="#"  data-title="编辑奖励类型" data-type="select"  class="editable1">'+gift+'</a>'+
                    ',  数量:<a  href="#"  data-title="编辑数量" data-type="text"  class="editable2">'+num+'</a></li>';
            }
            html +=' </ul>';

            return html;
        }
    };

    return Controller;
});