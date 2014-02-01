<?php echo $header; ?>
<div id="content">
<div class="breadcrumb">
  <?php foreach ($breadcrumbs as $breadcrumb) { ?>
  <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
  <?php } ?>
</div>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<?php if ($success) { ?>
  <div class="success"><?php echo $success; ?></div>
<?php } ?>
<div class="box">
  <div class="heading">
    <h1><img src="view/image/module.png" alt="" /> <?php echo $category_heading_title; ?></h1>
    <div class="buttons">
      <a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a>
      <a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a>
    </div>
  </div>
  <div class="content">
    <div id="tabs" class="htabs">
      <a href="#tab-general" class="selected"><?php echo $text_general; ?></a>
    </div>
    <form method="post" action="<?php echo $action; ?>" id="form">
      <input type="hidden" name="category_id" value="<?php echo $category['category_id']; ?>" />
      <div id="tab-general">
      <table class="form">
        <tbody>
          <tr>
            <td><?php echo $entry_category; ?></td>
            <td><input type="text" name="category_title" value="<?php echo $category['category_title']; ?>" /></td>
          </tr>
        </tbody>
      </table>
      </div>
    </form>
  </div>
</div>
<script type="text/javascript"><!--
$('#tabs a').tabs(); 
//$('#languages a').tabs();
//--></script>
<?php echo $footer; ?>