const heroScenes = window.SYNQ_DATA.heroScenes;
const scenes = window.SYNQ_DATA.scenes;
const plans = window.SYNQ_DATA.plans;
const ui = window.SYNQ_DATA.ui;
'use strict';
const $ = selector => document.querySelector(selector);
const menu = $('#menu'),
    nav = $('#nav');

function closeMenu(returnFocus = false) {
    nav.classList.remove('open');
    menu.setAttribute('aria-expanded', 'false');
    menu.setAttribute('aria-label', ui.openMenu);
    if (returnFocus) menu.focus();
}
menu.addEventListener('click', () => {
    const open = nav.classList.toggle('open');
    menu.setAttribute('aria-expanded', String(open));
    menu.setAttribute('aria-label', open ? ui.closeMenu : ui.openMenu);
});
nav.querySelectorAll('a').forEach(a => a.addEventListener('click', () => closeMenu()));
document.addEventListener('click', e => {
    if (!nav.contains(e.target) && !menu.contains(e.target)) closeMenu();
});
document.addEventListener('keydown', e => {
    if (e.key === 'Escape' && nav.classList.contains('open')) closeMenu(true);
});
window.addEventListener('resize', () => {
    if (window.innerWidth > 1000) closeMenu();
});

document.querySelectorAll('[data-scene]').forEach(button => button.addEventListener('click', () => {
    const scene = scenes[button.dataset.scene];
    if (!scene) return;
    document.querySelectorAll('[data-scene]').forEach(b => {
        b.classList.toggle('active', b === button);
        b.setAttribute('aria-pressed', String(b === button));
    });
    $('#scene-time').textContent = scene.time;
    $('#scene-title').textContent = scene.title;
    $('#lighting').textContent = scene.light;
    $('#curtains').textContent = scene.curtains;
    $('#scene-image').style.filter = scene.filter;
    $('#scene-tint').style.background = scene.tint;
}));
$('#scene-image').style.filter = scenes.relax.filter;
document.querySelectorAll('[data-plan]').forEach(button => button.addEventListener('click', () => {
    const plan = plans[button.dataset.plan];
    if (!plan) return;
    document.querySelectorAll('[data-plan]').forEach(b => {
        b.classList.toggle('active', b === button);
        b.setAttribute('aria-pressed', String(b === button));
    });
    $('#plan-title').textContent = plan.title;
    $('#plan-config').textContent = plan.label;
    $('#plan-description').textContent = plan.description;
    $('#plan-image').src = plan.image;
    $('#plan-image').alt = plan.alt;
    $('#plan-link').href = 'https://wa.me/' + document.body.dataset.whatsapp + '?text=' + encodeURIComponent(ui.planRequest.replace('{plan}', plan.label));
}));
const dialog = $('#lightbox');
let galleryTrigger = null,
    previousOverflow = '';

function closeLightbox() {
    if (typeof dialog.close === 'function') dialog.close();
    else {
        dialog.removeAttribute('open');
        afterClose();
    }
}

function afterClose() {
    document.body.style.overflow = previousOverflow;
    if (galleryTrigger) galleryTrigger.focus();
}
dialog.setAttribute('aria-label', $('#lightbox-image').alt);
document.querySelectorAll('[data-gallery]').forEach(button => button.addEventListener('click', () => {
    galleryTrigger = button;
    $('#lightbox-image').src = button.dataset.gallery;
    $('#lightbox-image').alt = button.querySelector('img').alt;
    previousOverflow = document.body.style.overflow;
    document.body.style.overflow = 'hidden';
    if (typeof dialog.showModal === 'function') dialog.showModal();
    else {
        dialog.setAttribute('open', '');
        dialog.setAttribute('role', 'dialog');
        dialog.setAttribute('aria-modal', 'true');
    }
    $('#close-lightbox').focus();
}));
$('#close-lightbox').addEventListener('click', closeLightbox);
dialog.addEventListener('close', afterClose);
dialog.addEventListener('click', e => {
    if (e.target === dialog) {
        const r = dialog.getBoundingClientRect();
        if (e.clientX < r.left || e.clientX > r.right || e.clientY < r.top || e.clientY > r.bottom) closeLightbox();
    }
});
dialog.addEventListener('keydown', e => {
    if (e.key === 'Tab') {
        e.preventDefault();
        $('#close-lightbox').focus();
    }
    if (e.key === 'Escape' && typeof dialog.close !== 'function') closeLightbox();
});

const hero = $('.hero'),
    heroImages = [...hero.querySelectorAll('.hero-image')],
    heroDots = [...hero.querySelectorAll('[data-hero-slide]')],
    pauseButton = $('#hero-pause');
const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
let heroIndex = 0,
    heroTimer = null,
    userPaused = reducedMotion.matches,
    hovered = false;

function showHero(index) {
    heroIndex = (index + heroScenes.length) % heroScenes.length;
    const slide = heroScenes[heroIndex];
    heroImages.forEach((img, i) => {
        img.classList.toggle('is-active', i === heroIndex);
        img.setAttribute('aria-hidden', String(i !== heroIndex));
    });
    heroDots.forEach((dot, i) => {
        dot.classList.toggle('active', i === heroIndex);
        dot.setAttribute('aria-pressed', String(i === heroIndex));
    });
    $('#hero-title').innerHTML = slide.title;
    $('#hero-description').innerHTML = slide.description;
    $('#hero-counter').textContent = String(heroIndex + 1).padStart(2, '0') + ' / ' + String(heroScenes.length).padStart(2, '0');
    for (const [id, key] of [
            ['hero-card-title', 'card'],
            ['hero-status', 'status'],
            ['hero-climate', 'climate'],
            ['hero-light', 'light'],
            ['hero-curtain', 'curtain'],
            ['hero-card-note', 'note']
        ]) document.getElementById(id).textContent = slide[key];
}

function stopHero() {
    window.clearInterval(heroTimer);
    heroTimer = null;
}

function startHero() {
    stopHero();
    if (!userPaused && !document.hidden && !hovered && !hero.contains(document.activeElement)) heroTimer = window.setInterval(() => showHero(heroIndex + 1), 5000);
}

function selectHero(index) {
    showHero(index);
    startHero();
}
heroDots.forEach((dot, i) => dot.addEventListener('click', () => selectHero(i)));
$('#hero-prev').addEventListener('click', () => selectHero(heroIndex - 1));
$('#hero-next').addEventListener('click', () => selectHero(heroIndex + 1));

function updatePause() {
    pauseButton.textContent = userPaused ? ui.play : ui.pause;
    pauseButton.setAttribute('aria-label', userPaused ? ui.playSlideshow : ui.pauseSlideshow);
}
pauseButton.addEventListener('click', () => {
    userPaused = !userPaused;
    updatePause();
    startHero();
});
hero.addEventListener('pointerenter', e => {
    if (e.pointerType === 'mouse') {
        hovered = true;
        stopHero();
    }
});
hero.addEventListener('pointerleave', e => {
    if (e.pointerType === 'mouse') {
        hovered = false;
        startHero();
    }
});
hero.addEventListener('focusin', stopHero);
hero.addEventListener('focusout', () => window.setTimeout(startHero, 0));
document.addEventListener('visibilitychange', startHero);

function motionChanged() {
    userPaused = reducedMotion.matches;
    updatePause();
    startHero();
}
if (reducedMotion.addEventListener) reducedMotion.addEventListener('change', motionChanged);
else if (reducedMotion.addListener) reducedMotion.addListener(motionChanged);
updatePause();
startHero();
