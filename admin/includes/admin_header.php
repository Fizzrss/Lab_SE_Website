<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Lab Software Engineering</title>

    <link rel="shortcut icon" href="/Lab_SE_Website/admin/assets/compiled/svg/favicon.svg" type="image/x-icon">

    <link rel="stylesheet" href="/Lab_SE_Website/admin/assets/compiled/css/app.css">
    <link rel="stylesheet" href="/Lab_SE_Website/admin/assets/compiled/css/iconly.css">
    
    <link rel="stylesheet" href="/Lab_SE_Website/admin/assets/extensions/perfect-scrollbar/perfect-scrollbar.css">
    
    <link rel="stylesheet" href="/Lab_SE_Website/admin/assets/extensions/simple-datatables/style.css">
    <link rel="stylesheet" href="/Lab_SE_Website/admin/assets/compiled/css/table-datatable.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <!-- Custom CSS -->
    <style>
        /* Custom styles */
        .stats-icon {
            width: 3rem;
            height: 3rem;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .stats-icon.purple {
            background-color: #E0E7FF;
            color: #5145CD;
        }

        .stats-icon.blue {
            background-color: #CCF0EB;
            color: #16AAAA;
        }

        .stats-icon.green {
            background-color: #D4F4DD;
            color: #2FA848;
        }

        .stats-icon.red {
            background-color: #FFE0E0;
            color: #E42728;
        }

        .card {
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        /* Sidebar active state */
        .sidebar-item.active>.sidebar-link {
            background-color: #435ebe;
            color: white;
        }

        .sidebar-item.active>.sidebar-link i {
            color: white;
        }

        /* Table hover effect */
        .table-hover tbody tr:hover {
            background-color: #f8f9fa;
            cursor: pointer;
        }

        /* Badge custom */
        .badge {
            padding: 0.5rem 1rem;
            font-weight: 600;
        }

        /* Loading spinner */
        .spinner-border-sm {
            width: 1rem;
            height: 1rem;
            border-width: 0.2em;
        }
    </style>
</head>

<body>
    <script src="/Lab_SE_Website/admin/assets/static/js/initTheme.js"></script>

    <div id="app">