/**
 * Real Estate Chatbot — Embed Script (v2.0)
 * Loads chatbot resources on any external website via a single script tag.
 */
(function () {
  if (window.reChatbotLoaded) return;

  const scriptTag =
    document.currentScript ||
    (function () {
      const scripts = document.getElementsByTagName('script');
      return scripts[scripts.length - 1];
    })();

  // Derive base URL from the script's own src (works for both http and file://)
  let currentDomain;
  try {
    const src = scriptTag.src;
    // Strip "/assets/js/embed.js" suffix to get the root path
    const assetsIndex = src.lastIndexOf('/assets/js/');
    if (assetsIndex !== -1) {
      currentDomain = src.substring(0, assetsIndex);
    } else {
      // Fallback: strip filename and go up two directories
      const url = new URL(src);
      const parts = url.pathname.split('/');
      parts.splice(-3); // remove embed.js, js, assets
      currentDomain = url.origin + parts.join('/');
    }
  } catch {
    currentDomain = window.location.origin;
  }

  const apiBaseUrl = currentDomain + '/api';
  const websiteId = scriptTag.getAttribute('data-website-id') || 'default';
  const themeColor = scriptTag.getAttribute('data-theme-color') || '#005b52';
  const position = scriptTag.getAttribute('data-position') || 'right';
  const initialMessage = scriptTag.getAttribute('data-initial-message');

  function loadChatbot() {
    // CSS
    const link = document.createElement('link');
    link.rel = 'stylesheet';
    link.href = currentDomain + '/assets/css/chatbot.css';
    document.head.appendChild(link);

    // JS
    const script = document.createElement('script');
    script.src = currentDomain + '/assets/js/chatbot.js';
    script.id = 'real-estate-chatbot';
    script.setAttribute('data-api-url', apiBaseUrl);
    script.setAttribute('data-website-id', websiteId);
    script.setAttribute('data-theme-color', themeColor);
    script.setAttribute('data-position', position);
    if (initialMessage) {
      script.setAttribute('data-initial-message', initialMessage);
    }

    // chatbot.js auto-initialises via its own DOMContentLoaded / boot block,
    // so we do NOT create a second instance here.

    script.onerror = function () {
      console.error('[Chatbot] Failed to load chatbot script.');
    };

    document.body.appendChild(script);
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', loadChatbot);
  } else {
    loadChatbot();
  }
})();
