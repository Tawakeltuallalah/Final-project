<?php
session_start();
require 'dbconfig.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $selected_role = $_POST['role'];

    if (empty($email) || empty($password) || empty($selected_role)) {
        echo json_encode(["status" => "error", "message" => "All fields are required"]);
        exit();
    }

    
    $stmt = $conn->prepare("SELECT * FROM user WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        // Check if account is active
        //if ($user['Status'] !== 'active') {
           // echo json_encode(["status" => "error", "message" => "Your account has been deactivated by the admin."]);
           // exit();
        //}

        
        if (password_verify($password, $user['Password']) && $selected_role === $user['Role']) {
            session_regenerate_id(true); // Prevent session fixation
            $_SESSION['user_id'] = $user['UserID'];
            $_SESSION['role'] = $user['Role'];
            $_SESSION['name'] = $user['Name'];

            echo json_encode(["status" => "success", "role" => $user['Role']]);
        } else {
            echo json_encode(["status" => "error", "message" => "Invalid credentials or role mismatch"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "User not found"]);
    }

    $stmt->close();
    $conn->close();
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
      
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to right, #1e3c72, #2a5298);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            width: 350px;
            text-align: center;
            animation: fadeIn 1s ease-in-out;
        }

        h2 {
            color: #2a3f54;
            font-size: 24px;
            margin-bottom: 15px;
        }

        input, select, button {
            display: block;
            margin: 12px auto;
            padding: 12px;
            width: 90%;
            font-size: 16px;
            border-radius: 8px;
            border: 1px solid #ddd;
            transition: all 0.3s ease-in-out;
        }

        input:focus, select:focus {
            border-color: #007bff;
            box-shadow: 0px 0px 8px rgba(0, 123, 255, 0.3);
            outline: none;
        }

        button {
            background: #28a745;
            color: white;
            font-weight: bold;
            cursor: pointer;
            border: none;
            transition: 0.3s ease-in-out;
        }

        button:hover {
            background: #218838;
            transform: scale(1.05);
        }

        .error {
            color: red;
            font-size: 14px;
            margin-top: 10px;
        }

        p {
            font-size: 14px;
        }

        p a {
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
        }

        p a:hover {
            text-decoration: underline;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

       
        @media (max-width: 400px) {
            .login-container {
                width: 90%;
                padding: 20px;
            }
        }
    </style>
</head>
<body>

    <div class="login-container">
        <h2>Login</h2>
        <form id="loginForm">
            <input type="email" id="email" name="email" placeholder="Email" required>
            <input type="password" id="password" name="password" placeholder="Password" required>
            <select id="role" name="role" required>
                <option value="">Select Role</option>
                <option value="Admin">Admin</option>
                <option value="School Director">School Director</option>
                <option value="Manager">Manager</option>
                <option value="Teacher">Teacher</option>
                <option value="Supervisor">Supervisor</option>
                <option value="Student">Student</option>
            </select>
            <button type="submit">Login</button>
        </form>
        <p class="error" id="error-message"></p>
        <p>Don't have an account? <a href="user-registration.php">Register here</a></p>
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function(event) {
            event.preventDefault();
            
            const loginButton = document.querySelector("button");
            loginButton.disabled = true;
            loginButton.innerText = "Logging in...";
            
            const formData = new FormData(this);

            fetch('login.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    alert("Login Successful as " + data.role);
                    
                    // Redirect user based on role
                    const roleRedirects = {
                        "Admin": "admin-panel.php",
                        "School Director": "Director.php",
                        "Manager": "manager_dashboard.php",
                        "Teacher": "teacher.php",
                        "Supervisor": "supervisor_dashboard.php",
                        "Student": "student_dashboard.php"
                    };

                    window.location.href = roleRedirects[data.role] || "dashboard.php";
                } else {
                    document.getElementById('error-message').innerText = data.message;
                }
            })
            .catch(error => console.error('Error:', error))
            .finally(() => {
                loginButton.disabled = false;
                loginButton.innerText = "Login";
            });
        });
    </script>
  
</body>
</html>
