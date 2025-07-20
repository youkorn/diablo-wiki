<?php get_header(); ?>
<div class="diablo-grid">
  <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <a href="<?php the_permalink(); ?>" class="diablo-card">
      <?php the_post_thumbnail('medium'); ?>
      <h2><?php the_title(); ?></h2>
      <hr>
      <p><?php echo wp_trim_words(get_post_meta(get_the_ID(), '_classe_desc', true), 20); ?></p>
    </a>
  <?php endwhile; endif; ?>
</div>
<?php get_footer(); ?>