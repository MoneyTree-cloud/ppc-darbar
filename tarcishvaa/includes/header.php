<header class="lux-header" id="lux-header">
    <div class="lux-header__inner">
        <a href="#hero" class="lux-logo" aria-label="TARC Ishva home">
            <span class="lux-logo__eyebrow">TARC Limited Presents</span>
            <span class="lux-logo__name">TARC ISHVA</span>
        </a>

        <nav class="lux-nav" aria-label="Primary">
            <a href="#overview">Overview</a>
            <a href="#directions">Directions</a>
            <a href="#residences">Residences</a>
            <a href="#amenities">Amenities</a>
            <a href="#location">Location</a>
            <a href="#faq">FAQ</a>
        </nav>

        <div class="lux-header__cta">
            <a href="tel:+919412234688" class="lux-header__phone">
                <i class="fas fa-phone-alt"></i>+91 94122 34688
            </a>
            <button class="mobile-menu-toggle" aria-label="Open menu">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </div>
</header>

<div class="mobile-menu" id="mobile-menu" aria-hidden="true">
    <button class="mobile-menu-close" aria-label="Close menu">&times;</button>
    <div class="lux-logo__eyebrow" style="color:var(--brass-deep); margin-bottom:6px;">TARC Limited Presents</div>
    <div class="lux-logo__name" style="color:var(--ink); margin-bottom:36px;">TARC ISHVA</div>
    <nav aria-label="Mobile">
        <a href="#overview">Overview</a>
        <a href="#directions">Four Directions</a>
        <a href="#residences">Residences</a>
        <a href="#floor-plans">Floor Plans</a>
        <a href="#amenities">Amenities</a>
        <a href="#location">Location</a>
        <a href="#payment">Payment Plan</a>
        <a href="#faq">FAQ</a>
        <a href="#contact">Contact</a>
    </nav>
    <a href="tel:+919412234688" class="btn btn--brass btn--full" style="margin-top:32px;">
        <i class="fas fa-phone-alt"></i> +91 94122 34688
    </a>
</div>
<div class="mobile-menu-overlay" id="mobile-menu-overlay"></div>

<script>
(function(){
  var h = document.getElementById('lux-header');
  function onScroll(){
    if (window.scrollY > 40) h.classList.add('scrolled');
    else h.classList.remove('scrolled');
  }
  onScroll();
  window.addEventListener('scroll', onScroll, { passive: true });

  var menu = document.getElementById('mobile-menu');
  var overlay = document.getElementById('mobile-menu-overlay');
  var toggle = document.querySelector('.mobile-menu-toggle');
  var close = document.querySelector('.mobile-menu-close');
  function openMenu(){ menu.classList.add('open'); overlay.classList.add('open'); }
  function closeMenu(){ menu.classList.remove('open'); overlay.classList.remove('open'); }
  if (toggle) toggle.addEventListener('click', openMenu);
  if (close) close.addEventListener('click', closeMenu);
  if (overlay) overlay.addEventListener('click', closeMenu);
  menu.querySelectorAll('a').forEach(function(a){ a.addEventListener('click', closeMenu); });
})();
</script>
