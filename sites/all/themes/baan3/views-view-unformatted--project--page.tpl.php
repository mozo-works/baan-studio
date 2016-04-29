<?php
// $Id: views-view-unformatted.tpl.php,v 1.6 2008/10/01 20:52:11 merlinofchaos Exp $
/**
 * @file views-view-unformatted.tpl.php
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
 
/* print (($id + 1) % 4 ? '' : ' grid-end'); */
?>
<?php if (!empty($title)): ?>
  <h3><?php print $title; ?></h3>
<?php endif; ?>
<?php foreach ($rows as $id => $row): ?>
  <div class="<?php print $classes[$id]; ?>">
    <?php print $row; ?>
  </div>
<?php endforeach; ?>

<?php
/*
    [0] => template_file
    [1] => variables
    [2] => template_files
    [3] => view
    [4] => options
    [5] => rows
    [6] => title
    [7] => zebra
    [8] => id
    [9] => directory
    [10] => is_admin
    [11] => is_front
    [12] => logged_in
    [13] => db_is_active
    [14] => user
    [15] => classes
    [16] => row
    
    $view->result
      0 -> object
      
    [nid] => 180
    [node_data_field_cover_field_cover_fid] => 1250
    [node_data_field_cover_field_cover_list] => 1
    [node_data_field_cover_field_cover_data] => a:2:{s:3:"alt";s:0:"";s:5:"title";s:0:"";}
    [node_type] => project
    [node_vid] => 180
    [node_title] => • 2011 HERMÈS FOUNDATION MISSULSANG
    [nodequeue_nodes_node_position] => 56
    
    print_r(array_keys(get_defined_vars()));

    print_r($view->result);
*/

/*     print_r($view->query->pager->current_page); */
?>