<?php
/**
 * ACM Atlanta — Front Page (Homepage) Template
 * WordPress uses this file automatically for the static front page.
 */
get_header(); ?>

<!-- ═══════════════════════════ HERO ═══════════════════════════ -->
<section class="hero">
    <div class="hero-bg" style="background-image: url('https://atlanta.acm.org/wp-content/uploads/2026/03/acm_desktopbanner-1.jpeg');"></div>
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <span class="hero-eyebrow">ACM Atlanta Professional Chapter · Atlanta, GA</span>
        <h1>Connecting Computing Professionals in the Heart of Metro Atlanta</h1>
        <p>A professional chapter of the Association for Computing Machinery — uniting developers, engineers, researchers, and technology leaders across Atlanta and the greater metro Atlanta area.</p>
        <div class="hero-btns">
            <a href="#membership" class="btn btn-gold">Join the Chapter</a>
            <a href="#events" class="btn btn-ghost">View Upcoming Events</a>
        </div>
    </div>
</section>

<!-- ═══════════════════════════ PURPOSE PILLARS ═══════════════════════════ -->
<section class="section section-light">
    <div class="section-inner">
        <span class="eyebrow">Our Purpose</span>
        <h2 class="section-title">Why ACM Atlanta Exists</h2>
        <p class="section-sub">We advance computing as a science and profession — bringing the global reach of ACM to our local Atlanta and the surrounding metro area community.</p>
        <div class="pillars-grid">

            <div class="card card-top-accent">
                <span class="pillar-icon">🎓</span>
                <h3>Professional Development</h3>
                <p>Expert-led talks, workshops, and seminars keeping you current across AI, cybersecurity, software engineering, and emerging technologies.</p>
            </div>

            <div class="card card-top-accent">
                <span class="pillar-icon">🤝</span>
                <h3>Community &amp; Networking</h3>
                <p>Build meaningful connections with fellow computing professionals across Atlanta and the surrounding metro area. Collaborate, mentor, and grow together in our local community.</p>
            </div>

            <div class="card card-top-accent">
                <span class="pillar-icon">💡</span>
                <h3>Industry Leadership</h3>
                <p>Contribute to the global ACM community while making a local impact. Help shape the future of computing in the Atlanta technology ecosystem.</p>
            </div>

        </div>
    </div>
</section>

<!-- ═══════════════════════════ MEMBERSHIP ═══════════════════════════ -->
<section class="section" id="membership">
    <div class="section-inner">
        <div class="membership-grid">

            <div>
                <span class="eyebrow">Chapter Membership</span>
                <h2 class="section-title">Join the ACM Atlanta Chapter</h2>
                <p style="color: var(--text-muted); font-size: 16px; line-height: 1.7;">
                    We are a local Professional Chapter of the ACM. By becoming a member, you are supporting the programs and meetups we organize and connecting with the local computing community in Atlanta and the surrounding metro area.
                </p>
                <ul class="benefits-list">
                    <li>
                        <span class="check-icon">✓</span>
                        <span><strong>Priority event invitations</strong> — first access to chapter meetups, workshops, and speaker series</span>
                    </li>
                    <li>
                        <span class="check-icon">✓</span>
                        <span><strong>Have a voice</strong> — members have a say in how the chapter is run and can take on leadership roles</span>
                    </li>
                    <li>
                        <span class="check-icon">✓</span>
                        <span><strong>Shape the chapter</strong> — influence the topics, speakers, and events we organize</span>
                    </li>
                    <li>
                        <span class="check-icon">✓</span>
                        <span><strong>Support the community</strong> — your membership directly funds chapter operations and events</span>
                    </li>
                    <li>
                        <span class="check-icon">✓</span>
                        <span><strong>Communications of the ACM</strong> — complimentary 3-month electronic subscription to ACM's flagship publication</span>
                    </li>
                    <li>
                        <span class="check-icon">✓</span>
                        <span><strong>acm.org email address</strong> — a personal @acm.org email forwarding address with filtering</span>
                    </li>
                    <li>
                        <span class="check-icon">✓</span>
                        <span><strong>ACM E-Newsletters</strong> — TechNews 3× weekly, CareerNews bi-monthly, and MemberNet quarterly</span>
                    </li>
                </ul>
                <a href="<?php echo esc_url(home_url('/membership')); ?>" class="btn btn-blue">
                    Learn More &amp; Join →
                </a>
            </div>

            <div class="membership-card">
                <h3>ACM Atlanta Chapter</h3>
                <p class="subtitle">Local chapter membership · Atlanta, GA</p>
                <div class="price-amount">$150</div>
                <div class="price-period">per year</div>
                <a href="<?php echo esc_url(home_url('/membership')); ?>" class="btn btn-gold btn-block">
                    Become a Member →
                </a>
                <hr class="card-divider"/>
                <p class="card-note">One rate for all members — no separate student rate</p>
                <hr class="card-divider"/>
                <p class="card-note">Our events are free to attend — membership supports chapter operations and gives you a voice in how we run.</p>
            </div>

        </div>
    </div>
</section>

<!-- ═══════════════════════════ UPCOMING EVENTS ═══════════════════════════ -->
<section class="section section-alt" id="events">
    <div class="section-inner">
        <span class="eyebrow">Upcoming Events</span>
        <h2 class="section-title">Stay Connected. Stay Current.</h2>
        <p class="section-sub">Talks, workshops, and networking events in Atlanta and the surrounding metro area. Join us in person and be part of the conversation.</p>

        <div class="events-list">
            <?php
            // Next 3 upcoming events, soonest first
            $events = new WP_Query([
                'post_type'      => 'acm_event',
                'posts_per_page' => 3,
                'meta_key'       => '_event_date',
                'orderby'        => 'meta_value',
                'order'          => 'ASC',
                'meta_query'     => [[
                    'key'     => '_event_date',
                    'value'   => current_time( 'Y-m-d' ),
                    'compare' => '>=',
                    'type'    => 'DATE',
                ]],
            ]);

            if ($events->have_posts()) :
                while ($events->have_posts()) : $events->the_post();
                    get_template_part( 'template-parts/event-card', null, [ 'variant' => 'upcoming' ] );
                endwhile;
                wp_reset_postdata();
            else : ?>
                <!-- Placeholder events shown when no posts exist yet -->
                <div class="event-card">
                    <div class="event-date-box event-date-box--tba">
                        <span class="month">Coming</span>
                        <span class="day">2027</span>
                    </div>
                    <div class="event-info">
                        <h3>AI &amp; Machine Learning in the Enterprise — Panel Discussion</h3>
                        <p>Industry practitioners discuss real-world AI adoption, challenges, and opportunities for computing professionals in Atlanta's growing tech sector.</p>
                        <div class="event-meta">
                            <span>🕕 6:00 – 8:30 PM</span>
                            <span>📍 Venue TBA – Atlanta, GA</span>
                            <span>🎟 Free for Members</span>
                        </div>
                    </div>
                    <a href="#" class="btn btn-rsvp">RSVP</a>
                </div>

                <div class="event-card">
                    <div class="event-date-box event-date-box--tba">
                        <span class="month">Coming</span>
                        <span class="day">2027</span>
                    </div>
                    <div class="event-info">
                        <h3>Cybersecurity Best Practices for Software Developers</h3>
                        <p>A hands-on workshop covering secure coding practices, OWASP Top 10, and tools every developer needs to build safer applications.</p>
                        <div class="event-meta">
                            <span>🕖 6:30 – 9:00 PM</span>
                            <span>📍 TBA – Atlanta, GA</span>
                            <span>🎟 Members &amp; Guests Welcome</span>
                        </div>
                    </div>
                    <a href="#" class="btn btn-rsvp">RSVP</a>
                </div>

                <div class="event-card">
                    <div class="event-date-box event-date-box--tba">
                        <span class="month">Coming</span>
                        <span class="day">2027</span>
                    </div>
                    <div class="event-info">
                        <h3>ACM Atlanta Chapter Kickoff Meetup &amp; Networking Night</h3>
                        <p>Welcome new members, meet chapter leadership, and hear about the 2027 event calendar. Light refreshments provided.</p>
                        <div class="event-meta">
                            <span>🕕 6:00 – 8:00 PM</span>
                            <span>📍 Atlanta, GA (Details TBD)</span>
                            <span>🎟 Free &amp; Open to All</span>
                        </div>
                    </div>
                    <a href="#" class="btn btn-rsvp">RSVP</a>
                </div>
            <?php endif; ?>
        </div>

        <div class="events-footer">
            <a href="<?php echo esc_url(home_url('/events')); ?>" class="btn btn-blue">
                View All Events →
            </a>
        </div>

    </div>
</section>

<?php get_footer(); ?>