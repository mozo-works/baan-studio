<?php
/**
 * @file views-view-unformatted.tpl.php
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
?>
<form action="/" accept-charset="UTF-8" method="post" id="media-nav-form">
<select id="work-title-nav" onchange="location.href = $('#work-title-nav').val();">
  <option value="/medias">types</option>
<?php foreach ($rows as $id => $row): ?>
  <?php print $row; ?>
<?php endforeach; ?>
</select>
</form>