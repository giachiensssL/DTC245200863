/**
 * TechPro Theme JavaScript
 * Student ID: DTC245200863
 */
(function() {
  'use strict';

  // Mobile navigation toggle
  const toggle = document.getElementById('nav-toggle');
  const nav = document.getElementById('main-nav');
  if (toggle && nav) {
    toggle.addEventListener('click', function() {
      const isOpen = nav.classList.toggle('open');
      toggle.setAttribute('aria-expanded', isOpen.toString());
    });
  }

  // Product filter (frontend filter for homepage products)
  const filterBtns = document.querySelectorAll('.filter-btn');
  filterBtns.forEach(function(btn) {
    btn.addEventListener('click', function() {
      filterBtns.forEach(function(b) { b.classList.remove('active'); });
      this.classList.add('active');
    });
  });

  // Sticky header shadow
  const header = document.getElementById('site-header');
  if (header) {
    window.addEventListener('scroll', function() {
      if (window.scrollY > 50) {
        header.style.boxShadow = '0 4px 20px rgba(0,0,0,0.2)';
      } else {
        header.style.boxShadow = 'none';
      }
    });
  }

  // Smooth scroll for anchor links
  document.querySelectorAll('a[href^="#"]').forEach(function(anchor) {
    anchor.addEventListener('click', function(e) {
      const target = document.querySelector(this.getAttribute('href'));
      if (target) {
        e.preventDefault();
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    });
  });

  // Contact form submission (basic UX)
  const contactForm = document.getElementById('contact-form');
  if (contactForm) {
    contactForm.addEventListener('submit', function(e) {
      const submitBtn = this.querySelector('[type="submit"]');
      if (submitBtn) {
        submitBtn.textContent = 'Đang gửi...';
        submitBtn.disabled = true;
      }
    });
  }

})();
