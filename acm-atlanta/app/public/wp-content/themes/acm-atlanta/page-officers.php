<?php
/**
 * Officers Page Template
 * ACM Atlanta — Auto-loaded by WordPress for any page with slug "officers".
 * No template assignment needed in WP Admin — just create a page with slug: officers
 */
get_header();

$officers = new WP_Query([
    'post_type'      => 'acm_officer',
    'posts_per_page' => -1,
    'meta_key'       => '_officer_order',
    'orderby'        => 'meta_value_num',
    'order'          => 'ASC',
]);

// Build officers array first so we can use it in both selector and panels
$officer_list = [];
if ( $officers->have_posts() ) {
    while ( $officers->have_posts() ) {
        $officers->the_post();
        $officer_list[] = [
            'id'       => get_the_ID(),
            'slug'     => sanitize_title( get_the_title() ),
            'name'     => get_the_title(),
            'title'    => get_post_meta( get_the_ID(), '_officer_title',    true ),
            'duties'   => get_post_meta( get_the_ID(), '_officer_duties',   true ),
            'email'    => get_post_meta( get_the_ID(), '_officer_email',    true ),
            'linkedin' => get_post_meta( get_the_ID(), '_officer_linkedin', true ),
            'bio'      => get_the_content(),
            'photo'    => get_the_post_thumbnail_url( get_the_ID(), 'medium' ),
            'initial'  => strtoupper( mb_substr( get_the_title(), 0, 1 ) ),
        ];
    }
    wp_reset_postdata();
}

// Gradient classes cycle through 4 options
$gradients = [ 'avatar-A', 'avatar-B', 'avatar-C', 'avatar-D' ];
?>

<!-- PAGE HERO -->
<section class="page-hero">
    <div class="page-hero-inner">
        <span class="eyebrow">ACM Atlanta Leadership</span>
        <h1>Chapter Officers</h1>
        <p>Meet the volunteers who organize events, run the chapter, and keep the Atlanta computing community connected.</p>
    </div>
</section>

<!-- OFFICERS -->
<section class="section">
    <div class="section-inner">

        <?php if ( ! empty( $officer_list ) ) : ?>

            <!-- Role selector -->
            <div class="role-selector">
                <?php foreach ( $officer_list as $i => $o ) :
                    $grad = $gradients[ $i % 4 ];
                    $short_name = explode( ' ', $o['name'] );
                    $display_name = $short_name[0] . ( isset($short_name[1]) ? ' ' . strtoupper(substr($short_name[1],0,1)) . '.' : '' );
                ?>
                <button
                    class="role-btn <?php echo $i === 0 ? 'active' : ''; ?>"
                    onclick="showOfficer('officer-<?php echo esc_attr($o['slug']); ?>', this)"
                    aria-label="View <?php echo esc_attr($o['name']); ?>"
                >
                    <div class="role-btn-avatar <?php echo $grad; ?>">
                        <?php if ( $o['photo'] ) : ?>
                            <img src="<?php echo esc_url($o['photo']); ?>" alt="<?php echo esc_attr($o['name']); ?>"/>
                        <?php else : ?>
                            <?php echo esc_html($o['initial']); ?>
                        <?php endif; ?>
                    </div>
                    <span class="role-btn-name"><?php echo esc_html($display_name); ?></span>
                    <span class="role-btn-title"><?php echo esc_html($o['title']); ?></span>
                </button>
                <?php endforeach; ?>
            </div>

            <!-- Officer panels -->
            <div class="officer-panels">
                <?php foreach ( $officer_list as $i => $o ) :
                    $grad = $gradients[ $i % 4 ];
                ?>
                <div id="officer-<?php echo esc_attr($o['slug']); ?>" class="officer-panel <?php echo $i === 0 ? 'active' : ''; ?>">

                    <div class="officer-identity">
                        <div class="identity-avatar <?php echo $grad; ?>">
                            <?php if ( $o['photo'] ) : ?>
                                <img src="<?php echo esc_url($o['photo']); ?>" alt="<?php echo esc_attr($o['name']); ?>"/>
                            <?php else : ?>
                                <?php echo esc_html($o['initial']); ?>
                            <?php endif; ?>
                        </div>
                        <div class="identity-name"><?php echo esc_html($o['name']); ?></div>
                        <span class="identity-role"><?php echo esc_html($o['title']); ?></span>
                        <div class="identity-links">
                            <?php if ( $o['email'] ) : ?>
                                <a href="mailto:<?php echo esc_attr($o['email']); ?>" class="identity-link link-email">
                                    ✉️ <?php echo esc_html($o['email']); ?>
                                </a>
                            <?php endif; ?>
                            <?php if ( $o['linkedin'] ) : ?>
                                <a href="<?php echo esc_url($o['linkedin']); ?>" class="identity-link link-linkedin" target="_blank" rel="noopener">
                                    in LinkedIn
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="officer-details">
                        <?php if ( $o['bio'] ) : ?>
                            <div class="detail-bio"><?php echo wpautop( wp_kses_post( $o['bio'] ) ); ?></div>
                        <?php endif; ?>
                        <?php if ( $o['duties'] ) : ?>
                            <div class="detail-section-label">Responsibilities</div>
                            <div class="detail-duties"><?php echo esc_html($o['duties']); ?></div>
                        <?php endif; ?>
                    </div>

                </div>
                <?php endforeach; ?>
            </div>

        <?php else : ?>
            <div class="events-empty">
                <p>Officer profiles are being set up — check back soon!</p>
            </div>
        <?php endif; ?>

    </div>
</section>

<!-- CTA -->
<section class="section section-cta">
    <div class="section-inner section-inner--center">
        <span class="eyebrow">Get Involved</span>
        <h2>Interested in a Leadership Role?</h2>
        <p>ACM Atlanta is entirely volunteer-run. If you're passionate about the computing community in Atlanta and the surrounding metro area, we'd love to hear from you.</p>
        <a href="<?php echo esc_url( home_url('/contact') ); ?>" class="btn btn-blue">Get in Touch →</a>
    </div>
</section>

<script>
function showOfficer(id, btn) {
    document.querySelectorAll('.officer-panel').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.role-btn').forEach(b => b.classList.remove('active'));
    document.getElementById(id).classList.add('active');
    btn.classList.add('active');
}
</script>

<?php get_footer(); ?>
