<?php
// Footer column configurations
$footerColumns = [
    'Shop' => [
        'RazerStores', 'RazerCafe', 'Store Locator', 'Purchase Programs', 
        'Bulk Order Program', 'Education', 'Only at Razer', 'RazerStore Rewards'
    ],
    'Explore' => [
        'Technology', 'Chroma RGB', 'Concepts', 'Esports', 'Collabs'
    ],
    'Support' => [
        'Get Help', 'Registration', 'RazerStore Support', 'RazerCare', 
        'Manage Razer ID', 'Support Video', 'Recycling', 'Accessibility'
    ],
    'Company' => [
        'About', 'Careers', 'Newsrooms', 'zVenture', 'Contact Us'
    ],
    'Follow Us' => [
        'fa-facebook', 'fa-instagram', 'fa-threads', 
        'fa-x-twitter', 'fa-youtube', 'fa-tiktok', 'fa-discord'
    ]
];

// Function to render footer links
function renderFooterLinks($title, $links, $isSocialMedia = false) {
    echo "<div class='container-list'>";
    echo "<h4 class='footer-title'>" . htmlspecialchars($title) . "</h4>";
    echo "<ul class='link'>";
    
    foreach ($links as $link) {
        if ($isSocialMedia) {
            echo "<li class='link-list social-link'>";
            echo "<a href='#'><i class='fa-brands " . htmlspecialchars($link) . "'></i></a>";
            echo "</li>";
        } else {
            echo "<li class='link-list'>";
            echo "<a href='#'>" . htmlspecialchars($link) . "</a>";
            echo "</li>";
        }
    }
    
    echo "</ul>";
    echo "</div>";
}
?>

<!DOCTYPE html>
<html lang="en">
<footer class="footer">
    <?php 
    $columnCount = 0;
    foreach ($footerColumns as $title => $links) {
        $isSocialMedia = ($title === 'Follow Us');
        renderFooterLinks($title, $links, $isSocialMedia);
        $columnCount++;
    }
    ?>
</footer>
</html>