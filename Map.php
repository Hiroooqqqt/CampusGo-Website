<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="CSS/map.css">
    <title>CampusGo</title>
</head>
<body>
    <div class="container">
        <div class="logo">
            <img src="background/Logo_with_name.png" alt="logoimg">
        </div>
    </div>
    <div class="button-container">
        <button class="btn-1" onclick="showHelp('general')">General Help</button>
        <button class="btn-2" onclick="showHelp('technical')">Technical Support</button>
        <button class="back-button" onclick="history.back();">Back</button>
    </div>

    <div class="popup" id="popup">
        <div class="popup-content">
            <span class="close-btn" onclick="closePopup()">&#10006;</span>
            <div id="help-content" style="color: #333; text-align: left;"></div>
        </div>
    </div>

</body>
<script>
function showHelp(topic) {
    let content = '';

    if (topic === 'general') {
        content = `
            <h2>General Help</h2>
            <p>Welcome to the CampusGo Help Center. Here you’ll find information about using the platform.</p>
            <ul>
                <li>How to log in and access features</li>
                <li>Navigation tips</li>
                <li>How to contact your teachers</li>
            </ul>
        `;
    } else if (topic === 'technical') {
        content = `
            <h2>Technical Support</h2>
            <p>Having issues? Here are some quick fixes:</p>
            <ul>
                <li>Clear your browser cache</li>
                <li>Ensure JavaScript is enabled</li>
                <li>Still stuck? Contact campusgo2024@gmail.com</li>
            </ul>
        `;
    }

    document.getElementById('help-content').innerHTML = content;
    document.getElementById('popup').style.display = 'flex';
}

function closePopup() {
    document.getElementById('popup').style.display = 'none';
}
</script>

</html>
