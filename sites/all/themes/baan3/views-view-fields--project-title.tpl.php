<?php
/**
 * @file views-view-fields.tpl.php
 * Default simple view template to all the fields as a row.
 *
 * - $view: The view in use.
 * - $fields: an array of $field objects. Each one contains:
 *   - $field->content: The output of the field.
 *   - $field->raw: The raw data for the field, if it exists. This is NOT output safe.
 *   - $field->class: The safe class id to use.
 *   - $field->handler: The Views field handler object controlling this field. Do not use
 *     var_export to dump this object, as it can't handle the recursion.
 *   - $field->inline: Whether or not the field should be inline.
 *   - $field->inline_html: either div or span based on the above flag.
 *   - $field->wrapper_prefix: A complete wrapper containing the inline_html to use.
 *   - $field->wrapper_suffix: The closing tag for the wrapper.
 *   - $field->separator: an optional separator that may appear before a field.
 *   - $field->label: The wrap label text to use.
 *   - $field->label_html: The full HTML of the label to use including
 *     configured element type.
 * - $row: The raw result object from the query, with all data it fetched.
 *
 * @ingroup views_templates
 */

/**
* foreach ($fields as $id => $field) {
*  print_r($field->raw);
* }
*/
// $view2 = views_get_view('project');
// $view2->execute_display('page_1');
// $items_per_page = $view2->display_handler->options['pager']['options']['items_per_page'];
// $page_num = ($view2->total_rows - $row->nodequeue_nodes_node_position - 1) / $items_per_page;
?>
<option value="/project/<?php print $fields['nid']->raw; ?>"><?php print $fields['title']->raw; ?></option>
