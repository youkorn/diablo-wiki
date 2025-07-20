<?php get_header(); ?>
<article class="diablo-single">
  <?php if ( have_posts() ) : the_post(); ?>
    <h1><?php the_title(); ?></h1>
    <?php if ($img = get_post_meta(get_the_ID(), '_classe_image', true)) : ?>
      <img src="<?php echo esc_url($img); ?>" alt="<?php the_title(); ?>">
    <?php endif; ?>
    <div class="description">
      <?php echo wpautop(get_post_meta(get_the_ID(), '_classe_desc', true)); ?>
    </div>

    <?php if ($skills = get_post_meta(get_the_ID(), '_classe_skills', true)) : ?>
      <section class="skills">
        <h2>Compétences</h2>
        <?php foreach ($skills as $skill) : ?>
          <div class="skill">
            <img src="<?php echo esc_attr($skill['icon']); ?>" alt="<?php echo esc_attr($skill['name']); ?>">
            <h3><?php echo esc_html($skill['name']); ?></h3>
            <p><?php echo esc_html($skill['description']); ?></p>
          </div>
        <?php endforeach; ?>
      </section>
    <?php endif; ?>
  <?php endif; ?>
</article>
<?php get_footer(); ?>