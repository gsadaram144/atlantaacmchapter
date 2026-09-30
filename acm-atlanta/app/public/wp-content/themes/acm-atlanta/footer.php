<footer class="site-footer">
    <div class="footer-inner">
        <div class="footer-grid">

            <!-- Brand Column -->
            <div class="footer-brand">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="footer-logo-link" aria-label="<?php bloginfo('name'); ?> Home">
                    <img
                        src="<?php echo esc_url( get_template_directory_uri() . '/images/acm-atlanta-logo.png' ); ?>"
                        alt=""
                        class="footer-logo"
                        width="56"
                        height="56"
                    />
                    <span class="site-logo-text">
                        <span class="site-logo-name">ACM Atlanta</span>
                        <span class="site-logo-tagline">Professional Chapter</span>
                    </span>
                </a>
                <p class="footer-desc">
                    A professional chapter of the Association for Computing Machinery
                    serving the greater metro Atlanta technology community.
                </p>
                <div class="social-row">
                    <?php
                    // Add a profile URL to show that icon; links left as '#' are hidden
                    $socials = [
                        'linkedin'  => ['url' => '#', 'label' => 'LinkedIn',    'img' => 'https://atlanta.acm.org/wp-content/uploads/2026/03/linkedin.svg'],
                        'twitter'   => ['url' => '#', 'label' => 'Twitter / X', 'img' => 'https://atlanta.acm.org/wp-content/uploads/2026/03/twitter.svg'],
                        'facebook'  => ['url' => '#', 'label' => 'Facebook',    'img' => 'https://atlanta.acm.org/wp-content/uploads/2026/03/facebook.svg'],
                        'youtube'   => ['url' => '#', 'label' => 'YouTube',     'img' => 'https://atlanta.acm.org/wp-content/uploads/2026/03/youtube.svg'],
                        'instagram' => ['url' => '#', 'label' => 'Instagram',   'img' => 'https://atlanta.acm.org/wp-content/uploads/2026/03/instagram.svg'],
                        'mail'      => ['url' => 'mailto:acmchapteratlanta@gmail.com', 'label' => 'Email', 'img' => get_template_directory_uri() . '/images/mail.svg'],
                    ];
                    foreach ($socials as $name => $data) :
                        if ( $data['url'] === '#' ) continue; ?>
                        <a href="<?php echo esc_url($data['url']); ?>"
                           class="social-btn"
                           title="<?php echo esc_attr($data['label']); ?>"
                           <?php if ($name !== 'mail') : ?>target="_blank" rel="noopener"<?php endif; ?>>
                            <img src="<?php echo esc_url($data['img']); ?>" alt="<?php echo esc_attr($data['label']); ?>"/>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Chapter Links -->
            <div class="footer-col">
                <h4>Chapter</h4>
                <ul>
                    <li><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
                    <li><a href="<?php echo esc_url(home_url('/about')); ?>">About Us</a></li>
                    <li><a href="<?php echo esc_url(home_url('/officers')); ?>">Officers</a></li>
                    <li><a href="<?php echo esc_url(home_url('/events')); ?>">Events</a></li>
                    <li><a href="<?php echo esc_url(home_url('/contact')); ?>">Contact</a></li>
                </ul>
            </div>

            <!-- Membership Links -->
            <div class="footer-col">
                <h4>Chapter Membership</h4>
                <ul>
                    <li><a href="<?php echo esc_url(home_url('/membership')); ?>">Join the Chapter</a></li>
                    <li><a href="<?php echo esc_url(home_url('/membership')); ?>#faq">Membership FAQ</a></li>
                    <li><a href="<?php echo esc_url(home_url('/officers')); ?>">Chapter Officers</a></li>
                    <li><a href="<?php echo esc_url(home_url('/contact')); ?>">Contact Us</a></li>
                </ul>
            </div>

            <!-- ACM Global Links -->
            <div class="footer-col">
                <h4>ACM Global</h4>
                <ul>
                    <li><a href="https://www.acm.org" target="_blank" rel="noopener">ACM.org</a></li>
                    <li><a href="https://dl.acm.org" target="_blank" rel="noopener">Digital Library</a></li>
                    <li><a href="https://www.acm.org/chapters" target="_blank" rel="noopener">All Chapters</a></li>
                    <li><a href="mailto:technicalsupport@acm.org">ACM Support</a></li>
                </ul>
            </div>

        </div><!-- .footer-grid -->

        <!-- Bottom Bar -->
        <div class="footer-bottom">
            <span>
                &copy; <?php echo date('Y'); ?>
                <?php bloginfo('name'); ?>.
                All rights reserved.
            </span>
            <span>
                Part of the
                <a href="https://www.acm.org" target="_blank" rel="noopener">
                    Association for Computing Machinery
                </a>
            </span>
        </div>

    </div><!-- .footer-inner -->
</footer>

<?php wp_footer(); ?>
</body>
</html>