<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .card {
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
            background: rgba(255, 255, 255, 0.9);
            width: 100%;
            max-width: 400px;
        }

        .profile-img {
            width: 80px;
            border: 3px solid #dee2e6;
            padding: 3px;
            transition: transform 0.3s;
        }

        .profile-img:hover {
            transform: scale(1.1);
        }

        .form-control {
            border-radius: 8px;
            transition: 0.3s;
        }

        .form-control:focus {
            box-shadow: 0px 0px 8px rgba(102, 126, 234, 0.5);
            border-color: #667eea;
        }

        .btn-dark {
            background-color: #4a5568;
            border: none;
            border-radius: 8px;
            transition: 0.3s;
        }

        .btn-dark:hover {
            background-color: #2d3748;
        }
    </style>
</head>

<body>
    <div class="card text-center">
        <div class="d-flex justify-content-center">
            <img src="img/user.jpg" class="img-fluid rounded-circle profile-img" alt="Profile">
        </div>

        <h2 class="mt-3 text-dark">SELAMAT DATANG DI TECHNOPARK GALLERY SMKN2 BANJARMASIN</h2>

        <form action="login_proses.php" method="POST">
            <div class="mb-3 text-start">
                <label for="username" class="form-label text-dark">Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>

            <div class="mb-3 text-start">
                <label for="password" class="form-label text-dark">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <!-- Tambahan: Pilihan role -->
            <div class="mb-3 text-start">
                <label for="role" class="form-label text-dark">Login sebagai</label>
                <select name="role" class="form-control" required>
                    <option value="pembeli">Pembeli</option>
                    <option value="kasir">Kasir</option>
                </select>
            </div>

            <button type="submit" name="login" class="btn btn-dark btn-lg w-100">Login</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>