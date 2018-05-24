<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:76:"/vagrant/cms/public/../application/admin/view/firstlogin/acsetting/edit.html";i:1526633870;s:65:"/vagrant/cms/public/../application/admin/view/layout/default.html";i:1505374143;s:62:"/vagrant/cms/public/../application/admin/view/common/meta.html";i:1520215499;s:64:"/vagrant/cms/public/../application/admin/view/common/script.html";i:1505374143;}*/ ?>
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
            <input id="c-channel_id" readonly data-rule="required" data-source="channel/index" class="form-control " name="channel_text" type="text" value="<?php echo $row['channel_text']; ?>">

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
        <label for="c-name" class="control-label col-xs-12 col-sm-2"><?php echo __('Name'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-name" data-rule="required" class="form-control" name="row[name]" type="text" value="<?php echo $row['name']; ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="c-title" class="control-label col-xs-12 col-sm-2"><?php echo __('Title'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-title" data-rule="required" class="form-control" name="row[title]" type="text" value="<?php echo $row['title']; ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="c-type" class="control-label col-xs-12 col-sm-2"><?php echo __('Type'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <select   id="c-type" data-rule="required" class="form-control selectpicker" name="row[type]">
                <?php if(is_array($typeList) || $typeList instanceof \think\Collection || $typeList instanceof \think\Paginator): if( count($typeList)==0 ) : echo "" ;else: foreach($typeList as $key=>$vo): ?>
                <option value="<?php echo $key; ?>" <?php if(in_array(($key), is_array($row['type'])?$row['type']:explode(',',$row['type']))): ?>selected<?php endif; ?>><?php echo $vo; ?></option>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="c-show_type" class="control-label col-xs-12 col-sm-2"><?php echo __('Show_type'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <select   id="c-show_type" data-rule="required" class="form-control selectpicker" name="row[show_type]">
                <?php if(is_array($rList) || $rList instanceof \think\Collection || $rList instanceof \think\Paginator): if( count($rList)==0 ) : echo "" ;else: foreach($rList as $key=>$vo): ?>
                <option value="<?php echo $key; ?>" <?php if(in_array(($key), is_array($row['show_type'])?$row['show_type']:explode(',',$row['show_type']))): ?>selected<?php endif; ?>><?php echo $vo; ?></option>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="c-gift_content" class="control-label col-xs-12 col-sm-2"><?php echo __('Gift_content'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <textarea id="c-gift_content" data-rule="required" class="form-control summernote" rows="5" name="row[gift_content]" cols="50"><?php echo $row['gift_content']; ?></textarea>
        </div>
    </div>
    <div class="form-group">
        <label for="c-redirect_id" class="control-label col-xs-12 col-sm-2"><?php echo __('Redirect_id'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <select   id="c-redirect_id" data-rule="required" class="form-control selectpicker" name="row[redirect_id]">
                <?php if(is_array($redirectList) || $redirectList instanceof \think\Collection || $redirectList instanceof \think\Paginator): if( count($redirectList)==0 ) : echo "" ;else: foreach($redirectList as $key=>$vo): ?>
                <option value="<?php echo $key; ?>" <?php if(in_array(($key), is_array($row['redirect_id'])?$row['redirect_id']:explode(',',$row['redirect_id']))): ?>selected<?php endif; ?>><?php echo $vo; ?></option>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="c-redirect_btn_text" class="control-label col-xs-12 col-sm-2"><?php echo __('Redirect_btn_text'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-redirect_btn_text" data-rule="required" class="form-control" name="row[redirect_btn_text]" type="text" value="<?php echo $row['redirect_btn_text']; ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="c-redirect_url" class="control-label col-xs-12 col-sm-2"><?php echo __('Redirect_url'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-redirect_url" data-rule="" class="form-control" name="row[redirect_url]" type="text" value="<?php echo $row['redirect_url']; ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="c-show_text" class="control-label col-xs-12 col-sm-2"><?php echo __('Show_text'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <textarea id="c-show_text" class="form-control " rows="5" name="row[show_text]" cols="50"><?php echo $row['show_text']; ?></textarea>
        </div>
    </div>
    <div class="form-group">
        <label for="c-text_args" class="control-label col-xs-12 col-sm-2"><?php echo __('Text_args'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-text_args" data-rule="required" class="form-control" name="row[text_args]" type="text" value='<?php echo $row['text_args']; ?>'>
        </div>
    </div>


<?php if($row['id'] == 1): ?>
    <div class="form-group">
        <label for="c-imgs" class="control-label col-xs-12 col-sm-2"><?php echo __('Imgs'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <div class="input-group">
                <input id="c-img" readonly data-rule="" class="form-control" size="50" name="row[imgs]" type="text" value="<?php echo $row['imgs']; ?>">
                <div class="input-group-addon no-border no-padding">
                    <span><button type="button" id="plupload-img" class="btn btn-danger plupload" data-input-id="c-img" data-mimetype="image/gif,image/jpeg,image/png,image/jpg,image/bmp" data-multiple="false" data-preview-id="p-img">
                        <i class="fa fa-upload"></i> 上传</button></span>
                    <span><button type="button" id="fachoose-img" class="btn btn-primary fachoose" data-input-id="c-img" data-mimetype="image/*" data-multiple="false"><i class="fa fa-list"></i> 选择</button></span>
                </div>
                <span class="msg-box n-right" for="c-img"></span>
            </div>
            <ul class="row list-inline plupload-preview" id="p-img"></ul>
        </div>
    </div>
<?php endif; ?>
    <div class="form-group">
        <label for="c-status" class="control-label col-xs-12 col-sm-2"><?php echo __('Status'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <select   id="c-status" data-rule="required" class="form-control selectpicker" name="row[status]">
                <?php if(is_array($statusList) || $statusList instanceof \think\Collection || $statusList instanceof \think\Paginator): if( count($statusList)==0 ) : echo "" ;else: foreach($statusList as $key=>$vo): ?>
                <option value="<?php echo $key; ?>" <?php if(in_array(($key), is_array($row['status'])?$row['status']:explode(',',$row['status']))): ?>selected<?php endif; ?>><?php echo $vo; ?></option>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="c-start_time" class="control-label col-xs-12 col-sm-2"><?php echo __('Start_time'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-start_time" data-rule="required" class="form-control datetimepicker" data-date-format="YYYY-MM-DD HH:mm:ss" data-use-current="true" name="row[start_time]" type="text" value="<?php echo datetime($row['start_time']); ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="c-end_time" class="control-label col-xs-12 col-sm-2"><?php echo __('End_time'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-end_time" data-rule="required" class="form-control datetimepicker" data-date-format="YYYY-MM-DD HH:mm:ss" data-use-current="true" name="row[end_time]" type="text" value="<?php echo datetime($row['end_time']); ?>">
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