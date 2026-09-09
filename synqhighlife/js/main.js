(() => {
    'use strict';
    const $ = s => document.querySelector(s),
        all = s => [...document.querySelectorAll(s)];
    const menu = $('.menu'),
        nav = $('.links');

    function closeMenu() {
        menu.setAttribute('aria-expanded', 'false');
        nav.classList.remove('open')
    }
    menu.addEventListener('click', () => {
        const open = menu.getAttribute('aria-expanded') !== 'true';
        menu.setAttribute('aria-expanded', String(open));
        nav.classList.toggle('open', open)
    });
    nav.querySelectorAll('a').forEach(a => a.addEventListener('click', closeMenu));
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape' && nav.classList.contains('open')) {
            closeMenu();
            menu.focus()
        }
    });
    // Honest visual simulation; no smart-home API or microphone access.
    const scene = $('#ai-scene'),
        modes = all('[data-mode]'),
        range = $('#brightness'),
        out = $('#light-value');
    const modeData = {
        day: {
            title: 'A brighter beginning.',
            level: 100,
            text: 'Daylight visual simulation.'
        },
        evening: {
            title: 'Slow down. Settle in.',
            level: 78,
            text: 'Evening visual simulation.'
        },
        night: {
            title: 'Your quiet moment.',
            level: 48,
            text: 'Night visual simulation.'
        }
    };

    function brightness(v) {
        scene.style.setProperty('--brightness', String(v / 100));
        out.textContent = v + '%'
    }
    range.addEventListener('input', () => brightness(Number(range.value)));
    modes.forEach(b => b.addEventListener('click', () => {
        const mode = modeData[b.dataset.mode];
        modes.forEach(x => x.setAttribute('aria-pressed', String(x === b)));
        scene.classList.remove('scene-mode-evening', 'scene-mode-night');
        scene.classList.add('scene-mode-' + b.dataset.mode);
        $('#scene-title').textContent = mode.title;
        $('#scene-status').textContent = mode.text + ' Not a confirmed project feature.';
        range.value = mode.level;
        brightness(mode.level)
    }));
    const reduced = window.matchMedia('(prefers-reduced-motion: reduce)'),
        motion = $('.motion-toggle');
    let paused = reduced.matches;

    function setMotion() {
        document.body.dataset.motion = paused ? 'off' : 'on';
        motion.textContent = paused ? 'Enable motion' : 'Pause motion';
        motion.setAttribute('aria-pressed', String(paused));
        if (paused) {
            scene.style.setProperty('--rx', '0deg');
            scene.style.setProperty('--ry', '0deg')
        }
    }
    setMotion();
    motion.addEventListener('click', () => {
        paused = !paused;
        setMotion()
    });
    reduced.addEventListener('change', () => {
        paused = reduced.matches;
        setMotion()
    });
    const stage = $('.hero-stage');
    let frame = 0;
    stage.addEventListener('pointermove', e => {
        if (paused || reduced.matches || e.pointerType === 'touch') return;
        const r = stage.getBoundingClientRect();
        const x = (e.clientX - r.left) / r.width - .5,
            y = (e.clientY - r.top) / r.height - .5;
        cancelAnimationFrame(frame);
        frame = requestAnimationFrame(() => {
            scene.style.setProperty('--ry', (x * 7) + 'deg');
            scene.style.setProperty('--rx', (-y * 5) + 'deg')
        })
    });
    stage.addEventListener('pointerleave', () => {
        cancelAnimationFrame(frame);
        scene.style.setProperty('--rx', '0deg');
        scene.style.setProperty('--ry', paused ? '0deg' : '-3deg')
    });
    // Native markup is readable without JavaScript; enhance the two plan panels as tabs.
    const tabs = all('[data-plan]'),
        panels = all('.plan-panel');

    function selectPlan(t, focus = false) {
        tabs.forEach(b => {
            const selected = b === t;
            b.setAttribute('aria-selected', String(selected));
            b.tabIndex = selected ? 0 : -1
        });
        panels.forEach(p => p.hidden = p.id !== t.dataset.plan);
        if (focus) t.focus()
    }
    tabs.forEach((t, i) => {
        t.addEventListener('click', () => selectPlan(t));
        t.addEventListener('keydown', e => {
            let n = i;
            if (e.key === 'ArrowRight') n = (i + 1) % tabs.length;
            else if (e.key === 'ArrowLeft') n = (i + tabs.length - 1) % tabs.length;
            else if (e.key === 'Home') n = 0;
            else if (e.key === 'End') n = tabs.length - 1;
            else return;
            e.preventDefault();
            selectPlan(tabs[n], true)
        })
    });
    selectPlan(tabs[0]);
    const dialog = $('.lightbox'),
        photos = all('[data-gallery]');
    let current = 0,
        lastTrigger = null;

    function showPhoto(i) {
        current = (i + photos.length) % photos.length;
        const a = photos[current];
        dialog.querySelector('img').src = a.getAttribute('href');
        dialog.querySelector('img').alt = a.querySelector('img').alt;
        $('#lightbox-title').textContent = a.dataset.caption + ' · ' + (current + 1) + ' / ' + photos.length
    }
    photos.forEach((a, i) => a.addEventListener('click', e => {
        if (typeof dialog.showModal !== 'function') return;
        e.preventDefault();
        lastTrigger = a;
        showPhoto(i);
        dialog.showModal();
        document.body.classList.add('modal-open')
    }));
    dialog.querySelector('[data-close]').addEventListener('click', () => dialog.close());
    dialog.querySelector('[data-prev]').addEventListener('click', () => showPhoto(current - 1));
    dialog.querySelector('[data-next]').addEventListener('click', () => showPhoto(current + 1));
    dialog.addEventListener('click', e => {
        if (e.target === dialog) {
            const r = dialog.getBoundingClientRect();
            if (e.clientX < r.left || e.clientX > r.right || e.clientY < r.top || e.clientY > r.bottom) dialog.close()
        }
    });
    dialog.addEventListener('close', () => {
        document.body.classList.remove('modal-open');
        if (lastTrigger) lastTrigger.focus()
    });
    dialog.addEventListener('keydown', e => {
        if (e.key === 'ArrowRight') {
            e.preventDefault();
            showPhoto(current + 1)
        }
        if (e.key === 'ArrowLeft') {
            e.preventDefault();
            showPhoto(current - 1)
        }
    });
    const navLinks = all('.links a'),
        sections = navLinks.map(a => $(a.getAttribute('href')));
    let scheduled = false;

    function updateScroll() {
        scheduled = false;
        const height = document.documentElement.scrollHeight - innerHeight;
        $('.progress').style.transform = 'scaleX(' + (height > 0 ? Math.min(1, Math.max(0, scrollY / height)) : 0) + ')';
        let active = null;
        sections.forEach(s => {
            if (s.getBoundingClientRect().top <= 160) active = s.id
        });
        navLinks.forEach(a => {
            if (a.hash === '#' + active) a.setAttribute('aria-current', 'location');
            else a.removeAttribute('aria-current')
        })
    }
    addEventListener('scroll', () => {
        if (!scheduled) {
            scheduled = true;
            requestAnimationFrame(updateScroll)
        }
    }, {
        passive: true
    });
    addEventListener('resize', updateScroll);
    updateScroll();
    if ('IntersectionObserver' in window && !reduced.matches) {
        document.documentElement.classList.add('animate');
        const observer = new IntersectionObserver(entries => entries.forEach(e => {
            if (e.isIntersecting) {
                e.target.classList.remove('pending');
                observer.unobserve(e.target)
            }
        }), {
            threshold: .08
        });
        all('.reveal').forEach(el => {
            el.classList.add('pending');
            observer.observe(el)
        });
        setTimeout(() => all('.pending').forEach(el => el.classList.remove('pending')), 8000)
    }
})();
