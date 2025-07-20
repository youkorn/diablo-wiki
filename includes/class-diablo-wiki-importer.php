<?php
if (!defined('ABSPATH')) exit;

class DiabloWiki_Importer {
  const HOOK = 'dw_hourly_import';

  public static function init() {
    add_action('init', [__CLASS__, 'schedule_cron']);
    add_action(self::HOOK, [__CLASS__, 'run_import']);
  }

  public static function schedule_cron() {
    if (!wp_next_scheduled(self::HOOK)) {
      wp_schedule_event(time(), 'hourly', self::HOOK);
    }
  }

  public static function run_import() {
    $token = get_option('dw_blizzard_token');
    $endpoints = get_option('dw_json_endpoints', []);
    foreach ($endpoints as $url) {
      $response = wp_remote_get("{$url}?access_token={$token}");
      if (is_wp_error($response)) continue;
      $data = json_decode(wp_remote_retrieve_body($response), true);
      if (empty($data['classes'])) continue;
      foreach ($data['classes'] as $item) {
        self::create_or_update_class($item);
      }
    }
  }

  private static function create_or_update_class($item) {
    $slug = sanitize_title($item['name']);
    $exists = get_posts(['post_type' => 'diablo_classe', 'name' => $slug]);
    $post_id = $exists ? $exists[0]->ID : wp_insert_post([
      'post_type' => 'diablo_classe',
      'post_title' => $item['name'],
      'post_name' => $slug,
      'post_status' => 'publish',
    ]);
    update_post_meta($post_id, '_classe_image', $item['assets']['image']);
    update_post_meta($post_id, '_classe_desc', $item['flavor_text']);
    update_post_meta($post_id, '_classe_skills', $item['skills']);
  }
}