(function () {
	'use strict';

	/* --- Sticky Header On Scroll ------------------------------------------- */
	const header = document.querySelector('.apollo-header');
	if (header) {
		const checkScroll = function () {
			if (window.scrollY > 20) {
				header.classList.add('is-scrolled');
			} else {
				header.classList.remove('is-scrolled');
			}
		};
		window.addEventListener('scroll', checkScroll, { passive: true });
		checkScroll();
	}

	/* --- Mobile Menu Toggle ------------------------------------------------ */
	const menuButton = document.querySelector('.apollo-menu-toggle');
	const navigation = document.querySelector('#apollo-navigation');

	if (menuButton && navigation) {
		menuButton.addEventListener('click', function () {
			const isOpen = menuButton.getAttribute('aria-expanded') === 'true';
			menuButton.setAttribute('aria-expanded', String(!isOpen));
			navigation.classList.toggle('is-open', !isOpen);
		});

		document.addEventListener('keydown', function (event) {
			if (event.key === 'Escape' && navigation.classList.contains('is-open')) {
				navigation.classList.remove('is-open');
				menuButton.setAttribute('aria-expanded', 'false');
				menuButton.focus();
			}
		});
	}

	/* --- Mobile Filters Toggle --------------------------------------------- */
	const filterButton = document.querySelector('.apollo-mobile-filter');
	const filters = document.querySelector('#apollo-product-filters');

	if (filterButton && filters) {
		filterButton.addEventListener('click', function () {
			const isOpen = filterButton.getAttribute('aria-expanded') === 'true';
			filterButton.setAttribute('aria-expanded', String(!isOpen));
			filters.classList.toggle('is-open', !isOpen);
		});
	}

	/* --- Header Search Panel ----------------------------------------------- */
	const searchButton = document.querySelector('.apollo-search-toggle');
	const searchPanel = document.querySelector('#apollo-search-panel');

	if (searchButton && searchPanel) {
		searchButton.addEventListener('click', function () {
			const isOpen = searchButton.getAttribute('aria-expanded') === 'true';
			searchButton.setAttribute('aria-expanded', String(!isOpen));
			searchPanel.hidden = isOpen;
			if (!isOpen) {
				const input = searchPanel.querySelector('input[type="search"]');
				if (input) input.focus();
			}
		});
	}

	/* --- Hero Indicators ---------------------------------------------------- */
	const heroIndicators = document.querySelectorAll('.apollo-hero-indicators__item');
	if (heroIndicators.length) {
		heroIndicators.forEach(function (indicator) {
			indicator.addEventListener('click', function () {
				heroIndicators.forEach(function (item) {
					item.classList.remove('is-active');
				});
				indicator.classList.add('is-active');
			});
		});
	}

	/* --- Newsletter Subscription Form -------------------------------------- */
	const newsletterForm = document.querySelector('#apollo-newsletter-form');
	const newsletterFeedback = document.querySelector('.apollo-newsletter__feedback');

	if (newsletterForm && newsletterFeedback && typeof apolloNewsletter !== 'undefined') {
		newsletterForm.addEventListener('submit', function (event) {
			event.preventDefault();
			const emailInput = newsletterForm.querySelector('input[type="email"]');
			const submitBtn = newsletterForm.querySelector('button[type="submit"]');
			const email = emailInput ? emailInput.value.trim() : '';

			if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
				newsletterFeedback.textContent = 'Vui lòng nhập địa chỉ email hợp lệ.';
				newsletterFeedback.className = 'apollo-newsletter__feedback is-error';
				if (emailInput) emailInput.focus();
				return;
			}

			const originalText = submitBtn.textContent;
			submitBtn.disabled = true;
			submitBtn.textContent = 'Đang gửi…';
			newsletterFeedback.textContent = '';
			newsletterFeedback.className = 'apollo-newsletter__feedback';

			const formData = new FormData();
			formData.append('action', 'apollo_newsletter');
			formData.append('email', email);
			formData.append('nonce', apolloNewsletter.nonce);

			fetch(apolloNewsletter.ajaxUrl, {
				method: 'POST',
				body: formData,
				credentials: 'same-origin',
			})
				.then(function (res) { return res.json(); })
				.then(function (data) {
					if (data.success) {
						newsletterFeedback.textContent = data.data.message || 'Đăng ký thành công!';
						newsletterFeedback.className = 'apollo-newsletter__feedback is-success';
						newsletterForm.reset();
					} else {
						newsletterFeedback.textContent = (data.data && data.data.message) || 'Đã xảy ra lỗi. Vui lòng thử lại.';
						newsletterFeedback.className = 'apollo-newsletter__feedback is-error';
					}
				})
				.catch(function () {
					newsletterFeedback.textContent = 'Lỗi kết nối. Vui lòng thử lại.';
					newsletterFeedback.className = 'apollo-newsletter__feedback is-error';
				})
				.finally(function () {
					submitBtn.disabled = false;
					submitBtn.textContent = originalText;
				});
		});
	}
}());
