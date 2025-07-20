<?php
if (!defined('ABSPATH')) exit;

class DiabloWiki_Template_Loader {
  public static function init() {
    add_filter('template_include', [__CLASS__, 'load_templates']);
  }

  public static function load_templates($template) {
    if (is_post_type_archive('diablo_classe')) return DW_PATH . 'templates/page-classes-grid.php';
    if (is_singular('diablo_classe')) return DW_PATH . 'templates/page-classes-single.php';
    return $template;
  }
}