
// Counter Up Animation
document.addEventListener('DOMContentLoaded', () => {
    const counters = document.querySelectorAll('[data-toggle="counter-up"]');
    const speed = 2000;

    counters.forEach(counter => {
        const updateCount = () => {
            const target = +counter.getAttribute('data-target');
            const count = +counter.innerText;

            const increment = target / speed * 10; 

            if (count < target) {
                counter.innerText = Math.ceil(count + increment);
                setTimeout(updateCount, 100);
            } else {
                counter.innerText = target;
            }
        };

        updateCount();
    });
});


