<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:81:"/vagrant/cms/public/../application/admin/view/firstlogin/checkinsetting/edit.html";i:1523848640;s:65:"/vagrant/cms/public/../application/admin/view/layout/default.html";i:1505374143;s:62:"/vagrant/cms/public/../application/admin/view/common/meta.html";i:1520215499;s:64:"/vagrant/cms/public/../application/admin/view/common/script.html";i:1505374143;}*/ ?>
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
        <label for="c-channel_id" class="control-label col-xs-12 col-sm-2"><?php echo __('Channel_id'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-channel_id" data-rule="required" data-source="channel/index" class="form-control " name="channel_text" type="text" value="<?php echo $row['channel_text']; ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="c-rule_id" class="control-label col-xs-12 col-sm-2"><?php echo __('Rule_id'); ?>:</label>
        <div class="col-xs-12 col-sm-8">

            <select  id="c-rule_id" data-rule="required" class="form-control selectpicker" name="row[rule_id]">
                <?php if(is_array($ruleList) || $ruleList instanceof \think\Collection || $ruleList instanceof \think\Paginator): if( count($ruleList)==0 ) : echo "" ;else: foreach($ruleList as $key=>$vo): ?>
                <option value="<?php echo $key; ?>" <?php if(in_array(($key), is_array($row['rule_id'])?$row['rule_id']:explode(',',$row['rule_id']))): ?>selected<?php endif; ?>><?php echo $vo; ?></option>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="c-register_way_id" class="control-label col-xs-12 col-sm-2"><?php echo __('Register_way_id'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <select  multiple id="c-register_way_id" data-rule="required" class="form-control selectpicker" name="row[register_way_id][]">
                <?php if(is_array($registerList) || $registerList instanceof \think\Collection || $registerList instanceof \think\Paginator): if( count($registerList)==0 ) : echo "" ;else: foreach($registerList as $key=>$vo): ?>
                <option value="<?php echo $key; ?>" <?php if(in_array(($key), is_array($row['register_way_id'])?$row['register_way_id']:explode(',',$row['register_way_id']))): ?>selected<?php endif; ?>><?php echo $vo; ?></option>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="c-platform_id" class="control-label col-xs-12 col-sm-2"><?php echo __('Platform_id'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <select  multiple id="c-platform_id" data-rule="required" class="form-control selectpicker" name="row[platform_id][]">
                <?php if(is_array($systemList) || $systemList instanceof \think\Collection || $systemList instanceof \think\Paginator): if( count($systemList)==0 ) : echo "" ;else: foreach($systemList as $key=>$vo): ?>
                <option value="<?php echo $key; ?>" <?php if(in_array(($key), is_array($row['platform_id'])?$row['platform_id']:explode(',',$row['platform_id']))): ?>selected<?php endif; ?>><?php echo $vo; ?></option>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="c-days" class="control-label col-xs-12 col-sm-2"><?php echo __('Days'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-days" data-rule="required" class="form-control" name="row[days]" type="number" value="<?php echo $row['days']; ?>">
        </div>
    </div>
    <div class="form-group hidden">
        <label for="c-gift_content" class="control-label col-xs-12 col-sm-2"><?php echo __('Gift_content'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-gift_content" data-rule="required" class="form-control" name="row[gift_content]" type="text" value='<?php echo $row['gift_content']; ?>'>

        </div>
    </div>
    <div class="form-group">
        <label for="c-update_time" class="control-label col-xs-12 col-sm-2"><?php echo __('Update_time'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-update_time" data-rule="required" class="form-control datetimepicker" data-date-format="YYYY-MM-DD HH:mm:ss" data-use-current="true" name="row[update_time]" type="text" value="<?php echo datetime($row['update_time']); ?>">
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