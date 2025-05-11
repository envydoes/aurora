// Mobile Menu Toggle
const hamburger = document.querySelector('.hamburger');
const navLinks = document.querySelector('.nav-links');

hamburger.addEventListener('click', () => {
    navLinks.classList.toggle('active');
    hamburger.classList.toggle('active');
});

// Smooth Scrolling for Navigation Links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
            // Close mobile menu if open
            navLinks.classList.remove('active');
            hamburger.classList.remove('active');
        }
    });
});

// Header Scroll Effect
const header = document.querySelector('.header');
let lastScroll = 0;

window.addEventListener('scroll', () => {
    const currentScroll = window.pageYOffset;
    
    if (currentScroll <= 0) {
        header.classList.remove('scroll-up');
        return;
    }
    
    if (currentScroll > lastScroll && !header.classList.contains('scroll-down')) {
        // Scroll Down
        header.classList.remove('scroll-up');
        header.classList.add('scroll-down');
    } else if (currentScroll < lastScroll && header.classList.contains('scroll-down')) {
        // Scroll Up
        header.classList.remove('scroll-down');
        header.classList.add('scroll-up');
    }
    lastScroll = currentScroll;
});

// Intersection Observer for Fade-in Animation
const observerOptions = {
    root: null,
    rootMargin: '0px',
    threshold: 0.1
};

const observer = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('fade-in');
            observer.unobserve(entry.target);
        }
    });
}, observerOptions);

// Observe all sections
document.querySelectorAll('section').forEach(section => {
    section.classList.add('fade-out');
    observer.observe(section);
});

// Gallery Image Modal
const galleryItems = document.querySelectorAll('.gallery-item');
const modal = document.createElement('div');
modal.classList.add('modal');
document.body.appendChild(modal);

galleryItems.forEach(item => {
    item.addEventListener('click', () => {
        const img = item.querySelector('img');
        modal.innerHTML = `
            <div class="modal-content">
                <img src="${img.src}" alt="${img.alt}">
                <button class="modal-close">&times;</button>
            </div>
        `;
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    });
});

modal.addEventListener('click', (e) => {
    if (e.target.classList.contains('modal') || e.target.classList.contains('modal-close')) {
        modal.classList.remove('active');
        document.body.style.overflow = '';
    }
});

// Modal-based Booking Flow
const bookingForm = document.querySelector('.booking-form');
const checkBtn = document.getElementById('check-availability-btn');
const bookingModal = document.getElementById('booking-modal');
const modalSummaryDetails = document.getElementById('modal-summary-details');
const modalBookNowBtn = document.getElementById('modal-book-now-btn');
const closeModalBtn = document.getElementById('close-modal-btn');
const thankyouModal = document.getElementById('thankyou-modal');
const modalThankyouDetails = document.getElementById('modal-thankyou-details');
const closeThankyouBtn = document.getElementById('close-thankyou-btn');

if (bookingForm && checkBtn && bookingModal && modalSummaryDetails && modalBookNowBtn && closeModalBtn && thankyouModal && modalThankyouDetails && closeThankyouBtn) {
    checkBtn.addEventListener('click', async function() {
        const checkIn = bookingForm.querySelector('#check-in').value;
        const checkOut = bookingForm.querySelector('#check-out').value;
        const accommodation = bookingForm.querySelector('#accommodation').value;
        const email = bookingForm.querySelector('#email').value;
        if (!checkIn || !checkOut || !accommodation || !email) {
            alert('Please fill in all fields.');
            return;
        }
        checkBtn.disabled = true;
        checkBtn.textContent = 'Checking...';
        const formData = new FormData();
        formData.append('check_in', checkIn);
        formData.append('check_out', checkOut);
        formData.append('accommodation', accommodation);
        const res = await fetch('includes/check_availability.php', { method: 'POST', body: formData });
        const data = await res.json();
        checkBtn.disabled = false;
        checkBtn.textContent = 'Check Availability';
        if (data.available) {
            // Calculate nights and price
            const start = new Date(checkIn);
            const end = new Date(checkOut);
            let nights = Math.round((end - start) / (1000 * 60 * 60 * 24));
            if (nights < 1) nights = 1;
            let pricePerNight = 0;
            if (accommodation === '1 Bed Room') pricePerNight = 1000;
            else if (accommodation === '2 Bed Room') pricePerNight = 1500;
            else if (accommodation === '3 Bed Room') pricePerNight = 1999;
            const totalPrice = nights * pricePerNight;
            // Show modal summary
            modalSummaryDetails.innerHTML = `
                <p><strong>Room Type:</strong> ${accommodation}</p>
                <p><strong>Check-in:</strong> ${checkIn}</p>
                <p><strong>Check-out:</strong> ${checkOut}</p>
                <p><strong>Email:</strong> ${email}</p>
                <p><strong>Number of Nights:</strong> ${nights}</p>
                <p><strong>Price per Night:</strong> PHP ${pricePerNight.toLocaleString()}</p>
                <p style="font-size:1.2em;"><strong>Total Price:</strong> PHP ${totalPrice.toLocaleString()}</p>
            `;
            bookingModal.style.display = 'flex';
        } else {
            alert('Sorry, this room is already booked for these dates: ' + (data.conflict_dates ? data.conflict_dates.join(', ') : ''));
        }
    });

    closeModalBtn.addEventListener('click', function() {
        bookingModal.style.display = 'none';
    });

    modalBookNowBtn.addEventListener('click', async function() {
        // Get form values again
        const checkIn = bookingForm.querySelector('#check-in').value;
        const checkOut = bookingForm.querySelector('#check-out').value;
        const accommodation = bookingForm.querySelector('#accommodation').value;
        const email = bookingForm.querySelector('#email').value;
        // Submit booking via AJAX
        const formData = new FormData();
        formData.append('check-in', checkIn);
        formData.append('check-out', checkOut);
        formData.append('accommodation', accommodation);
        formData.append('email', email);
        modalBookNowBtn.disabled = true;
        modalBookNowBtn.textContent = 'Booking...';
        try {
            const res = await fetch('includes/booking.php', { method: 'POST', body: formData });
            if (res.redirected) {
                window.location.href = res.url;
                return;
            }
            const data = await res.json();
            if (data.status === 'success') {
                bookingModal.style.display = 'none';
                modalThankyouDetails.innerHTML = `
                    <p>Your booking has been received. Please check your email for confirmation and payment instructions.</p>
                    <p><strong>Email:</strong> ${email}</p>
                    <p><strong>Room Type:</strong> ${accommodation}</p>
                    <p><strong>Check-in:</strong> ${checkIn}</p>
                    <p><strong>Check-out:</strong> ${checkOut}</p>
                    <p><strong>Number of Nights:</strong> ${data.nights}</p>
                    <p style="font-size:1.2em;"><strong>Total Price:</strong> PHP ${data.total_price.toLocaleString()}</p>
                `;
                thankyouModal.style.display = 'flex';
            } else {
                alert(data.message || 'There was an error processing your booking. Please try again.');
            }
        } catch (error) {
            alert('There was an error processing your booking. Please try again.');
        } finally {
            modalBookNowBtn.disabled = false;
            modalBookNowBtn.textContent = 'Book Now';
        }
    });

    closeThankyouBtn.addEventListener('click', function() {
        thankyouModal.style.display = 'none';
    });

    // Optional: close modal when clicking outside content
    window.addEventListener('click', function(e) {
        if (e.target === bookingModal) bookingModal.style.display = 'none';
        if (e.target === thankyouModal) thankyouModal.style.display = 'none';
    });
}

// Contact Form Validation
const contactForm = document.querySelector('.contact-form');
if (contactForm) {
    contactForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const name = this.querySelector('input[name="name"]').value;
        const email = this.querySelector('input[name="email"]').value;
        const message = this.querySelector('textarea[name="message"]').value;
        
        if (!name || !email || !message) {
            alert('Please fill in all fields');
            return;
        }
        
        if (!isValidEmail(email)) {
            alert('Please enter a valid email address');
            return;
        }
        
        // If validation passes, submit the form
        this.submit();
    });
}

// Email validation helper function
function isValidEmail(email) {
    const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}

// Animate elements on scroll
const animateOnScroll = () => {
    const elements = document.querySelectorAll('.animate-text, .attraction-card, .activity-card');
    
    elements.forEach(element => {
        const elementTop = element.getBoundingClientRect().top;
        const elementBottom = element.getBoundingClientRect().bottom;
        
        if (elementTop < window.innerHeight && elementBottom > 0) {
            element.classList.add('visible');
        }
    });
};

// Initial check for elements in view
animateOnScroll();

// Add scroll event listener
window.addEventListener('scroll', animateOnScroll);

// Add CSS for modal
const modalStyles = document.createElement('style');
modalStyles.textContent = `
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.8);
        z-index: 1000;
    }
    
    .modal.active {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .modal-content {
        position: relative;
        max-width: 90%;
        max-height: 90vh;
    }
    
    .modal-content img {
        max-width: 100%;
        max-height: 90vh;
        object-fit: contain;
    }
    
    .modal-close {
        position: absolute;
        top: -40px;
        right: 0;
        background: none;
        border: none;
        color: white;
        font-size: 30px;
        cursor: pointer;
    }
    
    .fade-out {
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.6s ease, transform 0.6s ease;
    }
    
    .fade-in {
        opacity: 1;
        transform: translateY(0);
    }
`;

document.head.appendChild(modalStyles);

// Weather Widget
const weatherWidget = {
    init() {
        this.updateWeather();
        // Update weather every 30 minutes
        setInterval(() => this.updateWeather(), 1800000);
    },

    async updateWeather() {
        try {
            // Replace with your actual API key and coordinates for Dingalan
            const response = await fetch('https://api.openweathermap.org/data/2.5/weather?lat=15.3897&lon=121.3927&units=metric&appid=YOUR_API_KEY');
            const data = await response.json();
            
            document.querySelector('.temp').textContent = Math.round(data.main.temp);
            document.querySelector('.wind').textContent = `${Math.round(data.wind.speed * 3.6)} km/h`;
            document.querySelector('.humidity').textContent = `${data.main.humidity}%`;
            
            // Update weather icon based on conditions
            const weatherIcon = document.querySelector('.weather-icon');
            const iconClass = this.getWeatherIcon(data.weather[0].id);
            weatherIcon.className = `fas ${iconClass} weather-icon`;
        } catch (error) {
            console.error('Error fetching weather data:', error);
        }
    },

    getWeatherIcon(code) {
        if (code >= 200 && code < 300) return 'fa-bolt';
        if (code >= 300 && code < 400) return 'fa-cloud-rain';
        if (code >= 500 && code < 600) return 'fa-cloud-showers-heavy';
        if (code >= 600 && code < 700) return 'fa-snowflake';
        if (code >= 700 && code < 800) return 'fa-smog';
        if (code === 800) return 'fa-sun';
        if (code > 800) return 'fa-cloud';
        return 'fa-cloud';
    }
};

// Virtual Tour
const virtualTour = {
    init() {
        this.locationButtons = document.querySelectorAll('.location-btn');
        this.tourFrame = document.querySelector('.tour-frame iframe');
        this.setupEventListeners();
    },

    setupEventListeners() {
        this.locationButtons.forEach(button => {
            button.addEventListener('click', () => {
                this.locationButtons.forEach(btn => btn.classList.remove('active'));
                button.classList.add('active');
                this.loadTour(button.dataset.location);
            });
        });
    },

    loadTour(location) {
        // Replace these URLs with actual 360° tour URLs
        const tourUrls = {
            beach: 'https://example.com/tours/white-beach',
            point: 'https://example.com/tours/dingalan-point',
            cave: 'https://example.com/tours/lamao-cave'
        };
        
        if (tourUrls[location]) {
            this.tourFrame.src = tourUrls[location];
        }
    }
};

// Booking System
const bookingSystem = {
    init() {
        this.form = document.querySelector('.booking-form');
        this.setupEventListeners();
    },

    setupEventListeners() {
        if (this.form) {
            this.form.addEventListener('submit', (e) => this.handleSubmit(e));
            
            // Set minimum date for check-in to today
            const checkInInput = this.form.querySelector('#check-in');
            const checkOutInput = this.form.querySelector('#check-out');
            
            const today = new Date().toISOString().split('T')[0];
            checkInInput.min = today;
            
            checkInInput.addEventListener('change', () => {
                checkOutInput.min = checkInInput.value;
            });
        }
    },

    async handleSubmit(e) {
        e.preventDefault();
        
        const formData = new FormData(this.form);
        
        try {
            const response = await fetch('includes/booking.php', {
                method: 'POST',
                body: formData
            });
            
            const data = await response.json();
            
            if (data.status === 'success') {
                alert(data.message);
                this.form.reset();
            } else {
                alert(data.message);
            }
        } catch (error) {
            console.error('Error submitting booking:', error);
            alert('There was an error processing your booking. Please try again.');
        }
    }
};

// Initialize new features
document.addEventListener('DOMContentLoaded', () => {
    weatherWidget.init();
    virtualTour.init();
    bookingSystem.init();
});

// Gallery Carousel with Infinite Scroll
document.addEventListener('DOMContentLoaded', function() {
    const galleryGrid = document.querySelector('.gallery-grid');
    const prevButton = document.querySelector('.gallery-nav.prev');
    const nextButton = document.querySelector('.gallery-nav.next');
    
    if (galleryGrid && prevButton && nextButton) {
        const itemWidth = galleryGrid.querySelector('.gallery-item').offsetWidth;
        const gap = 48; // 3rem gap in pixels
        let isScrolling = false;
        
        // Clone first and last items for infinite scroll
        const items = galleryGrid.querySelectorAll('.gallery-item');
        const firstItem = items[0].cloneNode(true);
        const lastItem = items[items.length - 1].cloneNode(true);
        
        galleryGrid.appendChild(firstItem);
        galleryGrid.insertBefore(lastItem, items[0]);
        
        // Set initial scroll position
        galleryGrid.scrollLeft = itemWidth + gap;
        
        function handleScroll() {
            if (isScrolling) return;
            
            const scrollLeft = galleryGrid.scrollLeft;
            const maxScroll = galleryGrid.scrollWidth - galleryGrid.clientWidth;
            
            // If we're at the end, jump to the beginning
            if (scrollLeft >= maxScroll - 10) {
                isScrolling = true;
                galleryGrid.scrollLeft = itemWidth + gap;
                setTimeout(() => isScrolling = false, 50);
            }
            // If we're at the beginning, jump to the end
            else if (scrollLeft <= 10) {
                isScrolling = true;
                galleryGrid.scrollLeft = maxScroll - itemWidth - gap;
                setTimeout(() => isScrolling = false, 50);
            }
        }
        
        function scrollToNext() {
            if (isScrolling) return;
            isScrolling = true;
            
            galleryGrid.scrollBy({
                left: itemWidth + gap,
                behavior: 'smooth'
            });
            
            setTimeout(() => isScrolling = false, 500);
        }
        
        function scrollToPrev() {
            if (isScrolling) return;
            isScrolling = true;
            
            galleryGrid.scrollBy({
                left: -(itemWidth + gap),
                behavior: 'smooth'
            });
            
            setTimeout(() => isScrolling = false, 500);
        }
        
        // Event Listeners
        prevButton.addEventListener('click', scrollToPrev);
        nextButton.addEventListener('click', scrollToNext);
        galleryGrid.addEventListener('scroll', handleScroll);
        
        // Auto-scroll every 5 seconds
        let autoScrollInterval = setInterval(scrollToNext, 5000);
        
        // Pause auto-scroll on hover
        galleryGrid.addEventListener('mouseenter', () => {
            clearInterval(autoScrollInterval);
        });
        
        galleryGrid.addEventListener('mouseleave', () => {
            autoScrollInterval = setInterval(scrollToNext, 5000);
        });
        
        // Touch support for mobile
        let touchStartX = 0;
        let touchEndX = 0;
        
        galleryGrid.addEventListener('touchstart', (e) => {
            touchStartX = e.changedTouches[0].screenX;
        });
        
        galleryGrid.addEventListener('touchend', (e) => {
            touchEndX = e.changedTouches[0].screenX;
            handleSwipe();
        });
        
        function handleSwipe() {
            const swipeThreshold = 50;
            if (touchEndX < touchStartX - swipeThreshold) {
                scrollToNext();
            } else if (touchEndX > touchStartX + swipeThreshold) {
                scrollToPrev();
            }
        }
    }
}); 