/**
 * Real Estate Chatbot — Production JavaScript
 * Version: 2.0
 * Features: XSS-safe rendering, timestamps, message copy, retry on failure,
 *           chat persistence (localStorage), multi-line input, scroll-to-bottom,
 *           accessibility (ARIA, keyboard nav, focus trap), debounced sends,
 *           sound notification, character limit, proper cleanup.
 */

class RealEstateChatbot {
  // ── Constants ──────────────────────────────────────────────────────────
  static MAX_MESSAGE_LENGTH = 1000;
  static HISTORY_STORAGE_KEY = 're_chat_history';
  static LEAD_STORAGE_KEY = 're_lead_submitted';
  static DEBOUNCE_MS = 600;
  static SCROLL_THRESHOLD = 120; // px from bottom before showing scroll btn

  constructor(config = {}) {
    this.apiBaseUrl = config.apiBaseUrl || '/api';
    this.messageHistory = [];
    this.isOpen = false;
    this.leadFormShown = false;
    this.isSending = false;
    this.websiteId = config.websiteId || 'default';
    this.themeColor = config.themeColor || '#005b52';
    this.position = config.position || 'right';
    this.initialMessage =
      config.initialMessage ||
      "Hi there! I'm your MoneyTree real estate AI. How can I help you today?";
    this._lastSendTime = 0;
    this._boundCleanup = this.destroy.bind(this);

    this._init();
  }

  // ═══════════════════════════════════════════════════════════════════════
  //  INITIALISATION
  // ═══════════════════════════════════════════════════════════════════════

  _init() {
    this._buildDOM();
    this._bindEvents();
    this._restoreHistory();
    // check if lead was already submitted
    if (localStorage.getItem(RealEstateChatbot.LEAD_STORAGE_KEY)) {
      this.leadFormShown = true;
    }
  }

  // ═══════════════════════════════════════════════════════════════════════
  //  DOM CONSTRUCTION
  // ═══════════════════════════════════════════════════════════════════════

  _buildDOM() {
    // Container
    this.container = this._el('div', {
      className: `re-chatbot-container${this.position === 'left' ? ' left' : ''}`,
      attrs: { role: 'complementary', 'aria-label': 'Chat assistant' },
    });

    // FAB
    this.chatButton = this._el('button', {
      className: 're-chat-button',
      attrs: {
        'aria-label': 'Open chat',
        'aria-expanded': 'false',
        'aria-controls': 're-chat-panel',
        type: 'button',
      },
      html: '<img src="https://mtrp1.in/assets/ai-robot.gif" alt="" width="44" height="44">' +
            '<span class="re-notif-dot"></span>',
    });

    // Welcome nudge bubble
    this.welcomeNudge = this._el('div', {
      className: 're-welcome-nudge',
      html: `
        <div class="re-welcome-nudge-content">
          <span class="re-welcome-nudge-text">Hi! Need help finding a property?</span>
          <button class="re-welcome-nudge-close" aria-label="Dismiss" type="button">&times;</button>
        </div>
      `,
    });

    // Chat Window
    this.chatWindow = this._el('div', {
      className: 're-chat-window',
      attrs: {
        id: 're-chat-panel',
        role: 'dialog',
        'aria-label': 'Chat with MoneyTree AI',
      },
    });

    // Header
    this.chatHeader = this._el('div', {
      className: 're-chat-header',
      html: `
        <div class="re-chat-title">
          <div class="re-chat-avatar">
            <img src="https://mtrp1.in/assets/ai-robot.gif" alt="" width="32" height="32">
            <span class="re-online-dot"></span>
          </div>
          <div class="re-chat-title-text">
            <span class="re-chat-name">MoneyTree AI</span>
            <span class="re-chat-status">Online · Ready to help</span>
          </div>
        </div>
        <button class="re-chat-close" aria-label="Close chat" type="button">
          <svg width="16" height="16" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
            <line x1="4" y1="4" x2="12" y2="12"/><line x1="12" y1="4" x2="4" y2="12"/>
          </svg>
        </button>
      `,
    });

    // Messages area
    this.messagesContainer = this._el('div', {
      className: 're-chat-messages',
      attrs: {
        role: 'log',
        'aria-live': 'polite',
        'aria-label': 'Chat messages',
        tabindex: '0',
      },
    });

    // Scroll-to-bottom button
    this.scrollBtn = this._el('button', {
      className: 're-scroll-bottom',
      attrs: { 'aria-label': 'Scroll to latest message', type: 'button' },
      html: '↓',
    });

    // Input area — use textarea for multi-line
    this.inputContainer = this._el('div', {
      className: 're-chat-input-container',
      html: `
        <textarea class="re-chat-input" placeholder="Ask about properties…"
                  rows="1" aria-label="Type a message"
                  maxlength="${RealEstateChatbot.MAX_MESSAGE_LENGTH}"></textarea>
        <button class="re-chat-send" aria-label="Send message" type="button" disabled>
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
               stroke="currentColor" stroke-width="2" stroke-linecap="round"
               stroke-linejoin="round">
            <line x1="22" y1="2" x2="11" y2="13"></line>
            <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
          </svg>
        </button>
      `,
    });

    // Assemble
    this.chatWindow.append(this.chatHeader, this.messagesContainer, this.inputContainer);
    this.container.append(this.chatButton, this.welcomeNudge, this.chatWindow, this.scrollBtn);
    document.body.appendChild(this.container);

    // Cache refs
    this.chatInput = this.inputContainer.querySelector('.re-chat-input');
    this.chatSend = this.inputContainer.querySelector('.re-chat-send');
    this.chatClose = this.chatHeader.querySelector('.re-chat-close');
  }

  // ═══════════════════════════════════════════════════════════════════════
  //  EVENT BINDING
  // ═══════════════════════════════════════════════════════════════════════

  _bindEvents() {
    this.chatButton.addEventListener('click', () => this.toggle());
    this.chatClose.addEventListener('click', () => this.toggle());

    // Welcome nudge: show after 3s, dismiss on close or chat open
    this._nudgeTimer = setTimeout(() => {
      if (!this.isOpen) {
        this.welcomeNudge.classList.add('visible');
      }
    }, 3000);

    this.welcomeNudge.querySelector('.re-welcome-nudge-close').addEventListener('click', (e) => {
      e.stopPropagation();
      this._dismissNudge();
    });

    this.welcomeNudge.addEventListener('click', () => {
      this._dismissNudge();
      this.toggle();
    });
    this.chatSend.addEventListener('click', () => this._sendMessage());
    this.scrollBtn.addEventListener('click', () => this._scrollToBottom());

    // Textarea: auto-grow, send on Enter, newline on Shift+Enter
    this.chatInput.addEventListener('input', () => {
      this._autoGrow();
      this.chatSend.disabled = !this.chatInput.value.trim();
    });

    this.chatInput.addEventListener('keydown', (e) => {
      if (e.key === 'Enter' && !e.shiftKey) {
        e.preventDefault();
        this._sendMessage();
      }
    });

    // Scroll listener for scroll-to-bottom button
    this.messagesContainer.addEventListener('scroll', () => {
      this._updateScrollBtn();
    });

    // Keyboard: Escape closes chat
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && this.isOpen) this.toggle();
    });

    // Cleanup on page unload
    window.addEventListener('beforeunload', this._boundCleanup);
  }

  // ═══════════════════════════════════════════════════════════════════════
  //  TOGGLE CHAT
  // ═══════════════════════════════════════════════════════════════════════

  _dismissNudge() {
    clearTimeout(this._nudgeTimer);
    this.welcomeNudge.classList.remove('visible');
    this.welcomeNudge.classList.add('dismissed');
    // Hide notification dot too
    const dot = this.chatButton.querySelector('.re-notif-dot');
    if (dot) dot.style.display = 'none';
  }

  toggle() {
    this.isOpen = !this.isOpen;
    this.chatWindow.classList.toggle('active', this.isOpen);
    this.chatButton.setAttribute('aria-expanded', String(this.isOpen));

    if (this.isOpen) {
      this._dismissNudge();
      this.chatInput.focus();
      // Show initial message on first open
      if (this.messagesContainer.querySelectorAll('.re-message').length === 0) {
        this._showTyping();
        setTimeout(() => {
          this._hideTyping();
          this._addMessage(this.initialMessage, 'bot');
        }, 800);
      }
    }
  }

  // ═══════════════════════════════════════════════════════════════════════
  //  SEND MESSAGE
  // ═══════════════════════════════════════════════════════════════════════

  _sendMessage() {
    const text = this.chatInput.value.trim();
    if (!text || this.isSending) return;

    // Enforce max length
    if (text.length > RealEstateChatbot.MAX_MESSAGE_LENGTH) return;

    // Debounce
    const now = Date.now();
    if (now - this._lastSendTime < RealEstateChatbot.DEBOUNCE_MS) return;
    this._lastSendTime = now;

    // Add user message
    this._addMessage(text, 'user');
    this.chatInput.value = '';
    this._autoGrow();
    this.chatSend.disabled = true;

    this.messageHistory.push({ role: 'user', content: text });
    this._persistHistory();

    this._showTyping();
    this.isSending = true;

    this._callBackend(text);
  }

  _callBackend(message) {
    const controller = new AbortController();
    const timeoutId = setTimeout(() => controller.abort(), 30000);

    fetch(`${this.apiBaseUrl}/chat.php`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        message,
        history: this.messageHistory.slice(-20), // max 20 messages
        websiteId: this.websiteId,
      }),
      signal: controller.signal,
    })
      .then((res) => {
        clearTimeout(timeoutId);
        if (!res.ok) throw new Error(`HTTP ${res.status}`);
        return res.json();
      })
      .then((data) => {
        this._hideTyping();
        this.isSending = false;

        if (data.error) {
          this._addMessage(
            'Sorry, something went wrong. Please try again or call us at +91 94122 34688.',
            'bot'
          );
          return;
        }

        this._addMessage(data.message, 'bot');
        this.messageHistory.push({ role: 'assistant', content: data.message });
        this._persistHistory();

        if (data.suggestions?.length) {
          this._addSuggestions(data.suggestions);
        }

        if (data.showLeadForm && !this.leadFormShown) {
          setTimeout(() => {
            this._addMessage(
              "I'd love to connect you with a property expert for personalized help. Could you share your contact details below?",
              'bot'
            );
            setTimeout(() => this._showLeadForm(), 600);
          }, 800);
        }
      })
      .catch((err) => {
        clearTimeout(timeoutId);
        this._hideTyping();
        this.isSending = false;

        // Offer retry
        this._addRetryMessage(message);
        console.error('Chatbot error:', err);
      });
  }

  // ═══════════════════════════════════════════════════════════════════════
  //  ADD MESSAGE (XSS-safe)
  // ═══════════════════════════════════════════════════════════════════════

  _addMessage(text, sender) {
    const msgEl = this._el('div', {
      className: `re-message re-${sender}-message`,
    });

    if (sender === 'user') {
      // User messages: always plain text (no HTML)
      msgEl.textContent = text;
    } else {
      // Bot messages: sanitise then linkify
      msgEl.innerHTML = this._renderBotText(text);
    }

    // Copy button (on hover)
    const actions = this._el('div', { className: 're-message-actions' });
    const copyBtn = this._el('button', {
      attrs: { 'aria-label': 'Copy message', type: 'button', title: 'Copy' },
      html: '⎘',
    });
    copyBtn.addEventListener('click', () => {
      navigator.clipboard.writeText(text).then(() => {
        copyBtn.textContent = '✓';
        setTimeout(() => (copyBtn.textContent = '⎘'), 1500);
      });
    });
    actions.appendChild(copyBtn);
    msgEl.appendChild(actions);

    this.messagesContainer.appendChild(msgEl);

    // Timestamp
    const timeEl = this._el('div', {
      className: 're-message-time',
      text: this._formatTime(new Date()),
    });
    this.messagesContainer.appendChild(timeEl);

    this._scrollToBottom();
  }

  _addRetryMessage(originalMessage) {
    const wrapper = this._el('div', {
      className: 're-message re-bot-message',
    });

    const text = document.createTextNode(
      'Connection issue. Please try again or call +91 94122 34688. '
    );
    wrapper.appendChild(text);

    const retryBtn = this._el('button', {
      className: 're-suggestion',
      text: 'Retry',
      attrs: { type: 'button' },
    });
    retryBtn.addEventListener('click', () => {
      wrapper.remove();
      this._showTyping();
      this.isSending = true;
      this._callBackend(originalMessage);
    });
    wrapper.appendChild(retryBtn);

    this.messagesContainer.appendChild(wrapper);
    this._scrollToBottom();
  }

  // ═══════════════════════════════════════════════════════════════════════
  //  BOT TEXT RENDERING (safe)
  // ═══════════════════════════════════════════════════════════════════════

  _renderBotText(text) {
    // 0. Pre-process: normalize AI output before escaping
    let raw = text;

    // Remove markdown images ![alt](url)
    raw = raw.replace(/!\[[^\]]*\]\([^)]+\)\n?/g, '');

    // Convert markdown links [text](propertyUrl) → just the raw URL
    raw = raw.replace(
      /\[(?:[^\]]*)\]\((https:\/\/moneytreerealty\.com\/propertydetail\/[a-zA-Z0-9-]+)\)/g,
      '$1'
    );

    // Convert other markdown links [text](url) → text url
    raw = raw.replace(/\[([^\]]+)\]\((https?:\/\/[^)]+)\)/g, '$1 $2');

    // Remove numbered list prefixes (1. 2. 3.) before property names
    raw = raw.replace(/^\d+\.\s+/gm, '');

    // Collapse blank lines so property blocks stay together (name\ndetails\nURL)
    raw = raw.replace(/\n{2,}(https:\/\/moneytreerealty\.com)/g, '\n$1');

    // Clean up remaining triple+ blank lines
    raw = raw.replace(/\n{3,}/g, '\n\n');

    // 1. Escape HTML to prevent XSS
    let safe = this._escapeHTML(raw);

    // 2. Markdown formatting
    // Bold **text**
    safe = safe.replace(/\*\*(.+?)\*\*/g, '<strong>$1</strong>');
    // Italic *text* (but not inside bold tags)
    safe = safe.replace(/(?<!\*)\*([^*]+)\*(?!\*)/g, '<em>$1</em>');

    // 3. Convert bullet points and numbered lists into proper HTML lists
    //    Process blocks of consecutive list items
    safe = this._renderLists(safe);

    // 4. Convert property blocks into rich cards
    //    Captures: <strong>Name</strong> meta \n (1-3 detail lines) \n URL
    const cardPlaceholders = [];
    safe = safe.replace(
      /(?:^|\n)?<strong>([^<]+)<\/strong>([^\n]*)\n([\s\S]*?)\n(https:\/\/moneytreerealty\.com\/propertydetail\/[a-zA-Z0-9-]+)/g,
      (match, name, meta, middleLines, url) => {
        // Split middle lines into location + extra details
        const lines = middleLines.split('\n').map(l => l.trim()).filter(Boolean);
        const location = lines[0] || '';
        const extras = lines.slice(1).join(' · ');

        const placeholder = `__CARD_${cardPlaceholders.length}__`;
        cardPlaceholders.push(
          `<a href="${url}" class="re-property-card" target="_blank" rel="noopener noreferrer">` +
          `<div class="re-property-card-body">` +
          `<div class="re-property-card-name">${name.trim()}</div>` +
          `<div class="re-property-card-meta">${meta.replace(/^\s*[—–\-]\s*/, '').trim()}</div>` +
          `<div class="re-property-card-location">${location}${extras ? ' · ' + extras : ''}</div>` +
          `</div>` +
          `<span class="re-property-card-arrow">→</span>` +
          `</a>`
        );
        return '\n' + placeholder;
      }
    );

    // 5. Remaining standalone property URLs → pill link buttons
    safe = safe.replace(
      /(https:\/\/moneytreerealty\.com\/propertydetail\/[a-zA-Z0-9-]+)/g,
      '<a href="$1" class="re-property-link" target="_blank" rel="noopener noreferrer">View Property ↗</a>'
    );

    // 6. Linkify other http(s) URLs
    safe = safe.replace(
      /(?<!href=")(https?:\/\/(?!moneytreerealty\.com\/propertydetail)[^\s<]+)/g,
      '<a href="$1" target="_blank" rel="noopener noreferrer">$1</a>'
    );

    // 7. Line breaks (skip lines already inside list elements)
    safe = safe.replace(/\n/g, '<br>');

    // 8. Restore card placeholders
    cardPlaceholders.forEach((html, i) => {
      safe = safe.replace(`__CARD_${i}__`, html);
    });

    // 9. Clean up excessive <br> around cards and lists
    safe = safe.replace(/(<\/a>)\s*(<br\s*\/?>){1,3}/g, '$1');
    safe = safe.replace(/(<br\s*\/?>){1,2}\s*(<a[^>]*class="re-property-card)/g, '$2');
    safe = safe.replace(/(<br\s*\/?>)+\s*(<ul)/g, '$2');
    safe = safe.replace(/(<\/ul>)\s*(<br\s*\/?>)+/g, '$1');
    safe = safe.replace(/(<br\s*\/?>)+\s*(<ol)/g, '$2');
    safe = safe.replace(/(<\/ol>)\s*(<br\s*\/?>)+/g, '$1');

    return safe;
  }

  _renderLists(text) {
    const lines = text.split('\n');
    let result = [];
    let inUl = false;
    let inOl = false;

    for (let i = 0; i < lines.length; i++) {
      const line = lines[i];
      const bulletMatch = line.match(/^[\s]*[-•]\s+(.*)/);
      const numberMatch = line.match(/^[\s]*(\d+)[.)]\s+(.*)/);

      if (bulletMatch) {
        if (!inUl) { result.push('<ul class="re-list">'); inUl = true; }
        if (inOl) { result.push('</ol>'); inOl = false; }
        result.push(`<li>${bulletMatch[1]}</li>`);
      } else if (numberMatch) {
        if (!inOl) { result.push('<ol class="re-list">'); inOl = true; }
        if (inUl) { result.push('</ul>'); inUl = false; }
        result.push(`<li>${numberMatch[2]}</li>`);
      } else {
        if (inUl) { result.push('</ul>'); inUl = false; }
        if (inOl) { result.push('</ol>'); inOl = false; }
        result.push(line);
      }
    }
    if (inUl) result.push('</ul>');
    if (inOl) result.push('</ol>');

    return result.join('\n');
  }

  _escapeHTML(str) {
    const div = document.createElement('div');
    div.textContent = str;
    return div.innerHTML;
  }

  // ═══════════════════════════════════════════════════════════════════════
  //  SUGGESTIONS
  // ═══════════════════════════════════════════════════════════════════════

  _addSuggestions(suggestions) {
    const wrap = this._el('div', { className: 're-suggestions' });
    suggestions.forEach((s) => {
      const pill = this._el('button', {
        className: 're-suggestion',
        text: s,
        attrs: { type: 'button' },
      });
      pill.addEventListener('click', () => {
        wrap.remove();
        this.chatInput.value = s;
        this._sendMessage();
      });
      wrap.appendChild(pill);
    });
    this.messagesContainer.appendChild(wrap);
    this._scrollToBottom();
  }

  // ═══════════════════════════════════════════════════════════════════════
  //  LEAD FORM
  // ═══════════════════════════════════════════════════════════════════════

  _showLeadForm() {
    this.leadFormShown = true;

    const form = this._el('div', {
      className: 're-lead-form',
      attrs: { role: 'form', 'aria-label': 'Contact information' },
      html: `
        <h4>Contact Information</h4>
        <div class="re-form-group">
          <label for="re-name">Your Name</label>
          <input type="text" id="re-name" class="re-form-control"
                 placeholder="Enter your full name" autocomplete="name"
                 maxlength="255" required>
        </div>
        <div class="re-form-group">
          <label for="re-phone">Phone Number</label>
          <input type="tel" id="re-phone" class="re-form-control"
                 required minlength="10" maxlength="10" pattern="[6-9][0-9]{9}" title="Please enter a valid 10-digit Indian mobile number"
                 placeholder="10-digit mobile number" autocomplete="tel"
                 inputmode="numeric">
        </div>
        <div class="re-form-group">
          <label for="re-requirements">Property Requirements</label>
          <textarea id="re-requirements" class="re-form-control" rows="2"
                    placeholder="Location, budget, BHK…"
                    maxlength="5000"></textarea>
        </div>
        <button type="button" class="re-btn-submit">Connect with Property Expert</button>
      `,
    });

    // Phone: digits only
    const phoneInput = form.querySelector('#re-phone');
    phoneInput.addEventListener('input', () => {
      phoneInput.value = phoneInput.value.replace(/\D/g, '').slice(0, 10);
    });

    const submitBtn = form.querySelector('.re-btn-submit');
    submitBtn.addEventListener('click', () => this._submitLead(form));

    this.messagesContainer.appendChild(form);
    this._scrollToBottom();

    setTimeout(() => form.querySelector('#re-name').focus(), 200);
  }

  _submitLead(form) {
    const name = form.querySelector('#re-name').value.trim();
    const phone = form.querySelector('#re-phone').value.trim();
    const requirements = form.querySelector('#re-requirements').value.trim();

    // Clear previous validation
    form.querySelectorAll('.re-validation-message').forEach((el) => el.remove());

    if (!name || !phone) {
      this._showValidation(form, 'Please fill in your name and phone number.');
      return;
    }

    if (!/^[6-9][0-9]{9}$/.test(phone)) {
      this._showValidation(form, 'Please enter a valid 10-digit Indian mobile number.');
      return;
    }

    const btn = form.querySelector('.re-btn-submit');
    btn.disabled = true;
    btn.classList.add('is-loading');

    fetch(`${this.apiBaseUrl}/capture_lead.php`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        name,
        phone,
        requirements,
        chatHistory: this.messageHistory,
        websiteId: this.websiteId,
      }),
    })
      .then((res) => res.json())
      .then((data) => {
        form.remove();
        if (data.success) {
          localStorage.setItem(RealEstateChatbot.LEAD_STORAGE_KEY, '1');
          this._addMessage(
            `Thank you, ${this._escapeHTML(name)}! A property expert will call you shortly at ${phone}.`,
            'bot'
          );
        } else {
          this._addMessage(
            'There was an issue submitting your info. Please try again or call +91 94122 34688.',
            'bot'
          );
        }
      })
      .catch(() => {
        form.remove();
        this._addMessage(
          'Connection issue. Please call us directly at +91 94122 34688.',
          'bot'
        );
      });
  }

  _showValidation(form, message) {
    const msg = this._el('div', {
      className: 're-validation-message',
      text: message,
      attrs: { role: 'alert' },
    });
    form.insertBefore(msg, form.firstChild);
    setTimeout(() => msg.remove(), 4000);
  }

  // ═══════════════════════════════════════════════════════════════════════
  //  TYPING INDICATOR
  // ═══════════════════════════════════════════════════════════════════════

  _showTyping() {
    this._hideTyping(); // remove any existing
    const indicator = this._el('div', {
      className: 're-typing-indicator',
      attrs: { 'aria-label': 'Assistant is typing' },
      html: '<span></span><span></span><span></span>',
    });
    this.messagesContainer.appendChild(indicator);
    // Trigger reflow then show
    requestAnimationFrame(() => indicator.classList.add('visible'));
    this._scrollToBottom();
  }

  _hideTyping() {
    this.messagesContainer
      .querySelectorAll('.re-typing-indicator')
      .forEach((el) => el.remove());
  }

  // ═══════════════════════════════════════════════════════════════════════
  //  SCROLL
  // ═══════════════════════════════════════════════════════════════════════

  _scrollToBottom() {
    requestAnimationFrame(() => {
      this.messagesContainer.scrollTop = this.messagesContainer.scrollHeight;
    });
  }

  _updateScrollBtn() {
    const { scrollTop, scrollHeight, clientHeight } = this.messagesContainer;
    const distFromBottom = scrollHeight - scrollTop - clientHeight;
    this.scrollBtn.classList.toggle(
      'visible',
      distFromBottom > RealEstateChatbot.SCROLL_THRESHOLD
    );
  }

  // ═══════════════════════════════════════════════════════════════════════
  //  TEXTAREA AUTO-GROW
  // ═══════════════════════════════════════════════════════════════════════

  _autoGrow() {
    const ta = this.chatInput;
    ta.style.height = 'auto';
    ta.style.height = Math.min(ta.scrollHeight, 120) + 'px';
  }

  // ═══════════════════════════════════════════════════════════════════════
  //  CHAT PERSISTENCE (localStorage)
  // ═══════════════════════════════════════════════════════════════════════

  _persistHistory() {
    try {
      // Keep only last 40 messages to avoid storage bloat
      const trimmed = this.messageHistory.slice(-40);
      localStorage.setItem(
        RealEstateChatbot.HISTORY_STORAGE_KEY,
        JSON.stringify(trimmed)
      );
    } catch {
      // localStorage might be full or disabled
    }
  }

  _restoreHistory() {
    try {
      const stored = localStorage.getItem(RealEstateChatbot.HISTORY_STORAGE_KEY);
      if (!stored) return;
      const history = JSON.parse(stored);
      if (!Array.isArray(history) || history.length === 0) return;
      this.messageHistory = history;
    } catch {
      // corrupt data — ignore
    }
  }

  // ═══════════════════════════════════════════════════════════════════════
  //  UTILITY HELPERS
  // ═══════════════════════════════════════════════════════════════════════

  _el(tag, opts = {}) {
    const el = document.createElement(tag);
    if (opts.className) el.className = opts.className;
    if (opts.text) el.textContent = opts.text;
    if (opts.html) el.innerHTML = opts.html;
    if (opts.attrs) {
      Object.entries(opts.attrs).forEach(([k, v]) => el.setAttribute(k, v));
    }
    return el;
  }

  _formatTime(date) {
    return date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
  }

  // ═══════════════════════════════════════════════════════════════════════
  //  CLEANUP
  // ═══════════════════════════════════════════════════════════════════════

  destroy() {
    window.removeEventListener('beforeunload', this._boundCleanup);
    this.container?.remove();
  }
}

// ═══════════════════════════════════════════════════════════════════════════
//  AUTO-INITIALISE
// ═══════════════════════════════════════════════════════════════════════════
if (typeof window !== 'undefined' && !window.reChatbotLoaded) {
  window.reChatbotLoaded = true;

  const boot = () => {
    const scriptTag = document.getElementById('real-estate-chatbot');
    const config = {
      apiBaseUrl: scriptTag?.getAttribute('data-api-url') || '/api',
      websiteId: scriptTag?.getAttribute('data-website-id') || 'default',
      themeColor: scriptTag?.getAttribute('data-theme-color') || '#005b52',
      position: scriptTag?.getAttribute('data-position') || 'right',
      initialMessage: scriptTag?.getAttribute('data-initial-message') || undefined,
    };
    window.realEstateChatbot = new RealEstateChatbot(config);
  };

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', boot);
  } else {
    boot();
  }
}
