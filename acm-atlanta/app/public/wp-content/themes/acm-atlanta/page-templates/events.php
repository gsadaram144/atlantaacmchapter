<?php
/**
 * Template Name: Events Page
 * ACM Atlanta — Events listing with paginated upcoming and past sections.
 * Assign via WP Admin → Pages → Edit → Page Attributes → Template → Events Page
 */
get_header();

$today         = date('Y-m-d');
$per_page      = 3;
$upcoming_page = max( 1, absint( $_GET['upcoming_page'] ?? 1 ) );
$past_page     = max( 1, absint( $_GET['past_page']     ?? 1 ) );

// ── Upcoming: soonest first ──────────────────────────────────────
$upcoming = new WP_Query([
    'post_type'      => 'acm_event',
    'posts_per_page' => $per_page,
    'paged'          => $upcoming_page,
    'meta_key'       => '_event_date',
    'orderby'        => 'meta_value',
    'order'          => 'ASC',
    'meta_query'     => [[
        'key'     => '_event_date',
        'value'   => $today,
        'compare' => '>=',
        'type'    => 'DATE',
    ]],
]);
$upcoming_pages = $upcoming->max_num_pages;

// ── Past: most recently completed first ─────────────────────────
$past = new WP_Query([
    'post_type'      => 'acm_event',
    'posts_per_page' => $per_page,
    'paged'          => $past_page,
    'meta_key'       => '_event_date',
    'orderby'        => 'meta_value',
    'order'          => 'DESC',
    'meta_query'     => [[
        'key'     => '_event_date',
        'value'   => $today,
        'compare' => '<',
        'type'    => 'DATE',
    ]],
]);
$past_pages = $past->max_num_pages;

/**
 * Build a pagination URL preserving both page params independently.
 */
function acm_pagination_url( $param, $page ) {
    $base   = strtok( $_SERVER['REQUEST_URI'], '?' );
    $params = $_GET;
    if ( $page <= 1 ) {
        unset( $params[$param] );
    } else {
        $params[$param] = $page;
    }
    return esc_url( $base . ( $params ? '?' . http_build_query( $params ) : '' ) );
}
?>

<!-- PAGE HERO -->
<section class="page-hero">
    <div class="page-hero-inner">
        <span class="eyebrow">Metro Atlanta</span>
        <h1>Events</h1>
        <p>Talks, workshops, and networking events for computing professionals in Atlanta and the greater metro Atlanta area.</p>
    </div>
</section>

<!-- UPCOMING EVENTS -->
<section class="section" id="upcoming">
    <div class="section-inner">
        <span class="eyebrow">What's Coming Up</span>
        <h2 class="section-title">Upcoming Events</h2>

        <?php if ( $upcoming->have_posts() ) : ?>
            <div class="events-list">
                <?php while ( $upcoming->have_posts() ) : $upcoming->the_post();
                    get_template_part( 'template-parts/event-card', null, [ 'variant' => 'upcoming' ] );
                endwhile;
                wp_reset_postdata(); ?>
            </div>

            <?php if ( $upcoming_pages > 1 ) : ?>
            <nav class="events-pagination" aria-label="Upcoming events pages">
                <?php if ( $upcoming_page > 1 ) : ?>
                    <a href="<?php echo acm_pagination_url( 'upcoming_page', $upcoming_page - 1 ); ?>#upcoming" class="pagination-btn">← Newer</a>
                <?php else : ?>
                    <span class="pagination-btn pagination-btn--disabled">← Newer</span>
                <?php endif; ?>

                <span class="pagination-info">Page <?php echo $upcoming_page; ?> of <?php echo $upcoming_pages; ?></span>

                <?php if ( $upcoming_page < $upcoming_pages ) : ?>
                    <a href="<?php echo acm_pagination_url( 'upcoming_page', $upcoming_page + 1 ); ?>#upcoming" class="pagination-btn">Later →</a>
                <?php else : ?>
                    <span class="pagination-btn pagination-btn--disabled">Later →</span>
                <?php endif; ?>
            </nav>
            <?php endif; ?>

        <?php else : ?>
            <div class="events-empty">
                <p>No upcoming events scheduled yet — check back soon, or <a href="<?php echo esc_url( home_url('/contact') ); ?>">contact us</a> to suggest a topic.</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- PAST EVENTS -->
<?php if ( $past->found_posts > 0 ) : ?>
<section class="section section-alt" id="past">
    <div class="section-inner">
        <span class="eyebrow">Previously</span>
        <h2 class="section-title">Past Events</h2>

        <div class="events-list events-list--past">
            <?php while ( $past->have_posts() ) : $past->the_post();
                get_template_part( 'template-parts/event-card', null, [ 'variant' => 'past' ] );
            endwhile;
            wp_reset_postdata(); ?>
        </div>

        <?php if ( $past_pages > 1 ) : ?>
        <nav class="events-pagination" aria-label="Past events pages">
            <?php if ( $past_page > 1 ) : ?>
                <a href="<?php echo acm_pagination_url( 'past_page', $past_page - 1 ); ?>#past" class="pagination-btn">← More Recent</a>
            <?php else : ?>
                <span class="pagination-btn pagination-btn--disabled">← More Recent</span>
            <?php endif; ?>

            <span class="pagination-info">Page <?php echo $past_page; ?> of <?php echo $past_pages; ?></span>

            <?php if ( $past_page < $past_pages ) : ?>
                <a href="<?php echo acm_pagination_url( 'past_page', $past_page + 1 ); ?>#past" class="pagination-btn">Older →</a>
            <?php else : ?>
                <span class="pagination-btn pagination-btn--disabled">Older →</span>
            <?php endif; ?>
        </nav>
        <?php endif; ?>

    </div>
</section>
<?php endif; ?>

<?php get_footer(); ?>
