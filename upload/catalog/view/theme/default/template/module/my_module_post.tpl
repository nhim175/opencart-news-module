<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <h1><?php echo $heading_title; ?></h1>
  <div class="post-content">
  <?php echo $post['post_content']; ?>

    <?php if ($related_posts): ?>
    <div class="related-posts">
      <h2><?php echo $text_related; ?></h2>
      <ul>
      <?php foreach ($related_posts as $p): ?>
        <li><a href="<?php echo $p['post_link']; ?>"><?php echo $p['post_title']; ?></a></li>
      <?php endforeach ?>
      </ul>
    </div>  
    <?php endif ?>
    
  </div>
  <?php echo $content_bottom; ?></div>
<?php echo $footer; ?>