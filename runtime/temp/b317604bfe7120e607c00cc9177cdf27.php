<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:85:"D:\phpStudy\WWW\fastadmin4\public/../application/admin\view\product\product\edit.html";i:1505791011;s:79:"D:\phpStudy\WWW\fastadmin4\public/../application/admin\view\layout\default.html";i:1502881244;s:76:"D:\phpStudy\WWW\fastadmin4\public/../application/admin\view\common\meta.html";i:1502881244;s:78:"D:\phpStudy\WWW\fastadmin4\public/../application/admin\view\common\script.html";i:1502881244;}*/ ?>
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
        <label for="c-product_category_id" class="control-label col-xs-12 col-sm-2"><?php echo __('Product_category_id'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-product_category_id" data-rule="required" data-source="product/category/index" class="form-control selectpage" name="row[product_category_id]" type="text" value="<?php echo $row['product_category_id']; ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="c-labels" class="control-label col-xs-12 col-sm-2"><?php echo __('Labels'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-labels" class="form-control" name="row[labels]" type="text" value="<?php echo $row['labels']; ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="c-status" class="control-label col-xs-12 col-sm-2"><?php echo __('Status'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
                        
            <?php if(is_array($statusList) || $statusList instanceof \think\Collection || $statusList instanceof \think\Paginator): if( count($statusList)==0 ) : echo "" ;else: foreach($statusList as $key=>$vo): ?>
            <label for="row[status]-<?php echo $key; ?>"><input id="row[status]-<?php echo $key; ?>" name="row[status]" type="radio" value="<?php echo $key; ?>" <?php if(in_array(($key), is_array($row['status'])?$row['status']:explode(',',$row['status']))): ?>checked<?php endif; ?> /> <?php echo $vo; ?></label> 
            <?php endforeach; endif; else: echo "" ;endif; ?>

        </div>
    </div>
    <div class="form-group">
        <label for="c-weigh" class="control-label col-xs-12 col-sm-2"><?php echo __('Weigh'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-weigh" class="form-control" name="row[weigh]" type="number" value="<?php echo $row['weigh']; ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="c-product_name" class="control-label col-xs-12 col-sm-2"><?php echo __('Product_name'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-product_name" data-rule="required" class="form-control" name="row[product_name]" type="text" value="<?php echo $row['product_name']; ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="c-old_price" class="control-label col-xs-12 col-sm-2"><?php echo __('Old_price'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-old_price" class="form-control" step="0.01" name="row[old_price]" type="number" value="<?php echo $row['old_price']; ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="c-price" class="control-label col-xs-12 col-sm-2"><?php echo __('Price'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-price" data-rule="required" class="form-control" step="0.01" name="row[price]" type="number" value="<?php echo $row['price']; ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="c-cost" class="control-label col-xs-12 col-sm-2"><?php echo __('Cost'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-cost" class="form-control" step="0.01" name="row[cost]" type="number" value="<?php echo $row['cost']; ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="c-title" class="control-label col-xs-12 col-sm-2"><?php echo __('Title'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-title" class="form-control" name="row[title]" type="text" value="<?php echo $row['title']; ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="c-keywords" class="control-label col-xs-12 col-sm-2"><?php echo __('Keywords'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-keywords" class="form-control" name="row[keywords]" type="text" value="<?php echo $row['keywords']; ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="c-description" class="control-label col-xs-12 col-sm-2"><?php echo __('Description'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <textarea id="c-description" class="form-control " rows="5" name="row[description]" cols="50"><?php echo $row['description']; ?></textarea>
        </div>
    </div>
    <div class="form-group">
        <label for="c-detailcontent" class="control-label col-xs-12 col-sm-2"><?php echo __('Detailcontent'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <textarea id="c-detailcontent" class="form-control summernote" rows="5" name="row[detailcontent]" cols="50"><?php echo $row['detailcontent']; ?></textarea>
        </div>
    </div>
    <div class="form-group">
        <label for="c-stock" class="control-label col-xs-12 col-sm-2"><?php echo __('Stock'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-stock" class="form-control" name="row[stock]" type="number" value="<?php echo $row['stock']; ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="c-sales" class="control-label col-xs-12 col-sm-2"><?php echo __('Sales'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-sales" class="form-control" name="row[sales]" type="number" value="<?php echo $row['sales']; ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="c-thumbimage" class="control-label col-xs-12 col-sm-2"><?php echo __('Thumbimage'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <div class="form-inline">
                <input id="c-thumbimage" class="form-control" size="50" name="row[thumbimage]" type="text" value="<?php echo $row['thumbimage']; ?>">
                <span><button type="button" id="plupload-thumbimage" class="btn btn-danger plupload" data-input-id="c-thumbimage" data-mimetype="image/gif,image/jpeg,image/png,image/jpg,image/bmp" data-multiple="false" data-preview-id="p-thumbimage"><i class="fa fa-upload"></i> <?php echo __('Upload'); ?></button></span>
                <span><button type="button" id="fachoose-thumbimage" class="btn btn-primary fachoose" data-input-id="c-thumbimage" data-mimetype="image/*" data-multiple="false"><i class="fa fa-list"></i> <?php echo __('Choose'); ?></button></span>
                <ul class="row list-inline plupload-preview" id="p-thumbimage"></ul>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="c-galleryimages" class="control-label col-xs-12 col-sm-2"><?php echo __('Galleryimages'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <div class="form-inline">
                <input id="c-galleryimages" class="form-control" size="50" name="row[galleryimages]" type="text" value="<?php echo $row['galleryimages']; ?>">
                <span><button type="button" id="plupload-galleryimages" class="btn btn-danger plupload" data-input-id="c-galleryimages" data-mimetype="image/gif,image/jpeg,image/png,image/jpg,image/bmp" data-multiple="true" data-preview-id="p-galleryimages"><i class="fa fa-upload"></i> <?php echo __('Upload'); ?></button></span>
                <span><button type="button" id="fachoose-galleryimages" class="btn btn-primary fachoose" data-input-id="c-galleryimages" data-mimetype="image/*" data-multiple="true"><i class="fa fa-list"></i> <?php echo __('Choose'); ?></button></span>
                <ul class="row list-inline plupload-preview" id="p-galleryimages"></ul>
            </div>
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