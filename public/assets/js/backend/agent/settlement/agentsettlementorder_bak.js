define(['jquery', 'bootstrap', 'backend', 'table', 'form','layer'], function ($, undefined, Backend, Table, Form,Layer) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'agent/settlement/agentsettlementorder/index',
                    add_url: 'agent/settlement/agentsettlementorder/add',
                    edit_url: 'agent/settlement/agentsettlementorder/edit',
                    del_url: 'agent/settlement/agentsettlementorder/del',
                    multi_url: 'agent/settlement/agentsettlementorder/multi',
                    table: 'agent_settlement_order',
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
                        {field: 'agent_id', title: __('Agent_id')},
                        {field: 'agent_truename', title: __('Agent_truename')},
                        {field: 'apply_no', title: __('Apply_no')},
                        {field: 'phone', title: __('Phone')},
                        {field: 'settlement_type', title: __('Settlement_type')},
                        {field: 'wx_openid', title: __('Wx_openid')},
                        {field: 'bank_account', title: __('Bank_account')},
                        {field: 'pay_money', title: __('Pay_money')},
                        {field: 'settlement_money', title: __('Settlement_money')},
                        {field: 'transfer_charge', title: __('Transfer_charge')},
                        {field: 'pay_status', title: __('Pay_status'), formatter: Table.api.formatter.status},
//                        {field: 'audit_img', title: __('Audit_img')},
//                        {field: 'settlement_img', title: __('Settlement_img')},
//                        {field: 'audit_refuse_reason', title: __('Audit_refuse_reason')},
//                        {field: 'settlement_fail_reason', title: __('Settlement_fail_reason')},
//                        {field: 'remark', title: __('Remark')},
                        {field: 'audit_time', title: __('Audit_time'), formatter: Table.api.formatter.datetime},
                        {field: 'settlement_time', title: __('Settlement_time'), formatter: Table.api.formatter.datetime},
//                        {field: 'fail_counts', title: __('Fail_counts')},
                        {field: 'create_time', title: __('Create_time'), formatter: Table.api.formatter.datetime},
//                        {field: 'ext', title: __('Ext')},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Controller.operate}
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
        operate: function (value, row, index) {
            var table = this.table;
            // 操作配置
            var options = table ? table.bootstrapTable('getOptions') : {};
            // 默认按钮组
            var buttons = $.extend([], this.buttons || []);
            buttons.push({name: 'dragsort', icon: 'fa fa-arrows', classname: 'btn btn-xs btn-primary btn-dragsort'});
            buttons.push({name: 'edit', classname: 'btn btn-xs btn-success btn-editone',text:"审核提现"});
//            buttons.push({name: 'del', icon: 'fa fa-trash', classname: 'btn btn-xs btn-danger btn-delone'});
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
                    html.push('<a href="' + url + '" class="' + classname + '" ' + extend + ' title="' + title + '"><i class="' + icon + '"></i>' + (text ? ' ' + text : '') + '</a>');
                }
            });
            return html.join(' ');
        }
    };
    $("form").on(" blur","#c-agent_id",(function(e){
        var ele = e.target;
        var clickCode = e.keyCode;
        if(clickCode != 13)
        {
            if(!$(this).val())
                return true;
        }
        var id = $(this).val();
        var url="agent/settlement/agentsettlementorder/agent";
        var data={"id":id};
        $.when($.get(url,data)).done(function(res){
            if(!res)
            {
                layer.msg('无该代理商信息');
                $("#c-pay_money").val('');
                $("#c-settlement_money").val('');
                $("#c-transfer_charge").val('');
                $("#c-phone").val('');
                $("#c-wx_openid").val('');
                $("#c-agent_truename").val('');
                $("#c-bank_account").val('');
                return false;
            }
            $("#c-agent_truename").val(res.truename);
            $("#c-phone").val(res.mobile);
            $("#c-wx_openid").val(res.union_id);
            $("#c-bank_account").val(res.bankcard);
            $("#c-pay_money").val(res.money);
            $("#c-settlement_money").val(res.settlement_money);
            $("#c-transfer_charge").val(res.transfer_charge);

        }).fail(function(){
//            alert("fail");
            layer.msg('无该代理商信息');
        });

    }));

    $("#c-pay_status").change(function(){
        var value = $(this).val();
        var $_refuse = $("#c-audit_refuse_reason").closest(".form-group");
        var $_fail =  $("#c-settlement_fail_reason").closest(".form-group");
        if(value == 2)
        {//审核拒绝
            $_refuse.show(); $_fail.hide();
        }else if(value == 4)
        {//结算失败
            $_refuse.hide(); $_fail.show();
        }else{
            $_refuse.hide(); $_fail.hide();
        }
    });
    $("form").on("input propertychange","#c-pay_money",(function(e){

        var pay_money = $(this).val();
        var url="agent/settlement/agentsettlementorder/calRate";
        var data={"pay_money":pay_money};
        $.ajax({
            url: url,
            data: data,
            'type':'post',
            success: function(res){
                if(res.length ==0)
                {
                    alert("数据异常");
                }else{
                    $("#c-pay_money").val(res.pay_money);
                    $("#c-settlement_money").val(res.settlement_money);
                    $("#c-transfer_charge").val(res.transfer_charge);

                }

            },
            dataType: 'json'
        });
//        $.when($.get(url,data)).done(function(res){
//            if(res.length ==0)
//            {
//
//                alert('无该代理商信息');
//                return false;
//
//            }
//            alert(res);
////            $("#c-agent_truename").val(res.truename);
////            $("#c-phone").val(res.mobile);
////            $("#c-wx_openid").val(res.union_id);
////            $("#c-bank_account").val(res.bankcard);
//            $("#c-pay_money").val(res.pay_money);
//            $("#c-settlement_money").val(res.settlement_money);
//            $("#c-transfer_charge").val(res.transfer_charge);
//
//        }).fail(function(){
////            alert("fail");
//            alert('无该代理商信息');
//        });

    }));
    return Controller;
});