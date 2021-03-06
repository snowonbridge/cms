define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

  var Controller = {
    index: function () {
      // 初始化表格参数配置
      Table.api.init({
        extend: {
          index_url: 'version/index',
          add_url: 'version/add',
          edit_url: 'version/edit',
          del_url: 'version/del',
          multi_url: 'version/multi',
          copy_url: 'version/copy',
          send_url: 'version/send',
          dragsort_url: 'ajax/weigh',
          table: 'version'
        }
      });

      var table = $("#table");

      // 初始化表格
      table.bootstrapTable({
        url: $.fn.bootstrapTable.defaults.extend.index_url,
        sortName: 'id',
        sortOrder: 'desc',
        columns: [
          [
            {field: 'state', checkbox: true},
            {field: 'id', title: __('Id')},
            {field: 'pidversion', title: __('Pidversion')},
            {field: 'version', title: __('Version')},
            {field: 'packtype', title: __('PackType'),formatter: this.api.formatter.packtype},
            {field: 'packname', title: __('PackName')},
            {field: 'packagesize', title: __('Packagesize')},
            {field: 'content', title: __('Content')},
            {field: 'downloadurl', title: __('Downloadurl'), formatter: Table.api.formatter.url},
            {field: 'enforce', title: __('Enforce')},
            {field: 'createtime', title: __('Createtime'), formatter: Table.api.formatter.datetime},
            {field: 'updatetime', title: __('Updatetime'), formatter: Table.api.formatter.datetime},
            {field: 'weigh', title: __('Weigh'),visible:false},
            {field: 'status', title: __('Status'), formatter: Table.api.formatter.status},
            {field: 'os', title: __('Os'), formatter: this.api.formatter.os},
            {field: 'unid', title: __('Unid'), formatter: this.api.formatter.unid},
            {field: 'gameid', title: __('Gameid'), formatter: this.api.formatter.gameid},
            {field: 'area', title: __('Area'), formatter: this.api.formatter.area},
            {field: 'scene', title: __('Scene'), formatter: this.api.formatter.scene},
            {
              field: 'operate',
              title: __('Operate'),
              table: table,
              events: Table.api.events.operate,
              formatter: Table.api.formatter.operate
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
      formatter: {
        packtype: function (value, row, index, custom) {
          //颜色状态数组,可使用red/yellow/aqua/blue/navy/teal/olive/lime/fuchsia/purple/maroon
          var colorArr = {1: 'success', 2: 'danger'};
          // value = value.toString();
          var color = value && typeof colorArr[value] !== 'undefined' ? colorArr[value] : 'primary';
          var mapArr = {'1': __('PackType_1'), '2': __('PackType_2')};
          value = mapArr[value];

          //如果字段列有定义custom
          if (typeof this.custom !== 'undefined') {
            colorArr = $.extend(colorArr, this.custom);
          }
          value = value.charAt(0).toUpperCase() + value.slice(1);
          //渲染状态
          var html = '<span class="text-' + color + '"><i class="fa fa-circle"></i> ' + __(value) + '</span>';
          return html;
        },
        os: function (value, row, index, custom) {
          var colorArr = {'1': __('Android'), '2': __('Ios'), '3': __('Pc')};

          if (typeof value === 'undefined' || value == null) {
            return '';
          }
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
        unid: function (value, row, index, custom) {
          var colorArr = {
            '1': 'appstore[1]',
            '2': '三星[2]',
            '3': '魅族[3]',
            '4': '联想[4]',
            '5': '酷派[5]',
            '6': '金立[6]',
            '7': '华为[7]',
            '8': '步步高[8]',
            '9': '百度多酷[9]',
            '10': '百度手机助手[10]',
            '11': '百度91[11]',
            '12': '百度贴吧[12]',
            '13': '阿里云[13]',
            '14': 'wifi万能钥匙2[14]',
            '15': 'wifi万能钥匙[15]',
            '16': 'UC[16]',
            '17': 'm4399[17]',
            '18': '优酷[18]',
            '19': '豌豆荚[19]',
            '20': 'OPPO[20]',
            '21': '移动MM[21]',
            '22': '小米[22]',
            '23': '腾讯应用宝[23]',
            '24': '腾讯管家[24]',
            '25': '腾讯QQ浏览器[25]',
            '26': '奇虎360[26]',
            '27': '灵游科技[27]',
            '28': '联通沃商店[28]',
            '29': '基地咪咕[29]',
            '30': '电信爱游戏[30]',
            '31': '电信爱动漫[31]',
            '32': '奥软[32]',
            '33': '乐视[33]',
            '34': '爱奇艺[34]',
            '35': '安智[35]',
            '36': 'taptap[36]'
          };
          if (typeof value === 'undefined' || value == null) {
            return '';
          }

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
        gameid: function (value, row, index, custom) {
          var colorArr = {
            '0': __('Game_0'),
            '1001': __('Game_1001'),
            '1002': __('Game_1002'),
            '1003': __('Game_1003'),
            '1004': __('Game_1004'),
            '1005': __('Game_1005')
          };

          if (typeof value === 'undefined' || value == null) {
            return '';
          }
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
        area: function (value, row, index, custom) {
          var colorArr = {'0': __('Area_0'), '1': __('Area_1'), '2': __('Area_2')};

          if (typeof value === 'undefined' || value == null) {
            return '';
          }
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
        scene: function (value, row, index, custom) {
          var colorArr = {'1': __('Scene_1'), '2': __('Scene_2')};

          if (typeof value === 'undefined' || value == null) {
            return '';
          }

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
        }
      }
    }
  };
  return Controller;
});