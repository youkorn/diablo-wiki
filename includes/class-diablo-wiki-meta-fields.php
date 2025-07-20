<?php
if (!defined('ABSPATH')) exit;

class DiabloWiki_Meta_Fields {
  public static function init() {
    add_meta_box('dw_classe_details', 'Détails de la classe', [__CLASS__, 'render_box'], 'diablo_classe', 'normal', 'high');
  }

  public static function render_box($post) {
    wp_nonce_field('dw_meta_nonce', 'dw_meta_nonce');
    $image = get_post_meta($post->ID, '_classe_image', true);
    $desc = get_post_meta($post->ID, '_classe_desc', true);
    ?>
    <p><label>Image :</label><br><input type="text" name="dw_classe_image" value="<?php echo esc_attr($image); ?>" style="width:100%;" /></p>
    <p><label>Description :</label><br><textarea name="dw_classe_desc" rows="4" style="width:100%;"><?php echo esc_textarea($desc); ?></textarea></p>
    <?php
  }

  public static function save_meta($post_id) {
    if (!isset($_POST['dw_meta_nonce']) || !wp_verify_nonce($_POST['dw_meta_nonce'], 'dw_meta_nonce') || (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)) return;
    if (isset($_POST['dw_classe_image'])) update_post_meta($post_id, '_classe_image', sanitize_text_field($_POST['dw_classe_image']));
    if (isset($_POST['dw_classe_desc'])) update_post_meta($post_id, '_classe_desc', sanitize_textarea_field($_POST['dw_classe_desc']));
  }
}