<?php
// $Id: page.tpl.php,v 1.4 2009/07/13 23:52:58 andregriffin Exp $
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" 
  "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language ?>" >
  <head>
    <title><?php print $node->title; ?> | BAAN</title>
    <?php print $head ?>
	  <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
    <?php print $styles ?>
    <?php print $scripts ?>
    <meta name="title" content="<?php print $node->title; ?> | BAAN" />
    <meta name="description" content="<?php print strip_tags($node->content['body']['#value']);?>" />
    <meta name="keywords" content="김성렬, 김성열, 반, 반스튜디오, 반그래픽스, Sungyeol Kim, Baan, Baanstudio, Baangraphics" />
    <meta property="og:title" content="<?php print $node->title; ?> | BAAN" />
    <meta property="og:description" content="<?php print strip_tags($node->content['body']['#value']);?>" />
    <meta property="og:image_src" content="http://baanstudio.com/<?php print $node->field_work_cover[0]['filepath']?>" />
    <!--[if lte IE 7]><?php print baan3_get_ie_styles(); ?><![endif]--> <!--If Less Than or Equal (lte) to IE 7-->
  </head>
  <body<?php print baan3_body_class($left, $right); ?>>
    <!-- Layout -->
    <div class="container"> <!-- add showgrid16 "showgrid12" class to display grid -->
      <div id="header" class="clearfix">
        <?php print $header; ?>
        <div id="sitename">
			    <?php if ($site_name): ?>
          <h1><a href="<?php print check_url($front_page); ?>" title="<?php print check_plain($site_name); ?>"><?php print check_plain($site_name); ?></a></h1>
          <?php endif; ?>
        </div> <!-- /#sitename -->
        <div id="project-nav">
        <?php
          //$block = module_invoke('prev_next', 'block', 'view', '0');
          $block = module_invoke('views', 'block', 'view', 'project_title-block_1');
          print $block['content'];
        ?>
        </div>
        <div id="media-nav">
        <?php
          //$block = module_invoke('prev_next', 'block', 'view', '0');
          $block = module_invoke('views', 'block', 'view', 'work_title-block_1');
          print $block['content'];
        ?>
        </div>
        <?php if (!$search_box): ?><?php print $search_box ?><?php endif; ?>
        <div id="about"><a href="/info">info</a></div>
      </div> <!-- /#header -->

      <div id="nav">
        <?php if ($nav): ?>
          <?php print $nav ?>
        <?php endif; ?>

        <?php if (!$nav): ?> <!-- if block in $nav, overrides default $primary and $secondary links -->

          <?php if (isset($primary_links)) : ?>
            <?php print theme('links', $primary_links, array('class' => 'links primary-links')) ?>
          <?php endif; ?>
          <?php if (isset($secondary_links)) : ?>
            <div id="secondary-links"><?php print theme('links', $secondary_links, array('class' => 'links secondary-links')) ?></div>
          <?php endif; ?>

        <?php endif; ?>
      </div> <!-- /#nav -->
  
      <div class="project-header clearfix">
        <div class="project-title">
          <?php print $breadcrumb; ?>
          <?php $title = $node->title; ?>
          <?php if ($title): print '<h2'. ($tabs ? ' class="with-tabs"' : '') .'>'. $title .'</h2>'; endif; ?>
          <?php
/*             print_r(array_keys($node->content['group_header']['group'])); */
            
            print $node->content['group_header']['#children'];
/*
            $test = $node->content['group_header'];
            $test['#printed'] = NULL;
            var_dump($test['#printed']);
*/
          ?>
        </div>
        <div class="nav-next">
          <?php
            $block = module_invoke('prev_next', 'block', 'view', '0');
            print $block['content'];
          ?>
        </div>
        <div class="nav-prev">
          <?php
            $block = module_invoke('prev_next', 'block', 'view', '1');
            print $block['content'];
          ?>
        </div>
      </div>
      
			<?php if ($left): ?>
        <div id="sidebar-left" class="sidebar">
          <?php print $left ?>
        </div> <!-- /#sidebar-left -->
      <?php endif; ?>

      <div id="main">
        <!-- <?php print $breadcrumb; ?>  -->
        <?php if ($mission): print '<div id="mission">'. $mission .'</div>'; endif; ?>
        <!-- title 
        <?php if ($title): print '<h2'. ($tabs ? ' class="with-tabs"' : '') .'>'. $title .'</h2>'; endif; ?>
        -->
        <?php if ($tabs): print '<div id="tabs-wrapper" class="clear-block"><ul class="tabs primary">'. $tabs .'</ul>'; endif; ?>
        <?php if ($tabs2): print '<ul class="tabs secondary">'. $tabs2 .'</ul>'; endif; ?>
        <?php if ($tabs): print '<span class="clear"></span></div>'; endif; ?>
        <?php if ($show_messages && $messages): print $messages; endif; ?>
        <?php print $help; ?>
        <?php print $content ?>
      </div> <!-- /#main -->

      <?php if ($right): ?>
        <div id="sidebar-right" class="sidebar">
          <?php print $right ?>
        </div> <!-- /#sidebar-right -->
      <?php endif; ?>
      
      <?php if ($contentFooter): ?>
        <div id="content-footer">
        	<?php print $contentFooter; ?>
        </div>
      <?php endif; ?>

      <div id="footer" class="clear">
        <?php print $footer_message . $footer ?>
        <?php print $feed_icons ?>
      </div> <!-- /#footer -->

    </div> <!-- /.container -->

    <!-- /layout -->
  <?php print $closure ?>

  </body>
</html>