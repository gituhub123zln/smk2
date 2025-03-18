<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('img/banner.png') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .logout-container {
            width: 300px;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            text-align: center;
        }

        h1 {
            margin-bottom: 20px;
            color: #333;
        }

        button {
            padding: 10px 20px;
            width: 100%;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            opacity: 0.8;
        }
    </style>
</head>

<body>

    <div class="logout-container">
        <h1>You are Logged Out</h1>
        <button onclick="redirectToLogin()">Kembali ke Halaman Login</button>
    </div>

    <script>
        function redirectToLogin() {
            // Redirect ke halaman login
            window.location.href = "login.php";
        }
    </script>

</body>

</html>