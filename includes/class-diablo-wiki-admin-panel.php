<?php
if (!defined('ABSPATH')) exit;

class DiabloWiki_Admin_Panel {
  public static function init() {
    add_menu_page('Diablo Wiki', 'Diablo Wiki', 'manage_options', 'dw-settings', [__CLASS__, 'render_settings_page'], 'dashicons-book', 61);
    add_action('admin_init', [__CLASS__, 'register_settings']);
  }

  public static function register_settings() {
    register_setting('dw_options', 'dw_blizzard_token');
    register_setting('dw_options', 'dw_json_endpoints');

    add_settings_section('dw_section_api', 'API & Endpoints JSON', null, 'dw-settings');

    add_settings_field('dw_blizzard_token', 'Token Blizzard', [__CLASS__, 'field_token'], 'dw-settings', 'dw_section_api');
    add_settings_field('dw_json_endpoints', 'Endpoints JSON', [__CLASS__, 'field_endpoints'], 'dw-settings', 'dw_section_api');
  }

  public static function field_token() {
    echo '<input type="text" name="dw_blizzard_token" value="' . esc_attr(get_option('dw_blizzard_token')) . '" class="regular-text" />';
  }

  public static function field_endpoints() {
    $eps = get_option('dw_json_endpoints', ["https://api.blizzard.com/data/d3/class/index"]);
    echo '<textarea name="dw_json_endpoints" rows="5" class="large-text">' . esc_textarea(implode("\n", $eps)) . '</textarea>';
  }

  public static function render_settings_page() {
    if (isset($_POST['run_dw_import'])) {
      DiabloWiki_Importer::run_import();
      echo '<div class="updated"><p>Import manuel terminé.</p></div>';
    }
    ?>
    <div class="wrap">
      <h1>Diablo Wiki – Paramètres</h1>
      <form method="post" action="options.php">
        <?php settings_fields('dw_options'); do_settings_sections('dw-settings'); submit_button(); ?>
      </form>
      <form method="post"><?php submit_button('Importer maintenant', 'primary', 'run_dw_import'); ?></form>
    </div>
    <?php
  }
}