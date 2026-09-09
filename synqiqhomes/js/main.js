(function () {
  'use strict';

  var rooms = window.SYNQIQ_ROOMS || [];
  var tabs = document.querySelectorAll('.roomTab');
  var roomImage = document.getElementById('roomImage'),
    mode = document.getElementById('roomMode'),
    nameEl = document.getElementById('roomName'),
    desc = document.getElementById('roomDesc'),
    light = document.getElementById('roomLight'),
    curtain = document.getElementById('roomCurtain'),
    climate = document.getElementById('roomClimate');

  function setRoom(id) {
    var r = rooms.find(function (x) { return x.id === id; });
    if (!r) return;
    tabs.forEach(function (t) {
      var active = t.dataset.room === id;
      t.classList.toggle('bg-white', active);
      t.classList.toggle('text-black', active);
      t.classList.toggle('text-white/60', !active);
    });
    [roomImage, mode, nameEl, desc, light, curtain, climate].forEach(function (el) {
      el.animate([
        { opacity: .1, transform: 'translateY(8px)' },
        { opacity: 1, transform: 'translateY(0)' }
      ], { duration: 300, easing: 'ease-out' });
    });
    roomImage.src = r.image;
    roomImage.alt = r.name + ' scene';
    mode.textContent = r.mode;
    nameEl.textContent = r.name;
    desc.textContent = r.desc;
    light.textContent = r.light;
    curtain.textContent = r.curtain;
    climate.textContent = r.climate;
  }
  tabs.forEach(function (t) {
    t.addEventListener('click', function () { setRoom(t.dataset.room); });
  });

  var io = new IntersectionObserver(function (es) {
    es.forEach(function (e) {
      if (e.isIntersecting) e.target.classList.add('in');
    });
  }, { threshold: .1 });
  document.querySelectorAll('.reveal').forEach(function (x) { io.observe(x); });

  var menuBtn = document.getElementById('menuBtn'),
    mobile = document.getElementById('mobileMenu');
  menuBtn?.addEventListener('click', function () { mobile.classList.toggle('hidden'); });
  mobile?.querySelectorAll('a').forEach(function (a) {
    a.addEventListener('click', function () { mobile.classList.add('hidden'); });
  });

  var brochureBtn = document.getElementById('brochureBtn');
  brochureBtn?.addEventListener('click', function () {
    setTimeout(function () {
      document.getElementById('leadForm')?.querySelector('input[name="name"]')?.focus();
    }, 550);
  });

  // ---------- Lead form: submit to CRM via process-form.php ----------
  var leadForm = document.getElementById('leadForm');
  var leadFormStatus = document.getElementById('leadFormStatus');
  leadForm.addEventListener('submit', function (e) {
    e.preventDefault();

    var submitBtn = leadForm.querySelector('button[type="submit"]');
    var originalLabel = submitBtn.innerHTML;
    submitBtn.disabled = true;
    submitBtn.innerHTML = 'Sending…';
    leadFormStatus.textContent = '';
    leadFormStatus.className = 'text-xs text-center';

    fetch('process-form.php', {
      method: 'POST',
      body: new FormData(leadForm),
      headers: { 'X-Requested-With': 'XMLHttpRequest' },
      credentials: 'same-origin'
    })
      .then(function (r) {
        return r.text().then(function (text) {
          try { return { ok: r.ok, json: JSON.parse(text) }; }
          catch (_) { return { ok: false, json: { success: false, message: 'Unexpected server response' } }; }
        });
      })
      .then(function (res) {
        var json = res.json || {};
        if (json.success) {
          leadFormStatus.textContent = json.message || 'Thank you — we will contact you shortly.';
          leadFormStatus.className = 'text-xs text-center text-emerald-300';
          leadForm.reset();
        } else {
          leadFormStatus.textContent = json.message || 'Please check the form and try again.';
          leadFormStatus.className = 'text-xs text-center text-red-300';
        }
      })
      .catch(function () {
        leadFormStatus.textContent = 'Network error. Please call us directly.';
        leadFormStatus.className = 'text-xs text-center text-red-300';
      })
      .finally(function () {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalLabel;
      });
  });
})();
