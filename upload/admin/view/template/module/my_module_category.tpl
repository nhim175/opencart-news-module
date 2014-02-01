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
      <a onclick="$('#delete-form').submit();" class="button"><span><?php echo $button_delete; ?></span></a>
      <a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a>
    </div>
  </div>
  <div class="content">
    <form action="<?php echo $action; ?>" method="post" id="form">
      <label for="category_title"><?php echo $entry_category; ?> : </label>
      <input type="text" id="category_title" name="category_title" />
      <input type="hidden" name="action" value="add" />
      <a onclick="$('#form').submit();" class="button"><span><?php echo $button_insert; ?></span></a>
    </form>

    <form action="<?php echo $action; ?>" method="post" id="delete-form">
      <input type="hidden" name="action" value="delete" />
      <table class="list">
        <thead>
            <tr>
              <td width="1" style="text-align: center;">
                <input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
              <td class="left"><?php echo $column_title; ?></td>
              <td class="right"><?php echo $text_action; ?></td>
            </tr>
          </thead>
          <tbody>
            <?php if($categories) : ?>
              <?php foreach ($categories as $category) : ?>
                <tr>
                  <td class="center"><input type="checkbox" name="selected[]" value="<?php echo $category['category_id']; ?>" /></td>
                  <td class="left"><?php echo $category['category_title'] ?></td>
                  <td class="right"><?php foreach ($category['action'] as $action) { ?>
                [ <a href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a> ]
                <?php } ?></td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
      </table>
    </form>
  </div>
</div>

<?php echo $footer; ?>