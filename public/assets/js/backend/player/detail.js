define(['jquery', 'bootstrap', 'backend', 'form', 'toastr'], function ($, undefined, Backend, Form, Toastr) {

  var Controller = {
    index: function () {
      $("form[role=form]").data("validator-options", {
        invalid: function (form, errors) {
          $.each(errors, function (i, j) {
            Toastr.error(j);
          });
        },
        target: '#errtips'
      });
      // 初始化表单参数配置
      Controller.api.bindevent();
      //本地验证未通过时提示
      this.api.init();
      require(['selectpage'], function () {

        var config = {
          showField: 'uid',
          keyField: 'uid',
          data: 'player/detail/selectpage',
          //启用多选模式
          multiple : true,
          multipleControlbar:false,
          dropButton:false,
          //限制最多选中三个项目
          maxSelectLimit : 1,
          //设置选中项目后不关闭列表
          selectToCloseList : false,
          params: function () {
            return {'type': Controller.api.search_type};
          },
          //格式化显示项目，提供源数据进行使用
          formatItem : function(data){
            return '[' + data.uname + '] mid:' + data.id + ',uid:' + data.uid;
          },
          //ajax请求后服务端返回的数据格式处理
          //返回的数据里必须包含list（Array）和totalRow（number|string）两个节点
          eSelect : function(data){
            var keyword = data.uid;
            $.ajax({
              type: "POST",
              url: "/player/detail/index",
              data: {keyword: keyword},
              success: function (data) {
                if (data && data !== undefined && data !== "") {
                  $('#userInfo').html(data);
                } else {
                  $('#userInfo').html('没有该用户数据！');
                }
              },
              dataType: 'json'
            });
          },
          eAjaxSuccess: function (d) {
            var result;
            if (d) {
              if(d.hasOwnProperty('list') && d.hasOwnProperty('totalRow')){
                result = d;
              }
            } else {
              result = undefined;
            }
            return result;
          },
          inputDelay:0.5
        };
        $('#keyword').selectPage(config);
      });
    },
    api: {
      bindevent: function () {
        Form.api.bindevent($("form[role=form]"), null, null, null);
      },
      init: function () {
        $('#search-type').on('change',function () {
          Controller.api.search_type = $('#search-type').val();
        });
        $('#search-type').trigger('change');
      },
      search_type:'uid'
    }
  };
  return Controller;
});