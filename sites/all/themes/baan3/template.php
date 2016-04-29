<?php
// $Id: template.php,v 1.4 2009/07/13 23:52:57 andregriffin Exp $

/**
 * Sets the body-tag class attribute.
 *
 * Adds 'sidebar-left', 'sidebar-right' or 'sidebars' classes as needed.
 */
function baan3_body_class($left, $right) {
  $class = array();

  if ($left != '' && $right != '') {
    $class[] = 'sidebars';
  }
  elseif ($left != '') {
    $class[] = 'sidebar-left';
  }
  elseif ($right != '') {
    $class[] = 'sidebar-right';
  }

  if ((arg(0) == 'admin') or (user_access('administer'))) {
    $class[] = 'admin';
  }

  if ((arg(0) == 'projects') && (!arg(1))) {
  	$class[] = 'page-project';
  }

  $alias = drupal_get_path_alias($_GET['q']);
  foreach (explode('/', $alias) as $path_part) {
    $class[] = (is_numeric($path_part)) ? 'node-'.$path_part : $path_part;
  }

  if ($class) {
    print ' class="' . implode(' ', $class) . '"';
  }
}

/**
 * Return a themed breadcrumb trail.
 *
 * @param $breadcrumb
 *   An array containing the breadcrumb links.
 * @return a string containing the breadcrumb output.
 */
function phptemplate_breadcrumb($breadcrumb) {
  if (!empty($breadcrumb)) {
  //uncomment the next line to enable current page in the breadcrumb trail
    $breadcrumb[] = drupal_get_title();
  //return '<div class="breadcrumb">'. implode(' » ', $breadcrumb) .'</div>';

    global $user;
    $link = '';
    if (arg(0) == 'node') {
      if (in_array('administrator', array_values($user->roles))) {
        $link = '<a class="custom-edit" href="/node/'. arg(1) .'/edit">edit</a>';
      }

      $node = node_load(array('nid' => arg(1)));
      $types = array('project' => 'projects', 'work' => 'medias', 'page' => '/');
	    $list = (array_key_exists($node->type, $types)) ? $types[$node->type] : '';
	    $page = (is_numeric($_GET['page'])) ? '/?page='.$_GET['page'] : '';

      if ($list !== '/') {
		    return '<div class="breadcrumb"><a href="/'. $list . $page .'">↑ </a>'. $link .'</div>';
	    }


/*
	    else {
	      return '<div class="breadcrumb"><a href="/project/'. $node->field_project_ref[0]['nid'] .'">↑ </a>'. $link .'</div>';
	    }
*/
    }
  }
}

/**
 * Allow themable wrapping of all comments.
 */
function baan3_comment_wrapper($content, $node) {
  if (!$content || $node->type == 'forum') {
    return '<div id="comments">'. $content .'</div>';
  }
  else {
    return '<div id="comments"><h2 class="comments">'. t('Comments') .'</h2>'. $content .'</div>';
  }
}

/**
 * Override or insert PHPTemplate variables into the templates.
 */
function baan3_preprocess_page(&$vars) {
  $vars['tabs2'] = menu_secondary_local_tasks();
  // Hook into color.module
  if (module_exists('color')) {
    _color_page_alter($vars);
  }
  if (isset($vars['node'])) {
    $vars['template_files'][] = 'page-'.$vars['node']->type;
  }
}

/**
 * Returns the rendered local tasks. The default implementation renders
 * them as tabs. Overridden to split the secondary tasks.
 *
 * @ingroup themeable
 */
function phptemplate_menu_local_tasks() {
  return menu_primary_local_tasks();
}

function baan3_comment_submitted($comment) {
  return t('by <strong>!username</strong> | !datetime',
    array(
      '!username' => theme('username', $comment),
      '!datetime' => format_date($comment->timestamp)
    ));
}

function phptemplate_node_submitted($node) {
  return t('!datetime | by <strong>!username</strong>',
    array(
      '!username' => theme('username', $node),
      '!datetime' => format_date($node->created),
    ));
}

/**
 * Override or insert variables into the block templates.
	*
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("block" in this case.)
 */
function baan3_preprocess_block(&$vars, $hook) {
  $block = $vars['block'];

  // Special classes for blocks.
  $classes = array('block');
  $classes[] = 'block-' . $block->module;
  $classes[] = 'region-' . $vars['block_zebra'];
  $classes[] = $vars['zebra'];
  $classes[] = 'region-count-' . $vars['block_id'];
  $classes[] = 'count-' . $vars['id'];

  $vars['edit_links_array'] = array();
  $vars['edit_links'] = '';
  if (user_access('administer blocks')) {
    include_once './' . drupal_get_path('theme', 'baan3') . '/template.block-editing.inc';
    baan3_preprocess_block_editing($vars, $hook);
    $classes[] = 'with-block-editing';
  }

  // Render block classes.
  $vars['classes'] = implode(' ', $classes);

  // paging!
/*
  if($block->module == 'prev_next') {
    $view = views_get_view('project');
    $view->build();
    $total = $view->query->pager->total_items + 1;
    $page = '';
    $page = (int) $page = ($total - $row->nodequeue_nodes_node_position) / 12;
    $vars['block']->test = array($total);
  }
*/



}

/**
 * Generates IE CSS links.
 */
function baan3_get_ie_styles() {
  $iecss = '<link type="text/css" rel="stylesheet" media="all" href="'. base_path() . path_to_theme() .'/ie.css" />';
  return $iecss;
}

function baan3_get_ie6_styles() {
  $iecss = '<link type="text/css" rel="stylesheet" media="all" href="'. base_path() . path_to_theme() .'/ie6.css" />';
  return $iecss;
}

/**
 * Adds even and odd classes to <li> tags in ul.menu lists
 */
function phptemplate_menu_item($link, $has_children, $menu = '', $in_active_trail = FALSE, $extra_class = NULL) {
  static $zebra = FALSE;
  $zebra = !$zebra;
  $class = ($menu ? 'expanded' : ($has_children ? 'collapsed' : 'leaf'));
  if (!empty($extra_class)) {
    $class .= ' '. $extra_class;
  }
  if ($in_active_trail) {
    $class .= ' active-trail';
  }
  if ($zebra) {
    $class .= ' even';
  }
  else {
    $class .= ' odd';
  }
  return '<li class="'. $class .'">'. $link . $menu ."</li>\n";
}


/**
* Override or insert PHPTemplate variables into the search_theme_form template.
*
* @param $vars
*   A sequential array of variables to pass to the theme template.
* @param $hook
*   The name of the theme function being called (not used in this case.)
*/
function baan3_preprocess_search_theme_form(&$vars, $hook) {
  // Remove the "Search this site" label from the form.
  $vars['form']['search_theme_form']['#title'] = t('Search');

  // Set a default value for text inside the search box field.
  $vars['form']['search_theme_form']['#value'] = '';

  // Add a custom class and placeholder text to the search box.
  $vars['form']['search_theme_form']['#attributes'] = array('class' => 'NormalTextBox txtSearch', 'onblur' => "if (this.value == '') {this.value = '".$vars['form']['search_block_form']['#value']."';} ;", 'onfocus' => "if (this.value == '".$vars['form']['search_block_form']['#value']."') {this.value = '';} ;" );

  // Change the text on the submit button
  $vars['form']['submit']['#value'] = t('search');

  // Rebuild the rendered version (search form only, rest remains unchanged)
  unset($vars['form']['search_theme_form']['#printed']);
  $vars['search']['search_theme_form'] = drupal_render($vars['form']['search_theme_form']);

  // $vars['form']['submit']['#type'] = 'image_button';
  // $vars['form']['submit']['#src'] = path_to_theme() . '/images/search.jpg';

  // Rebuild the rendered version (submit button, rest remains unchanged)
  unset($vars['form']['submit']['#printed']);
  $vars['search']['submit'] = drupal_render($vars['form']['submit']);

  // Collect all form elements to make it easier to print the whole form.
  $vars['search_form'] = implode($vars['search']);
}


function baan3_pager($tags = array(), $limit = 10, $element = 0, $parameters = array(), $quantity = 9) {
  global $pager_page_array, $pager_total;

  // Calculate various markers within this pager piece:
  // Middle is used to "center" pages around the current page.
  $pager_middle = ceil($quantity / 2);
  // current is the page we are currently paged to
  $pager_current = $pager_page_array[$element] + 1;
  // first is the first page listed by this pager piece (re quantity)
  $pager_first = $pager_current - $pager_middle + 1;
  // last is the last page listed by this pager piece (re quantity)
  $pager_last = $pager_current + $quantity - $pager_middle;
  // max is the maximum page number
  $pager_max = $pager_total[$element];
  // End of marker calculations.

  // Prepare for generation loop.
  $i = $pager_first;
  if ($pager_last > $pager_max) {
    // Adjust "center" if at end of query.
    $i = $i + ($pager_max - $pager_last);
    $pager_last = $pager_max;
  }
  if ($i <= 0) {
    // Adjust "center" if at start of query.
    $pager_last = $pager_last + (1 - $i);
    $i = 1;
  }
  // End of generation loop preparation.

  // $li_first = theme('pager_first', (isset($tags[0]) ? $tags[0] : t('« first')), $limit, $element, $parameters);
  $li_previous = theme('pager_previous', (isset($tags[1]) ? $tags[1] : t('←')), $limit, $element, 1, $parameters);
  $li_next = theme('pager_next', (isset($tags[3]) ? $tags[3] : t('→')), $limit, $element, 1, $parameters);
  // $li_last = theme('pager_last', (isset($tags[4]) ? $tags[4] : t('last »')), $limit, $element, $parameters);

  if ($pager_total[$element] > 1) {
/*
    if ($li_first) {
      $items[] = array(
        'class' => 'pager-first',
        'data' => $li_first,
      );
    }
*/
    if ($li_previous) {
      $items[] = array(
        'class' => 'pager-previous',
        'data' => $li_previous,
      );
    }
    else {
      $items[] = array(
        'class' => 'pager-previous',
        'data' => '←',
      );
    }

    // When there is more than one page, create the pager list.
    if ($i != $pager_max) {
      if ($i > 1) {
        $items[] = array(
          'class' => 'pager-ellipsis',
          'data' => '…',
        );
      }

      $selector = '•';

      // Now generate the actual pager piece.
      for (; $i <= $pager_last && $i <= $pager_max; $i++) {
        if ($i < $pager_current) {
          $items[] = array(
            'class' => 'pager-item',
            'data' => theme('pager_previous', $selector, $limit, $element, ($pager_current - $i), $parameters),
          );
        }
        if ($i == $pager_current) {
          $items[] = array(
            'class' => 'pager-current',
            'data' => $selector,
          );
        }
        if ($i > $pager_current) {
          $items[] = array(
            'class' => 'pager-item',
            'data' => theme('pager_next', $selector, $limit, $element, ($i - $pager_current), $parameters),
          );
        }
      }
      if ($i < $pager_max) {
        $items[] = array(
          'class' => 'pager-ellipsis',
          'data' => '…',
        );
      }
    }
    // End generation.
    if ($li_next) {
      $items[] = array(
        'class' => 'pager-next',
        'data' => $li_next,
      );
    }
    else {
      $items[] = array(
        'class' => 'pager-next',
        'data' => '→',
      );
    }
/*
    if ($li_last) {
      $items[] = array(
        'class' => 'pager-last',
        'data' => $li_last,
      );
    }
*/
    $pages = array();
    foreach($items as $field) {
      if($field['class'] == 'pager-item' || $field['class'] == 'pager-current') {
        $pages[] = $field;
      }
    }

    $pages = theme('item_list', $pages, NULL, 'ul', array('class' => 'pager'));
    $output = array( 'data' => array($items[0], $pages, $items[count($items)-1]));

    return '<div id="baan_pager_wrapper" class="clearfix">'. theme('table', NULL, $output, array('class' => 'baan_pager'), NULL) . '</div>';
  }
}


function baan3_content_view_multiple_field($items, $field, $values) {
  $output = '';
  switch($field['field_name']) {
    // display img title of each image
    case 'field_work_img':
      foreach ($items as $item) {
        if (!empty($item) || $item == '0') {
          $obj = new SimpleXMLElement($item);
          $html = $obj->img;
          $desc = $html['title'];
	        $output .= '<div class="field-item">'. $item . '<span class="image-desc">'. $desc .'</span></div>';
	      }
	    }
      break;

    default:
      foreach ($items as $item) {
        if (!empty($item) || $item == '0') {
	       $output .= '<div class="field-item">'. $item .'</div>';
	      }
      }
      break;
  }
  return $output;
}
/*

function baan3_preprocess_views_view_field(&$vars) {
  print '<h1>hooked!</h1>';
  if($vars['view']->name == 'project') {
    $page = $view->query->pager->current_page;
    $vars['field']->options['alter']['path'] .= '?page='.$page;
  }
}
*/


/**
* Override or insert variables into the node templates.
*
* @param $vars
*   An array of variables to pass to the theme template.
* @param $hook
*   The name of the template being rendered ("node" in this case.)
*/
function baan3_preprocess_node(&$vars, $hook) {
  $node = $vars['node'];
  $vars['template_file'] = 'node-'. $node->nid;
}
