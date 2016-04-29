<?php
/**
 * @file views-view-unformatted.tpl.php
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
?>
<form action="/" accept-charset="UTF-8" method="post" id="project-nav-form">
<select id="title-nav" onchange="location.href = $('#title-nav').val();">
  <option value="/projects">projects</option>
<?php foreach ($rows as $id => $row): ?>
  <?php print $row; ?>
<?php endforeach; ?>
</select>
</form>