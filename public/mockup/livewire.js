document.addEventListener('DOMContentLoaded', function () {
  const root = document.querySelector('[data-mockup-root]');

  if (!root) {
    return;
  }

  const body = document.body;
  const html = document.documentElement;
  const navLinks = Array.from(root.querySelectorAll('[data-nav-link]'));
  const navDropdownTrigger = root.querySelector('[data-videos-trigger]');
  const navDropdown = root.querySelector('[data-videos-dropdown]');
  const navDropdownItem = navDropdownTrigger ? navDropdownTrigger.closest('.nav-item') : null;
  const mobileToggle = root.querySelector('[data-mobile-toggle]');
  const mobileMenu = root.querySelector('[data-mobile-menu]');
  const themeToggle = root.querySelector('[data-theme-toggle]');
  const clockNodes = Array.from(root.querySelectorAll('[data-clock]'));
  const visitorNode = root.querySelector('[data-visitor-counter]');
  const toastNode = root.querySelector('[data-easter-toast]');
  const taglineNode = root.querySelector('[data-tagline-text]');
  const taglineDots = Array.from(root.querySelectorAll('[data-tagline-dot]'));
  const taglines = JSON.parse(root.querySelector('#mockup-taglines').textContent);
  let taglineIndex = 0;

  function applyTheme(theme) {
    html.setAttribute('data-theme', theme);
    localStorage.setItem('acenaga_theme', theme);

    if (themeToggle) {
      themeToggle.textContent = theme === 'dark' ? '☀' : '☾';
    }
  }

  applyTheme(localStorage.getItem('acenaga_theme') || 'dark');

  if (themeToggle) {
    themeToggle.addEventListener('click', function () {
      const nextTheme = html.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
      applyTheme(nextTheme);
    });
  }

  function updateClock() {
    const now = new Date();
    const time = now.toLocaleTimeString('es-AR', {
      hour: '2-digit',
      minute: '2-digit',
      second: '2-digit'
    });

    clockNodes.forEach(function (node) {
      node.textContent = time;
    });
  }

  updateClock();
  setInterval(updateClock, 1000);

  const visits = parseInt(localStorage.getItem('acenaga_visits') || '42', 10) + 1;
  localStorage.setItem('acenaga_visits', String(visits));

  if (visitorNode) {
    visitorNode.textContent = String(visits).padStart(5, '0');
  }

  function setTagline(index) {
    taglineIndex = index;

    if (taglineNode) {
      taglineNode.textContent = taglines[taglineIndex];
    }

    taglineDots.forEach(function (dot, currentIndex) {
      dot.style.width = currentIndex === taglineIndex ? '22px' : '8px';
      dot.style.background = currentIndex === taglineIndex ? 'var(--accent)' : 'var(--border-strong)';
    });
  }

  setTagline(0);

  taglineDots.forEach(function (dot) {
    dot.addEventListener('click', function () {
      setTagline(Number(dot.dataset.taglineDot));
    });
  });

  setInterval(function () {
    setTagline((taglineIndex + 1) % taglines.length);
  }, 3500);

  const revealObserver = new IntersectionObserver(function (entries) {
    entries.forEach(function (entry) {
      if (entry.isIntersecting) {
        entry.target.classList.add('in');
      }
    });
  }, { threshold: 0.12 });

  root.querySelectorAll('.reveal').forEach(function (section) {
    revealObserver.observe(section);
  });

  function updateActiveSection() {
    const sectionIds = ['top', 'about', 'stack', 'classes', 'projects', 'blog', 'instagram', 'youtube', 'twitch', 'contact'];
    let activeId = 'top';

    sectionIds.forEach(function (id) {
      const section = document.getElementById(id);

      if (!section) {
        return;
      }

      const rect = section.getBoundingClientRect();

      if (rect.top <= 120 && rect.bottom > 120) {
        activeId = id;
      }
    });

    navLinks.forEach(function (link) {
      link.classList.toggle('active', link.dataset.navLink === activeId);
    });

    if (navDropdownTrigger) {
      navDropdownTrigger.classList.toggle('active', activeId === 'youtube' || activeId === 'twitch');
    }
  }

  updateActiveSection();
  document.addEventListener('scroll', updateActiveSection, { passive: true });

  if (navDropdownTrigger && navDropdown && navDropdownItem) {
    navDropdownTrigger.addEventListener('click', function (event) {
      event.stopPropagation();
      navDropdownItem.classList.toggle('open');
    });

    document.addEventListener('click', function (event) {
      if (!navDropdown.contains(event.target) && !navDropdownTrigger.contains(event.target)) {
        navDropdownItem.classList.remove('open');
      }
    });
  }

  if (mobileToggle && mobileMenu) {
    mobileToggle.addEventListener('click', function () {
      mobileMenu.classList.toggle('open');
    });

    mobileMenu.querySelectorAll('a').forEach(function (link) {
      link.addEventListener('click', function () {
        mobileMenu.classList.remove('open');
      });
    });
  }

  function showToast(message) {
    if (!toastNode) {
      return;
    }

    toastNode.textContent = message;
    toastNode.classList.add('show');
    clearTimeout(window.__mockupToast);
    window.__mockupToast = setTimeout(function () {
      toastNode.classList.remove('show');
    }, 2500);
  }

  const konami = ['ArrowUp', 'ArrowUp', 'ArrowDown', 'ArrowDown', 'ArrowLeft', 'ArrowRight', 'ArrowLeft', 'ArrowRight', 'b', 'a'];
  let konamiIndex = 0;

  window.addEventListener('keydown', function (event) {
    if (event.key.toLowerCase() === konami[konamiIndex].toLowerCase()) {
      konamiIndex++;

      if (konamiIndex === konami.length) {
        body.classList.toggle('crt-mode');
        showToast(body.classList.contains('crt-mode') ? '★ MODO CRT 90s ACTIVADO ★' : '✕ CRT MODE OFF');
        konamiIndex = 0;
      }
    } else {
      konamiIndex = 0;
    }
  });
});
