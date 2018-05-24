define(['jquery', 'bootstrap', 'backend', 'table', 'form','bootstrap-editable'], function ($, undefined, Backend, Table, Form,editable) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'firstlogin/newhandsetting/index',
                    add_url: 'firstlogin/newhandsetting/add',
                    edit_url: 'firstlogin/newhandsetting/edit',
                    del_url: 'firstlogin/newhandsetting/del',
                    multi_url: 'firstlogin/newhandsetting/multi',
                    table: 'newhand_setting',
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
                        {field: 'register_way_id',visible:false, title: __('Register_way_id'),operate:"LIKE %...%", formatter: Table.api.formatter.label,searchList:{"1":"游客","2":"手机","3":"微信","4":"QQ","5":"灵游"}},
                        {field: 'register_text', searchable:false,title: __('Register_way_id'), formatter: Table.api.formatter.label},
                        {field: 'system_text',searchable:false, title: __('Platform_id'), formatter: Table.api.formatter.label},
                        {field: 'platform_id',visible:false, title: __('Platform_id'), formatter: Table.api.formatter.label,operate:"LIKE %...%",searchList:{"1":"android","2":"IOS","3":"PC"}},
                        {field: 'gift_content',searchable:false, title: __('Gift_content'),formatter: Controller.giftListformatter},
                        {field: 'times', title: __('Times'),type:"number"},
                        {field: 'valid_days', title: __('Valid_days'),type:"number"},
                        {field: 'update_time', title: __('Update_time'), formatter: Table.api.formatter.datetime,type:'datetime',addclass:'datetimepicker', data: 'data-date-format="YYYY-MM-DD HH:mm:ss"'},
                        {field: 'create_time', title: __('Create_time'), formatter: Table.api.formatter.datetime,type:'datetime',addclass:'datetimepicker', data: 'data-date-format="YYYY-MM-DD HH:mm:ss"'},

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
        },
        giftListformatter:function (value,row,index) {
            var data = JSON.parse(row.gift_content);
            if(!data)
                return value;
            var html='';
            html += '<ul class="list-group">';
            for(var i=0;i<data.length;i++)
            {
                var day = "第"+data[i].time_nd+"次 ";
                var gift = data[i]['list'][0].name;
                var num =  "   "+data[i]['list'][0].num;
                html += '<li class="list-group-item" data-id="'+row.id+'"  data-time_nd="'+data[i].time_nd+'">'+day +'<a  href="#"  data-title="编辑奖励类型" data-type="select"  class="editable1">'+gift+'</a>'+
                    ',  数量:<a  href="#"  data-title="编辑数量" data-type="text"  class="editable2">'+num+'</a></li>';
            }
            html +=' </ul>';
            setTimeout(function () {
                $('.editable1').editable({
                    field: "gift_id",
                    url: '/firstlogin/newhandsetting/changeName',
                    ajaxOptions: {
                        type:'post',
                        dataType: 'json', //assuming json response
                    },
                    send:'always',
                    params: function(params) {
                        //originally params contain pk, name and value
                        params.id = $(this).parent('.list-group-item').attr('data-id');
                        params.time_nd =$(this).parent('.list-group-item').attr('data-time_nd');
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
                    url: '/firstlogin/newhandsetting/changeNum',
                    ajaxOptions: {
                        type:'post',
                        dataType: 'json', //assuming json response
                    },
                    send:'always',
                    params: function(params) {
                        //originally params contain pk, name and value
                        params.id = $(this).parent('.list-group-item').attr('data-id');
                        params.time_nd =$(this).parent('.list-group-item').attr('data-time_nd');
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
            },1000)
            return html;
        }
    };
    return Controller;
});