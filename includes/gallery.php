<?php
// Array of gallery images with their descriptions (6 items, no Lamao Cave or White Beach)
$gallery_images = [
    [
        'src' => 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=600&q=80',
        'alt' => 'Mountain View',
        'description' => 'Breathtaking mountain views of Dingalan'
    ],
    [
        'src' => 'https://images.unsplash.com/photo-1464983953574-0892a716854b?auto=format&fit=crop&w=600&q=80',
        'alt' => 'Sunset View',
        'description' => 'Beautiful sunset views from Dingalan Point'
    ],
    [
        'src' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=600&q=80',
        'alt' => 'Crystal Clear Waters',
        'description' => 'Crystal clear waters perfect for snorkeling'
    ],
    [
        'src' => 'https://images.unsplash.com/photo-1465101046530-73398c7f28ca?auto=format&fit=crop&w=600&q=80',
        'alt' => 'Local Culture',
        'description' => 'Experience the rich local culture and traditions'
    ],
    [
        'src' => 'https://images.unsplash.com/photo-1502082553048-f009c37129b9?auto=format&fit=crop&w=600&q=80',
        'alt' => 'Rock Formation',
        'description' => 'Unique rock formations along the Dingalan coast'
    ],
    [
        'src' => 'https://images.unsplash.com/photo-1500534314209-a25ddb2bd429?auto=format&fit=crop&w=600&q=80',
        'alt' => 'Forest Trail',
        'description' => 'Lush forest trails perfect for hiking and adventure'
    ]
];

// Output gallery items
foreach ($gallery_images as $image) {
    echo '<div class="gallery-item">';
    echo '<img src="' . htmlspecialchars($image['src']) . '" alt="' . htmlspecialchars($image['alt']) . '" class="gallery-img">';
    echo '<div class="gallery-caption"><strong>' . htmlspecialchars($image['alt']) . '</strong><br>' . htmlspecialchars($image['description']) . '</div>';
    echo '</div>';
}
?> 