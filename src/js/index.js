document.addEventListener("DOMContentLoaded", function() {
    const lazyImages = document.querySelectorAll('.lazy-image');
    const lazyTexts = document.querySelectorAll('.lazy-text');

    const lazyLoad = (entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const container = entry.target;
                const image = container.querySelector('img');
                const texts = container.querySelectorAll('p');

                container.classList.add('loading');

                image.onload = () => {
                    container.classList.remove('loading');
                    container.classList.add('loaded');
                };

                image.src = image.getAttribute('src');
                texts.forEach(text => text.classList.add('loaded'));

                observer.unobserve(container);
            }
        });
    };

    const observer = new IntersectionObserver(lazyLoad, {
        rootMargin: '50px 0px',
        threshold: 0.1
    });

    document.querySelectorAll('.lazy-load-container').forEach(container => {
        observer.observe(container);
    });
});
