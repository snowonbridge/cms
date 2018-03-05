define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'mail/index',
                    add_url: 'mail/add',
                    edit_url: 'mail/edit',
                    del_url: 'mail/del',
                    multi_url: 'mail/multi',
                    send_url: 'mail/send',
                    table: 'mail_config',
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
                        {field: 'title', title: __('Title')},
                        {field: 'content', title: __('Content')},
                        {field: 'con_type_text', title: __('Con_type'), operate:false},
                        {field: 'keepday', title: __('Keepday')},
                        {field: 'sendtime', title: __('Sendtime'), formatter: Table.api.formatter.datetime},
                        {field: 'status', title: __('Status'), formatter: Table.api.formatter.status},
                        {field: 'reward', title: __('Reward'),visible:false},
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
                $(document).on("change", "#c-con_type", function () {
                    if ($(this).val() == 3) {
                        $('#c-reward input,#c-reward select').prop('disabled', true);
                        $('#c-reward').hide();
                    } else {
                        $('#c-reward input,#c-reward select').prop('disabled', false);
                        $('#c-reward').show();
                    }
                });
                $(document).on("change", "#c-type", function () {
                    if ($(this).val() == 1) {
                        $('#c-type-c input,#c-type-c input').prop('disabled', true);
                        $('#c-type-c').hide();
                    } else {
                        $('#c-type-c input,#c-type-c input').prop('disabled', false);
                        $('#c-type-c').show();
                    }
                });

                $("#c-con_type",document).trigger("change");
                $("#c-type",document).trigger("change");
                $(document).on("click", ".fieldlist .append", function () {
                    var rel = parseInt($(this).closest("dl").attr("rel")) + 1;
                    var name = $(this).closest("dl").data("name");
                    $(this).closest("dl").attr("rel", rel);
                    var $doc = $(this);
                    $(this).closest("dd").prev().clone()
                        .find("input[name$='[id]']").attr("name", 'row[' + name + '][' + rel + '][id]').end()
                        .find("input[name$='[num]']").attr("name", 'row[' + name + '][' + rel + '][num]')
                        .end().insertBefore($doc.parent());
                    $('.selectpicker').data('selectpicker', null);
                    $('.bootstrap-select').find("button:first").remove();
                    $('.selectpicker').selectpicker();
                });
                $(document).on("click", ".fieldlist dd .btn-remove", function () {
                    $(this).parent().remove();
                });
                //拖拽排序
                require(['dragsort'], function () {
                    //绑定拖动排序
                    $("dl.fieldlist").dragsort({
                        itemSelector: 'dd',
                        dragSelector: ".btn-dragsort",
                        dragEnd: function () {

                        },
                        placeHolderTemplate: "<dd></dd>"
                    });
                });
            }
        }
    };
    return Controller;
});