const btn = document.getElementById('mobile-menu-btn');
        const menu = document.getElementById('mobile-menu');
        const navOffset = 92;
        let activeScrollAnimation = null;

        const easeInOutCubic = (progress) => {
            return progress < 0.5
                ? 4 * progress * progress * progress
                : 1 - Math.pow(-2 * progress + 2, 3) / 2;
        };

        const animateScrollTo = (targetTop, duration = 950) => {
            const startTop = window.pageYOffset;
            const distance = targetTop - startTop;
            const startTime = performance.now();

            if (activeScrollAnimation) {
                cancelAnimationFrame(activeScrollAnimation);
            }

            const step = (currentTime) => {
                const elapsed = currentTime - startTime;
                const progress = Math.min(elapsed / duration, 1);
                const eased = easeInOutCubic(progress);

                window.scrollTo(0, startTop + distance * eased);

                if (progress < 1) {
                    activeScrollAnimation = requestAnimationFrame(step);
                } else {
                    activeScrollAnimation = null;
                }
            };

            activeScrollAnimation = requestAnimationFrame(step);
        };

        btn?.addEventListener('click', () => {
            menu?.classList.toggle('hidden');
        });

        menu?.querySelectorAll('a').forEach((link) => {
            link.addEventListener('click', () => menu.classList.add('hidden'));
        });

        document.querySelectorAll('a[href^="#"]').forEach((link) => {
            link.addEventListener('click', (event) => {
                const targetId = link.getAttribute('href');

                if (!targetId || targetId === '#') {
                    return;
                }

                const target = document.querySelector(targetId);

                if (!target) {
                    return;
                }

                event.preventDefault();

                const targetTop = target.getBoundingClientRect().top + window.pageYOffset - navOffset;

                animateScrollTo(Math.max(targetTop, 0));

                history.pushState(null, '', targetId);
            });
        });

        const statsSection = document.getElementById('landing-stats');
        const statValues = document.querySelectorAll('.landing-stat-value');
        const numberFormatter = new Intl.NumberFormat('id-ID');

        const animateStatValue = (element) => {
            if (element.dataset.counted === 'true') {
                return;
            }

            const target = Number(element.dataset.countupTarget || '0');
            const suffix = element.dataset.countupSuffix || '';
            const duration = 1400;
            const startTime = performance.now();

            const updateValue = (currentTime) => {
                const elapsed = currentTime - startTime;
                const progress = Math.min(elapsed / duration, 1);
                const eased = 1 - Math.pow(1 - progress, 3);
                const currentValue = Math.round(target * eased);

                element.textContent = `${numberFormatter.format(currentValue)}${suffix}`;

                if (progress < 1) {
                    requestAnimationFrame(updateValue);
                } else {
                    element.textContent = `${numberFormatter.format(target)}${suffix}`;
                    element.dataset.counted = 'true';
                }
            };

            requestAnimationFrame(updateValue);
        };

        if (statsSection && statValues.length > 0) {
            const statsObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach((entry) => {
                    if (!entry.isIntersecting) {
                        return;
                    }

                    statValues.forEach((element) => animateStatValue(element));
                    observer.disconnect();
                });
            }, { threshold: 0.35 });

            statsObserver.observe(statsSection);
        }