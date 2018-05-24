define(['jquery', 'bootstrap', 'backend', 'table', 'form','bootstrap-editable'], function ($, undefined, Backend, Table, Form,editable) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'firstlogin/firstchargesetting/index',
                    add_url: 'firstlogin/firstchargesetting/add',
                    edit_url: 'firstlogin/firstchargesetting/edit',
                    del_url: 'firstlogin/firstchargesetting/del',
                    multi_url: 'firstlogin/firstchargesetting/multi',
                    table: 'firstcharge_setting',
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
                        {field: 'system_text',searchable:false, title: __('Platform_id'), formatter: Table.api.formatter.label},
                        {field: 'platform_id',visible:false, title: __('Platform_id'), formatter: Table.api.formatter.label,operate:"LIKE %...%",searchList:{"1":"android","2":"IOS","3":"PC"}},

                        {field: 'goods_name', searchable:false,title: __('Goods_id')},
                        {field: 'goods_id',visible:false,searchable:false, title: __('Goods_id')},
                        {field: 'money', title: __('Money'),type:"number"},
                        {field: 'title', title: __('Title'),operate:'LIKE %...%',},
                        {field: 'base_gift_content',  searchable:false,title: __('Base_gift_content'),formatter:Controller.giftListformatter},
                        {field: 'extra_gift_content',  searchable:false,title: __('Extra_gift_content'),formatter:Controller.giftListformatter2},
                        {field: 'desc', searchable:false, title: __('Desc')},
                        {field: 'status', title: __('Status'), visible:false,formatter: Table.api.formatter.status,searchList:{'0':'隐藏','1':'正常'}},
                        {field: 'status_text', title: __('Status'),searchable:false,formatter: Table.api.formatter.status,},
                        {field: 'create_time', title: __('Create_time'), formatter: Table.api.formatter.datetime,type:'datetime',addclass:'datetimepicker', data: 'data-date-format="YYYY-MM-DD HH:mm:ss"'},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ]
                ]
            });

            // 为表格绑定事件
            Table.api.bindevent(table);
            console.log($('.editable3').length);
            $('.editable3').editable({
                field: "gift_id",
                url: '/firstlogin/firstchargesetting/changeExtraName',
                ajaxOptions: {
                    type:'post',
                    dataType: 'json', //assuming json response
                },
                send:'always',
                params: function(params) {
                    //originally params contain pk, name and value
                    params.id = $(this).parent('.list-group-item').attr('data-id');
                    params.gift_old_id =$(this).parent('.list-group-item').attr('data-gift_old_id');
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
            $('.editable4').editable({
                field: "gift_num",
                type: "text",
                url: '/firstlogin/firstchargesetting/changeExtraNum',
                ajaxOptions: {
                    type:'post',
                    dataType: 'json', //assuming json response
                },
                send:'always',
                params: function(params) {
                    //originally params contain pk, name and value
                    params.id = $(this).parent('.list-group-item').attr('data-id');
                    params.gift_old_id =$(this).parent('.list-group-item').attr('data-gift_old_id');
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
            $('.editable1').editable({
                field: "gift_id",
                url: '/firstlogin/firstchargesetting/changeName',
                ajaxOptions: {
                    type:'post',
                    dataType: 'json', //assuming json response
                },
                send:'always',
                params: function(params) {
                    //originally params contain pk, name and value
                    params.id = $(this).parent('.list-group-item').attr('data-id');
                    params.gift_old_id =$(this).parent('.list-group-item').attr('data-gift_old_id');
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
                url: '/firstlogin/firstchargesetting/changeNum',
                ajaxOptions: {
                    type:'post',
                    dataType: 'json', //assuming json response
                },
                send:'always',
                params: function(params) {
                    //originally params contain pk, name and value
                    params.id = $(this).parent('.list-group-item').attr('data-id');
                    params.gift_old_id =$(this).parent('.list-group-item').attr('data-gift_old_id');
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
            var data = JSON.parse(row.base_gift_content);
            if(!data)
                return value;
            var html='';
            html += '<ul class="list-group">';
            for(var i=0;i<data.length;i++)
            {
                var gift = data[i].name;
                var num =  "   "+data[i].num;
                html += '<li class="list-group-item" data-id="'+row.id+'"  data-gift_old_id="'+data[i].id+'">' +'<a  href="#"  data-title="编辑奖励类型" data-type="select"  class="editable1">'+gift+'</a>'+
                    ',  数量:<a  href="#"  data-title="编辑数量" data-type="text"  class="editable2">'+num+'</a></li>';
            }
            html +=' </ul>';

            return html;
        },
        giftListformatter2:function (value,row,index) {
            var data = JSON.parse(row.extra_gift_content);
            if(!data)
                return value;
            var html='';
            html += '<ul class="list-group">';
            for(var i=0;i<data.length;i++)
            {
                var gift = data[i].name;
                var num =  "   "+data[i].num;
                html += '<li class="list-group-item" data-id="'+row.id+'"  data-gift_old_id="'+data[i].id+'">' +'<a  href="#"  data-title="编辑奖励类型" data-type="select"  class="editable3">'+gift+'</a>'+
                    ',  数量:<a  href="#"  data-title="编辑数量" data-type="text"  class="editable4">'+num+'</a></li>';
            }
            html +=' </ul>';

            return html;
        }
    };
    return Controller;
});