<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Rooms - Dingalan Aurora</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background: #f5f9fa; }
        .rooms-container { max-width: 1100px; margin: 60px auto; background: #fff; border-radius: 12px; box-shadow: 0 0 20px rgba(0,0,0,0.08); padding: 40px 30px; }
        .rooms-title { text-align: center; color: #1a5f7a; margin-bottom: 30px; }
        .room-list { display: grid; grid-template-columns: 1fr 1fr; gap: 2.5rem; }
        .room-card { background: #f5f9fa; border-radius: 10px; box-shadow: 0 2px 8px rgba(44,62,80,0.06); padding: 24px; display: flex; flex-direction: column; align-items: center; }
        .room-card img { width: 100%; max-width: 340px; border-radius: 10px; margin-bottom: 18px; box-shadow: 0 2px 8px rgba(44,62,80,0.08); }
        .room-card h3 { color: #2e8b57; margin-bottom: 10px; }
        .room-card p { color: #2c3e50; margin-bottom: 10px; }
        .room-features { margin-bottom: 10px; }
        .room-features span { display: inline-block; background: #e6b17a; color: #fff; border-radius: 5px; padding: 4px 10px; margin: 0 5px 5px 0; font-size: 0.95em; }
        .room-price { color: #007bff; font-weight: 600; font-size: 1.1em; margin-bottom: 10px; }
        .book-btn { background: #1a5f7a; color: #fff; padding: 10px 28px; border-radius: 5px; text-decoration: none; font-weight: 500; transition: background 0.2s; }
        .book-btn:hover { background: #2e8b57; }
        @media (max-width: 900px) { .room-list { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <div class="rooms-container">
        <h2 class="rooms-title">Our Rooms</h2>
        <div class="room-list">
            <!-- 1 Bed Room -->
            <div class="room-card">
                <img src="images/room1-placeholder.jpg" alt="1 Bed Room">
                <h3>1 Bed Room</h3>
                <div class="room-features">
                    <span>1 Double Bed</span>
                    <span>Air Conditioning</span>
                    <span>Private Bathroom</span>
                    <span>Free WiFi</span>
                </div>
                <p>Perfect for solo travelers or couples, our 1 Bed Room offers comfort and privacy with a touch of Filipino hospitality. Enjoy a restful stay with all the essentials you need.</p>
                <div class="room-price">PHP 1,500 / night</div>
                <a href="index.php#booking" class="book-btn">Book Now</a>
            </div>
            <!-- 2 Bed Room -->
            <div class="room-card">
                <img src="images/room2-placeholder.jpg" alt="2 Bed Room">
                <h3>2 Bed Room</h3>
                <div class="room-features">
                    <span>2 Double Beds</span>
                    <span>Air Conditioning</span>
                    <span>Private Bathroom</span>
                    <span>Mountain View</span>
                </div>
                <p>Ideal for families or friends, our 2 Bed Room provides extra space and comfort. Experience the beauty of Dingalan with a relaxing stay in a modern Filipino-inspired setting.</p>
                <div class="room-price">PHP 1,500 / night</div>
                <a href="index.php#booking" class="book-btn">Book Now</a>
            </div>
            <!-- 3 Bed Room -->
            <div class="room-card">
                <img src="images/room3-placeholder.jpg" alt="3 Bed Room">
                <h3>3 Bed Room</h3>
                <div class="room-features">
                    <span>3 Double Beds</span>
                    <span>Air Conditioning</span>
                    <span>Private Bathroom</span>
                    <span>Ocean View</span>
                </div>
                <p>Traveling with a group? Our 3 Bed Room is perfect for barkadas or big families. Spacious, clean, and designed for comfort, it's your home away from home in Aurora.</p>
                <div class="room-price">PHP 1,500 / night</div>
                <a href="index.php#booking" class="book-btn">Book Now</a>
            </div>
            <!-- 4 Bed Room -->
            <div class="room-card">
                <img src="images/room4-placeholder.jpg" alt="4 Bed Room">
                <h3>4 Bed Room</h3>
                <div class="room-features">
                    <span>4 Double Beds</span>
                    <span>Air Conditioning</span>
                    <span>Private Bathroom</span>
                    <span>Garden Access</span>
                </div>
                <p>For large groups or extended families, our 4 Bed Room offers maximum space and convenience. Enjoy a memorable stay with all the amenities you need for a relaxing vacation.</p>
                <div class="room-price">PHP 1,500 / night</div>
                <a href="index.php#booking" class="book-btn">Book Now</a>
            </div>
        </div>
    </div>
</body>
</html> 