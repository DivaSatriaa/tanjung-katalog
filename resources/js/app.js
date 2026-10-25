const menuButton = document.getElementById('mobile-menu-button');
const mobileMenu = document.getElementById('mobile-menu');

if (menuButton && mobileMenu) {
    const openIcon = menuButton.querySelector('[data-menu-icon="open"]');
    const closeIcon = menuButton.querySelector('[data-menu-icon="close"]');

    const setMenuOpen = (isOpen) => {
        mobileMenu.classList.toggle('hidden', !isOpen);
        openIcon.classList.toggle('hidden', isOpen);
        closeIcon.classList.toggle('hidden', !isOpen);
        menuButton.setAttribute('aria-expanded', String(isOpen));
        menuButton.setAttribute('aria-label', isOpen ? 'Tutup menu' : 'Buka menu');
    };

    menuButton.addEventListener('click', () => {
        setMenuOpen(menuButton.getAttribute('aria-expanded') !== 'true');
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            setMenuOpen(false);
        }
    });
}

const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
const numberFormat = new Intl.NumberFormat('id-ID');

/**
 * Hitung naik angka statistik dari 0 ke nilai akhirnya.
 */
function countUp(element) {
    const target = Number(element.dataset.countUp);

    if (prefersReducedMotion || !Number.isFinite(target) || target <= 0) {
        return;
    }

    const duration = 1200;
    const startedAt = performance.now();

    const tick = (now) => {
        const progress = Math.min((now - startedAt) / duration, 1);
        const eased = 1 - Math.pow(1 - progress, 3);

        element.textContent = numberFormat.format(Math.round(target * eased));

        if (progress < 1) {
            requestAnimationFrame(tick);
        }
    };

    element.textContent = '0';
    requestAnimationFrame(tick);
}

window.tanjungMotionStarted = true;

if (document.documentElement.classList.contains('motion-ready') && 'IntersectionObserver' in window) {
    document.querySelectorAll('[data-reveal-group]').forEach((group) => {
        [...group.children].forEach((child, index) => {
            child.setAttribute('data-reveal', '');
            child.style.setProperty('--reveal-delay', `${(index % 8) * 70}ms`);
        });
    });

    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (!entry.isIntersecting) {
                return;
            }

            entry.target.classList.add('is-revealed');
            revealObserver.unobserve(entry.target);
        });
    }, { rootMargin: '0px 0px -8% 0px', threshold: 0.1 });

    document.querySelectorAll('[data-reveal]').forEach((element) => revealObserver.observe(element));
} else {
    document.documentElement.classList.remove('motion-ready');
}

document.querySelectorAll('[data-count-up]').forEach(countUp);

const siteHeader = document.querySelector('[data-site-header]');

if (siteHeader) {
    const updateHeaderShadow = () => siteHeader.classList.toggle('is-scrolled', window.scrollY > 8);

    updateHeaderShadow();
    window.addEventListener('scroll', updateHeaderShadow, { passive: true });
}

document.querySelectorAll('[data-gallery]').forEach((gallery) => {
    const mainImage = gallery.querySelector('[data-gallery-main]');
    const thumbnails = gallery.querySelectorAll('[data-gallery-thumb]');

    if (!mainImage) {
        return;
    }

    thumbnails.forEach((thumbnail) => {
        thumbnail.addEventListener('click', () => {
            mainImage.src = thumbnail.dataset.src;

            thumbnails.forEach((item) => item.removeAttribute('aria-current'));
            thumbnail.setAttribute('aria-current', 'true');
        });
    });
});

const MAX_IMAGE_DIMENSION = 1920;
const COMPRESS_THRESHOLD_BYTES = 1024 * 1024;

/**
 * Perkecil foto besar (misalnya dari kamera ponsel) sebelum diunggah agar
 * tidak melebihi batas ukuran unggahan server.
 */
async function shrinkImage(file) {
    const isCompressible = ['image/jpeg', 'image/webp', 'image/png'].includes(file.type);

    if (!isCompressible || file.size <= COMPRESS_THRESHOLD_BYTES) {
        return file;
    }

    try {
        const bitmap = await createImageBitmap(file);
        const scale = Math.min(1, MAX_IMAGE_DIMENSION / Math.max(bitmap.width, bitmap.height));
        const canvas = document.createElement('canvas');
        canvas.width = Math.round(bitmap.width * scale);
        canvas.height = Math.round(bitmap.height * scale);

        const context = canvas.getContext('2d');
        context.fillStyle = '#ffffff';
        context.fillRect(0, 0, canvas.width, canvas.height);
        context.drawImage(bitmap, 0, 0, canvas.width, canvas.height);
        bitmap.close();

        const blob = await new Promise((resolve) => canvas.toBlob(resolve, 'image/jpeg', 0.85));

        if (!blob || blob.size >= file.size) {
            return file;
        }

        const name = file.name.replace(/\.[^.]+$/, '') + '.jpg';

        return new File([blob], name, { type: 'image/jpeg', lastModified: Date.now() });
    } catch {
        return file;
    }
}

function renderPreviews(input) {
    const singlePreview = document.getElementById(input.dataset.imagePreview ?? '');
    const galleryPreview = document.getElementById(input.dataset.galleryPreview ?? '');

    if (singlePreview) {
        const [file] = input.files;

        if (file) {
            singlePreview.src = URL.createObjectURL(file);
            singlePreview.classList.remove('hidden');
        } else {
            singlePreview.classList.add('hidden');
            singlePreview.removeAttribute('src');
        }
    }

    if (galleryPreview) {
        galleryPreview.replaceChildren();

        Array.from(input.files).forEach((file) => {
            const image = document.createElement('img');
            image.src = URL.createObjectURL(file);
            image.alt = '';
            image.className = 'aspect-square w-full rounded-xl border border-gray-200 object-cover';
            galleryPreview.append(image);
        });
    }
}

document.querySelectorAll('.admin-panel input[type="file"]').forEach((input) => {
    const form = input.closest('form');
    const submitButtons = form ? form.querySelectorAll('button[type="submit"]') : [];

    input.addEventListener('change', async () => {
        if (input.files.length === 0) {
            renderPreviews(input);

            return;
        }

        submitButtons.forEach((button) => {
            button.disabled = true;
        });

        try {
            const files = await Promise.all(Array.from(input.files).map(shrinkImage));

            if (typeof DataTransfer !== 'undefined') {
                const transfer = new DataTransfer();
                files.forEach((file) => transfer.items.add(file));
                input.files = transfer.files;
            }
        } finally {
            submitButtons.forEach((button) => {
                button.disabled = false;
            });

            renderPreviews(input);
        }
    });
});
