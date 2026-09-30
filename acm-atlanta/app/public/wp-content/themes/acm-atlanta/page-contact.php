<?php
/**
 * Contact Page Template
 * ACM Atlanta — Auto-loaded by WordPress for any page with slug "contact".
 */
get_header();
?>

<!-- PAGE HERO -->
<section class="page-hero">
    <div class="page-hero-inner">
        <span class="eyebrow">Get in Touch</span>
        <h1>Contact Us</h1>
        <p>Have a question, idea, or want to get involved with ACM Atlanta? Here's how to reach us.</p>
    </div>
</section>

<!-- CONTACT SECTION -->
<section class="section">
    <div class="section-inner contact-cards-layout">

        <div class="contact-card">
            <span class="contact-card-icon">✉️</span>
            <h3>Email Us</h3>
            <p>For general questions, membership inquiries, or anything else — email is the best way to reach the chapter.</p>
            <a href="mailto:acmchapteratlanta@gmail.com" class="contact-card-action">acmchapteratlanta@gmail.com</a>
        </div>

        <div class="contact-card">
            <span class="contact-card-icon">🗣️</span>
            <h3>Speak at an Event</h3>
            <p>We're always looking for computing professionals to share their expertise with the Atlanta and surrounding metro community. Tell us about your topic.</p>
            <a href="mailto:acmchapteratlanta@gmail.com?subject=Speaker%20Proposal" class="contact-card-action">Submit a Speaker Proposal →</a>
        </div>

        <div class="contact-card">
            <span class="contact-card-icon">🤝</span>
            <h3>Join the Chapter</h3>
            <p>Become a chapter member for $150/year. Pay via Zelle and send your receipt to us — or email us and we'll walk you through it.</p>
            <a href="<?php echo esc_url( home_url('/membership/#join') ); ?>" class="contact-card-action">Join the Chapter →</a>
        </div>

        <div class="contact-card">
            <span class="contact-card-icon">📍</span>
            <h3>Where We Meet</h3>
            <p>Our events are held in and around Atlanta, Georgia — serving the greater metro Atlanta area. Location details are included with each event.</p>
            <a href="<?php echo esc_url( home_url('/events') ); ?>" class="contact-card-action">View Upcoming Events →</a>
        </div>

    </div>
</section>

<!-- ACM SUPPORT -->
<section class="section section-alt">
    <div class="section-inner section-inner--center">
        <span class="eyebrow">ACM Global</span>
        <h2 class="section-title">Need Help with ACM Membership?</h2>
        <p class="section-sub">For questions about your ACM membership, the Digital Library, or global ACM services — contact ACM directly.</p>
        <a href="https://www.acm.org/about-acm/contact-us" target="_blank" rel="noopener" class="btn btn-blue">ACM Global Support →</a>
    </div>
</section>

<?php get_footer(); ?>