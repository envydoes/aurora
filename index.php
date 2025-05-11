<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dingalan Aurora - Discover Paradise in the Philippines</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Header Section -->
    <header class="header">
        <nav class="navbar">
            <div class="logo">
                <img src="images/logo.png" alt="Dingalan Aurora Logo">
            </div>
            <ul class="nav-links">
                <li><a href="#home">Home</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#attractions">Attractions</a></li>
                <li><a href="#rooms">Rooms</a></li>
                <li><a href="#booking">Book Now</a></li>
                <li><a href="#calendar">Calendar</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
            <div class="hamburger">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </nav>
    </header>

    <!-- Hero Section -->
    <section id="home" class="hero">
        <div class="hero-content">
            <h1 class="hero-title">Dingalan Aurora</h1>
            <p class="hero-subtitle">A Hidden Gem on the Pacific Coast</p>
            <a href="#attractions" class="cta-button">Plan Your Journey</a>
        </div>
        <div class="hero-wave" style="line-height:0;">
            <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" style="display:block;width:100%;height:100px;">
                <path fill="#f5f9fa" d="M0,80 C360,140 1080,20 1440,80 L1440,120 L0,120Z" />
            </svg>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="about">
        <div class="container">
            <h2>About Dingalan</h2>
            <div class="about-content">
                <div class="about-text">
                    <p>Dingalan is a first-class municipality in the province of Aurora, Philippines. Known for its pristine beaches, majestic mountains, and rich cultural heritage, Dingalan offers visitors an unforgettable experience of natural beauty and local hospitality.</p>
                    <p>With its strategic location along the Pacific coast, Dingalan boasts stunning coastal views, crystal-clear waters, and a perfect blend of adventure and relaxation.</p>
                </div>
                <div class="about-image">
                    <img src="images/dingalan-placeholder.jpg" alt="Dingalan View" class="about-img-placeholder">
                </div>
            </div>
        </div>
    </section>

    <!-- Attractions Section -->
    <section id="attractions" class="attractions">
        <div class="container">
            <h2>Popular Attractions</h2>
            <div class="attractions-grid">
                <div class="attraction-card">
                    <img src="images/white-beach.jpg" alt="White Beach" class="attraction-img">
                    <h3>White Beach</h3>
                    <p>Pristine white sand beach perfect for swimming and relaxation</p>
                </div>
                <div class="attraction-card">
                    <img src="images/dingalan-point.jpg" alt="Dingalan Point" class="attraction-img">
                    <h3>Dingalan Point</h3>
                    <p>Scenic viewpoint offering panoramic ocean views</p>
                </div>
                <div class="attraction-card">
                    <img src="images/lamao-cave.jpg" alt="Lamao Cave" class="attraction-img">
                    <h3>Lamao Cave</h3>
                    <p>Explore the mysterious underground cave system</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section class="gallery">
        <div class="gallery-title">
            <h2>Gallery</h2>
        </div>
        <div class="gallery-container">
            <button class="gallery-nav prev" aria-label="Previous image"></button>
            <div class="gallery-grid">
                <div class="gallery-item">
                    <img src="images/white-beach.jpg" alt="White Beach" class="gallery-img">
                    <div class="gallery-caption">
                        <strong>White Beach</strong>
                        Crystal clear waters and pristine white sand beaches
                    </div>
                </div>
                <div class="gallery-item">
                    <img src="images/mountainview.jpg" alt="Dingalan Mountains" class="gallery-img">
                    <div class="gallery-caption">
                        <strong>Mountain View</strong>
                        Breathtaking views of the Sierra Madre mountain range
                    </div>
                </div>
                <div class="gallery-item">
                    <img src="images/dingalan-point.jpg" alt="Dingalan Point" class="gallery-img">
                    <div class="gallery-caption">
                        <strong>Sunset Point</strong>
                        Spectacular sunsets over the Pacific Ocean
                    </div>
                </div>
                <div class="gallery-item">
                    <img src="images/lighthouse.jpg" alt="Dingalan Lighthouse" class="gallery-img">
                    <div class="gallery-caption">
                        <strong>Lighthouse</strong>
                        The iconic Dingalan Lighthouse overlooking the Pacific Ocean
                    </div>
                </div>
                <div class="gallery-item">
                    <img src="images/seacliffs.jpg" alt="Dingalan Cliffs" class="gallery-img">
                    <div class="gallery-caption">
                        <strong>Sea Cliffs</strong>
                        Dramatic cliffs overlooking the ocean
                    </div>
                </div>
                <div class="gallery-item">
                    <img src="images/coastline.jpg" alt="Dingalan Coastline" class="gallery-img">
                    <div class="gallery-caption">
                        <strong>Coastline</strong>
                        Stunning coastline views and dramatic seascapes
                    </div>
                </div>
                <div class="gallery-item">
                    <img src="images/hiddenwaterfall.jpg" alt="Dingalan Waterfall" class="gallery-img">
                    <div class="gallery-caption">
                        <strong>Hidden Waterfall</strong>
                        Discover secluded waterfalls in the forest
                    </div>
                </div>
                <div class="gallery-item">
                    <img src="images/lamao-cave.jpg" alt="Dingalan Cave" class="gallery-img">
                    <div class="gallery-caption">
                        <strong>Lamao Cave</strong>
                        Explore ancient cave formations
                    </div>
                </div>
            </div>
            <button class="gallery-nav next" aria-label="Next image"></button>
        </div>
    </section>

    <!-- Activities Section -->
    <section id="activities" class="activities">
        <div class="container">
            <h2>Things to Do</h2>
            <div class="activities-grid">
                <div class="activity-card">
                    <i class="fas fa-swimmer"></i>
                    <h3>Beach Activities</h3>
                    <p>Swimming, snorkeling, and beach volleyball</p>
                </div>
                <div class="activity-card">
                    <i class="fas fa-hiking"></i>
                    <h3>Hiking</h3>
                    <p>Explore scenic trails and viewpoints</p>
                </div>
                <div class="activity-card">
                    <i class="fas fa-camera"></i>
                    <h3>Photography</h3>
                    <p>Capture stunning landscapes and sunsets</p>
                </div>
            </div>
        </div>
    </section>

    <!-- After Activities Section -->
    <section id="rooms" class="rooms-section">
        <div class="container">
            <h2 class="section-title">Our Rooms</h2>
            <div class="room-list horizontal-scroll">
                <!-- 1 Bed Room -->
                <div class="room-card">
                    <img src="images/1bed.jpg" alt="1 Bed Room">
                    <h3>1 Bed Room</h3>
                    <div class="room-features">
                        <span>1 Double Bed</span>
                        <span>Air Conditioning</span>
                        <span>Private Bathroom</span>
                        <span>Free WiFi</span>
                    </div>
                    <p>Perfect for solo travelers or couples, our 1 Bed Room offers comfort and privacy with a touch of Filipino hospitality. Enjoy a restful stay with all the essentials you need.</p>
                    <div class="room-price">PHP 1,000 / night</div>
                    <a href="#booking" class="book-btn">Book Now</a>
                </div>
                <!-- 2 Bed Room -->
                <div class="room-card">
                    <img src="images/2bed.jpg" alt="2 Bed Room">
                    <h3>2 Bed Room</h3>
                    <div class="room-features">
                        <span>2 Double Beds</span>
                        <span>Air Conditioning</span>
                        <span>Private Bathroom</span>
                        <span>Mountain View</span>
                    </div>
                    <p>Ideal for families or friends, our 2 Bed Room provides extra space and comfort. Experience the beauty of Dingalan with a relaxing stay in a modern Filipino-inspired setting.</p>
                    <div class="room-price">PHP 1,500 / night</div>
                    <a href="#booking" class="book-btn">Book Now</a>
                </div>
                <!-- 3 Bed Room -->
                <div class="room-card">
                    <img src="images/3bed.jpg" alt="3 Bed Room">
                    <h3>3 Bed Room</h3>
                    <div class="room-features">
                        <span>3 Double Beds</span>
                        <span>Air Conditioning</span>
                        <span>Private Bathroom</span>
                        <span>Ocean View</span>
                    </div>
                    <p>Traveling with a group? Our 3 Bed Room is perfect for barkadas or big families. Spacious, clean, and designed for comfort, it's your home away from home in Aurora.</p>
                    <div class="room-price">PHP 1,999 / night</div>
                    <a href="#booking" class="book-btn">Book Now</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Booking Section -->
    <section id="booking" class="booking">
        <div class="container">
            <h2>Book Your Visit</h2>
            <?php if (!empty($_SESSION['booking_error'])): ?>
                <div class="alert alert-danger" style="margin-bottom:20px;">
                    <?php echo $_SESSION['booking_error']; unset($_SESSION['booking_error']); ?>
                </div>
            <?php endif; ?>
            <div class="booking-content">
                <div class="booking-info">
                    <h3>Plan Your Perfect Trip</h3>
                    <p>Book your accommodation, tours, and activities in advance to ensure a memorable experience in Dingalan.</p>
                    <div class="booking-features">
                        <div class="feature">
                            <i class="fas fa-hotel"></i>
                            <h4>Accommodations</h4>
                            <p>Find the perfect place to stay</p>
                        </div>
                        <div class="feature">
                            <i class="fas fa-map-marked-alt"></i>
                            <h4>Guided Tours</h4>
                            <p>Explore with local experts</p>
                        </div>
                        <div class="feature">
                            <i class="fas fa-calendar-check"></i>
                            <h4>Easy Booking</h4>
                            <p>Simple and secure process</p>
                        </div>
                    </div>
                </div>
                <form class="booking-form" action="includes/booking.php" method="POST">
                    <div class="form-group">
                        <label for="check-in">Check-in Date</label>
                        <input type="date" id="check-in" name="check-in" required>
                    </div>
                    <div class="form-group">
                        <label for="check-out">Check-out Date</label>
                        <input type="date" id="check-out" name="check-out" required>
                    </div>
                    <div class="form-group">
                        <label for="accommodation">Room Type</label>
                        <select id="accommodation" name="accommodation" required>
                            <option value="1 Bed Room">1 Bed Room</option>
                            <option value="2 Bed Room">2 Bed Room</option>
                            <option value="3 Bed Room">3 Bed Room</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="email">Your Email</label>
                        <input type="email" id="email" name="email" required placeholder="you@email.com">
                    </div>
                    <button type="button" class="booking-btn" id="check-availability-btn">Check Availability</button>
                </form>
            </div>
        </div>
    </section>

    <!-- After Booking Section -->
    <?php
    require_once 'includes/config.php';
    $sql = "SELECT s.name as room_type, b.booking_date, COUNT(*) as booked_count
            FROM bookings b
            JOIN services s ON b.service_id = s.id
            WHERE b.status IN ('pending','confirmed','checkedin')
            GROUP BY s.name, b.booking_date";
    $result = mysqli_query($conn, $sql);
    $booked = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $booked[$row['room_type']][] = $row['booking_date'];
    }
    $room_types = ['1 Bed Room', '2 Bed Room', '3 Bed Room'];
    ?>
    <section id="calendar" class="calendar-section">
        <div class="container">
            <h2 class="section-title">Room Availability Calendar</h2>
            <div class="calendar-grid">
                <?php foreach ($room_types as $room): ?>
                <?php $year = date('Y'); $month = date('m'); ?>
                <div class="room-calendar" data-room="<?php echo $room; ?>" data-year="<?php echo $year; ?>" data-month="<?php echo $month; ?>">
                    <h3 style="text-align:center;margin-bottom:0.5rem;"><?php echo $room; ?></h3>
                    <div class="calendar-table-wrapper" style="width:100%;display:flex;justify-content:center;">
                    <?php
                    $days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                    $first_day = date('w', strtotime("$year-$month-01"));
                    $booked_dates = $booked[$room] ?? [];
                    ?>
                    <table class="calendar-table">
                        <tr>
                            <th>Sun</th><th>Mon</th><th>Tue</th><th>Wed</th><th>Thu</th><th>Fri</th><th>Sat</th>
                        </tr>
                        <tr>
                        <?php
                        $day = 1;
                        for ($i = 0; $i < $first_day; $i++) echo '<td></td>';
                        for ($i = $first_day; $i < 7; $i++) {
                            $date_str = sprintf('%04d-%02d-%02d', $year, $month, $day);
                            $is_booked = in_array($date_str, $booked_dates);
                            echo '<td class="' . ($is_booked ? 'booked' : 'available') . '">' . $day . '</td>';
                            $day++;
                        }
                        echo '</tr>';
                        while ($day <= $days_in_month) {
                            echo '<tr>';
                            for ($i = 0; $i < 7 && $day <= $days_in_month; $i++) {
                                $date_str = sprintf('%04d-%02d-%02d', $year, $month, $day);
                                $is_booked = in_array($date_str, $booked_dates);
                                echo '<td class="' . ($is_booked ? 'booked' : 'available') . '">' . $day . '</td>';
                                $day++;
                            }
                            while ($i < 7) { echo '<td></td>'; $i++; }
                            echo '</tr>';
                        }
                        ?>
                    </table>
                    </div>
                    <div style="margin-top:10px; font-size:0.95em;">
                        <span class="calendar-legend-booked"></span> Booked
                        <span class="calendar-legend-available"></span> Available
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Booking Summary Modal (hidden by default) -->
    <div id="booking-modal" class="modal" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(0,0,0,0.5); z-index:9999; align-items:center; justify-content:center;">
        <div class="modal-content" style="background:#fff; border-radius:10px; padding:32px 24px; max-width:400px; width:90%; margin:auto; position:relative;">
            <button id="close-modal-btn" style="position:absolute; top:12px; right:16px; background:none; border:none; font-size:1.5em; cursor:pointer;">&times;</button>
            <h4>Booking Summary</h4>
            <div id="modal-summary-details"></div>
            <button class="booking-btn" id="modal-book-now-btn" style="margin-top:18px; width:100%;">Book Now</button>
        </div>
    </div>
    <!-- Thank You Modal (hidden by default) -->
    <div id="thankyou-modal" class="modal" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(0,0,0,0.5); z-index:9999; align-items:center; justify-content:center;">
        <div class="modal-content" style="background:#e6f7e6; border-radius:10px; padding:32px 24px; max-width:400px; width:90%; margin:auto; text-align:center; position:relative;">
            <button id="close-thankyou-btn" style="position:absolute; top:12px; right:16px; background:none; border:none; font-size:1.5em; cursor:pointer;">&times;</button>
            <h4>Thank You for Booking!</h4>
            <div id="modal-thankyou-details"></div>
            <a href="index.php" class="booking-btn" style="margin-top:20px;">Back to Home</a>
        </div>
    </div>

    <!-- Contact Section -->
    <section id="contact" class="contact">
        <div class="container">
            <h2>Contact Us</h2>
            <div class="contact-content">
                <div class="contact-info">
                    <div class="info-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <p>Dingalan, Aurora, Philippines</p>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-phone"></i>
                        <p>09288103008</p>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-envelope"></i>
                        <p>dingalantravels@gmail.com</p>
                    </div>
                </div>
                <form class="contact-form" action="includes/contact.php" method="POST">
                    <input type="text" name="name" placeholder="Your Name" required>
                    <input type="email" name="email" placeholder="Your Email" required>
                    <textarea name="message" placeholder="Your Message" required></textarea>
                    <button type="submit" class="submit-btn">Send Message</button>
                </form>
            </div>
        </div>
    </section>

    <!-- Location/Map Section -->
    <section id="location" class="location-section">
        <div class="container">
            <h2>Find Us</h2>
            <p class="location-desc">Dingalan is located on the eastern coast of Aurora province, Philippines. Use the map below to explore our beautiful location and plan your visit!</p>
            <div class="map-responsive">
                <iframe src="https://www.google.com/maps?q=Dingalan%2C+Aurora%2C+Philippines&output=embed" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section" style="min-width:220px;">
                    <img src="images/logo.png" alt="Dingalan Aurora Logo" style="height:48px; margin-bottom:16px;">
                    <p>Discover the beauty of Dingalan, Aurora—where mountains meet the sea. Enjoy pristine beaches, breathtaking views, and the warmth of Filipino hospitality. Your adventure starts here!</p>
                </div>
                <div class="footer-section" style="margin-left:56px;">
                    <h3>Quick Links</h3>
                    <ul class="footer-quicklinks">
                        <li><a href="#home">Home</a></li>
                        <li><a href="#about">About</a></li>
                        <li><a href="#attractions">Attractions</a></li>
                        <li><a href="#rooms">Rooms</a></li>
                        <li><a href="#booking">Book Now</a></li>
                        <li><a href="#calendar">Calendar</a></li>
                        <li><a href="#contact">Contact</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3>Follow Us</h3>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> Dingalan Aurora Tourism. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="js/main.js"></script>
    <script>
    function showNextMonth(btn) {
        const calendar = btn.closest('.room-calendar');
        const wrapper = calendar.querySelector('.calendar-table-wrapper');
        let currentYear = calendar.dataset.year ? parseInt(calendar.dataset.year) : new Date().getFullYear();
        let currentMonth = calendar.dataset.month ? parseInt(calendar.dataset.month) : new Date().getMonth() + 1;
        let nextMonth = currentMonth + 1;
        let nextYear = currentYear;
        if (nextMonth > 12) { nextMonth = 1; nextYear++; }
        const room = calendar.getAttribute('data-room');
        wrapper.innerHTML = '<div style="text-align:center;padding:2rem;">Loading next month...</div>';
        fetch(`includes/calendar_month.php?room=${encodeURIComponent(room)}&year=${nextYear}&month=${nextMonth}`)
            .then(res => res.text())
            .then(html => {
                wrapper.innerHTML = html;
                calendar.dataset.year = nextYear;
                calendar.dataset.month = nextMonth;
            })
            .catch(() => {
                wrapper.innerHTML = '<div style="color:red;">Failed to load calendar.</div>';
            });
    }

    function showPrevMonth(btn) {
        const calendar = btn.closest('.room-calendar');
        const wrapper = calendar.querySelector('.calendar-table-wrapper');
        let currentYear = calendar.dataset.year ? parseInt(calendar.dataset.year) : new Date().getFullYear();
        let currentMonth = calendar.dataset.month ? parseInt(calendar.dataset.month) : new Date().getMonth() + 1;
        let prevMonth = currentMonth - 1;
        let prevYear = currentYear;
        if (prevMonth < 1) { prevMonth = 12; prevYear--; }
        const room = calendar.getAttribute('data-room');
        wrapper.innerHTML = '<div style="text-align:center;padding:2rem;">Loading previous month...</div>';
        fetch(`includes/calendar_month.php?room=${encodeURIComponent(room)}&year=${prevYear}&month=${prevMonth}`)
            .then(res => res.text())
            .then(html => {
                wrapper.innerHTML = html;
                calendar.dataset.year = prevYear;
                calendar.dataset.month = prevMonth;
            })
            .catch(() => {
                wrapper.innerHTML = '<div style="color:red;">Failed to load calendar.</div>';
            });
    }
    </script>
</body>
</html> 