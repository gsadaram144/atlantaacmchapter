<?php
/**
 * ACM Atlanta — Fallback Index Template
 * WordPress requires this file to exist.
 * Specific page templates live in /page-templates/
 */
get_header(); ?>

<main id="main-content" class="site-main">
    <div class="container">
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>">
                <h1><?php the_title(); ?></h1>
                <div class="entry-content"><?php the_content(); ?></div>
            </article>
        <?php endwhile; endif; ?>
    </div>
</main>

<?php get_footer(); ?>