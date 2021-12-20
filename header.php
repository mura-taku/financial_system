<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <!-- Basic Page Needs
  -------------------------------------------------- -->
  <meta <?php bloginfo('charset'); ?>>
  <meta name="description" content="<?php bloginfo('description'); ?>">
  <!-- Mobile Specific Metas
  -------------------------------------------------- -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="<?php echo esc_url(get_theme_file_uri('style.css')); ?>">
  <link rel="stylesheet" href="<?php echo esc_url(get_theme_file_uri('css/style.css')); ?>">
  <?php wp_head(); ?>
</head>