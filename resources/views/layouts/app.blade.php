<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'EEJ-C Admin') - Gestion des membres</title>
    
    <style>
        /* ===== RESET & BASE ===== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: var(--bg-light);
            color: var(--gray-800);
            line-height: 1.5;
        }

        /* ===== VARIABLES - COULEURS DU LOGO ===== */
        :root {
            --blue: #1f4fd8;
            --blue-dark: #183fb4;
            --blue-soft: #e8edff;
            
            --green: #1fa85b;
            --green-dark: #168a4a;
            --green-soft: #e8f5e9;
            
            --yellow: #f2c200;
            --yellow-dark: #d9ae00;
            --yellow-soft: #fff9e6;
            
            --red: #d62828;
            --red-dark: #b91f1f;
            --red-soft: #fee2e2;
            
            --black: #111111;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-400: #9ca3af;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --gray-900: #111827;
            
            --bg-light: #f8fafc;
            --sidebar-bg: #0f172a;
            --sidebar-card: #1e293b;
            --text-light: #ffffff;
            --border-soft: #e4e7ec;
            
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            --shadow-2xl: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            
            --sidebar-width: 280px;
            --sidebar-collapsed-width: 80px;
            --header-height: 70px;
        }

        /* ===== LAYOUT PRINCIPAL ===== */
        .dashboard-container {
            display: flex;
            min-height: 100vh;
            background: var(--bg-light);
            position: relative;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(180deg, var(--sidebar-bg) 0%, #1a2639 100%);
            color: var(--text-light);
            padding: 1.5rem 1rem;
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
            transition: width 0.3s ease;
            box-shadow: 4px 0 10px rgba(0, 0, 0, 0.1);
            z-index: 50;
            display: flex;
            flex-direction: column;
        }

        /* Scrollbar personnalisée */
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 3px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        /* Header du sidebar */
        .sidebar-header {
            background: var(--sidebar-card);
            border-radius: 1rem;
            padding: 1.5rem 1rem;
            text-align: center;
            margin-bottom: 2rem;
            border: 1px solid rgba(31, 79, 216, 0.3);
            position: relative;
            overflow: hidden;
        }

        .sidebar-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--blue), var(--green), var(--yellow));
        }

        .sidebar-header img {
            width: 90px;
            height: 90px;
            margin-bottom: 1rem;
            border-radius: 50%;
            border: 3px solid var(--blue);
            object-fit: cover;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s ease;
        }

        .sidebar-header img:hover {
            transform: scale(1.05);
        }

        .sidebar-header h3 {
            color: var(--text-light);
            font-size: 1.125rem;
            font-weight: 600;
            margin: 0;
            background: linear-gradient(135deg, var(--blue), var(--green));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Menu de navigation */
        .sidebar-menu {
            list-style: none;
            flex: 1;
        }

        .sidebar-menu li {
            margin-bottom: 0.5rem;
        }

        .sidebar-menu li a {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            background: transparent;
            color: var(--gray-300);
            text-decoration: none;
            padding: 0.875rem 1rem;
            border-radius: 0.75rem;
            transition: all 0.3s ease;
            font-weight: 500;
            position: relative;
            overflow: hidden;
        }

        .sidebar-menu li a::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background: var(--yellow);
            transform: scaleY(0);
            transition: transform 0.3s ease;
            border-radius: 0 2px 2px 0;
        }

        .sidebar-menu li a:hover {
            background: var(--sidebar-card);
            color: var(--text-light);
            transform: translateX(4px);
        }

        .sidebar-menu li a:hover::before {
            transform: scaleY(1);
        }

        .sidebar-menu li a.active {
            background: linear-gradient(90deg, var(--green), #2563eb);
            color: white;
            box-shadow: 0 4px 10px rgba(31, 79, 216, 0.3);
        }

        .sidebar-menu li a.active::before {
            background: var(--yellow);
            transform: scaleY(1);
        }

        /* Icônes du menu */
        .menu-icon {
            width: 1.5rem;
            height: 1.5rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.3s ease;
        }

        .sidebar-menu li a:hover .menu-icon {
            transform: scale(1.1);
        }

        /* Footer utilisateur */
        .sidebar-footer {
            margin-top: auto;
            background: var(--sidebar-card);
            border-radius: 1rem;
            padding: 1.25rem;
            border: 1px solid rgba(242, 194, 0, 0.2);
            position: relative;
            overflow: hidden;
        }

        .sidebar-footer::after {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(31, 168, 91, 0.1) 0%, transparent 70%);
            opacity: 0.5;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1rem;
            position: relative;
            z-index: 1;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--blue), var(--green));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 1rem;
            text-transform: uppercase;
        }

        .user-details {
            flex: 1;
            min-width: 0;
        }

        .user-name {
            display: block;
            font-weight: 600;
            color: var(--text-light);
            font-size: 0.875rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-role {
            display: block;
            font-size: 0.7rem;
            color: var(--gray-400);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .btn-logout {
            width: 100%;
            padding: 0.75rem;
            border: none;
            border-radius: 0.75rem;
            background: linear-gradient(135deg, var(--red), #dc2626);
            color: white;
            font-weight: 500;
            font-size: 0.875rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            position: relative;
            z-index: 1;
            overflow: hidden;
        }

        .btn-logout::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn-logout:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(214, 40, 40, 0.4);
        }

        .btn-logout:hover::before {
            width: 300px;
            height: 300px;
        }

        .btn-logout svg {
            width: 1.125rem;
            height: 1.125rem;
        }

        /* ===== CONTENU PRINCIPAL ===== */
        .dashboard-main {
            flex: 1;
            padding: 2rem;
            overflow-x: hidden;
            position: relative;
        }

        /* En-tête de page */
        .page-header {
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .page-title {
            font-size: 1.875rem;
            font-weight: 700;
            color: var(--gray-800);
            position: relative;
            padding-bottom: 0.5rem;
        }

        .page-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 4px;
            background: linear-gradient(90deg, var(--blue), var(--green));
            border-radius: 2px;
        }

        .page-actions {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        /* Cartes réutilisables */
        .card {
            background: white;
            border-radius: 1.25rem;
            padding: 1.5rem;
            border: 1px solid var(--gray-200);
            box-shadow: var(--shadow-lg);
            transition: all 0.3s ease;
            margin-bottom: 1.5rem;
            position: relative;
            overflow: hidden;
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--blue), var(--green), var(--yellow));
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-2xl);
        }

        .card:hover::before {
            opacity: 1;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.25rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid var(--gray-200);
        }

        .card-header h2 {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--gray-800);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .card-header h2 svg {
            width: 1.5rem;
            height: 1.5rem;
            color: var(--blue);
        }

        /* Alertes */
        .alert {
            padding: 1rem 1.5rem;
            border-radius: 1rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            animation: slideIn 0.3s ease-out;
        }

        .alert-success {
            background: var(--green-soft);
            color: var(--green-dark);
            border: 1px solid var(--green);
        }

        .alert-danger {
            background: var(--red-soft);
            color: var(--red-dark);
            border: 1px solid var(--red);
        }

        .alert-warning {
            background: var(--yellow-soft);
            color: var(--yellow-dark);
            border: 1px solid var(--yellow);
        }

        .alert-info {
            background: var(--blue-soft);
            color: var(--blue-dark);
            border: 1px solid var(--blue);
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Badges */
        .badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 2rem;
            font-size: 0.75rem;
            font-weight: 500;
            letter-spacing: 0.025em;
        }

        .badge-blue {
            background: var(--blue-soft);
            color: var(--blue-dark);
        }

        .badge-green {
            background: var(--green-soft);
            color: var(--green-dark);
        }

        .badge-yellow {
            background: var(--yellow-soft);
            color: var(--yellow-dark);
        }

        .badge-red {
            background: var(--red-soft);
            color: var(--red-dark);
        }

        /* Boutons */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.625rem 1.25rem;
            border-radius: 0.75rem;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.3s ease;
            cursor: pointer;
            border: none;
            outline: none;
            text-decoration: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--green), var(--green-dark));
            color: white;
            box-shadow: 0 4px 6px rgba(31, 168, 91, 0.2);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(31, 168, 91, 0.3);
        }

        .btn-secondary {
            background: linear-gradient(135deg, var(--blue), var(--blue-dark));
            color: white;
            box-shadow: 0 4px 6px rgba(31, 79, 216, 0.2);
        }

        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(31, 79, 216, 0.3);
        }

        .btn-outline {
            background: transparent;
            color: var(--gray-600);
            border: 2px solid var(--gray-200);
        }

        .btn-outline:hover {
            background: var(--gray-100);
            color: var(--gray-800);
            border-color: var(--gray-300);
        }

        /* Tables */
        .table-container {
            background: white;
            border-radius: 1.25rem;
            padding: 1.5rem;
            border: 1px solid var(--gray-200);
            box-shadow: var(--shadow-lg);
            overflow-x: auto;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table thead th {
            text-align: left;
            padding: 1rem;
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--gray-600);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            background: var(--gray-50);
            border-bottom: 2px solid var(--gray-200);
        }

        .table tbody tr {
            transition: all 0.2s ease;
            border-bottom: 1px solid var(--gray-200);
        }

        .table tbody tr:hover {
            background: var(--gray-50);
        }

        .table td {
            padding: 1rem;
            color: var(--gray-700);
        }

        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 2rem;
        }

        .pagination a, .pagination span {
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            background: white;
            color: var(--gray-700);
            text-decoration: none;
            border: 1px solid var(--gray-200);
            transition: all 0.2s ease;
        }

        .pagination a:hover {
            background: var(--blue);
            color: white;
            border-color: var(--blue);
        }

        .pagination .active {
            background: var(--green);
            color: white;
            border-color: var(--green);
        }

        /* Formulaires */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--gray-700);
            margin-bottom: 0.5rem;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            color: var(--gray-800);
            background: white;
            border: 2px solid var(--gray-200);
            border-radius: 0.75rem;
            transition: all 0.2s ease;
            outline: none;
        }

        .form-control:focus {
            border-color: var(--blue);
            box-shadow: 0 0 0 3px rgba(31, 79, 216, 0.1);
        }

        /* Loading spinner */
        .spinner {
            width: 40px;
            height: 40px;
            border: 3px solid var(--gray-200);
            border-top-color: var(--blue);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* ===== TOAST NOTIFICATIONS ===== */
        #toast-container {
            position: fixed;
            top: 1.5rem;
            right: 1.5rem;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            max-width: 420px;
            width: 100%;
            pointer-events: none;
        }

        .toast {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 1rem 1.25rem;
            border-radius: 1rem;
            background: white;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15), 0 4px 10px rgba(0, 0, 0, 0.1);
            border-left: 4px solid;
            animation: toastIn 0.4s ease-out;
            pointer-events: auto;
            position: relative;
            overflow: hidden;
        }

        .toast-success {
            border-left-color: var(--green);
            background: #f0fdf4;
        }

        .toast-error {
            border-left-color: var(--red);
            background: #fef2f2;
        }

        .toast-warning {
            border-left-color: var(--yellow);
            background: #fffbeb;
        }

        .toast-info {
            border-left-color: var(--blue);
            background: #eff6ff;
        }

        .toast-icon {
            width: 1.5rem;
            height: 1.5rem;
            flex-shrink: 0;
        }

        .toast-success .toast-icon { color: var(--green); }
        .toast-error .toast-icon { color: var(--red); }
        .toast-warning .toast-icon { color: var(--yellow); }
        .toast-info .toast-icon { color: var(--blue); }

        .toast-message {
            flex: 1;
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--gray-800);
            line-height: 1.4;
        }

        .toast-close {
            width: 1.5rem;
            height: 1.5rem;
            border: none;
            background: none;
            cursor: pointer;
            color: var(--gray-400);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 0.25rem;
            transition: all 0.2s;
            flex-shrink: 0;
        }

        .toast-close:hover {
            background: rgba(0, 0, 0, 0.05);
            color: var(--gray-600);
        }

        .toast-close svg {
            width: 1rem;
            height: 1rem;
        }

        @keyframes toastIn {
            from {
                opacity: 0;
                transform: translateX(100%) scale(0.9);
            }
            to {
                opacity: 1;
                transform: translateX(0) scale(1);
            }
        }

        @keyframes toastOut {
            from {
                opacity: 1;
                transform: translateX(0) scale(1);
            }
            to {
                opacity: 0;
                transform: translateX(100%) scale(0.9);
            }
        }

        .toast-removing {
            animation: toastOut 0.3s ease-in forwards;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 1024px) {
            .sidebar {
                width: var(--sidebar-collapsed-width);
                padding: 1rem 0.5rem;
            }

            .sidebar-header h3,
            .sidebar-menu li a span:not(.menu-icon),
            .user-details,
            .btn-logout span {
                display: none;
            }

            .sidebar-menu li a {
                justify-content: center;
                padding: 0.875rem;
            }

            .menu-icon {
                margin: 0;
            }

            .sidebar-footer {
                padding: 1rem 0.5rem;
                text-align: center;
            }

            .user-info {
                justify-content: center;
            }

            .btn-logout {
                padding: 0.75rem;
            }

            .btn-logout svg {
                margin: 0;
            }
        }

        @media (max-width: 768px) {
            .dashboard-container {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                height: auto;
                position: static;
                padding: 1rem;
            }

            .sidebar-header {
                display: flex;
                align-items: center;
                gap: 1rem;
                text-align: left;
            }

            .sidebar-header img {
                width: 50px;
                height: 50px;
                margin: 0;
            }

            .sidebar-menu {
                display: flex;
                flex-wrap: wrap;
                gap: 0.5rem;
            }

            .sidebar-menu li {
                flex: 1;
                min-width: 120px;
                margin: 0;
            }

            .sidebar-footer {
                margin-top: 1rem;
            }

            .user-info {
                justify-content: flex-start;
            }

            .sidebar-header h3,
            .sidebar-menu li a span:not(.menu-icon),
            .user-details,
            .btn-logout span {
                display: block;
            }

            .dashboard-main {
                padding: 1.5rem;
            }

            .page-title {
                font-size: 1.5rem;
            }
        }

        /* Utilitaires */
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-left { text-align: left; }
        
        .mt-1 { margin-top: 0.25rem; }
        .mt-2 { margin-top: 0.5rem; }
        .mt-3 { margin-top: 1rem; }
        .mt-4 { margin-top: 1.5rem; }
        .mt-5 { margin-top: 2rem; }
        
        .mb-1 { margin-bottom: 0.25rem; }
        .mb-2 { margin-bottom: 0.5rem; }
        .mb-3 { margin-bottom: 1rem; }
        .mb-4 { margin-bottom: 1.5rem; }
        .mb-5 { margin-bottom: 2rem; }
        
        .p-1 { padding: 0.25rem; }
        .p-2 { padding: 0.5rem; }
        .p-3 { padding: 1rem; }
        .p-4 { padding: 1.5rem; }
        .p-5 { padding: 2rem; }

        .d-flex { display: flex; }
        .flex-wrap { flex-wrap: wrap; }
        .align-center { align-items: center; }
        .justify-between { justify-content: space-between; }
        .gap-1 { gap: 0.25rem; }
        .gap-2 { gap: 0.5rem; }
        .gap-3 { gap: 1rem; }
        .gap-4 { gap: 1.5rem; }

        .w-100 { width: 100%; }
        .h-100 { height: 100%; }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <!-- SIDEBAR -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <img src="{{ asset('assets/LogoEEJC.jpeg') }}" alt="Logo Église des Envoyés de Jésus-Christ">
                <h3>EEJ-C Admin</h3>
            </div>

            <ul class="sidebar-menu">
                <li>
                    <a href="{{ route('welcome') }}" class="{{ request()->routeIs('welcome') ? 'active' : '' }}">
                        <span class="menu-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                            </svg>
                        </span>
                        <span>Accueil</span>
                    </a>
                </li>

                @auth
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <span class="menu-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="3" width="7" height="7"></rect>
                                <rect x="14" y="3" width="7" height="7"></rect>
                                <rect x="14" y="14" width="7" height="7"></rect>
                                <rect x="3" y="14" width="7" height="7"></rect>
                            </svg>
                        </span>
                        <span>Tableau de bord</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('members.index') }}" class="{{ request()->routeIs('members.*') ? 'active' : '' }}">
                        <span class="menu-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                        </span>
                        <span>Membres</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('cotisations.index') }}" class="{{ request()->routeIs('cotisations.*') ? 'active' : '' }}">
                        <span class="menu-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="2" y="5" width="20" height="14" rx="2"></rect>
                                <line x1="2" y1="10" x2="22" y2="10"></line>
                            </svg>
                        </span>
                        <span>Cotisations</span>
                    </a>
                </li>

                <li>
    <a href="{{ route('depenses.index') }}" class="{{ request()->routeIs('depenses.*') ? 'active' : '' }}">
        <span class="menu-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
            </svg>
        </span>
        <span>Dépenses</span>
    </a>
</li>
                @endauth
            </ul>

            @auth
            <div class="sidebar-footer">
                <div class="user-info">
                    <div class="user-avatar">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="user-details">
                        <span class="user-name">{{ Auth::user()->name }}</span>
                        <span class="user-role">{{ Auth::user()->isAdmin() ? 'Administrateur' : 'Utilisateur' }}</span>
                    </div>
                </div>

                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" class="btn-logout">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                            <polyline points="16 17 21 12 16 7"></polyline>
                            <line x1="21" y1="12" x2="9" y2="12"></line>
                        </svg>
                        <span>Déconnexion</span>
                    </button>
                </form>
            </div>
            @endauth
        </aside>

        <!-- CONTENU PRINCIPAL -->
        <main class="dashboard-main">
            @yield('content')
        </main>
    </div>

    <!-- Toast notifications -->
    <div id="toast-container"></div>

    <script>
    function showToast(message, type = 'success') {
        const container = document.getElementById('toast-container');
        if (!container) return;

        const icons = {
            success: '<svg class="toast-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>',
            error: '<svg class="toast-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>',
            warning: '<svg class="toast-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>',
            info: '<svg class="toast-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>'
        };

        const toast = document.createElement('div');
        toast.className = `toast toast-${type}`;
        toast.innerHTML = `
            ${icons[type] || icons.info}
            <span class="toast-message">${message}</span>
            <button class="toast-close" onclick="this.parentElement.remove()">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        `;

        container.appendChild(toast);

        setTimeout(() => {
            if (toast.parentElement) {
                toast.classList.add('toast-removing');
                setTimeout(() => toast.remove(), 300);
            }
        }, 5000);
    }

    @if(session('success'))
        document.addEventListener('DOMContentLoaded', function() {
            showToast('{{ session('success') }}', 'success');
        });
    @endif

    @if(session('error'))
        document.addEventListener('DOMContentLoaded', function() {
            showToast('{{ session('error') }}', 'error');
        });
    @endif

    @if(session('warning'))
        document.addEventListener('DOMContentLoaded', function() {
            showToast('{{ session('warning') }}', 'warning');
        });
    @endif

    @if(session('info'))
        document.addEventListener('DOMContentLoaded', function() {
            showToast('{{ session('info') }}', 'info');
        });
    @endif

    </script>

    @stack('scripts')
</body>
</html>