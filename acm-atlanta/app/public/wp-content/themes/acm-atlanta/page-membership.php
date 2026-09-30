<?php
/**
 * Membership Page Template
 * ACM Atlanta — Auto-loaded by WordPress for any page with slug "membership".
 * Covers local chapter membership only — intentionally distinct from ACM global membership.
 */
get_header();
?>

<!-- PAGE HERO -->
<section class="page-hero membership-hero">
    <div class="page-hero-inner">
        <span class="eyebrow">ACM Atlanta Professional Chapter</span>
        <h1>Become a Chapter Member</h1>
        <p>Join the local computing community in Atlanta and the metro Atlanta area. Support the events we organize, connect with fellow professionals, and help shape the future of this chapter.</p>
    </div>
</section>



<!-- WHAT MEMBERSHIP MEANS -->
<section class="section">
    <div class="section-inner">
        <span class="eyebrow">Why Join</span>
        <h2 class="section-title">What Chapter Membership Means</h2>
        <p class="section-sub">We are a local Professional Chapter of the ACM. By becoming a member, you are joining the local computing community and directly supporting the programs we run in Atlanta and the surrounding metro area.</p>

        <div class="membership-benefits-grid">

            <div class="membership-benefit">
                <span class="benefit-icon">📅</span>
                <div>
                    <h3>Priority Event Access</h3>
                    <p>Receive direct invitations to chapter meetups, workshops, networking events, and speaker series before they're announced publicly.</p>
                </div>
            </div>

            <div class="membership-benefit">
                <span class="benefit-icon">🏛️</span>
                <div>
                    <h3>Have a Voice</h3>
                    <p>Members have a say in how the chapter is run and are eligible to take on leadership roles as the chapter grows.</p>
                </div>
            </div>

            <div class="membership-benefit">
                <span class="benefit-icon">🤝</span>
                <div>
                    <h3>Community &amp; Networking</h3>
                    <p>Connect with computing professionals across Atlanta and the surrounding metro area. Build relationships that go beyond the event room.</p>
                </div>
            </div>

            <div class="membership-benefit">
                <span class="benefit-icon">💡</span>
                <div>
                    <h3>Shape What We Build</h3>
                    <p>Members influence the direction of the chapter — the topics we cover, the speakers we invite, and the events we organize.</p>
                </div>
            </div>

            <div class="membership-benefit">
                <span class="benefit-icon">🌱</span>
                <div>
                    <h3>Support the Community</h3>
                    <p>Your membership directly funds chapter operations — venue costs, speaker logistics, and everything that keeps our events running.</p>
                </div>
            </div>

            <div class="membership-benefit">
                <span class="benefit-icon">📰</span>
                <div>
                    <h3>Communications of the ACM</h3>
                    <p>Complimentary three-month electronic subscription to ACM's flagship publication — one of the most respected journals in computing.</p>
                </div>
            </div>

            <div class="membership-benefit">
                <span class="benefit-icon">📧</span>
                <div>
                    <h3>acm.org Email Address</h3>
                    <p>A personal @acm.org email forwarding address with filtering — a recognizable mark of your computing community membership.</p>
                </div>
            </div>

            <div class="membership-benefit">
                <span class="benefit-icon">📬</span>
                <div>
                    <h3>ACM E-Newsletters</h3>
                    <p><strong>TechNews</strong> — computing news 3× weekly. <strong>CareerNews</strong> — career and industry news bi-monthly. <strong>MemberNet</strong> — ACM people and events quarterly.</p>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- TRANSPARENCY SECTION -->
<section class="section section-alt">
    <div class="section-inner membership-transparency-layout">

        <div class="transparency-text">
            <span class="eyebrow">Transparency</span>
            <h2>About Our Costs</h2>
            <p>Our meetings are currently <strong>free to attend</strong> — and we want to keep it that way. But running a chapter isn't without cost. Venue arrangements, event logistics, communications, and operational overhead all add up.</p>
            <p>Chapter membership fees help us cover these costs sustainably, without relying on sponsorships or charging for individual events. When you become a member, you're not just joining a community — you're helping keep it running for everyone.</p>
            <p>We believe in being upfront about this. There's no hidden agenda — just a group of computing professionals trying to build something meaningful for Atlanta and the surrounding metro area.</p>
        </div>

        <div class="transparency-card">
            <div class="pricing-label">Chapter Membership</div>
            <div class="pricing-amount">$150</div>
            <div class="pricing-period">per year</div>
            <div class="pricing-note">One rate for all members — no separate student rate</div>
            <hr class="pricing-divider"/>
            <ul class="pricing-includes">
                <li>✓ Priority event invitations</li>
                <li>✓ Voice in chapter governance</li>
                <li>✓ Direct support of chapter programs</li>
            </ul>
            <a href="mailto:acmchapteratlanta@gmail.com?subject=Chapter%20Membership" class="btn btn-gold btn-block">
                Join the Chapter →
            </a>
            <p class="pricing-footer">Reach out by email and we'll walk you through the process.</p>
        </div>

    </div>
</section>

<!-- PAYMENT SECTION -->
<section class="section section-light" id="join">
    <div class="section-inner">
        <span class="eyebrow">Pay for Membership</span>
        <h2 class="section-title">How to Pay</h2>
        <p class="section-sub">Pay your $150 annual membership fee via Zelle, then email your receipt to confirm your membership.</p>

        <div class="payment-options">

            <!-- ZELLE OPTION -->
            <div class="payment-option payment-option--primary">
                <div class="payment-option-header">
                    <span class="payment-option-badge">Recommended</span>
                    <h3>Pay via Zelle</h3>
                </div>

                <!-- DESKTOP: QR code -->
                <div class="payment-qr-block desktop-only">
                    <p class="payment-option-desc">On a computer? Scan the QR code with your phone's banking app, or log into your bank's website and send via Zelle.</p>
                    <button class="payment-qr-trigger" id="qrOpenBtn" aria-label="Enlarge QR code for scanning">
                        <img
                            src="<?php echo esc_url( get_template_directory_uri() . '/images/zelle-qr-code.png' ); ?>"
                            alt="Zelle QR code for ACM Atlanta chapter membership payment"
                            class="payment-qr-img"
                        />
                        <span class="payment-qr-hint">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 3 21 3 21 9"/><polyline points="9 21 3 21 3 15"/><line x1="21" y1="3" x2="14" y2="10"/><line x1="3" y1="21" x2="10" y2="14"/></svg>
                            Tap to enlarge &amp; scan
                        </span>
                    </button>
                    <p class="payment-qr-caption">Tap to enlarge · Scan with your phone's banking app</p>
                </div>

                <!-- MOBILE: copyable email -->
                <div class="payment-mobile-zelle mobile-only">
                    <p class="payment-option-desc">Open your bank's app, go to Zelle, and send to the address below.</p>
                    <div class="zelle-email-copy">
                        <span class="zelle-email-address">acmchapteratlanta@gmail.com</span>
                        <button class="zelle-copy-btn" id="zelleCopyBtn" aria-label="Copy Zelle email address">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
                            <span id="zelleCopyLabel">Copy</span>
                        </button>
                    </div>
                </div>

                <!-- Steps -->
                <div class="payment-step-list">
                    <div class="payment-step">
                        <span class="payment-step-num">1</span>
                        <span class="step-desktop">Open your bank's mobile app or website and go to Zelle.</span>
                        <span class="step-mobile">Open your bank's app and go to Zelle or Pay &amp; Transfer.</span>
                    </div>
                    <div class="payment-step">
                        <span class="payment-step-num">2</span>
                        <span class="step-desktop">Scan the QR code with your phone, or search for <strong>acmchapteratlanta@gmail.com</strong>.</span>
                        <span class="step-mobile">Tap Send and enter or paste <strong>acmchapteratlanta@gmail.com</strong>.</span>
                    </div>
                    <div class="payment-step">
                        <span class="payment-step-num">3</span>
                        <span>Send <strong>$150</strong> with memo <strong>"Chapter Membership – [Your Full Name]"</strong>.</span>
                    </div>
                    <div class="payment-step">
                        <span class="payment-step-num">4</span>
                        <span>Email your payment receipt to <a href="mailto:acmchapteratlanta@gmail.com?subject=Chapter%20Membership%20Payment%20Receipt">acmchapteratlanta@gmail.com</a> with subject <strong>"Chapter Membership Payment Receipt"</strong>. Once received, we'll process it and send you a confirmation email.</span>
                    </div>
                </div>

                <!-- Online banking callout (desktop only) -->
                <div class="payment-online-banking desktop-only">
                    <span class="payment-online-banking-icon">🏦</span>
                    <div>
                        <strong>Paying via your bank's website?</strong>
                        <p>Log into your bank's online portal, go to Zelle or Transfers, and send $150 to <strong>acmchapteratlanta@gmail.com</strong>. No app or QR code needed.</p>
                    </div>
                </div>
            </div>

            <!-- DIVIDER -->
            <div class="payment-options-divider">
                <span>or</span>
            </div>

            <!-- OTHER OPTIONS -->
            <div class="payment-option payment-option--secondary">
                <h3>Other Payment Options</h3>

                <div class="payment-alt-item">
                    <span class="payment-alt-icon">💳</span>
                    <div>
                        <strong>PayPal</strong>
                        <p>Online payment via PayPal is coming soon. Once available, you'll be able to pay directly from this page.</p>
                    </div>
                </div>

                <div class="payment-alt-item">
                    <span class="payment-alt-icon">🏦</span>
                    <div>
                        <strong>Pay via bank details</strong>
                        <p>Prefer to pay using bank details directly? Email us at <a href="mailto:acmchapteratlanta@gmail.com?subject=Membership%20Payment%20-%20Bank%20Details%20Request">acmchapteratlanta@gmail.com</a> and we'll share our bank details with you.</p>
                    </div>
                </div>

                <div class="payment-alt-item">
                    <span class="payment-alt-icon">✉️</span>
                    <div>
                        <strong>Not sure?</strong>
                        <p>Email us at <a href="mailto:acmchapteratlanta@gmail.com?subject=Chapter%20Membership">acmchapteratlanta@gmail.com</a> and we'll walk you through the process.</p>
                    </div>
                </div>
            </div>

        </div>
        <!-- PAYPAL PLACEHOLDER: Replace this comment with your PayPal button code once your account is ready -->
    </div>
</section>

<!-- QR MODAL -->
<div class="qr-modal" id="qrModal" role="dialog" aria-modal="true" aria-label="Zelle QR code" hidden>
    <div class="qr-modal-backdrop" id="qrBackdrop"></div>
    <div class="qr-modal-content">
        <button class="qr-modal-close" id="qrCloseBtn" aria-label="Close">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>
        <p class="qr-modal-label">Scan with your bank's Zelle app</p>
        <img
            src="<?php echo esc_url( get_template_directory_uri() . '/images/zelle-qr-code.png' ); ?>"
            alt="Zelle QR code for ACM Atlanta chapter membership payment"
            class="qr-modal-img"
        />
        <p class="qr-modal-sub">Send <strong>$150</strong> to <strong>acmchapteratlanta@gmail.com</strong></p>
    </div>
</div>

<script>
(function () {
    var isMobile = window.matchMedia('(max-width: 768px)').matches;

    // Show correct step text per device
    document.querySelectorAll('.step-desktop').forEach(function (el) {
        el.style.display = isMobile ? 'none' : 'inline';
    });
    document.querySelectorAll('.step-mobile').forEach(function (el) {
        el.style.display = isMobile ? 'inline' : 'none';
    });

    // QR modal (desktop)
    var qrBtn    = document.getElementById('qrOpenBtn');
    var modal    = document.getElementById('qrModal');
    var backdrop = document.getElementById('qrBackdrop');
    var closeBtn = document.getElementById('qrCloseBtn');

    if (qrBtn && modal) {
        function openModal()  { modal.hidden = false; document.body.style.overflow = 'hidden'; closeBtn.focus(); }
        function closeModal() { modal.hidden = true;  document.body.style.overflow = '';        qrBtn.focus(); }
        qrBtn.addEventListener('click', openModal);
        closeBtn.addEventListener('click', closeModal);
        backdrop.addEventListener('click', closeModal);
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && !modal.hidden) closeModal();
        });
    }

    // Copy email (mobile)
    var copyBtn   = document.getElementById('zelleCopyBtn');
    var copyLabel = document.getElementById('zelleCopyLabel');
    if (copyBtn) {
        copyBtn.addEventListener('click', function () {
            navigator.clipboard.writeText('acmchapteratlanta@gmail.com').then(function () {
                copyLabel.textContent = 'Copied!';
                copyBtn.classList.add('copied');
                setTimeout(function () {
                    copyLabel.textContent = 'Copy';
                    copyBtn.classList.remove('copied');
                }, 2000);
            });
        });
    }
})();
</script>

<!-- FAQ -->
<section class="section">
    <div class="section-inner membership-faq-layout">
        <div>
            <span class="eyebrow">Common Questions</span>
            <h2>FAQ</h2>
        </div>
        <div class="faq-list">

            <div class="faq-item">
                <h4>Do I need to be an ACM global member to join?</h4>
                <p>No. The ACM Atlanta Professional Chapter is a locally organized community. You do not need a global ACM membership to become a chapter member or attend our events.</p>
            </div>

            <div class="faq-item">
                <h4>Can I attend events without being a member?</h4>
                <p>Yes — our events are currently free and open to all computing professionals in the Metro Atlanta area. Membership gives you priority access and supports the chapter, but it is not required to attend.</p>
            </div>

            <div class="faq-item">
                <h4>How do I pay for membership?</h4>
                <p>Pay $150 via Zelle by scanning the QR code on this page (or send to <strong>acmchapteratlanta@gmail.com</strong>), then email your payment receipt to <a href="mailto:acmchapteratlanta@gmail.com?subject=Chapter%20Membership%20Payment%20Receipt">acmchapteratlanta@gmail.com</a>. If you prefer Zelle via manual bank details or need another option, email us and we'll help. PayPal payment will be available soon.</p>
            </div>

            <div class="faq-item">
                <h4>Is there a student rate?</h4>
                <p>No — we do not have a separate rate for students. Membership is $150/year for all members.</p>
            </div>

        </div>
    </div>
</section>

<?php get_footer(); ?>