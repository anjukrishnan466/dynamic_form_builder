<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f8;
            display: flex;
            min-height: 100vh;
            margin: 0;
        }

        .sidebar {
            width: 220px;
            background-color: #2c3e50;
            color: #fff;
            padding-top: 30px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
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

        .sidebar ul {
            list-style: none;
            padding-left: 0;
        }

        .logout-sidebar {
            padding: 20px;
        }

        .main-content {
            flex: 1;
            padding: 30px;
        }

        .header {
            margin-bottom: 20px;
        }

        .logout-button {
            background-color: #e74c3c;
            color: white;
            padding: 8px 14px;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            width: 100%;
        }

        .logout-button:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <div>
            <h2>Admin Panel</h2>
            <ul class="list-unstyled">
                <li><a href="{{ route('form.index') }}">Form List</a></li>
<li><a href="{{ route('form.create') }}">Create Form</a></li>

                <!-- Add more links as needed -->
            </ul>
        </div>

        <!-- Logout Button at Bottom -->
        @auth
        <div class="logout-sidebar">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-button">Logout</button>
            </form>
        </div>
        @endauth
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="header">
            <h1>Welcome, {{ Auth::user()->name }}</h1>
            <p>You are logged in as an admin.</p>  
        </div>

        <!-- Page Content -->
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
