<!DOCTYPE html>
<html lang="en">
<head>
    <title>CampusGo</title>
    <link rel="stylesheet" href="CSS/map.css">
  
</head>
<body>
    <div class="container">
        <div class="logo">
            <img src="background/Logo_with_name.png" alt="logoimg">
        </div>
    </div>
    <div class="button-container">
        <button class="btn-1" onclick="openPopup('Map/Ground.png')">Ground Floor</button>
        <button class="btn-2" onclick="openPopup('Map/2nd_Floor.png')">Second Floor</button>
        <button class="back-button" onclick="history.back();" >Back</button>
    </div>

    <div class="popup" id="popup">
        <div class="popup-content">
            <span class="close-btn" onclick="closePopup()">&#10006;</span>
            <img id="popup-image" src="" alt="Floor Plan">
        </div>
    </div>

</body>
</html>
