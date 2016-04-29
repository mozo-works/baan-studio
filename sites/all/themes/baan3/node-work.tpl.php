<?php
// $Id: node.tpl.php,v 1.4 2009/07/13 23:52:58 andregriffin Exp $

/* $content */
?>
<div id="node-<?php print $node->nid; ?>" class="node<?php if ($sticky) { print ' sticky'; } ?><?php if (!$status) { print ' node-unpublished'; } ?>">

  <?php print $picture ?>

  <?php if ($page == 0): ?>
    <h2><a href="<?php print $node_url ?>" title="<?php print $title ?>"><?php print $title ?></a></h2>
  <?php endif; ?>

  <?php if ($submitted): ?>
    <span class="submitted"><?php print $submitted; ?></span>
  <?php endif; ?>

  <div class="content">
    <?php
      print $node->content['body']['#value'];
      $images = $node->field_work_img;
      foreach($images as $image) {
        print '<div class="work-img-row">'. $image['view'].'<div class="image-desc">'. $image['data']['title']. '</div></div>';
      }
    ?>
  </div>


</div>
