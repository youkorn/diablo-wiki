<?php
/**
 * Plugin Name: Diablo Wiki
 * Description: Gestion des classes Diablo Immortal avec Elementor, import JSON et admin panel.
 * Version: 1.0
 * Author: YouKoRn
 */

if (!defined('ABSPATH')) exit;

define('DW_PATH', plugin_dir_path(__FILE__));
define('DW_URL', plugin_dir_url(__FILE__));

add_action('init', function () {
  register_post_type('diablo_classe', [
    'label'       => 'Classes Diablo',
    'public'      => true,
    'has_archive' => true,
    'rewrite'     => ['slug' => 'classes'],
    'supports'    => ['title', 'editor', 'thumbnail'],
    'menu_icon'   => 'dashicons-shield-alt',
  ]);
});

require_once DW_PATH . 'includes/class-diablo-wiki-importer.php';
require_once DW_PATH . 'includes/class-diablo-wiki-admin-panel.php';
require_once DW_PATH . 'includes/class-diablo-wiki-template-loader.php';
require_once DW_PATH . 'includes/class-diablo-wiki-meta-fields.php';

add_action('plugins_loaded', ['DiabloWiki_Importer', 'init']);
add_action('admin_menu',     ['DiabloWiki_Admin_Panel', 'init']);
add_action('init',           ['DiabloWiki_Template_Loader', 'init']);
add_action('add_meta_boxes', ['DiabloWiki_Meta_Fields', 'init']);
add_action('save_post',      ['DiabloWiki_Meta_Fields', 'save_meta']);

add_action('wp_enqueue_scripts', function () {
  if (is_post_type_archive('diablo_classe') || is_singular('diablo_classe')) {
    wp_enqueue_style('dw-style', DW_URL . 'assets/css/style.css', [], '1.0.0');
    wp_enqueue_script('dw-scripts', DW_URL . 'assets/js/scripts.js', ['jquery'], '1.0.0', true);
  }
});