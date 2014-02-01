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
    <h1><img src="view/image/module.png" alt="" /> <?php echo $post_heading_title; ?></h1>
    <div class="buttons">
      <a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a>
      <a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a>
    </div>
  </div>
  <div class="content">
    <div id="tabs" class="htabs">
      <a href="#tab-general" class="selected"><?php echo $text_general; ?></a>
      <a href="#tab-data" class="selected"><?php echo $text_data; ?></a>
    </div>
    <form method="post" action="<?php echo $action; ?>" id="form">
      <input type="hidden" name="post_id" value="<?php echo $post['post_id']; ?>" />
      <input type="hidden" name="action" value="update" />
      <div id="tab-general">
        <table class="form">
          <tbody>
            <tr>
              <td><?php echo $entry_post_title; ?></td>
              <td><input type="text" name="post_title" value="<?php echo $post['post_title']; ?>" size="100" /></td>
            </tr>
            <tr>
              <td><?php echo $entry_post_content; ?></td>
              <td><textarea id="post_content" name="post_content"><?php echo $post['post_content']; ?></textarea></td>
            </tr>
            <tr>
              <td><?php echo $entry_post_status; ?></td>
              <td>
                <select name="status">
                  <option value="0" <?php if($post['status'] == 0) echo 'selected'; ?>>Disable</option>
                  <option value="1" <?php if($post['status'] == 1) echo 'selected'; ?>>Enable</option>
                </select>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div id="tab-data">
        <table class="form">
          <tbody>
            <tr>
              <td><?php echo $entry_image; ?></td>
              <td>
                <div class="image"><img src="<?php echo $post['thumb']; ?>" alt="" id="thumb" /><br />
                <input type="hidden" name="post_img" value="<?php echo $post['post_img']; ?>" id="image" />
                <a onclick="image_upload('image', 'thumb');"><?php echo $text_browse; ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a onclick="$('#thumb').attr('src', '<?php echo $no_image; ?>'); $('#image').attr('value', '');"><?php echo $text_clear; ?></a></div>    
              </td>
            </tr>
            <tr>
              <td><?php echo $entry_category; ?></td>
              <td>
                <select name="category_id">
                <?php foreach ($categories as $category): ?>
                  <option value="<?php echo $category['category_id']; ?>" <?php if($category['category_id'] == $post['category_id']) echo 'selected' ?>><?php echo $category['category_title']; ?></option>
                <?php endforeach ?>
                </select>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </form>
  </div>
</div>
<script type="text/javascript" src="view/javascript/ckeditor/ckeditor.js"></script> 
<script type="text/javascript">
CKEDITOR.replace('post_content', {
  filebrowserBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
  filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
  filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
  filebrowserUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
  filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
  filebrowserFlashUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>'
});
</script>
<script type="text/javascript"><!--
$('#tabs a').tabs(); 
//$('#languages a').tabs();
//--></script>
<script type="text/javascript">
function image_upload(field, thumb) {
  $('#dialog').remove();
  
  $('#content').prepend('<div id="dialog" style="padding: 3px 0px 0px 0px;"><iframe src="index.php?route=common/filemanager&token=<?php echo $token; ?>&field=' + encodeURIComponent(field) + '" style="padding:0; margin: 0; display: block; width: 100%; height: 100%;" frameborder="no" scrolling="auto"></iframe></div>');
  
  $('#dialog').dialog({
    title: '<?php echo $text_image_manager; ?>',
    close: function (event, ui) {
      if ($('#' + field).attr('value')) {
        $.ajax({
          url: 'index.php?route=common/filemanager/image&token=<?php echo $token; ?>&image=' + encodeURIComponent($('#' + field).attr('value')),
          dataType: 'text',
          success: function(text) {
            $('#' + thumb).replaceWith('<img src="' + text + '" alt="" id="' + thumb + '" />');
          }
        });
      }
    },  
    bgiframe: false,
    width: 800,
    height: 400,
    resizable: false,
    modal: false
  });
};
</script> 
<?php echo $footer; ?>