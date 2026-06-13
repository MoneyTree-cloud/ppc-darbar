<header class="lux-header" id="lux-header">
    <div class="lux-header__inner">
        <a href="#hero" class="lux-logo" aria-label="Joyville Vyomora home">
            <span class="lux-logo__eyebrow">Shapoorji Pallonji Presents</span>
            <span class="lux-logo__name">JOYVILLE VYOMORA</span>
        </a>

        <nav class="lux-nav" aria-label="Primary">
            <a href="#overview">Overview</a>
            <a href="#residences">Residences</a>
            <a href="#amenities">Amenities</a>
            <a href="#location">Location</a>
            <a href="#faq">FAQ</a>
        </nav>

        <div class="lux-header__cta">
            <a href="tel:+919100000000" class="lux-header__phone">
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
    <div class="lux-logo__eyebrow" style="color:var(--gold-soft); margin-bottom:6px;">Shapoorji Pallonji Presents</div>
    <div class="lux-logo__name" style="color:var(--ink); margin-bottom:36px;">JOYVILLE VYOMORA</div>
    <nav aria-label="Mobile">
        <a href="#overview">Overview</a>
        <a href="#residences">Residences &amp; Pricing</a>
        <a href="#floor-plans">Floor Plans</a>
        <a href="#amenities">Amenities</a>
        <a href="#location">Location</a>
        <a href="#about">About Developer</a>
        <a href="#faq">FAQ</a>
        <a href="#contact">Contact</a>
    </nav>
    <a href="tel:+919100000000" class="btn btn--green btn--full" style="margin-top:32px;">
        <i class="fas fa-phone-alt"></i> +91 94122 34688
    </a>
</div>
<div class="mobile-menu-overlay" id="mobile-menu-overlay"></div>

<script>
(function(){
  var h       = document.getElementById('lux-header');
  var menu    = document.getElementById('mobile-menu');
  var overlay = document.getElementById('mobile-menu-overlay');
  var toggle  = document.querySelector('.mobile-menu-toggle');
  var close   = document.querySelector('.mobile-menu-close');

  function onScroll(){ h.classList.toggle('scrolled', window.scrollY > 40); }
  onScroll();
  window.addEventListener('scroll', onScroll, { passive: true });

  function openMenu()  { menu.classList.add('open');    overlay.classList.add('open');    menu.setAttribute('aria-hidden','false'); }
  function closeMenu() { menu.classList.remove('open'); overlay.classList.remove('open'); menu.setAttribute('aria-hidden','true'); }

  if (toggle)  toggle.addEventListener('click', openMenu);
  if (close)   close.addEventListener('click', closeMenu);
  if (overlay) overlay.addEventListener('click', closeMenu);
  menu.querySelectorAll('a').forEach(function(a){ a.addEventListener('click', closeMenu); });
})();
</script>
