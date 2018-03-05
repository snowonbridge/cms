define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    // index_url: 'http://www.ivm.com/poker/cms_gate/api.php?do=goodIndex',
                    index_url: 'ajax/gameApi/do/goodIndex',
                    add_url: 'goods/add',
                    edit_url: 'goods/edit',
                    del_url: 'ajax/gameApi/do/goodDel'
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'goodid',
                sortName: 'goodid',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'goodid', title: __('GoodID')},
                        {field: 'name', title: __('Name')},
                        {field: 'description', title: __('Description')},
                        {field: 'category_text', title: __('Category')},
                        {field: 'ptype_text', title: __('Ptype')},
                        {field: 'status_text', title: __('Status')},
                        {field: 'apple_id', title: __('Apple_id')},
                        {field: 'num', title: __('Num')},
                        {field: 'version', title: __('Version')},
                        {field: 'price', title: __('Price')},
                        {field: 'pcard', title: __('Pcard')},
                        {field: 'tabletypes', title: __('Tabletypes'),formatter: Controller.formatter.tabletypes},
                        {field: 'os', title: __('OS'),formatter: Controller.formatter.os},
                        {field: 'sid', title: __('sid'),formatter: Controller.formatter.sid},
                        {field: 'inroom_text', title: __('Inroom')},
                        {field: 'extra', title: __('Extra')},
                        {field: 'createtime', title: __('Createtime'),formatter: Table.api.formatter.datetime},
                        {field: 'good_image', title: __('Good_image'), formatter: Table.api.formatter.image},
                        {
                            field: 'operate',
                            title: __('Operate'),
                            table: table,
                            events: Table.api.events.operate,
                            formatter: Table.api.formatter.operate
                        }
                    ]
                ],
                dataType:'jsonp'
            });

            // 为表格绑定事件
            Table.api.bindevent(table);


            $("form.edit-form").data("validator-options", {
                display: function (elem) {
                    return $(elem).closest('tr').find("td:first").text();
                }
            });
            Form.api.bindevent($("form.edit-form"));

            //不可见的元素不验证
            $("form.add-form").data("validator-options", {ignore: ':hidden'});
            Form.api.bindevent($("form.add-form"), null, function (ret) {
                location.reload();
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
                $(document).on("change", "#c-type_id", function () {
                    if ($(this).val() == 1) {
                        $(this).parents().closest('.form-group').nextAll().find('input,select,checkbox,textarea').prop('disabled', true);
                        //$(this).parents().closest('.form-group').nextAll().find('input,select,checkbox,textarea').prop('disabled', true).hide();
                    } else {
                        $(this).parents().closest('.form-group').nextAll().find('input,select,checkbox,textarea').prop('disabled', false).show();
                    }
                });

                $(document).on("click", ".fieldlist .append", function () {
                    var rel = parseInt($(this).closest("dl").attr("rel")) + 1;
                    var name = $(this).closest("dl").data("name");
                    $(this).closest("dl").attr("rel", rel);
                    var $doc = $(this);
                    $(this).closest("dd").prev().clone()
                        .find("select[name$='[type]']").attr("name", 'row[' + name + '][' + rel + '][type]').end()
                        .find("input[name$='[val]']").attr("name", 'row[' + name + '][' + rel + '][val]').end()
                        .find("input[name$='[name]']").attr("name", 'row[' + name + '][' + rel + '][name]')
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
                        goodselector: 'dd',
                        dragSelector: ".btn-dragsort",
                        dragEnd: function () {

                        },
                        placeHolderTemplate: "<dd></dd>"
                    });
                });

                Form.api.bindevent($("form[role=form]"));
            }
        },
        formatter:{
            tabletypes: function (value, row, index, custom) {
                var colorArr = {'0' : __('tabletypes_0'),'1': __('tabletypes_1'),'2': __('tabletypes_2'),'3': __('tabletypes_3'),'4':__('tabletypes_4')};

                //如果有自定义状态,可以按需传入
                if (typeof custom !== 'undefined') {
                    colorArr = $.extend(colorArr, custom);
                }
                //渲染Flag
                var html = [];
                var arr = value.split(',');
                $.each(arr, function (i, value) {
                    value = value.toString();
                    if (value == '')
                        return true;
                    var color = value && typeof colorArr[value] !== 'undefined' ? colorArr[value] : '';
                    html.push('<span class="label label-success">' + color + '</span>');
                });
                return html.join(' ');
            },

            os: function (value, row, index, custom) {
                var colorArr = {'0' : __('All_OS'),'1': __('OS_1'),'2': __('OS_2'),'3': __('OS_3')};

                //如果有自定义状态,可以按需传入
                if (typeof custom !== 'undefined') {
                    colorArr = $.extend(colorArr, custom);
                }
                //渲染Flag
                var html = [];
                var arr = value.split(',');
                $.each(arr, function (i, value) {
                    value = value.toString();
                    if (value == '')
                        return true;
                    var color = value && typeof colorArr[value] !== 'undefined' ? colorArr[value] : '';
                    html.push('<span class="label label-success">' + color + '</span>');
                });
                return html.join(' ');
            },
        sid: function (value, row, index, custom) {
            var colorArr = {'10001': __('SID_1'),'10002': __('SID_2')};

            //如果有自定义状态,可以按需传入
            if (typeof custom !== 'undefined') {
                colorArr = $.extend(colorArr, custom);
            }
            //渲染Flag
            var html = [];
            var arr = value.split(',');
            $.each(arr, function (i, value) {
                value = value.toString();
                if (value == '')
                    return true;
                var color = value && typeof colorArr[value] !== 'undefined' ? colorArr[value] : '';
                html.push('<span class="label label-success">' + color + '</span>');
            });
            return html.join(' ');
        },
        }
    };
    return Controller;
});
