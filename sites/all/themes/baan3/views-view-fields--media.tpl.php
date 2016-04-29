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

/*   print_r($fields['field_work_cover_fid']); */

  // get image width
  $file = field_file_load($fields['field_work_cover_fid']->raw);
  $image = image_get_info($file['filepath']);
  $width = ($image['width']) ? $image['width'] + 2 : 220;
  print '<div style="width:'. $width . 'px;">';

  /** $image!
  [width] => 158
  [height] => 236
  [extension] => jpg
  [file_size] => 60042
  [mime_type] => image/jpeg
  */

/*   print_r(array_keys(get_defined_vars())); */
  $page = $view->query->pager->current_page;
?>

<?php foreach ($fields as $id => $field): ?>
  <?php if (!empty($field->separator)): ?>
    <?php print $field->separator; ?>
  <?php endif; ?>

  <?php
  if($id == 'title') {
    $path2 = $field->handler->options['alter']['path'] .= '?page='.$page;
  }
  ?>

  <?php print $field->wrapper_prefix; ?>
    <?php print $field->label_html; ?>
    <?php if ($id == 'field_work_cover_fid'): ?>
    <a href="/media/<?php print $row->nid; ?>"><img src="/<?php print $file['filepath'] ?>" /></a>
    <?php endif; ?>
    <?php if ($id == 'title'): ?>
    <a href="/media/<?php print $row->nid; ?>"><?php print $fields['title']->raw ?></a>
    <?php endif; ?>
  <?php print $field->wrapper_suffix; ?>
<?php endforeach; ?>
</div>
