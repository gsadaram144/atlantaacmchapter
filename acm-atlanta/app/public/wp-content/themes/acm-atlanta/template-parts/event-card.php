<?php
/**
 * Template Part: Event Card
 *
 * Renders a single event card consistently across all pages.
 * Used by front-page.php and page-templates/events.php.
 *
 * Expects the following variables in $args (passed via get_template_part):
 *   $args['variant']  — 'upcoming' (default) or 'past'
 *   $args['limit']    — optional, used by caller to control count
 *
 * Reads post meta from the current post in The Loop:
 *   _event_date, _event_time, _event_location, _event_rsvp_url, _event_ticket
 */

$variant  = $args['variant'] ?? 'upcoming';
$date     = get_post_meta( get_the_ID(), '_event_date', true );
$time     = get_post_meta( get_the_ID(), '_event_time', true );
$location = get_post_meta( get_the_ID(), '_event_location', true );
$rsvp_url = get_post_meta( get_the_ID(), '_event_rsvp_url', true );
$ticket   = get_post_meta( get_the_ID(), '_event_ticket', true );
$ts       = $date ? strtotime( $date ) : false;

$card_class = 'event-card';
if ( $variant === 'past' ) $card_class .= ' event-card--past';
?>

<div class="<?php echo $card_class; ?>">

    <div class="event-date-box">
        <span class="month"><?php echo $ts ? strtoupper( date( 'M', $ts ) ) : '—'; ?></span>
        <span class="day"><?php echo $ts ? date( 'd', $ts ) : '—'; ?></span>
        <span class="year"><?php echo $ts ? date( 'Y', $ts ) : ''; ?></span>
    </div>

    <div class="event-info">
        <h3><a href="<?php the_permalink(); ?>" class="event-title-link"><?php the_title(); ?></a></h3>
        <?php
        $excerpt = get_the_excerpt() ?: wp_trim_words( get_the_content(), 25 );
        if ( $excerpt ) : ?>
            <p><?php echo esc_html( wp_trim_words( $excerpt, 25 ) ); ?></p>
        <?php endif; ?>

        <div class="event-meta">
            <?php if ( $time )     : ?><span>🕕 <?php echo esc_html( $time ); ?></span><?php endif; ?>
            <?php if ( $location ) : ?><span>📍 <?php echo esc_html( $location ); ?></span><?php endif; ?>
            <?php if ( $ticket )   : ?><span>🎟 <?php echo esc_html( $ticket ); ?></span><?php endif; ?>
        </div>
    </div>

    <div class="event-card-actions">
        <?php if ( $rsvp_url && $variant !== 'past' ) : ?>
            <a href="<?php echo esc_url( $rsvp_url ); ?>" class="btn btn-rsvp" target="_blank" rel="noopener">RSVP</a>
        <?php endif; ?>
        <a href="<?php the_permalink(); ?>" class="btn <?php echo $variant === 'past' ? 'btn-details-past' : 'btn-details'; ?>">Details</a>
    </div>

</div>
