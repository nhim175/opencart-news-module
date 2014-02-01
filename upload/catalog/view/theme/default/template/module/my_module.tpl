<!--  DIY Module Builder By HostJars http://opencart.hostjars.com -->
<div class="box">
  <div class="box-heading"><?php echo $heading_title; ?></div>
  <div class="box-content" style="text-align: center;">
  <?php foreach ($posts as $post): ?>
    <div class="post">
      <h2><?php echo $post['post_title']; ?></h2>
      <div class="post-thumb">
        <img src="<?php echo $post['post_img']; ?>" />
      </div>
      <div class="post-description">
        <?php echo $post['post_description']; ?>
      </div>
      <p class="read-more"><a href="<?php echo $post['post_link']; ?>"><?php echo $text_readmore; ?></a></p>
    </div>
  <?php endforeach ?>
  </div>
</div>
<!--  /DIY Module Builder By HostJars http://opencart.hostjars.com -->