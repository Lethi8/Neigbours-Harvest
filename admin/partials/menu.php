<?php include('../config/constants.php'); ?>

<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Neighbours Harvest - Admin</title>

    <style>
        .container {
            background-color: #8BC34A;
        }

        .navbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 20px;
        }

        .logo img {
            height: 45px;
            width: auto;
            object-fit: contain;
            display: block;
        }

        .nav-links {
            display: flex;
            align-items: center;
            list-style: none;
            gap: 18px;
            margin: 0;
            padding: 0;
        }

        .nav-links li {
            display: flex;
            align-items: center;
        }

        .nav-links a {
            text-decoration: none;
            color: white;
            font-weight: bold;
            padding: 8px 10px;
            display: block;
        }

        .nav-links a:hover {
            background-color: rgba(0,0,0,0.15);
            border-radius: 5px;
        }


        .tbl-full {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
        }

        .tbl-full th {
            background-color: #8BC34A;
            color: white;
            text-align: left;
            padding: 12px;
            border: 1px solid #ddd;
        }

        .tbl-full td {
            padding: 10px;
            border: 1px solid #ddd;
        }

        .tbl-full tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .tbl-full tr:hover {
            background-color: #f1f1f1;
        }

        /* Buttons consistency inside tables */
        .btn-primary,
        .btn-secondary,
        .btn-danger {
            display: inline-block;
            padding: 8px 12px;
            font-weight: bold;
            text-decoration: none;
            border-radius: 5px;
            color: white;
        }

        .btn-primary { background-color: #1e90ff; }
        .btn-primary:hover { background-color: #3742fa; }

        .btn-secondary { background-color: rgb(25, 191, 25); color: black; }
        .btn-secondary:hover { background-color: rgb(5, 60, 5); color: white; }

        .btn-danger { background-color: red; }
        .btn-danger:hover { background-color: rgb(176, 18, 18); }

        /* Mobile navbar */
        @media (max-width: 768px) {
            .navbar {
                flex-direction: column;
                text-align: center;
            }

            .nav-links {
                flex-direction: column;
                width: 100%;
                margin-top: 10px;
            }

            .nav-links li {
                justify-content: center;
            }
        }
    </style>
</head>

<body>

<div class="container">
    <div class="navbar">

        <div class="logo">
            <a href="index.php">
                <img src="../images/logo.png" alt="Neighbours Harvest Logo">
            </a>
        </div>

        <ul class="nav-links">

            <li><a href="index.php">Dashboard</a></li>
            <li><a href="manage-users.php">Users</a></li>
            <li><a href="manage-listings.php">Listings</a></li>
            <li><a href="manage-orders.php">Orders</a></li>
            <li><a href="logout.php">Logout</a></li>

        </ul>

    </div>
</div>