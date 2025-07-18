<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f8;
            display: flex;
            height: 100vh;
        }

        .sidebar {
            width: 220px;
            background-color: #2c3e50;
            color: #fff;
            padding-top: 30px;
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .sidebar a {
            display: block;
            padding: 15px 20px;
            color: #ecf0f1;
            text-decoration: none;
            transition: 0.3s;
        }

        .sidebar a:hover {
            background-color: #34495e;
        }

        .main-content {
            flex: 1;
            padding: 40px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logout-button {
            background-color: #e74c3c;
            color: white;
            padding: 8px 14px;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .logout-button:hover {
            background-color: #c0392b;
        }

        h1 {
            margin-top: 20px;
            font-size: 26px;
            color: #2c3e50;
        }

        p {
            margin-top: 10px;
            color: #555;
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <h2>Admin Panel</h2>
        <a href="{{ route('form.create') }}">Create Form</a>
        <a href="{{ route('form.update') }}">Update Form</a>
    </div>

    <div class="main-content">
        <div class="header">
            <div>
                <h1>Welcome, {{ Auth::user()->name }}</h1>
                <p>You are logged in as an admin.</p>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-button">Logout</button>
            </form>
        </div>
    </div>

</body>
</html>
