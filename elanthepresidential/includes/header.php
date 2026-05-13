<header class="lux-header" id="lux-header">
    <div class="lux-header__inner">
        <a href="#hero" class="lux-logo" aria-label="Elan The Presidential home">
            <span class="lux-logo__eyebrow">Elan Group Presents</span>
            <span class="lux-logo__name">Elan The Presidential</span>
        </a>

        <nav class="lux-nav" aria-label="Primary">
            <a href="#overview">Overview</a>
            <a href="#residences">Residences</a>
            <a href="#amenities">Amenities</a>
            <a href="#location">Location</a>
            <a href="#payment">Payment</a>
            <a href="#faq">FAQ</a>
        </nav>

        <div class="lux-header__cta">
            <a href="tel:+919412234688" class="lux-header__phone">
                <i class="fas fa-phone-alt"></i>9412-234-688
            </a>
            <button class="mobile-menu-toggle" aria-label="Open menu">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </div>
</header>

<!-- Mobile Menu -->
<div class="mobile-menu" aria-hidden="true">
    <button class="mobile-menu-close" aria-label="Close menu">&times;</button>
    <div class="lux-logo__eyebrow" style="margin-bottom:8px;">Elan Group Presents</div>
    <div class="lux-logo__name" style="margin-bottom:36px;">Elan The Presidential</div>
    <nav aria-label="Mobile">
        <a href="#overview">Overview</a>
        <a href="#residences">Residences</a>
        <a href="#floor-plans">Floor Plans</a>
        <a href="#amenities">Amenities</a>
        <a href="#location">Location</a>
        <a href="#payment">Payment Plan</a>
        <a href="#faq">FAQ</a>
        <a href="#contact">Contact</a>
    </nav>
    <a href="tel:+919412234688" class="btn btn--gold" style="margin-top:32px; width:100%;">
        <i class="fas fa-phone-alt"></i> 9412-234-688
    </a>
</div>
<div class="mobile-menu-overlay"></div>

<script>
(function(){
  var h = document.getElementById('lux-header');
  function onScroll(){
    if (window.scrollY > 40) h.classList.add('scrolled');
    else h.classList.remove('scrolled');
  }
  onScroll();
  window.addEventListener('scroll', onScroll, { passive: true });
})();
</script>
