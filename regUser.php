<!DOCTYPE html>
<html lang="en">
<head>
    <title>CampusGo</title>
    <link rel="stylesheet" href="CSS/regUser.css">
    <style>
        body {
    background-image: url(background/background_log_in.png);
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

.container {
    display: flex;
    flex-direction: column; 
    justify-content: space-between; 
    align-items: left; 
    height: 100%; 
    width: 100%; 
}

.logo {
    margin-top: 60px;
    max-width: 100px; 
    margin-bottom: 20px; 
    margin-left: 110px;
}

.info-container {
    display: flex;
    justify-content: center;
    align-items: center;
    color: #333;
    width: 100%;
}

.form-box {
    background-color: rgba(255, 255, 255, 0.3);
    padding: 40px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    width: 400px;
    text-align: center;
}

input[type="text"], input[type="password"] {
    color: #333;
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #ccc;
    border-radius: 20px;
    box-sizing: border-box;
}

.btn-login {
    margin-top: 20px;
    height: 50px;
    width: 100%;
    border: none;
    background-color: #c90060;
    color: aliceblue;
    border-radius: 50px;
    font-weight: bold;
    cursor: pointer;
}

.btn-login:hover {
    background-color: #a5003f;
}

            .modal {
            display: none;
            position: fixed;
            z-index: 999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(4px);
            animation: fadeIn 0.3s ease;
        }

        .modal-content {
            background-color: #fff;
            margin: 10% auto;
            padding: 30px;
            border-radius: 20px;
            width: 90%;
            max-width: 450px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            font-family: 'Segoe UI', sans-serif;
            color: #333;
        }

        .modal-content h3 {
            margin-top: 0;
            font-size: 1.6rem;
            color: #e91e63; /* pinkish tone */
        }

        .modal-content p {
            font-size: 1rem;
            line-height: 1.6;
            margin: 20px 0;
        }

        .modal-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .modal-buttons button {
            padding: 10px 18px;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.2s ease-in-out;
        }

        .modal-buttons button:first-child {
            background-color: #f2f2f2;
            color: #333;
        }

        .modal-buttons button:first-child:hover {
            background-color: #ddd;
        }

        .modal-buttons button:last-child {
            background-color: #e91e63;
            color: #fff;
        }

        .modal-buttons button:last-child:hover {
            background-color: #d81b60;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
    <script>
        function showTermsModal(e) {
            e.preventDefault();

            const password = document.getElementById('password').value;
            const confPassword = document.getElementById('confPassword').value;

            if (password !== confPassword) {
                alert("Passwords do not match!");
                return;
            }

            const currentDate = new Date();
            const formattedDate = currentDate.toLocaleString();  
            document.getElementById('effectiveDate').textContent = formattedDate;
            document.getElementById('termsModal').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('termsModal').style.display = 'none';
        }

        function acceptTermsAndRegister() {
            closeModal();
            document.getElementById('registerForm').submit();
            window.location.href = "loginpage.php";
        }
    </script>
</head>
<body>
    <div class="container">
        <div class="logo">
            <img src="background/Logo_with_name.png" alt="logoimg">
        </div>
    </div>
    <div class="info-container">
        <div class="form-box">
            <form id="registerForm" action="register_user.php" method="POST" onsubmit="showTermsModal(event)">
                <input type="text" id="name" name="name" placeholder="Full Name" required><br>
                <input type="text" id="Identification" name="Identification" placeholder="Identification Number" required><br>
                <input type="text" id="email" name="email" placeholder="Email" required><br>
                <input type="password" id="password" name="password" placeholder="Password" required><br>
                <input type="password" id="confPassword" placeholder="Confirm Password" required><br>
                <button class="btn-login" type="submit">Register</button>
            </form>
        </div>
    </div>

    
<div id="termsModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h3>Terms and Conditions for Student Portal</h3>
            <p><strong>Effective Date: <span id="effectiveDate">[Insert Date]</span></strong></p>
            <p>Welcome to CampusGo of Bulacan State University - Meneses Campus. By accessing or using this portal, you agree to be bound by the following Terms and Conditions. Please read them carefully.</p>

            <ol>
                <li><strong>Acceptance of Terms</strong><br>
                    By logging in and using the Student Portal, you agree to comply with and be bound by these Terms and Conditions. If you do not agree, please do not use the portal.
                </li>
                <li><strong>Eligibility</strong><br>
                    Only officially enrolled students, authorized faculty, and staff of Bulacan State University - Meneses Campus are permitted to access this portal.
                </li>
                <li><strong>User Account and Responsibility</strong><br>
                    You are responsible for maintaining the confidentiality of your login credentials. You agree to notify the administration immediately of any unauthorized use of your account. Misuse of your account (e.g., impersonating others or accessing restricted areas) may result in disciplinary action.
                </li>
                <li><strong>Permitted Use</strong><br>
                    The portal is intended solely for educational and academic purposes, including:
                    <ul>
                        <li>Viewing class schedules, announcements, and academic records.</li>
                        <li>Submitting assignments and communicating with faculty.</li>
                    </ul>
                    You agree not to use the portal for any illegal or unauthorized purpose.
                </li>
                <li><strong>Data Privacy</strong><br>
                    Your personal information will be handled in accordance with our [Privacy Policy] and applicable data protection laws. The school reserves the right to monitor portal activity for security and academic integrity.
                </li>
                <li><strong>Content Ownership</strong><br>
                    All materials available on the portal, including documents, videos, and software, are the property of [School Name] or its licensors and are protected by intellectual property laws.
                </li>
                <li><strong>Prohibited Activities</strong><br>
                    You agree not to:
                    <ul>
                        <li>Attempt to breach the security of the system.</li>
                        <li>Upload viruses or harmful software.</li>
                        <li>Harass, threaten, or harm other users.</li>
                        <li>Share or distribute copyrighted material without permission.</li>
                    </ul>
                </li>
                <li><strong>System Availability</strong><br>
                    We strive to ensure the portal is always accessible but do not guarantee uninterrupted service. Maintenance or technical issues may result in temporary unavailability.
                </li>
                <li><strong>Modifications</strong><br>
                    We reserve the right to modify these Terms at any time. Continued use of the portal after changes means you accept the new Terms.
                </li>
                <li><strong>Termination of Access</strong><br>
                    We reserve the right to suspend or terminate your access to the portal for violations of these Terms, academic misconduct, or other applicable policies.
                </li>
            </ol>
            <div class="modal-buttons">
                <button onclick="closeModal()">Cancel</button>
                <button onclick="acceptTermsAndRegister()">I Accept</button>
            </div>
        </div>
    </div>
</body>
</html>


