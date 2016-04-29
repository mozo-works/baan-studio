<?php

$info = array(
  // Pre-defined color schemes.
  'schemes' => array(
    // base color, link color, top header, bottom header, text color
    '#000000, #006699, #006699, #006699, #000000' => t('Plain (Default)'),
    '#006699, #006699, #000000, #000000, #006699' => t('Dark Blue'),
/*     '' => t('Hot Pink'), */
  ),

  // Images to copy over.
  'copy' => array(
    'images/menu-collapsed.gif',
    'images/menu-collapsed-rtl.gif',
    'images/menu-expanded.gif',
    'images/menu-leaf.gif',
  ),

  // CSS files (excluding @import) to rewrite with new color scheme.
  'css' => array(
    'style.css',
  ),

  // Coordinates of gradient (x, y, width, height).
  'gradient' => array(0, 37, 760, 121),

  // Color areas to fill (x, y, width, height).
  'fill' => array(
    'base' => array(0, 0, 760, 568),
    'link' => array(107, 533, 41, 23),
  ),
  
  // Reference color used for blending. Matches the base.png's colors.
  'blend_target' => '#ffffff',

  // Preview files.
  'preview_image' => 'color/preview.png',
  'preview_css' => 'color/preview.css',

  // Base file for image generation.
  'base_image' => 'color/base.png',
  
);