<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:76:"/vagrant/cms/public/../application/admin/view/general/switchsetting/add.html";i:1526981715;s:65:"/vagrant/cms/public/../application/admin/view/layout/default.html";i:1505374143;s:62:"/vagrant/cms/public/../application/admin/view/common/meta.html";i:1520215499;s:64:"/vagrant/cms/public/../application/admin/view/common/script.html";i:1505374143;}*/ ?>
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
                                <form id="add-form" class="form-horizontal" role="form" data-toggle="validator" method="POST" action="">

    <div class="form-group">
        <label for="c-name" class="control-label col-xs-12 col-sm-2"><?php echo __('Name'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-name" data-rule="required" class="form-control" name="row[name]" type="text" value="">
        </div>
    </div>
    <div class="form-group">
        <label for="c-channel_id" class="control-label col-xs-12 col-sm-2"><?php echo __('Channel_id'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-channel_id" data-rule="required" data-source="channel/index" class="form-control selectpage" name="row[channel_id]" type="text" value="">
        </div>
    </div>
    <div class="form-group">
        <label for="c-platform_id" class="control-label col-xs-12 col-sm-2"><?php echo __('Platform_id'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-platform_id" data-rule="required" data-source="platform/index" class="form-control selectpage" name="row[platform_id]" type="text" value="">
        </div>
    </div>
    <div class="form-group">
        <label for="c-register" class="control-label col-xs-12 col-sm-2"><?php echo __('Register'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-register" data-rule="required" class="form-control" name="row[register]" type="text" value="">
        </div>
    </div>
    <div class="form-group">
        <label for="c-login" class="control-label col-xs-12 col-sm-2"><?php echo __('Login'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-login" data-rule="required" class="form-control" name="row[login]" type="text" value="">
        </div>
    </div>
    <div class="form-group">
        <label for="c-version" class="control-label col-xs-12 col-sm-2"><?php echo __('Version'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-version" data-rule="required" class="form-control" name="row[version]" type="text" value="">
        </div>
    </div>
    <div class="form-group">
        <label for="c-game" class="control-label col-xs-12 col-sm-2"><?php echo __('Game'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-game" data-rule="required" class="form-control" name="row[game]" type="text" value="">
        </div>
    </div>
    <div class="form-group">
        <label for="c-pay_way" class="control-label col-xs-12 col-sm-2"><?php echo __('Pay_way'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-pay_way" data-rule="required" class="form-control" name="row[pay_way]" type="text" value="">
        </div>
    </div>
    <div class="form-group">
        <label for="c-waning" class="control-label col-xs-12 col-sm-2"><?php echo __('Waning'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-waning" data-rule="required" class="form-control" name="row[waning]" type="text" value="">
        </div>
    </div>
    <div class="form-group">
        <label for="c-status" class="control-label col-xs-12 col-sm-2"><?php echo __('Status'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-status" data-rule="required" class="form-control" name="row[status]" type="number" value="1">
        </div>
    </div>
    <div class="form-group">
        <label for="c-update_time" class="control-label col-xs-12 col-sm-2"><?php echo __('Update_time'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-update_time" data-rule="required" class="form-control datetimepicker" data-date-format="YYYY-MM-DD HH:mm:ss" data-use-current="true" name="row[update_time]" type="text" value="<?php echo date('Y-m-d H:i:s'); ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="c-create_time" class="control-label col-xs-12 col-sm-2"><?php echo __('Create_time'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-create_time" data-rule="required" class="form-control datetimepicker" data-date-format="YYYY-MM-DD HH:mm:ss" data-use-current="true" name="row[create_time]" type="text" value="<?php echo date('Y-m-d H:i:s'); ?>">
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