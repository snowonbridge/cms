<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:77:"/vagrant/cms/public/../application/admin/view/general/switchsetting/edit.html";i:1527058608;s:65:"/vagrant/cms/public/../application/admin/view/layout/default.html";i:1505374143;s:62:"/vagrant/cms/public/../application/admin/view/common/meta.html";i:1520215499;s:64:"/vagrant/cms/public/../application/admin/view/common/script.html";i:1505374143;}*/ ?>
<!DOCTYPE html>
<html lang="<?php echo $config['language']; ?>">
    <head>
        <meta charset="utf-8">
<title><?php echo (isset($title) && ($title !== '')?$title:''); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<meta name="renderer" content="webkit">

<link rel="shortcut icon" href="__CDN__/assets/img/favicon.ico" />
<!-- Loading Bootstrap -->
<link href="__CDN__/assets/css/backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.css?v=<?php echo \think\Config::get('site.version'); ?>" rel="stylesheet">

<!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
<!--[if lt IE 9]>
  <script src="__CDN__/assets/js/html5shiv.js"></script>
  <script src="__CDN__/assets/js/respond.min.js"></script>
<![endif]-->
<script type="text/javascript">
    var require = {
        config:  <?php echo json_encode($config); ?>
    };
</script>
    </head>

    <body class="inside-header inside-aside <?php echo defined('IS_DIALOG') && IS_DIALOG ? 'is-dialog' : ''; ?>">
        <div id="main" role="main">
            <div class="tab-content tab-addtabs">
                <div id="content">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <section class="content-header hide">
                                <h1>
                                    <?php echo __('Dashboard'); ?>
                                    <small><?php echo __('Control panel'); ?></small>
                                </h1>
                            </section>
                            <?php if(!IS_DIALOG): ?>
                            <!-- RIBBON -->
                            <div id="ribbon">
                                <ol class="breadcrumb pull-left">
                                    <li><a href="dashboard" class="addtabsit"><i class="fa fa-dashboard"></i> <?php echo __('Dashboard'); ?></a></li>
                                </ol>
                                <ol class="breadcrumb pull-right">
                                    <?php foreach($breadcrumb as $vo): ?>
                                    <li><a href="javascript:;" data-url="<?php echo $vo['url']; ?>"><?php echo $vo['title']; ?></a></li>
                                    <?php endforeach; ?>
                                </ol>
                            </div>
                            <!-- END RIBBON -->
                            <?php endif; ?>
                            <div class="content">
                                <form id="edit-form" class="form-horizontal" role="form" data-toggle="validator" method="POST" action="">

    <div class="form-group">
        <label for="c-name" class="control-label col-xs-12 col-sm-2"><?php echo __('Name'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-name"  class="form-control" name="row[name]" type="text" value="<?php echo $row['name']; ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="c-channel_text" class="control-label col-xs-12 col-sm-2"><?php echo __('Channel_id'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input ready_only id="c-channel_text" readonly data-rule="required" data-source="channel/index" class="form-control " name="channel_text" type="text" value="<?php echo $row['channel_text']; ?>">
        </div>
    </div>
    <!--<div class="form-group">-->
        <!--<label for="c-platform_id" class="control-label col-xs-12 col-sm-2"><?php echo __('Platform_id'); ?>:</label>-->
        <!--<div class="col-xs-12 col-sm-8">-->
            <!--<input id="c-platform_id" data-rule="required" data-source="platform/index" class="form-control selectpage" name="row[platform_id]" type="text" value="<?php echo $row['platform_id']; ?>">-->
        <!--</div>-->
    <!--</div>-->
    <div class="form-group">
        <label for="c-platform_id" class="control-label col-xs-12 col-sm-2"><?php echo __('Platform_id'); ?>:</label>
        <div class="col-xs-12 col-sm-8">

            <select  id="c-platform_id" data-rule="required" class="form-control selectpicker" name="row[platform_id][]" multiple>
                <?php if(is_array($systemList) || $systemList instanceof \think\Collection || $systemList instanceof \think\Paginator): if( count($systemList)==0 ) : echo "" ;else: foreach($systemList as $key=>$vo): ?>
                <option value="<?php echo $key; ?>" <?php if(in_array(($key), is_array($row['platform_id'])?$row['platform_id']:explode(',',$row['platform_id']))): ?>selected<?php endif; ?>><?php echo $vo; ?></option>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </select>

        </div>
    </div>

    <div class="form-group">
        <label for="c-register" class="control-label col-xs-12 col-sm-2"><?php echo __('Register'); ?>:</label>
        <div class="col-xs-12 col-sm-8">

            <select  id="c-register" data-rule="required" class="form-control selectpicker" name="row[register][]" multiple>
                <?php if(is_array($registerList) || $registerList instanceof \think\Collection || $registerList instanceof \think\Paginator): if( count($registerList)==0 ) : echo "" ;else: foreach($registerList as $key=>$vo): ?>
                <option value="<?php echo $key; ?>" <?php if(in_array(($key), is_array($row['register'])?$row['register']:explode(',',$row['register']))): ?>selected<?php endif; ?>><?php echo $vo; ?></option>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="c-login" class="control-label col-xs-12 col-sm-2"><?php echo __('Login'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <select  id="c-login" data-rule="required" class="form-control selectpicker" name="row[login][]" multiple>
                <?php if(is_array($loginList) || $loginList instanceof \think\Collection || $loginList instanceof \think\Paginator): if( count($loginList)==0 ) : echo "" ;else: foreach($loginList as $key=>$vo): ?>
                <option value="<?php echo $key; ?>" <?php if(in_array(($key), is_array($row['login'])?$row['login']:explode(',',$row['login']))): ?>selected<?php endif; ?>><?php echo $vo; ?></option>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="c-version" class="control-label col-xs-12 col-sm-2"><?php echo __('Version'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <select  id="c-version" data-rule="required" class="form-control selectpicker" name="row[version][]" multiple>
                <?php if(is_array($versionList) || $versionList instanceof \think\Collection || $versionList instanceof \think\Paginator): if( count($versionList)==0 ) : echo "" ;else: foreach($versionList as $key=>$vo): ?>
                <option value="<?php echo $key; ?>" <?php if(in_array(($key), is_array($row['version'])?$row['version']:explode(',',$row['version']))): ?>selected<?php endif; ?>><?php echo $vo; ?></option>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="c-game" class="control-label col-xs-12 col-sm-2"><?php echo __('Game'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <ul>
                <?php if(is_array($gamesList) || $gamesList instanceof \think\Collection || $gamesList instanceof \think\Paginator): if( count($gamesList)==0 ) : echo "" ;else: foreach($gamesList as $key=>$vo): ?>
                    <li><?php echo $vo; ?>(<?php echo $key; ?>)</li>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
        </div>
        <div class="col-xs-12 col-sm-8">
            <input  readonly id="c-game" data-rule="required" class="form-control" name="row[game]" type="hidden" value='<?php echo $row['game']; ?>'>
            <input type="button" id="add_game_row" value="添加行">
            <input type="button" id="del_game_row" value="删除最后一行">
        </div>
    </div>
    <div class="form-group "  style="overflow:scroll;width:100%" >
    <table id="game_table" class="table table-striped table-bordered table-hover table-responsive" style="width:100%" >
        <thead>
        <tr>
            <th style="text-align: center; vertical-align: middle; ">游戏名称</th>
            <th style="text-align: center; vertical-align: middle; ">至少满足条件数量</th>
            <th style="text-align: center; vertical-align: middle; ">总玩牌时间(小时)</th>
            <th style="text-align: center; vertical-align: middle; ">总在线时间(小时)</th>
            <th style="text-align: center; vertical-align: middle; ">至今注册时间（小时）</th>
            <th style="text-align: center; vertical-align: middle; ">VIP等级</th>
            <th style="text-align: center; vertical-align: middle; ">充值金额(元)</th>
            <th style="text-align: center; vertical-align: middle; ">金币流(个)</th>
            <th style="text-align: center; vertical-align: middle; ">玩斗地主次数</th>
            <th style="text-align: center; vertical-align: middle; ">玩牛牛次数</th>
            <th style="text-align: center; vertical-align: middle; ">玩炸金花次数</th>
            <th style="text-align: center; vertical-align: middle; ">玩麻将次数</th>
            <th style="text-align: center; vertical-align: middle; ">状态</th>
            <th style="text-align: center; vertical-align: middle; ">配置快速开始</th>
        </tr>
        </thead>
        <tbody>
        <?php if(is_array($gameList) || $gameList instanceof \think\Collection || $gameList instanceof \think\Paginator): if( count($gameList)==0 ) : echo "" ;else: foreach($gameList as $key=>$game): ?>
        <tr id="game-<?php echo $key; ?>" data-value="<?php echo $key; ?>">
            <?php if(is_array($game) || $game instanceof \think\Collection || $game instanceof \think\Paginator): if( count($game)==0 ) : echo "" ;else: foreach($game as $key=>$vo): ?>
            <td><input type="text" class="<?php echo $key; ?>" value="<?php echo $vo; ?>"></td>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </tr>
        <?php endforeach; endif; else: echo "" ;endif; ?>
        </tbody>
    </table>
    </div>
    <div class="form-group">
        <label for="c-pay_way" class="control-label col-xs-12 col-sm-2"><?php echo __('Pay_way'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <select  id="c-pay_way" data-rule="required" class="form-control selectpicker" name="row[pay_way][]" multiple>
                <?php if(is_array($payList) || $payList instanceof \think\Collection || $payList instanceof \think\Paginator): if( count($payList)==0 ) : echo "" ;else: foreach($payList as $key=>$vo): ?>
                <option value="<?php echo $key; ?>" <?php if(in_array(($key), is_array($row['pay_way'])?$row['pay_way']:explode(',',$row['pay_way']))): ?>selected<?php endif; ?>><?php echo $vo; ?></option>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="c-warning" class="control-label col-xs-12 col-sm-2"><?php echo __('Waning'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-warning" data-rule="required" class="form-control" name="row[warning]" type="hidden" value='<?php echo $row['warning']; ?>'>
            <div class="form-group">
                <label for="c-version" class="control-label col-xs-12 col-sm-2"><?php echo __('支付告警方式'); ?>:</label>
                <div class="col-xs-12 col-sm-8">
                    <select  id="c-notify_way" data-rule="required" class="form-control selectpicker" name="notify_way"  >
                        <?php if(is_array($warnList) || $warnList instanceof \think\Collection || $warnList instanceof \think\Paginator): if( count($warnList)==0 ) : echo "" ;else: foreach($warnList as $key=>$vo): ?>
                        <option value="<?php echo $key; ?>" <?php if(in_array(($key), is_array($row['notify_way'])?$row['notify_way']:explode(',',$row['notify_way']))): ?>selected<?php endif; ?>><?php echo $vo; ?></option>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="c-ceil" class="control-label col-xs-12 col-sm-2"><?php echo __('支付告警初始上限'); ?>:</label>
                <div class="col-xs-12 col-sm-8">
                    <input id="c-ceil" data-rule="required" class="form-control" name="ceil" type="number" value='<?php echo $row['ceil']; ?>'>
                </div>
            </div>
            <div class="form-group">
                <label for="c-new_ceil" class="control-label col-xs-12 col-sm-2"><?php echo __('支付告警当天上限'); ?>:</label>
                <div class="col-xs-12 col-sm-8">
                    <input id="c-new_ceil" data-rule="required" class="form-control" name="new_ceil" type="number" value='<?php echo $row['new_ceil']; ?>'>
                </div>
            </div>
            <div class="form-group">
                <label for="c-to" class="control-label col-xs-12 col-sm-2"><?php echo __('支付告警通知人,多个地址英文逗号分隔'); ?>:</label>
                <div class="col-xs-12 col-sm-8">
                    <input id="c-to" data-rule="required" class="form-control" name="to" type="text" value='<?php echo $row['to']; ?>'>
                </div>
            </div>
        </div>

    </div>

    <div class="form-group">
        <label for="c-quick_start_game" class="control-label col-xs-12 col-sm-2"><?php echo __('大厅快速开始游戏'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <select  id="c-quick_start_game" data-rule="required" class="form-control selectpicker" name="row[quick_start_game]" multiple>
                <?php if(is_array($gamesList) || $gamesList instanceof \think\Collection || $gamesList instanceof \think\Paginator): if( count($gamesList)==0 ) : echo "" ;else: foreach($gamesList as $key=>$vo): ?>
                <option value="<?php echo $key; ?>" <?php if(in_array(($key), is_array($row['quick_start_game'])?$row['quick_start_game']:explode(',',$row['quick_start_game']))): ?>selected<?php endif; ?>><?php echo $vo; ?></option>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label for="c-status" class="control-label col-xs-12 col-sm-2"><?php echo __('Status'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <div class="radio">
                <?php if(is_array($statusList) || $statusList instanceof \think\Collection || $statusList instanceof \think\Paginator): if( count($statusList)==0 ) : echo "" ;else: foreach($statusList as $key=>$vo): ?>
                <label for="row[status]-<?php echo $key; ?>"><input id="row[status]-<?php echo $key; ?>" name="row[status]" type="radio" value="<?php echo $key; ?>" <?php if(in_array(($key), is_array($row['status'])?$row['status']:explode(',',$row['status']))): ?>checked<?php endif; ?> /> <?php echo $vo; ?></label>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label for="c-show_charge" class="control-label col-xs-12 col-sm-2"><?php echo __('兑换商店'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <div class="radio">
                <?php if(is_array($statusList) || $statusList instanceof \think\Collection || $statusList instanceof \think\Paginator): if( count($statusList)==0 ) : echo "" ;else: foreach($statusList as $key=>$vo): ?>
                <label for="row[status]-<?php echo $key; ?>"><input id="row[show_charge]-<?php echo $key; ?>" name="row[show_charge]" type="radio" value="<?php echo $key; ?>" <?php if(in_array(($key), is_array($row['show_charge'])?$row['show_charge']:explode(',',$row['show_charge']))): ?>checked<?php endif; ?> /> <?php echo $vo; ?></label>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label for="c-update_time" class="control-label col-xs-12 col-sm-2"><?php echo __('Update_time'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-update_time" data-rule="required" class="form-control datetimepicker" data-date-format="YYYY-MM-DD HH:mm:ss" data-use-current="true" name="row[update_time]" type="text" value="<?php echo datetime($row['update_time']); ?>">
        </div>
    </div>


    <div class="form-group">
        <label for="c-select-page" class="control-label col-xs-12 col-sm-2"><?php echo __('selectpage'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="mobile" data-rule="required" class="form-control btn-captcha">
        </div>
    </div>

    <div class="form-group">
        <label for="c-create_time" class="control-label col-xs-12 col-sm-2"><?php echo __('Create_time'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-create_time" data-rule="required" class="form-control datetimepicker" data-date-format="YYYY-MM-DD HH:mm:ss" data-use-current="true" name="row[create_time]" type="text" value="<?php echo datetime($row['create_time']); ?>">
        </div>
    </div>
    <div class="form-group layer-footer">
        <label class="control-label col-xs-12 col-sm-2"></label>
        <div class="col-xs-12 col-sm-8">
            <button type="submit" class="btn btn-success btn-embossed disabled"><?php echo __('OK'); ?></button>
            <button type="reset" class="btn btn-default btn-embossed"><?php echo __('Reset'); ?></button>
        </div>
    </div>
</form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="__CDN__/assets/js/require.js" data-main="__CDN__/assets/js/require-backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js?v=<?php echo $site['version']; ?>"></script>
    </body>
</html>