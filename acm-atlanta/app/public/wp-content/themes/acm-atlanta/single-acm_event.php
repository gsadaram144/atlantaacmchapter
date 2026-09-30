<?php
/**
 * Single Event Template
 * Renders an individual event page at /events/event-slug/
 * WordPress routes here automatically for any acm_event post.
 */
get_header();

while ( have_posts() ) : the_post();
    $date     = get_post_meta( get_the_ID(), '_event_date', true );
    $time     = get_post_meta( get_the_ID(), '_event_time', true );
    $location = get_post_meta( get_the_ID(), '_event_location', true );
    $rsvp_url = get_post_meta( get_the_ID(), '_event_rsvp_url', true );
    $ticket   = get_post_meta( get_the_ID(), '_event_ticket', true );
    $ts       = $date ? strtotime( $date ) : false;
    $is_past  = $ts && $ts < strtotime('today');
?>

<!-- EVENT HERO -->
<section class="page-hero event-single-hero">
    <div class="page-hero-inner">
        <span class="eyebrow">
            <?php echo $is_past ? 'Past Event' : 'Upcoming Event'; ?>
        </span>
        <h1><?php the_title(); ?></h1>
        <?php if ( $ts ) : ?>
        <p class="event-single-date">
            <?php echo date( 'l, F j, Y', $ts ); ?>
            <?php if ( $time ) : ?>· <?php echo esc_html( $time ); ?><?php endif; ?>
        </p>
        <?php endif; ?>
    </div>
</section>

<!-- EVENT BODY -->
<section class="section">
    <div class="section-inner event-single-layout">

        <!-- Main content -->
        <article class="event-single-content">
            <?php the_content(); ?>

            <?php if ( ! $is_past ) :
                $reg_status = sanitize_key( $_GET['reg'] ?? '' );
            ?>
            <div class="event-registration">
                <?php if ( $reg_status === 'success' ) : ?>
                    <div class="reg-notice reg-notice--success">You're registered! We look forward to seeing you there.</div>
                <?php elseif ( $reg_status === 'error' ) : ?>
                    <div class="reg-notice reg-notice--error">Something went wrong. Please check your details and try again.</div>
                <?php endif; ?>

                <?php if ( $reg_status !== 'success' ) : ?>
                <h3>Register as an Attendee</h3>
                <p class="reg-subtitle">Fill out the form below to reserve your spot. We'll keep you informed about this event.</p>

                <form method="post" action="<?php echo esc_url( admin_url('admin-post.php') ); ?>">
                    <input type="hidden" name="action"       value="acm_event_register">
                    <input type="hidden" name="acm_event_id" value="<?php echo get_the_ID(); ?>">
                    <?php wp_nonce_field( 'acm_event_register', 'acm_reg_nonce' ); ?>

                    <div class="reg-form-grid">
                        <div class="reg-field">
                            <label for="reg_first_name">First Name <span class="req">*</span></label>
                            <input type="text" id="reg_first_name" name="first_name" required autocomplete="given-name">
                        </div>
                        <div class="reg-field">
                            <label for="reg_last_name">Last Name <span class="req">*</span></label>
                            <input type="text" id="reg_last_name" name="last_name" required autocomplete="family-name">
                        </div>
                        <div class="reg-field reg-field--full">
                            <label for="reg_email">Email <span class="req">*</span></label>
                            <input type="email" id="reg_email" name="email" required autocomplete="email">
                        </div>
                        <div class="reg-field reg-field--full">
                            <label for="reg_phone">Phone <span style="font-weight:400; color:var(--text-muted)">(optional)</span></label>
                            <input type="tel" id="reg_phone" name="phone" autocomplete="tel">
                        </div>
                        <div class="reg-field reg-field--full">
                            <div class="cf-turnstile" data-sitekey="<?php echo esc_attr( get_option( 'acm_turnstile_site_key', '' ) ); ?>"></div>
                        </div>
                        <div class="reg-actions">
                            <button type="submit" class="btn btn-register">Register Now</button>
                        </div>
                    </div>
                </form>
                <?php wp_enqueue_script( 'cf-turnstile', 'https://challenges.cloudflare.com/turnstile/v0/api.js', [], null, true ); ?>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </article>

        <!-- Details sidebar -->
        <aside class="event-single-sidebar">
            <div class="event-sidebar-card">
                <h3>Event Details</h3>

                <?php if ( $ts ) : ?>
                <div class="sidebar-detail">
                    <span class="detail-icon">📅</span>
                    <div>
                        <strong>Date</strong>
                        <span><?php echo date( 'F j, Y', $ts ); ?></span>
                    </div>
                </div>
                <?php endif; ?>

                <?php if ( $time ) : ?>
                <div class="sidebar-detail">
                    <span class="detail-icon">🕕</span>
                    <div>
                        <strong>Time</strong>
                        <span><?php echo esc_html( $time ); ?></span>
                    </div>
                </div>
                <?php endif; ?>

                <?php if ( $location ) : ?>
                <div class="sidebar-detail">
                    <span class="detail-icon">📍</span>
                    <div>
                        <strong>Location</strong>
                        <span><?php echo esc_html( $location ); ?></span>
                    </div>
                </div>
                <?php endif; ?>

                <?php if ( $ticket ) : ?>
                <div class="sidebar-detail">
                    <span class="detail-icon">🎟</span>
                    <div>
                        <strong>Admission</strong>
                        <span><?php echo esc_html( $ticket ); ?></span>
                    </div>
                </div>
                <?php endif; ?>

                <?php if ( $rsvp_url && ! $is_past ) : ?>
                    <a href="<?php echo esc_url( $rsvp_url ); ?>" class="btn btn-gold btn-block" target="_blank" rel="noopener">
                        RSVP Now →
                    </a>
                <?php elseif ( $is_past ) : ?>
                    <p class="sidebar-past-note">This event has already taken place.</p>
                <?php endif; ?>
            </div>

            <a href="<?php echo esc_url( home_url('/events') ); ?>" class="event-back-link">
                ← Back to All Events
            </a>
        </aside>

    </div>
</section>

<?php endwhile; ?>

<?php get_footer(); ?>
