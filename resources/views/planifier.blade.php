<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="dummy-token">
    <title>Exped Drive</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        /* Bouton Voir tous sur la carte */
        #viewAllTripsBtn {
            margin-top: 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        #viewAllTripsBtn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.15);
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        }

        [x-cloak] {
            display: none !important;
        }
        .book-trip-component {
            margin-top: -80px;
        }
        /* Styles pour les boutons d'action */
        .action-buttons {
            display: flex;
            gap: 5px;
            justify-content: center;
        }

        .action-btn {
            width: 32px;
            height: 32px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            transition: all 0.3s ease;
        }

        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }

        /* Bouton Voir sur la carte */
        .btn-view {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-view:hover {
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        }

        /* Bouton Modifier */
        .btn-edit {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
        }

        .btn-edit:hover {
            background: linear-gradient(135deg, #f5576c 0%, #f093fb 100%);
        }

        /* Bouton Supprimer */
        .btn-delete {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
        }

        .btn-delete:hover {
            background: linear-gradient(135deg, #f5576c 0%, #f093fb 100%);
        }

        /* Tooltips pour les boutons */
        .action-btn {
            position: relative;
        }

        .action-btn::after {
            content: attr(title);
            position: absolute;
            bottom: -30px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(0,0,0,0.8);
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 12px;
            white-space: nowrap;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .action-btn:hover::after {
            opacity: 1;
            visibility: visible;
        }
        :root {
            --primary-color: #33A9DC;
            --secondary-color: #1C204B;
            --primary-gradient: linear-gradient(135deg, var(--primary-color) 0%, #2980b9 100%);
            --secondary-gradient: linear-gradient(135deg, var(--secondary-color) 0%, #2c3e50 100%);
            --success-gradient: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);
            --warning-gradient: linear-gradient(135deg, #e67e22 0%, #f39c12 100%);
            --glass-bg: rgba(255, 255, 255, 0.25);
            --glass-border: rgba(255, 255, 255, 0.18);
            --shadow-lg: 0 10px 30px rgba(0, 0, 0, 0.15);
            --shadow-xl: 0 15px 40px rgba(0, 0, 0, 0.2);
            --border-radius: 15px;
            --animation-speed: 0.3s;
        }

        body {
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, var(--secondary-color) 0%, #2c3e50 50%, var(--primary-color) 100%);
            min-height: 100vh;
            color: #2d3748;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* Alert System */
        .alert-container {
            position: fixed;
            top: 10px;
            right: 10px;
            z-index: 10000;
            max-width: 90%;
            width: 350px;
        }

        .alert {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 12px 16px;
            border-radius: var(--border-radius);
            margin-bottom: 8px;
            box-shadow: var(--shadow-xl);
            border: 1px solid var(--glass-border);
            display: flex;
            align-items: center;
            gap: 10px;
            transform: translateX(120%);
            transition: transform 0.5s cubic-bezier(0.68, -0.55, 0.27, 1.55);
            backdrop-filter: blur(10px);
            font-size: 14px;
        }

        .alert.show {
            transform: translateX(0);
        }

        .alert.hide {
            transform: translateX(120%);
        }

        .alert.success {
            background: linear-gradient(135deg, #ffffff 0%, #ffffff 100%);
            color: black;
        }

        .alert.error {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            color: rgb(255, 255, 255);
        }

        .alert.warning {
            background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
             color: rgb(255, 255, 255);
        }

        .alert-icon {
            font-size: 1.1em;
            width: 20px;
            text-align: center;
        }

        .alert-message {
            flex: 1;
            font-weight: 500;
            font-size: 13px;
        }

        /* Container */
        .container {
            max-width: 100%;
            margin: 0 auto;
            padding: 10px;
        }

        /* Header */
        .header {
            text-align: center;
            margin: 0 auto 15px;
            margin-top: -20px;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            border: 1px solid var(--glass-border);
            border-radius: var(--border-radius);
            padding: 15px;
            box-shadow: var(--shadow-lg);
        }

        .header h1 {
            font-size: 1.3em;
            margin-bottom: 5px;
            background: linear-gradient(90deg, #ffffff, #e6f7ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        .header p {
            font-size: 0.8em;
            color: rgba(255, 255, 255, 0.9);
            font-weight: 300;
        }

        /* Main Layout */
        .main-layout {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        /* Combined Card */
        .combined-card {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            border: 1px solid var(--glass-border);
            border-radius: var(--border-radius);
            padding: 15px;
            box-shadow: var(--shadow-xl);
        }

        /* Sidebar */
        .sidebar {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border-radius: var(--border-radius);
            padding: 15px;
            backdrop-filter: blur(10px);
        }

        /* Modal Styles */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(5px);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 10000;
            padding: 20px;
        }

        .modal-overlay.show {
            display: flex;
        }

        .modal-content {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            border: 1px solid var(--glass-border);
            border-radius: var(--border-radius);
            padding: 25px;
            max-width: 500px;
            width: 100%;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: var(--shadow-xl);
            backdrop-filter: blur(20px);
        }

        .modal-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .modal-header h3 {
            color: white;
            font-size: 1.3em;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .modal-header p {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.9em;
        }

        .modal-buttons {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-bottom: 20px;
        }

        .modal-btn {
            padding: 15px;
            border: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .modal-btn-primary {
            background: var(--success-gradient);
            color: white;
        }

        .modal-btn-secondary {
            background: rgba(255, 255, 255, 0.15);
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .modal-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        /* Styles pour les formulaires dans les modals */
        .modal-content .form-group {
            margin-bottom: 20px;
        }

        .modal-content .form-group label {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 8px;
            font-weight: 600;
            color: white;
            font-size: 14px;
        }

        .modal-content .input-field {
            width: 100%;
            padding: 12px;
            border: 2px solid rgba(255,255,255,0.2);
            border-radius: 10px;
            font-size: 14px;
            background: rgba(255,255,255,0.95);
            color: #333;
            transition: all 0.3s ease;
        }

        .modal-content .input-field:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(51, 169, 220, 0.2);
            background: white;
        }

        .modal-content small {
            display: block;
            margin-top: 5px;
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.8em;
        }

        /* Planning Selection */
        .planning-selection {
            display: none;
            margin-top: 20px;
        }

        .planning-selection.show {
            display: block;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .planning-list {
            max-height: 300px;
            overflow-y: auto;
            margin: 15px 0;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 10px;
        }

        .planning-item {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            color: white;
        }

        .planning-item:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateX(5px);
        }

        .planning-item.selected {
            background: rgba(51, 169, 220, 0.3);
            border-color: var(--primary-color);
        }

        .planning-name {
            font-weight: 600;
            font-size: 1em;
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .planning-details {
            font-size: 0.8em;
            opacity: 0.8;
            display: flex;
            gap: 15px;
        }

        .planning-detail {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .no-plannings {
            text-align: center;
            padding: 30px;
            color: rgba(255, 255, 255, 0.7);
            font-style: italic;
        }

        /* Loading state for planning selection */
        .planning-loading {
            text-align: center;
            padding: 20px;
            color: rgba(255, 255, 255, 0.7);
        }

        .loading-spinner-small {
            display: inline-block;
            width: 16px;
            height: 16px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-top: 2px solid white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-right: 8px;
        }

        /* Form Switcher */
        .form-switcher {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
            margin-bottom: 15px;
        }

        .form-tab {
            padding: 10px;
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            color: white;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            font-size: 13px;
        }

        .form-tab:hover {
            background: rgba(255, 255, 255, 0.15);
        }

        .form-tab.active {
            background: var(--primary-color);
            border-color: var(--primary-color);
            box-shadow: 0 0 15px rgba(51, 169, 220, 0.3);
        }

        .form-tab i {
            font-size: 14px;
        }

        /* Forms */
        .trip-form, .day-rate-form {
            transition: all 0.3s ease;
        }

        .trip-form.hidden, .day-rate-form.hidden {
            display: none;
        }

        .trip-form.active, .day-rate-form.active {
            display: block;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 8px;
            font-weight: 600;
            color: white;
            font-size: 13px;
        }

        .input-container {
            position: relative;
        }

        .input-field, .select-field, .passenger-select {
            width: 100%;
            padding: 12px;
            border: 2px solid rgba(255,255,255,0.2);
            border-radius: 10px;
            font-size: 14px;
            background: rgba(255,255,255,0.95);
            color: #333;
            transition: all var(--animation-speed) ease;
        }

        .input-field:focus, .select-field:focus, .passenger-select:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(51, 169, 220, 0.2);
            background: white;
        }

        .select-field, .passenger-select {
            appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23333' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 14px;
            padding-right: 35px;
        }

        /* Suggestions */
        .suggestions {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 1px solid #ddd;
            border-radius: 10px;
            max-height: 200px;
            overflow-y: auto;
            z-index: 1000;
            box-shadow: var(--shadow-xl);
            margin-top: 5px;
        }

        .suggestion-item {
            padding: 10px 12px;
            cursor: pointer;
            border-bottom: 1px solid #eee;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            color: #333;
            font-size: 13px;
        }

        .suggestion-item:hover {
            background: rgba(51, 169, 220, 0.1);
        }

        .suggestion-item:last-child {
            border-bottom: none;
        }

        /* Buttons */
        .btn {
            background: var(--primary-gradient);
            color: white;
            border: none;
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all var(--animation-speed) ease;
            width: 100%;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: var(--shadow-lg);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn:hover:not(:disabled) {
            background: linear-gradient(135deg, #2980b9 0%, var(--primary-color) 100%);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(51, 169, 220, 0.4);
        }

        .btn:active {
            transform: translateY(0);
        }

        .btn:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }

        .btn-warning {
            background: var(--warning-gradient);
        }

        .btn-success {
            background: var(--success-gradient);
        }

        /* Loading */
        .loading {
            display: none;
            text-align: center;
            padding: 15px;
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            border-radius: 10px;
            margin: 12px 0;
            border: 1px solid rgba(255,255,255,0.2);
        }

        .loading.show {
            display: block;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 0.8; }
            50% { opacity: 1; }
        }

        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255,255,255,0.3);
            border-top: 3px solid var(--primary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-bottom: 8px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .error, .success {
            display: none;
            padding: 10px 12px;
            border-radius: 10px;
            margin: 10px 0;
            font-size: 13px;
        }

        .error {
            background: rgba(244, 63, 94, 0.1);
            color: #f43f5e;
            border: 1px solid rgba(244, 63, 94, 0.3);
        }

        .success {
            background: rgba(34, 197, 94, 0.1);
            color: #22c55e;
            border: 1px solid rgba(34, 197, 94, 0.3);
        }

        .error.show, .success.show {
            display: block;
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Map */
        .map-sidebar {
            height: 300px;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            order: 2;
        }

        #map {
            height: 100%;
            width: 100%;
            border-radius: var(--border-radius);
            position: relative;
            z-index: 1;
            box-shadow: var(--shadow-xl);
        }

        /* Custom Markers */
        .user-marker {
            background: var(--primary-gradient);
            border: 3px solid white;
            border-radius: 50%;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
            animation: pulse 2s infinite;
        }

        .route-marker-start {
            background: var(--success-gradient);
            border: 3px solid white;
            border-radius: 50%;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        }

        .route-marker-end {
            background: var(--warning-gradient);
            border: 3px solid white;
            border-radius: 50%;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        }

        /* Content Section */
        .content-section {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            border: 1px solid var(--glass-border);
            border-radius: 15px;
            padding: 15px;
            margin-bottom: 15px;
            box-shadow: var(--shadow-xl);
            color: white;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 12px;
            border-bottom: 2px solid rgba(255, 255, 255, 0.2);
            flex-wrap: wrap;
            gap: 10px;
        }

        .section-title {
            font-size: 1.1em;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .section-badge {
            background: rgba(255, 255, 255, 0.2);
            padding: 5px 12px;
            border-radius: 15px;
            font-weight: 600;
            font-size: 0.8em;
        }

        /* Recap Stats */
        .recap-stats {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }

        .recap-stat {
            background: rgba(255, 255, 255, 0.1);
            padding: 12px;
            border-radius: 12px;
            text-align: center;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }

        .recap-stat:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            background: rgba(255, 255, 255, 0.15);
        }

        .recap-value {
            font-size: 1.3em;
            font-weight: 800;
            display: block;
            margin-bottom: 4px;
            background: linear-gradient(135deg, #ffffff, #e6f7ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .recap-label {
            font-size: 0.7em;
            opacity: 0.9;
            font-weight: 500;
        }

        /* Table */
        .table-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--shadow-xl);
            margin-top: 15px;
        }

        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .trips-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
            min-width: 700px;
        }

        .trips-table th {
            background: var(--secondary-color);
            color: white;
            padding: 10px 8px;
            text-align: left;
            font-weight: 600;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid var(--primary-color);
        }

        .trips-table td {
            padding: 10px 8px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            font-size: 11px;
            color: #333;
            background: white;
        }

        .trips-table tr:hover td {
            background: rgba(51, 169, 220, 0.05);
        }

        .status-badge {
            padding: 4px 10px;
            border-radius: 15px;
            font-size: 0.7em;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-block;
        }

        .status-pending {
            background: rgba(255, 193, 7, 0.15);
            color: #ffc107;
            border: 1px solid rgba(255, 193, 7, 0.3);
        }

        .status-approved {
            background: rgba(40, 167, 69, 0.15);
            color: #28a745;
            border: 1px solid rgba(40, 167, 69, 0.3);
        }

        .status-paid {
            background: rgba(111, 66, 193, 0.15);
            color: #6f42c1;
            border: 1px solid rgba(111, 66, 193, 0.3);
        }

        .action-btn {
            padding: 5px 8px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 2px;
            font-size: 0.7em;
            transition: all 0.2s ease;
            font-weight: 500;
        }

        .btn-edit {
            background: rgba(255, 193, 7, 0.1);
            color: #ffc107;
            border: 1px solid rgba(255, 193, 7, 0.3);
        }

        .btn-delete {
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545;
            border: 1px solid rgba(220, 53, 69, 0.3);
        }

        .btn-view {
            background: rgba(108, 117, 125, 0.1);
            color: #6c757d;
            border: 1px solid rgba(108, 117, 125, 0.3);
        }

        .btn-pay {
            background: rgba(40, 167, 69, 0.1);
            color: #28a745;
            border: 1px solid rgba(40, 167, 69, 0.3);
        }

        .action-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
        }

        /* Day Rate Specific */
        .day-rate-section {
            background: rgba(255, 255, 255, 0.1);
            border-radius: var(--border-radius);
            padding: 12px;
            margin-bottom: 12px;
        }

        .day-rate-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }

        .day-rate-title {
            display: flex;
            align-items: center;
            gap: 6px;
            color: white;
            font-size: 1em;
        }

        .cities-container {
            margin-bottom: 12px;
        }

        .city-item {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            padding: 10px;
            margin-bottom: 10px;
        }

        .city-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }

        .city-name {
            font-weight: 600;
            color: white;
            font-size: 13px;
        }

        .remove-city {
            background: rgba(244, 63, 94, 0.2);
            border: 1px solid rgba(244, 63, 94, 0.3);
            color: #f43f5e;
            border-radius: 4px;
            padding: 4px 8px;
            cursor: pointer;
            font-size: 10px;
        }

        .add-city-btn {
            background: var(--primary-gradient);
            color: white;
            border: none;
            padding: 10px 12px;
            border-radius: 8px;
            cursor: pointer;
            width: 100%;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            font-size: 13px;
        }

        .day-rate-summary {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            padding: 10px;
            margin-bottom: 12px;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 6px;
            font-size: 13px;
            color: white;
        }

        .summary-total {
            font-weight: 600;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            padding-top: 6px;
            margin-top: 6px;
        }

        /* Info Card */
        .info-card {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .info-card h4 {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 8px;
            font-size: 13px;
        }

        .info-card p {
            font-size: 12px;
            opacity: 0.9;
        }

        /* Form Split Layout */
        .form-split {
            display: grid;
            grid-template-columns: 1fr;
            gap: 15px;
        }

        .form-left, .form-right {
            display: flex;
            flex-direction: column;
        }

        .form-buttons {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 10px;
        }

        /* Manual Route Creation Styles */
        .manual-marker {
            animation: bounce 0.5s ease infinite alternate;
        }

        @keyframes bounce {
            from { transform: translateY(0px); }
            to { transform: translateY(-5px); }
        }

        .map-creator-mode .leaflet-container {
            cursor: crosshair !important;
        }

        .creation-instructions {
            position: absolute;
            top: 10px;
            left: 50%;
            transform: translateX(-50%);
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 10px 15px;
            border-radius: var(--border-radius);
            z-index: 1000;
            font-weight: 600;
            box-shadow: var(--shadow-xl);
            border: 1px solid var(--glass-border);
            backdrop-filter: blur(10px);
            text-align: center;
            font-size: 14px;
        }

        .manual-route-info {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 15px;
            margin: 15px 0;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .manual-route-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            margin-top: 10px;
        }

        .manual-route-stat {
            text-align: center;
            padding: 8px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
        }

        .manual-route-value {
            font-size: 1.1em;
            font-weight: 700;
            display: block;
            color: white;
        }

        .manual-route-label {
            font-size: 0.7em;
            opacity: 0.8;
            color: white;
        }

        /* Map Marker Controls */
        .map-controls {
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .map-control-btn {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            box-shadow: var(--shadow-lg);
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            transition: all 0.3s ease;
        }

        .map-control-btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-xl);
        }

        .map-control-btn.active {
            background: var(--warning-gradient);
        }

        .map-control-btn i {
            font-size: 14px;
        }

        /* RESPONSIVE BREAKPOINTS */

        /* Small phones (320px - 374px) */
        @media (max-width: 374px) {
            .header h1 {
                font-size: 1.1em;
            }
            .header p {
                font-size: 0.75em;
            }
            .form-tab {
                font-size: 11px;
                padding: 8px;
            }
            .input-field, .select-field, .passenger-select {
                padding: 10px;
                font-size: 13px;
            }
            .btn {
                padding: 10px 12px;
                font-size: 12px;
            }
            .recap-value {
                font-size: 1.1em;
            }
            .recap-label {
                font-size: 0.65em;
            }
            .creation-instructions {
                font-size: 12px;
                padding: 8px 12px;
            }
            .map-control-btn {
                padding: 8px 12px;
                font-size: 11px;
            }
        }

        /* Standard phones (375px - 479px) - iPhone SE, iPhone 6/7/8 */
        @media (min-width: 375px) and (max-width: 479px) {
            .container {
                padding: 12px;
            }
            .header h1 {
                font-size: 1.2em;
            }
            .map-sidebar {
                height: 350px;
            }
        }

        /* Large phones (480px - 599px) - iPhone Plus, Redmi */
        @media (min-width: 480px) and (max-width: 599px) {
            .container {
                padding: 15px;
            }
            .header h1 {
                font-size: 1.4em;
            }
            .recap-stats {
                grid-template-columns: repeat(2, 1fr);
            }
            .map-sidebar {
                height: 400px;
            }
        }

        /* Small tablets (600px - 767px) */
        @media (min-width: 600px) and (max-width: 767px) {
            .container {
                padding: 20px;
                max-width: 600px;
            }
            .header h1 {
                font-size: 1.6em;
            }
            .input-field, .select-field, .passenger-select {
                padding: 14px;
                font-size: 15px;
            }
            .btn {
                padding: 14px 18px;
                font-size: 15px;
            }
            .recap-stats {
                grid-template-columns: repeat(4, 1fr);
            }
            .map-sidebar {
                height: 450px;
            }
            .form-split {
                grid-template-columns: 1fr 1fr;
            }
        }

        /* Tablets (768px - 1023px) - iPad, tablets */
        @media (min-width: 768px) and (max-width: 1023px) {
            .container {
                padding: 25px;
                max-width: 750px;
            }
            .header {
                padding: 20px;
                margin-bottom: 20px;
            }
            .header h1 {
                font-size: 1.8em;
            }
            .header p {
                font-size: 1em;
            }
            .sidebar {
                padding: 20px;
            }
            .input-field, .select-field, .passenger-select {
                padding: 16px;
                font-size: 16px;
            }
            .btn {
                padding: 16px 24px;
                font-size: 16px;
            }
            .recap-stats {
                grid-template-columns: repeat(4, 1fr);
                gap: 12px;
            }
            .map-sidebar {
                height: 500px;
            }
            .trips-table {
                font-size: 13px;
            }
            .trips-table th, .trips-table td {
                padding: 12px 10px;
            }
            .form-split {
                grid-template-columns: 1fr 1fr;
                gap: 20px;
            }
        }

        /* Small laptops (1024px - 1199px) */
        @media (min-width: 1024px) and (max-width: 1199px) {
            .container {
                max-width: 1000px;
                padding: 30px;
            }
            .header h1 {
                font-size: 2em;
            }
            .main-layout {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 20px;
            }
            .map-sidebar {
                height: 550px;
                order: 0;
            }
            .recap-stats {
                grid-template-columns: repeat(4, 1fr);
            }
            .content-section {
                grid-column: 1 / -1;
            }
            .form-split {
                grid-template-columns: 1fr 1fr;
                gap: 25px;
            }
        }

        /* Large screens (1200px+) - Desktop */
        @media (min-width: 1200px) {
            .container {
                max-width: 1400px;
                padding: 30px;
            }
            .header {
                max-width: 1200px;
                margin-left: auto;
                margin-right: auto;
                padding: 25px;
            }
            .header h1 {
                font-size: 2.2em;
            }
            .main-layout {
                display: grid;
                grid-template-columns: 1fr 500px;
                gap: 25px;
                align-items: start;
            }
            .map-sidebar {
                position: sticky;
                top: 20px;
                height: 600px;
                order: 0;
            }
            .combined-card, .content-section {
                max-width: 100%;
            }
            .sidebar {
                padding: 25px;
            }
            .recap-stats {
                grid-template-columns: repeat(4, 1fr);
                gap: 15px;
            }
            .trips-table {
                font-size: 14px;
            }
            .trips-table th, .trips-table td {
                padding: 14px 12px;
            }
            .form-split {
                grid-template-columns: 1fr 1fr;
                gap: 30px;
            }
            .form-buttons {
                flex-direction: row;
                justify-content: space-between;
            }
            .form-buttons .btn {
                width: 48%;
            }
        }

        /* Extra large screens (1400px+) */
        @media (min-width: 1400px) {
            .container {
                max-width: 1600px;
            }
            .header {
                max-width: 1400px;
            }
            .map-sidebar {
                height: 700px;
            }
        }

        /* Landscape orientation for phones */
        @media (max-height: 500px) and (orientation: landscape) {
            .header {
                padding: 10px;
                margin-bottom: 10px;
            }
            .header h1 {
                font-size: 1.1em;
            }
            .header p {
                font-size: 0.75em;
            }
            .combined-card {
                padding: 12px;
            }
            .sidebar {
                padding: 12px;
            }
            .map-sidebar {
                height: 250px;
            }
            .form-group {
                margin-bottom: 10px;
            }
            .btn {
                padding: 8px 12px;
                font-size: 12px;
            }
        }

        /* iPhone specific fixes */
        @supports (-webkit-touch-callout: none) {
            .input-field, .select-field, .passenger-select {
                -webkit-appearance: none;
                -moz-appearance: none;
            }
            body {
                -webkit-text-size-adjust: 100%;
            }
        }

        /* Android specific fixes */
        @media screen and (-webkit-min-device-pixel-ratio: 0) {
            select:focus, input:focus {
                font-size: 16px;
            }
        }

        /* Touch device optimizations */
        @media (hover: none) and (pointer: coarse) {
            .btn, .action-btn, .form-tab {
                min-height: 44px;
            }
            .suggestion-item {
                min-height: 44px;
                padding: 12px;
            }
        }

        /* High DPI displays */
        @media (-webkit-min-device-pixel-ratio: 2), (min-resolution: 192dpi) {
            .custom-marker {
                image-rendering: -webkit-optimize-contrast;
                image-rendering: crisp-edges;
            }
        }

        /* Dark mode support */
        @media (prefers-color-scheme: dark) {
            .input-field, .select-field, .passenger-select {
                background: rgba(255, 255, 255, 0.98);
            }
        }

        /* Reduced motion for accessibility */
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }

        /* Print styles */
        @media print {
            .header, .sidebar, .btn, .alert-container {
                display: none;
            }
            .content-section {
                break-inside: avoid;
            }
            .table-container {
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body>
    <div class="book-trip-component">
        <!-- Alert Container -->
        <div class="alert-container" id="alertContainer"></div>

        <!-- Save Trip Modal -->
        <div class="modal-overlay" id="saveTripModal">
            <div class="modal-content">
                <div class="modal-header">
                    <h3><i class="fas fa-save"></i> {{ __('Sauvegarder les Trajets')}}</h3>
                    <p>{{ __('Choisissez comment organiser vos trajets')}}</p>
                </div>

                <div class="modal-buttons">
                    <button class="modal-btn modal-btn-primary" id="createNewPlanningBtn">
                        <i class="fas fa-plus-circle"></i> {{ __('Nouveau Planning')}}
                    </button>
                    <button class="modal-btn modal-btn-secondary" id="useExistingPlanningBtn">
                        <i class="fas fa-folder-open"></i> {{ __('Planning Existant')}}
                    </button>
                </div>

                <div class="planning-selection" id="planningSelection">
                    <h4 style="color: white; margin-bottom: 15px; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-list"></i> {{ __('Sélectionnez un Planning')}}
                    </h4>

                    <div class="planning-list" id="planningList">
                        <div class="planning-loading">
                            <div class="loading-spinner-small"></div>
                            {{ __('Chargement de vos plannings...')}}
                        </div>
                    </div>

                    <div class="modal-buttons">
                        <button class="modal-btn modal-btn-primary" id="confirmSelectionBtn" disabled>
                            <i class="fas fa-check"></i> {{ __('Confirmer la Sélection')}}
                        </button>
                        <button class="modal-btn modal-btn-secondary" id="backToChoiceBtn">
                            <i class="fas fa-arrow-left"></i> {{ __('Retour')}}
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- New Planning Name Modal -->
        <div class="modal-overlay" id="newPlanningModal">
            <div class="modal-content">
                <div class="modal-header">
                    <h3><i class="fas fa-plus-circle"></i> {{ __('Nouveau Planning')}}</h3>
                    <p>{{ __('Donnez un nom à votre nouveau planning')}}</p>
                </div>

                <div class="form-group">
                    <label for="newPlanningName">
                        <i class="fas fa-edit"></i> {{ __('Nom du Planning')}}
                    </label>
                    <input type="text"
                           id="newPlanningName"
                           class="input-field"
                           placeholder="Ex: Voyage à Marrakech, Vacances d'été..."
                           maxlength="255">
                    <small>
                        {{ __('Ce nom vous aidera à identifier facilement votre planning')}}
                    </small>
                </div>

                <div class="modal-buttons">
                    <button class="modal-btn modal-btn-primary" id="confirmNewPlanningBtn">
                        <i class="fas fa-check"></i> {{ __('Créer le Planning')}}
                    </button>
                    <button class="modal-btn modal-btn-secondary" id="cancelNewPlanningBtn">
                        <i class="fas fa-times"></i> {{ __('Annuler')}}
                    </button>
                </div>
            </div>
        </div>

        <div class="container">
            <!-- Header -->
            <div class="header">
                <h1><i class="fas fa-map-marked-alt"></i> {{ __('Morocco Route Planner Pro')}}</h1>
                <p>{{ __('Professional journey planning with advanced route optimization')}}</p>
            </div>

            <!-- Main Layout -->
            <div class="main-layout">
                <!-- Left Column: Forms and Content -->
                <div class="content-column">
                    <!-- Form Card -->
                    <div class="combined-card">
                        <div class="sidebar">
                            <!-- Form Switcher Tabs -->
                            <div class="form-switcher">
                                <div class="form-tab active" data-form="trip">
                                    <i class="fas fa-route"></i>
                                    <span>{{ __('Trip')}}</span>
                                </div>
                                <div class="form-tab" data-form="day-rate">
                                    <i class="fas fa-calendar-day"></i>
                                    <span>{{ __('Par Journée')}}</span>
                                </div>
                            </div>

                            <!-- Form Container -->
                            <div class="form-container">
                                <!-- Trip Form (Default) -->
                                <div class="trip-form active" id="tripForm">
                                    <div class="form-split">
                                        <!-- Left Column -->
                                        <div class="form-left">
                                            <!-- Passenger Selection -->
                                            <div class="form-group passenger-selection">
                                                <label for="passengerCount">
                                                    <i class="fas fa-users"></i>
                                                    {{ __('Nombre de Passagers')}}
                                                </label>
                                                <select id="passengerCount" class="passenger-select">
                                                    <option value="">{{ __('Sélectionner le nombre de passagers')}}</option>
                                                </select>
                                            </div>

                                            <!-- Location Detection Status -->
                                            <div class="info-card" id="locationCard" style="display: none;">
                                                <h4><i class="fas fa-crosshairs"></i> {{ __('Position Actuelle')}}</h4>
                                                <p id="detectedLocation">{{ __('Détection de votre position...')}}</p>
                                            </div>
                                        </div>

                                        <!-- Right Column -->
                                        <div class="form-right">
                                            <!-- From -->
                                            <div class="form-group">
                                                <label for="from">
                                                    <i class="fas fa-play"></i>
                                                    {{ __('Point de Départ')}}
                                                </label>
                                                <div class="input-container">
                                                    <input type="text" id="from" class="input-field" placeholder="Entrez le lieu de départ">
                                                    <div id="fromSuggestions" class="suggestions"></div>
                                                </div>
                                            </div>

                                            <!-- To -->
                                            <div class="form-group">
                                                <label for="to">
                                                    <i class="fas fa-flag-checkered"></i>
                                                    {{ __('Destination')}}
                                                </label>
                                                <div class="input-container">
                                                    <input type="text" id="to" class="input-field" placeholder="Entrez la destination">
                                                    <div id="toSuggestions" class="suggestions"></div>
                                                </div>
                                            </div>

                                            <!-- Date Debut -->
                                            <div class="form-group">
                                                <label for="dateDebut">
                                                    <i class="fas fa-calendar-alt"></i>
                                                    {{ __('Date Début')}}
                                                </label>
                                                <input type="date" id="dateDebut" class="input-field" required>
                                            </div>

                                            <!-- Date Fin -->
                                            <div class="form-group">
                                                <label for="dateFin">
                                                    <i class="fas fa-calendar-check"></i>
                                                    {{ __('Date Fin')}}
                                                </label>
                                                <input type="date" id="dateFin" class="input-field" required>
                                            </div>

                                            <!-- Vehicle Type -->
                                            <div class="form-group">
                                                <label for="vehicleType">
                                                    <i class="fas fa-car"></i>
                                                    {{ __('Type de Véhicule')}}
                                                </label>
                                                <select id="vehicleType" class="select-field" required>
                                                    <option value="">{{ __('Choisir un véhicule')}}</option>
                                                    <option value="car">{{ __('Voiture')}}</option>
                                                    <option value="van">{{ __('Van')}}</option>
                                                    <option value="minibus">{{ __('Mini Bus')}}</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Buttons Row -->
                                        <div class="form-buttons">
                                            <button class="btn" id="calculateRoute">
                                                <i class="fas fa-plus"></i>
                                                {{ __('Ajouter Trajet')}}
                                            </button>

                                            <button class="btn btn-warning" id="useCurrentLocation">
                                                <i class="fas fa-location-arrow"></i>
                                                {{ __('Ma Position')}}
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Day Rate Form -->
                                <div class="hidden day-rate-form" id="dayRateForm">
                                    <div class="day-rate-section">
                                        <div class="day-rate-header">
                                            <h3 class="day-rate-title">
                                                <i class="fas fa-calendar-day"></i>
                                                {{ __('Location Par Journée')}}
                                            </h3>
                                        </div>

                                        <!-- Passenger Selection for Day Rate -->
                                        <div class="form-group passenger-selection">
                                            <label for="dayRatePassengerCount">
                                                <i class="fas fa-users"></i>
                                                {{ __('Nombre de Passagers')}}
                                            </label>
                                            <select id="dayRatePassengerCount" class="passenger-select">
                                                <option value="">{{ __('Sélectionner le nombre de passagers')}}</option>
                                            </select>
                                        </div>

                                        <div class="cities-container" id="citiesContainer">
                                            <!-- Cities will be added here dynamically -->
                                        </div>

                                        <button class="add-city-btn" id="addCityBtn">
                                            <i class="fas fa-plus"></i> {{ __('Ajouter une Ville')}}
                                        </button>

                                        <div class="form-group">
                                            <label for="dayRateStartDate">
                                                <i class="fas fa-calendar-alt"></i>
                                                {{ __('Date de Début')}}
                                            </label>
                                            <input type="datetime-local" id="dayRateStartDate" class="input-field" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="dayRateDays">
                                                <i class="fas fa-clock"></i>
                                                {{ __('Nombre de Jours')}}
                                            </label>
                                            <input type="number" id="dayRateDays" class="input-field" min="1" max="30" value="1" required>
                                        </div>

                                        <div class="day-rate-summary" id="dayRateSummary">
                                            <div class="summary-item">
                                                <span>{{ __('Nombre de Villes')}}:</span>
                                                <span id="summaryCities">0</span>
                                            </div>
                                            <div class="summary-item">
                                                <span>{{ __('Jours Totaux')}}:</span>
                                                <span id="summaryDays">0</span>
                                            </div>
                                        </div>

                                        <button class="btn" id="confirmDayRate">
                                            <i class="fas fa-check"></i> {{ __('Confirmer la Location')}}
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Loading and Error States -->
                            <div class="loading" id="loading">
                                <div class="loading-spinner"></div>
                                <div>
                                    <i class="fas fa-cogs"></i> {{ __('Calculating the optimal route...')}}
                                </div>
                            </div>

                            <div class="error" id="error"></div>
                            <div class="success" id="success"></div>
                        </div>
                    </div>

                    <!-- Trip Recap Section -->
                    <div class="content-section" id="tripRecap" style="display: none;">
                        <div class="section-header">
                            <div class="section-title">
                                <i class="fas fa-clipboard-list"></i>
                                {{ __('Récapitulatif du Voyage')}}
                            </div>
                            <span class="section-badge" id="tripCount">0 {{ __('trajets')}}</span>
                        </div>
                        <div class="recap-stats" id="recapStats">
                            <div class="recap-stat">
                                <span class="recap-value" id="totalDistance">0</span>
                                <span class="recap-label">{{ __('Kilomètres Totals')}}</span>
                            </div>
                            <div class="recap-stat">
                                <span class="recap-value" id="totalDuration">0</span>
                                <span class="recap-label">{{ __('Heures Totales')}}</span>
                            </div>
                            <div class="recap-stat">
                                <span class="recap-value" id="tripDays">0</span>
                                <span class="recap-label">{{ __('Jours de Voyage')}}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Trips Table -->
                    <div class="content-section" id="tripsTableContainer" style="display: none;">
                        <div class="section-header">
                            <h3 class="section-title">
                                <i class="fas fa-table"></i> {{ __('Liste des Trajets')}}
                            </h3>
                            <button class="btn-success" id="saveAllTrips" style="width: auto; padding: 10px 16px; margin: 0;">
                                <i class="fas fa-save"></i>
                                {{ __('Sauvegarder')}}
                            </button>
                        </div>
                        <div class="table-container">
                            <div class="table-responsive">
                                <table class="trips-table" id="tripsTable">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Réf')}}</th>
                                            <th>{{ __('Trajet')}}</th>
                                            <th>{{ __('Dates')}}</th>
                                            <th>{{ __('Véhicule')}}</th>
                                            <th>{{ __('Distance')}}</th>
                                            <th>{{ __('Durée')}}</th>
                                            <th>{{ __('Status')}}</th>
                                            <th>{{ __('Actions')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tripsTableBody">
                                        <!-- Dynamic rows will be added here -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Fixed Map -->
                <div class="map-sidebar">
                    <div id="map"></div>
                    <!-- Map Controls -->
                    <div class="map-controls">
                        <button class="map-control-btn" id="manualRouteBtnMap">
                            <i class="fas fa-draw-polygon"></i>
                            <span>{{ __('Créer Trajet')}}</span>
                        </button>
                        <button class="map-control-btn" id="clearRouteBtn" style="display: none;">
                            <i class="fas fa-trash"></i>
                            <span>{{ __('Effacer')}}</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>

<script>
    const MAP_CONFIG = {
        center: [31.7917, -7.0926],
        zoom: 6,
        maxZoom: 18,
        minZoom: 4
    };

    let map = null;
    let mapInitialized = false;
    let mapInitializationAttempted = false;

    let tripsList = [];
    let tripCounter = 0;
    let currentTrip = null;
    let passengerOptions = [];
    let dayRatePassengerOptions = [];

    // Variables pour la création manuelle de trajets
    let manualRouteMode = false;
    let startMarker = null;
    let endMarker = null;
    let manualRouteLayer = null;
    let tempMarkers = [];

    // Cache pour stocker les résultats de géocodage
    let geocodingCache = new Map();

    // Track event listeners to prevent duplicates
    let eventListeners = new Map();

    class SaveTripModal {
        constructor() {
            this.modal = null;
            this.newPlanningModal = null;
            this.selectedPlanningId = null;
            this.createNewPlanning = false;
            this.newPlanningName = '';
            this.init();
        }

        init() {
            this.createModals();
            this.setupEventListeners();
        }

        createModals() {
            this.modal = document.getElementById('saveTripModal');
            this.newPlanningModal = document.getElementById('newPlanningModal');
        }

        setupEventListeners() {
            const listeners = {
                'createNewPlanningBtn': () => this.handleCreateNewPlanning(),
                'useExistingPlanningBtn': () => this.handleUseExistingPlanning(),
                'confirmSelectionBtn': () => this.confirmSelection(),
                'backToChoiceBtn': () => this.showInitialChoice(),
                'confirmNewPlanningBtn': () => this.confirmNewPlanning(),
                'cancelNewPlanningBtn': () => this.cancelNewPlanning()
            };

            Object.entries(listeners).forEach(([id, handler]) => {
                const element = document.getElementById(id);
                if (element && !eventListeners.has(id)) {
                    element.addEventListener('click', handler);
                    eventListeners.set(id, { element, handler });
                }
            });

            const newPlanningNameInput = document.getElementById('newPlanningName');
            if (newPlanningNameInput && !eventListeners.has('newPlanningName')) {
                const handler = (e) => {
                    if (e.key === 'Enter') {
                        this.confirmNewPlanning();
                    }
                };
                newPlanningNameInput.addEventListener('keypress', handler);
                eventListeners.set('newPlanningName', { element: newPlanningNameInput, handler });
            }
        }

        show() {
            if (this.modal) {
                this.modal.classList.add('show');
                this.showInitialChoice();
                this.selectedPlanningId = null;
                this.createNewPlanning = false;
                this.newPlanningName = '';
            }
        }

        hide() {
            if (this.modal) this.modal.classList.remove('show');
            if (this.newPlanningModal) this.newPlanningModal.classList.remove('show');
        }

        showInitialChoice() {
            const planningSelection = document.getElementById('planningSelection');
            const modalButtons = document.querySelector('.modal-buttons');

            if (planningSelection) planningSelection.classList.remove('show');
            if (modalButtons) modalButtons.style.display = 'grid';
        }

        handleCreateNewPlanning() {
            this.modal.classList.remove('show');
            this.showNewPlanningModal();
        }

        handleUseExistingPlanning() {
            const modalButtons = document.querySelector('.modal-buttons');
            const planningSelection = document.getElementById('planningSelection');

            if (modalButtons) modalButtons.style.display = 'none';
            if (planningSelection) planningSelection.classList.add('show');

            this.loadUserPlannings();
        }

        showNewPlanningModal() {
            const newPlanningName = document.getElementById('newPlanningName');
            if (newPlanningName) {
                newPlanningName.value = '';
                const suggestedName = this.generateSuggestedName();
                newPlanningName.placeholder = suggestedName;
            }

            if (this.newPlanningModal) {
                this.newPlanningModal.classList.add('show');
                setTimeout(() => {
                    if (newPlanningName) newPlanningName.focus();
                }, 300);
            }
        }

        generateSuggestedName() {
            const today = new Date();
            const options = {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };
            const dateString = today.toLocaleDateString('fr-FR', options);

            const suggestions = [
                `Planning ${dateString}`,
                `Voyage ${today.getFullYear()}`,
                `Mes trajets ${today.getMonth() + 1}/${today.getFullYear()}`,
                `Itinéraire ${dateString}`
            ];

            return suggestions[Math.floor(Math.random() * suggestions.length)];
        }

        confirmNewPlanning() {
            const nameInput = document.getElementById('newPlanningName');
            if (!nameInput) return;

            const planningName = nameInput.value.trim();

            if (!planningName) {
                this.showAlert('Veuillez donner un nom à votre planning', 'error');
                nameInput.focus();
                return;
            }

            if (planningName.length < 2) {
                this.showAlert('Le nom du planning doit contenir au moins 2 caractères', 'error');
                nameInput.focus();
                return;
            }

            if (planningName.length > 255) {
                this.showAlert('Le nom du planning est trop long (max 255 caractères)', 'error');
                nameInput.focus();
                return;
            }

            this.newPlanningName = planningName;
            this.createNewPlanning = true;
            this.selectedPlanningId = null;

            this.hide();
            if (window.routePlanner) {
                window.routePlanner.saveAllTripsWithOptions(true, null, this.newPlanningName);
            }
        }

        cancelNewPlanning() {
            if (this.newPlanningModal) this.newPlanningModal.classList.remove('show');
            if (this.modal) this.modal.classList.add('show');
        }

        async loadUserPlannings() {
            const planningList = document.getElementById('planningList');
            if (!planningList) return;

            try {
                planningList.innerHTML = `
                    <div class="planning-loading">
                        <div class="loading-spinner-small"></div>
                        Chargement de vos plannings...
                    </div>
                `;

                const response = await fetch('/api/user-plannings', {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }

                const data = await response.json();

                if (data.success && data.plannings && data.plannings.length > 0) {
                    planningList.innerHTML = data.plannings.map(planning => `
                        <div class="planning-item" data-planning-id="${planning.id}">
                            <div class="planning-name">
                                <i class="fas fa-map"></i> ${planning.name}
                            </div>
                            <div class="planning-details">
                                <span class="planning-detail">
                                    <i class="fas fa-route"></i> ${planning.trips_count || 0} trajet(s)
                                </span>
                                <span class="planning-detail">
                                    <i class="fas fa-money-bill-wave"></i> ${planning.total_cost || 0} MAD
                                </span>
                                <span class="planning-detail">
                                    <i class="fas fa-road"></i> ${planning.total_distance || 0} km
                                </span>
                            </div>
                            <div class="planning-details">
                                <span class="planning-detail">
                                    <i class="fas fa-calendar"></i> Créé le ${planning.created_at || 'N/A'}
                                </span>
                                <span class="planning-detail">
                                    <i class="fas fa-tag"></i> ${planning.status || 'N/A'}
                                </span>
                            </div>
                        </div>
                    `).join('');

                    planningList.querySelectorAll('.planning-item').forEach(item => {
                        const existingListener = item.getAttribute('data-listener-attached');
                        if (!existingListener) {
                            item.addEventListener('click', () => {
                                this.selectPlanning(item);
                            });
                            item.setAttribute('data-listener-attached', 'true');
                        }
                    });

                } else {
                    planningList.innerHTML = `
                        <div class="no-plannings">
                            <i class="fas fa-folder-open" style="font-size: 2em; margin-bottom: 10px;"></i>
                            <p>Aucun planning existant trouvé.</p>
                            <p>Créez d'abord un planning pour pouvoir l'utiliser.</p>
                        </div>
                    `;
                }

            } catch (error) {
                planningList.innerHTML = `
                    <div class="no-plannings">
                        <i class="fas fa-exclamation-triangle" style="font-size: 2em; margin-bottom: 10px;"></i>
                        <p>Erreur lors du chargement des plannings.</p>
                        <p>Veuillez réessayer.</p>
                    </div>
                `;
            }
        }

        selectPlanning(item) {
            document.querySelectorAll('.planning-item').forEach(el => {
                el.classList.remove('selected');
            });

            item.classList.add('selected');
            this.selectedPlanningId = item.dataset.planningId;

            const confirmSelectionBtn = document.getElementById('confirmSelectionBtn');
            if (confirmSelectionBtn) {
                confirmSelectionBtn.disabled = false;
            }
        }

        async confirmSelection() {
            if (!this.selectedPlanningId) return;

            this.createNewPlanning = false;
            this.hide();
            if (window.routePlanner) {
                await window.routePlanner.saveAllTripsWithOptions(false, this.selectedPlanningId);
            }
        }

        showAlert(message, type = 'info') {
            const alertContainer = document.getElementById('alertContainer');
            if (!alertContainer) return;

            const alert = document.createElement('div');
            alert.className = `alert ${type}`;

            const icons = {
                'info': 'fas fa-info-circle',
                'success': 'fas fa-check-circle',
                'error': 'fas fa-exclamation-circle',
                'warning': 'fas fa-exclamation-triangle'
            };

            alert.innerHTML = `
                <div class="alert-icon">
                    <i class="${icons[type] || icons.info}"></i>
                </div>
                <div class="alert-message">${message}</div>
            `;

            alertContainer.appendChild(alert);

            setTimeout(() => {
                alert.classList.add('show');
            }, 10);

            setTimeout(() => {
                alert.classList.remove('show');
                alert.classList.add('hide');

                setTimeout(() => {
                    if (alert.parentNode) {
                        alert.parentNode.removeChild(alert);
                    }
                }, 500);
            }, 3000);
        }
    }

    let saveTripModal;

    // Fonction d'initialisation de la carte CORRIGÉE
    function initMap() {
        if (mapInitializationAttempted && mapInitialized) {
            return;
        }

        mapInitializationAttempted = true;

        const mapElement = document.getElementById('map');
        if (!mapElement) {
            console.log('Élément map non trouvé');
            mapInitializationAttempted = false;
            return;
        }

        if (typeof L === 'undefined') {
            console.log('Leaflet pas encore chargé');
            mapInitializationAttempted = false;
            setTimeout(initMap, 500);
            return;
        }

        // Nettoyer complètement l'ancienne carte
        if (map) {
            try {
                map.remove();
            } catch (e) {
                console.log('Erreur suppression ancienne carte:', e);
            }
            map = null;
        }

        // Réinitialiser l'élément map
        mapElement.innerHTML = '';
        mapElement.style.width = '100%';
        mapElement.style.height = '500px';
        mapElement.style.minHeight = '500px';
        mapElement.style.borderRadius = '15px';
        mapElement.style.overflow = 'hidden';
        mapElement.style.visibility = 'visible';
        mapElement.style.display = 'block';
        mapElement.style.opacity = '1';

        try {
            map = L.map('map', {
                center: MAP_CONFIG.center,
                zoom: MAP_CONFIG.zoom,
                zoomControl: true,
                attributionControl: true,
                minZoom: MAP_CONFIG.minZoom,
                maxZoom: MAP_CONFIG.maxZoom,
                preferCanvas: true,
                fadeAnimation: true,
                markerZoomAnimation: true
            });

            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                maxZoom: MAP_CONFIG.maxZoom,
                detectRetina: true
            }).addTo(map);

            console.log('Carte Leaflet initialisée avec succès');

            // Forcer le redimensionnement et l'initialisation
            const initializeMapComplete = () => {
                try {
                    map.invalidateSize(true);

                    // Vérifier que la carte est vraiment initialisée
                    const bounds = map.getBounds();
                    if (bounds && bounds.isValid()) {
                        mapInitialized = true;
                        console.log('Carte complètement initialisée et prête');

                        // Déclencher l'événement de succès
                        const event = new CustomEvent('mapInitialized', {
                            detail: {
                                map: map,
                                bounds: bounds
                            }
                        });
                        document.dispatchEvent(event);
                    } else {
                        throw new Error('Bounds invalides');
                    }
                } catch (e) {
                    console.log('Erreur initialisation carte, réessai:', e);
                    setTimeout(initializeMapComplete, 500);
                }
            };

            // Plusieurs tentatives d'initialisation
            setTimeout(initializeMapComplete, 100);
            setTimeout(initializeMapComplete, 500);
            setTimeout(initializeMapComplete, 1000);
            setTimeout(initializeMapComplete, 2000);

        } catch (error) {
            console.error('Erreur critique lors de l\'initialisation de la carte:', error);
            mapInitializationAttempted = false;
            // Réessayer après un délai
            setTimeout(initMap, 2000);
        }
    }

    function forceMapInit() {
        console.log('🚀 Forcer l\'initialisation de la carte');
        mapInitializationAttempted = false;
        mapInitialized = false;

        if (map) {
            try {
                map.remove();
            } catch (e) {
                console.log('Erreur suppression carte:', e);
            }
            map = null;
        }

        const mapElement = document.getElementById('map');
        if (mapElement) {
            mapElement.innerHTML = '';
        }

        setTimeout(initMap, 100);
    }

    function checkMapVisibility() {
        const mapElement = document.getElementById('map');
        if (!mapElement) {
            return false;
        }

        const style = window.getComputedStyle(mapElement);
        const isVisible = style.display !== 'none' &&
                         style.visibility !== 'hidden' &&
                         parseFloat(style.opacity) > 0;

        const rect = mapElement.getBoundingClientRect();
        const hasSize = rect.width > 50 && rect.height > 50;

        return isVisible && hasSize;
    }

    function initializeMap() {
        if (typeof L === 'undefined') {
            console.log('Leaflet pas encore chargé, réessai dans 500ms');
            setTimeout(initializeMap, 500);
            return;
        }

        if (!checkMapVisibility()) {
            console.log('Carte pas encore visible, réessai dans 1000ms');
            setTimeout(initializeMap, 1000);
            return;
        }

        console.log('✅ Conditions remplies, initialisation de la carte...');
        initMap();
    }

    function observeMapVisibility() {
        const mapElement = document.getElementById('map');
        if (!mapElement) {
            setTimeout(observeMapVisibility, 1000);
            return;
        }

        // Initialisation immédiate si visible
        if (checkMapVisibility() && !mapInitialized) {
            console.log('🎯 Carte visible, initialisation immédiate');
            initializeMap();
        }

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && !mapInitialized) {
                    console.log('🎯 Carte devenue visible dans la fenêtre, initialisation...');
                    initializeMap();
                }
            });
        }, {
            threshold: [0.1],
            rootMargin: '50px'
        });

        observer.observe(mapElement);

        // Observer aussi les changements de style
        const styleObserver = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                if (mutation.type === 'attributes' &&
                    (mutation.attributeName === 'style' || mutation.attributeName === 'class')) {
                    if (!mapInitialized && checkMapVisibility()) {
                        console.log('🎯 Carte devenue visible (changement style), initialisation...');
                        setTimeout(initializeMap, 500);
                    }
                }
            });
        });

        styleObserver.observe(mapElement, {
            attributes: true,
            attributeFilter: ['style', 'class']
        });
    }

    function setupMapResizeHandler() {
        let resizeTimeout;
        const handler = () => {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(() => {
                if (map && mapInitialized) {
                    try {
                        map.invalidateSize(true);
                        console.log('Carte redimensionnée');
                    } catch (e) {
                        console.log('Erreur redimensionnement carte:', e);
                    }
                }
            }, 250);
        };

        if (!eventListeners.has('resize')) {
            window.addEventListener('resize', handler);
            eventListeners.set('resize', { element: window, handler });
        }
    }

    function setupTabChangeListener() {
        const handler = (e) => {
            const target = e.target;
            if (target.classList.contains('tab') ||
                target.classList.contains('.nav-link') ||
                target.closest('.tab') ||
                target.closest('.nav-link')) {
                setTimeout(() => {
                    if (!mapInitialized && checkMapVisibility()) {
                        console.log('🔄 Changement d\'onglet, initialisation carte...');
                        forceMapInit();
                    } else if (map && mapInitialized) {
                        setTimeout(() => {
                            if (map) {
                                map.invalidateSize(true);
                                console.log('Carte actualisée après changement d\'onglet');
                            }
                        }, 300);
                    }
                }, 400);
            }
        };

        if (!eventListeners.has('tabChange')) {
            document.addEventListener('click', handler);
            eventListeners.set('tabChange', { element: document, handler });
        }
    }

    // Classe principale du planificateur d'itinéraires - COMPLÈTEMENT CORRIGÉE
    class MoroccoRoutePlanner {
        constructor() {
            this.map = null;
            this.routeLayer = null;
            this.markers = [];
            this.currentRoute = null;
            this.userLocation = null;
            this.userLocationMarker = null;
            this.currentTileLayer = null;
            this.mapStyles = this.getMapStyles();
            this.currentTrip = null;
            this.currentForm = 'trip';
            this.editingTripId = null;

            // Variables pour la création manuelle
            this.manualRouteMode = false;
            this.startMarker = null;
            this.endMarker = null;
            this.manualRouteLayer = null;
            this.tempMarkers = [];

            this.init();
        }

        getMapStyles() {
            return {
                'esri-satellite': {
                    name: 'Satellite',
                    icon: '🛰️',
                    url: 'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}',
                    attribution: 'Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community',
                    maxZoom: 18,
                    className: 'esri-satellite'
                },
                'carto-light': {
                    name: 'Carto Light',
                    icon: '☀️',
                    url: 'https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png',
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
                    maxZoom: 19,
                    className: 'carto-light'
                }
            };
        }

        async init() {
            await this.loadPassengerOptions();
            this.setupEventListeners();
            this.setupFormSwitcher();
            this.initTripSystem();
            this.initPassengerSelects();
            this.initManualRouteMode();

            // Démarrer la détection de localisation APRÈS l'initialisation de base
            setTimeout(() => {
                this.detectUserLocation();
            }, 1000);
        }

        /**
         * Initialise la carte même sans accès à la localisation - CORRIGÉ
         */
        initializeMapWithoutLocation() {
            console.log('🗺️ Initialisation de la carte sans localisation utilisateur');

            if (!mapInitialized && !mapInitializationAttempted) {
                console.log('🚀 Lancement de l\'initialisation de la carte...');
                forceMapInit();
            } else if (!mapInitialized) {
                console.log('🔄 Réinitialisation de la carte...');
                forceMapInit();
            }

            // Mettre à jour l'interface
            const locationCard = document.getElementById('locationCard');
            const detectedLocation = document.getElementById('detectedLocation');

            if (locationCard) {
                locationCard.style.display = 'block';
            }
            if (detectedLocation) {
                detectedLocation.innerHTML = '<i class="fas fa-map"></i> Vue par défaut du Maroc';
            }
        }

        /**
         * Détection de la localisation COMPLÈTEMENT CORRIGÉE
         */
        async detectUserLocation() {
            const locationCard = document.getElementById('locationCard');
            const detectedLocation = document.getElementById('detectedLocation');

            console.log('📍 Début de la détection de localisation...');

            // TOUJOURS initialiser la carte, même sans géolocalisation
            this.initializeMapWithoutLocation();

            if (!navigator.geolocation) {
                console.log('❌ Géolocalisation non supportée');
                this.showMessage('La géolocalisation n\'est pas supportée. Utilisation de la vue par défaut.', 'info');
                return;
            }

            if (locationCard) locationCard.style.display = 'block';
            if (detectedLocation) {
                detectedLocation.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Détection de votre position...';
            }

            // Options améliorées pour la géolocalisation
            const geoOptions = {
                enableHighAccuracy: true,  // GPS si disponible
                timeout: 15000,           // 15 secondes max
                maximumAge: 60000         // Accepter une position de moins d'1 minute
            };

            console.log('📍 Demande de position avec options:', geoOptions);

            navigator.geolocation.getCurrentPosition(
                async (position) => {
                    console.log('✅ Position obtenue avec succès:', position.coords);

                    this.userLocation = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude,
                        accuracy: position.coords.accuracy
                    };

                    try {
                        // Reverse geocoding pour obtenir le nom du lieu
                        const response = await fetch(
                            `https://nominatim.openstreetmap.org/reverse?format=json&lat=${this.userLocation.lat}&lon=${this.userLocation.lng}&zoom=18&addressdetails=1`
                        );

                        if (!response.ok) {
                            throw new Error('Erreur reverse geocoding');
                        }

                        const data = await response.json();
                        console.log('📌 Données reverse geocoding:', data);

                        let locationName = 'Position actuelle';
                        if (data.address) {
                            locationName = data.address.road || data.address.neighbourhood ||
                                         data.address.suburb || data.address.city ||
                                         data.address.town || data.address.village ||
                                         data.address.county || data.display_name?.split(',')[0] ||
                                         'Position actuelle';
                        }

                        if (detectedLocation) {
                            detectedLocation.innerHTML = `<i class="fas fa-map-marker-alt"></i> ${locationName}`;
                        }

                        // Ajouter le marqueur de position
                        this.addUserLocationMarker();

                        this.showMessage(`📍 Position détectée: ${locationName} (Précision: ${Math.round(this.userLocation.accuracy)}m)`, 'success');

                        // Centrer la carte sur la position
                        this.centerMapOnUserLocation();

                    } catch (error) {
                        console.error('❌ Erreur reverse geocoding:', error);
                        if (detectedLocation) {
                            detectedLocation.innerHTML = `<i class="fas fa-map-marker-alt"></i> Position actuelle`;
                        }
                        this.addUserLocationMarker();
                        this.centerMapOnUserLocation();
                    }

                },
                (error) => {
                    console.error('❌ Erreur géolocalisation:', error);

                    let errorMessage = 'Impossible de détecter votre position';
                    switch(error.code) {
                        case error.PERMISSION_DENIED:
                            errorMessage = '📍 Autorisation de localisation refusée - Utilisation de la vue par défaut';
                            break;
                        case error.POSITION_UNAVAILABLE:
                            errorMessage = '📍 Position indisponible - Vérifiez votre connexion';
                            break;
                        case error.TIMEOUT:
                            errorMessage = '📍 Délai de détection dépassé - Utilisation de la vue par défaut';
                            break;
                    }

                    if (detectedLocation) {
                        detectedLocation.innerHTML = '<i class="fas fa-map"></i> Vue par défaut du Maroc';
                    }

                    this.showMessage(errorMessage, 'warning');

                    // S'assurer que la carte est initialisée même en cas d'erreur
                    setTimeout(() => {
                        if (!mapInitialized) {
                            this.initializeMapWithoutLocation();
                        }
                    }, 1000);
                },
                geoOptions
            );
        }

        /**
         * Centre la carte sur la position utilisateur - CORRIGÉ
         */
        centerMapOnUserLocation() {
            if (!this.userLocation) return;

            const tryCenterMap = () => {
                if (map && mapInitialized) {
                    try {
                        map.setView([this.userLocation.lat, this.userLocation.lng], 13);
                        console.log('🎯 Carte centrée sur la position utilisateur');
                    } catch (e) {
                        console.log('Erreur centrage carte:', e);
                        setTimeout(tryCenterMap, 500);
                    }
                } else {
                    console.log('⏳ Carte pas encore prête pour centrage...');
                    setTimeout(tryCenterMap, 500);
                }
            };

            tryCenterMap();
        }

        /**
         * Ajoute le marqueur de position utilisateur - CORRIGÉ
         */
        addUserLocationMarker() {
            if (!this.userLocation) return;

            const tryAddMarker = () => {
                if (map && mapInitialized) {
                    try {
                        // Supprimer l'ancien marqueur s'il existe
                        if (this.userLocationMarker) {
                            map.removeLayer(this.userLocationMarker);
                        }

                        const userIcon = L.divIcon({
                            className: 'custom-marker user-marker',
                            html: '<i class="fas fa-user" style="color: white; font-size: 12px;"></i>',
                            iconSize: [30, 30],
                            iconAnchor: [15, 15]
                        });

                        this.userLocationMarker = L.marker([this.userLocation.lat, this.userLocation.lng], {
                            icon: userIcon,
                            zIndexOffset: 1000
                        })
                        .addTo(map)
                        .bindPopup('<strong><i class="fas fa-user"></i> Votre Position Actuelle</strong>')
                        .openPopup();

                        console.log('📍 Marqueur de position utilisateur ajouté');

                    } catch (e) {
                        console.log('Erreur ajout marqueur utilisateur:', e);
                    }
                } else {
                    console.log('⏳ Carte pas encore prête pour marqueur...');
                    setTimeout(tryAddMarker, 500);
                }
            };

            tryAddMarker();
        }

        initManualRouteMode() {
            const manualRouteBtn = document.getElementById('manualRouteBtn');
            const manualRouteBtnMap = document.getElementById('manualRouteBtnMap');
            const clearRouteBtn = document.getElementById('clearRouteBtn');

            const setupListener = (id, handler) => {
                const element = document.getElementById(id);
                if (element && !eventListeners.has(id)) {
                    element.addEventListener('click', handler);
                    eventListeners.set(id, { element, handler });
                }
            };

            if (manualRouteBtn) {
                setupListener('manualRouteBtn', () => this.toggleManualRouteMode());
            }

            if (manualRouteBtnMap) {
                setupListener('manualRouteBtnMap', () => this.toggleManualRouteMode());
            }

            if (clearRouteBtn) {
                setupListener('clearRouteBtn', () => this.cancelManualRoute());
            }
        }

        toggleManualRouteMode() {
            this.manualRouteMode = !this.manualRouteMode;

            const manualRouteBtn = document.getElementById('manualRouteBtn');
            const manualRouteBtnMap = document.getElementById('manualRouteBtnMap');
            const clearRouteBtn = document.getElementById('clearRouteBtn');
            const manualRouteInfo = document.getElementById('manualRouteInfo');

            if (manualRouteBtn) {
                if (this.manualRouteMode) {
                    manualRouteBtn.innerHTML = '<i class="fas fa-times"></i> Annuler la Sélection';
                    manualRouteBtn.classList.add('active');
                } else {
                    manualRouteBtn.innerHTML = '<i class="fas fa-draw-polygon"></i> Créer sur la Carte';
                    manualRouteBtn.classList.remove('active');
                }
            }

            if (manualRouteBtnMap) {
                if (this.manualRouteMode) {
                    manualRouteBtnMap.innerHTML = '<i class="fas fa-times"></i> Annuler';
                    manualRouteBtnMap.classList.add('active');
                } else {
                    manualRouteBtnMap.innerHTML = '<i class="fas fa-draw-polygon"></i> Créer Trajet';
                    manualRouteBtnMap.classList.remove('active');
                }
            }

            if (clearRouteBtn) {
                clearRouteBtn.style.display = this.manualRouteMode ? 'flex' : 'none';
            }

            if (manualRouteInfo) {
                manualRouteInfo.style.display = this.manualRouteMode ? 'block' : 'none';
            }

            if (this.manualRouteMode) {
                this.showMessage('Mode création activé: Cliquez sur la carte pour placer le départ et l\'arrivée', 'info');
                this.prepareMapForManualCreation();
            } else {
                this.cancelManualRoute();
                this.showMessage('Mode création désactivé', 'info');
            }
        }

        prepareMapForManualCreation() {
            if (!map || !mapInitialized) {
                this.showMessage('La carte n\'est pas encore prête. Veuillez patienter...', 'warning');
                setTimeout(() => this.prepareMapForManualCreation(), 1000);
                return;
            }

            // Nettoyer les anciens marqueurs
            this.clearManualMarkers();

            // Changer le curseur
            map.getContainer().style.cursor = 'crosshair';

            // Ajouter les instructions
            this.showCreationInstructions();

            // Configurer le gestionnaire de clics
            map.off('click'); // Supprimer les anciens gestionnaires
            map.on('click', this.handleMapClick.bind(this));
        }

        showCreationInstructions() {
            // Supprimer les anciennes instructions
            const oldInstructions = document.querySelector('.creation-instructions');
            if (oldInstructions) oldInstructions.remove();

            const instructions = document.createElement('div');
            instructions.className = 'creation-instructions';
            instructions.innerHTML = `
                <i class="fas fa-mouse-pointer"></i>
                Cliquez sur la carte pour placer le point de départ et d'arrivée
                <br><small>Départ → Arrivée</small>
            `;

            map.getContainer().appendChild(instructions);
        }

        handleMapClick(e) {
            if (!this.manualRouteMode) return;

            const latlng = e.latlng;

            if (!this.startMarker) {
                this.placeStartMarker(latlng);
            } else if (!this.endMarker) {
                this.placeEndMarker(latlng);
                this.calculateManualRoute();
            }
        }

        placeStartMarker(latlng) {
            const startIcon = L.divIcon({
                className: 'custom-marker route-marker-start manual-marker',
                html: '<i class="fas fa-play" style="color: white; font-size: 12px;"></i>',
                iconSize: [30, 30],
                iconAnchor: [15, 15]
            });

            this.startMarker = L.marker(latlng, {
                icon: startIcon,
                draggable: true
            }).addTo(map);

            this.startMarker.bindPopup('<strong>Point de Départ</strong><br>Glissez pour ajuster');
            this.startMarker.on('dragend', (e) => {
                const newLatLng = e.target.getLatLng();
                this.updateManualFromLocation(newLatLng);
                if (this.endMarker) {
                    this.calculateManualRoute();
                }
            });

            this.tempMarkers.push(this.startMarker);
            this.updateManualFromLocation(latlng);
            this.showMessage('Point de départ placé. Cliquez pour placer le point d\'arrivée', 'success');
        }

        placeEndMarker(latlng) {
            const endIcon = L.divIcon({
                className: 'custom-marker route-marker-end manual-marker',
                html: '<i class="fas fa-flag-checkered" style="color: white; font-size: 12px;"></i>',
                iconSize: [30, 30],
                iconAnchor: [15, 15]
            });

            this.endMarker = L.marker(latlng, {
                icon: endIcon,
                draggable: true
            }).addTo(map);

            this.endMarker.bindPopup('<strong>Point d\'Arrivée</strong><br>Glissez pour ajuster');
            this.endMarker.on('dragend', (e) => {
                const newLatLng = e.target.getLatLng();
                this.updateManualToLocation(newLatLng);
                this.calculateManualRoute();
            });

            this.tempMarkers.push(this.endMarker);
            this.updateManualToLocation(latlng);
            this.showMessage('Point d\'arrivée placé. Calcul de l\'itinéraire en cours...', 'success');
        }

        async updateManualFromLocation(latlng) {
            const locationName = await this.reverseGeocode(latlng.lat, latlng.lng);
            const fromInput = document.getElementById('from');

            if (fromInput) {
                fromInput.value = locationName;
                fromInput.dataset.lat = latlng.lat;
                fromInput.dataset.lng = latlng.lng;
            }
        }

        async updateManualToLocation(latlng) {
            const locationName = await this.reverseGeocode(latlng.lat, latlng.lng);
            const toInput = document.getElementById('to');

            if (toInput) {
                toInput.value = locationName;
                toInput.dataset.lat = latlng.lat;
                toInput.dataset.lng = latlng.lng;
            }
        }

        async calculateManualRoute() {
            if (!this.startMarker || !this.endMarker) return;

            const loading = document.getElementById('loading');

            if (loading) loading.classList.add('show');

            try {
                const startLatLng = this.startMarker.getLatLng();
                const endLatLng = this.endMarker.getLatLng();

                const url = `https://router.project-osrm.org/route/v1/driving/${startLatLng.lng},${startLatLng.lat};${endLatLng.lng},${endLatLng.lat}?overview=full&geometries=geojson`;
                const response = await fetch(url);
                const data = await response.json();

                if (!data.routes || data.routes.length === 0) {
                    throw new Error('Aucun itinéraire trouvé entre ces points');
                }

                const route = data.routes[0];
                const distance = (route.distance / 1000).toFixed(1);
                const duration = Math.round(route.duration / 60);

                const passengerCount = parseInt(document.getElementById('passengerCount').value) || 3;
                const cost = await this.calculateCostByPassengers(distance, passengerCount);

                // Dessiner l'itinéraire
                this.drawManualRoute(route.geometry.coordinates);

                // Mettre à jour l'interface
                document.getElementById('manualDistance').textContent = distance;
                document.getElementById('manualDuration').textContent = this.formatDuration(duration);
                document.getElementById('manualCost').textContent = `${cost} MAD`;

                this.showMessage('Itinéraire calculé avec succès! Remplissez les dates et cliquez sur "Ajouter Trajet"', 'success');

            } catch (error) {
                console.error('Erreur lors du calcul de l\'itinéraire:', error);
                this.showMessage('Erreur lors du calcul de l\'itinéraire. Veuillez réessayer.', 'error');
            } finally {
                if (loading) loading.classList.remove('show');
            }
        }

        drawManualRoute(geometry) {
            this.clearManualRoute();

            if (geometry && geometry.length > 0) {
                const routeCoords = geometry.map(coord => [coord[1], coord[0]]);
                this.manualRouteLayer = L.polyline(routeCoords, {
                    color: '#33A9DC',
                    weight: 6,
                    opacity: 0.8,
                    lineJoin: 'round',
                    lineCap: 'round'
                }).addTo(map);

                // Ajuster la vue pour montrer l'itinéraire complet
                const routeBounds = this.manualRouteLayer.getBounds();
                map.fitBounds(routeBounds, {
                    padding: [50, 50],
                    maxZoom: 12
                });
            }
        }

        cancelManualRoute() {
            this.manualRouteMode = false;

            // Nettoyer la carte
            this.clearManualMarkers();
            this.clearManualRoute();

            // Réinitialiser l'interface
            if (map) {
                map.off('click');
                map.getContainer().style.cursor = '';
            }

            // Supprimer les instructions
            const instructions = document.querySelector('.creation-instructions');
            if (instructions) instructions.remove();

            // Réinitialiser les boutons
            const manualRouteBtn = document.getElementById('manualRouteBtn');
            const manualRouteBtnMap = document.getElementById('manualRouteBtnMap');
            const clearRouteBtn = document.getElementById('clearRouteBtn');
            const manualRouteInfo = document.getElementById('manualRouteInfo');

            if (manualRouteBtn) {
                manualRouteBtn.innerHTML = '<i class="fas fa-draw-polygon"></i> Créer sur la Carte';
                manualRouteBtn.classList.remove('active');
            }

            if (manualRouteBtnMap) {
                manualRouteBtnMap.innerHTML = '<i class="fas fa-draw-polygon"></i> Créer Trajet';
                manualRouteBtnMap.classList.remove('active');
            }

            if (clearRouteBtn) {
                clearRouteBtn.style.display = 'none';
            }

            if (manualRouteInfo) {
                manualRouteInfo.style.display = 'none';
            }

            // Réinitialiser les statistiques
            document.getElementById('manualDistance').textContent = '0';
            document.getElementById('manualDuration').textContent = '0h 0min';
            document.getElementById('manualCost').textContent = '0 MAD';
        }

        clearManualMarkers() {
            this.tempMarkers.forEach(marker => {
                if (map && marker) {
                    map.removeLayer(marker);
                }
            });
            this.tempMarkers = [];
            this.startMarker = null;
            this.endMarker = null;
        }

        clearManualRoute() {
            if (this.manualRouteLayer && map) {
                map.removeLayer(this.manualRouteLayer);
                this.manualRouteLayer = null;
            }
        }

        async reverseGeocode(lat, lng) {
            const cacheKey = `reverse_${lat}_${lng}`;

            // Vérifier le cache
            if (geocodingCache.has(cacheKey)) {
                return geocodingCache.get(cacheKey);
            }

            try {
                const response = await fetch(
                    `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=16&addressdetails=1`
                );
                const data = await response.json();

                let locationName = 'Lieu inconnu';

                if (data.address) {
                    locationName = data.address.road || data.address.neighbourhood ||
                                 data.address.suburb || data.address.city ||
                                 data.address.town || data.address.village ||
                                 data.address.municipality || data.address.county ||
                                 data.display_name?.split(',')[0] || 'Lieu inconnu';
                }

                // Mettre en cache le résultat
                geocodingCache.set(cacheKey, locationName);

                return locationName;
            } catch (error) {
                console.error('Erreur reverse geocoding:', error);
                return 'Lieu inconnu';
            }
        }

        async loadPassengerOptions() {
            try {
                // For regular trips - all passenger options
                const response = await fetch('/api/passenger-options');

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();

                if (data.success && data.options && data.options.length > 0) {
                    passengerOptions = data.options;
                } else {
                    passengerOptions = [3, 6, 8, 17, 40, 50, 90];
                }

                // For day rate trips - only cost_by_day type
                try {
                    const dayRateResponse = await fetch('/api/passenger-options?type=cost_by_day');

                    if (dayRateResponse.ok) {
                        const dayRateData = await dayRateResponse.json();
                        if (dayRateData.success && dayRateData.options && dayRateData.options.length > 0) {
                            dayRatePassengerOptions = dayRateData.options;
                        } else {
                            // Filter only cost_by_day options from the main list
                            dayRatePassengerOptions = passengerOptions.filter(passengers =>
                                passengers <= 17 // Only show options up to 17 passengers for day rate
                            );
                        }
                    } else {
                        // Fallback: filter from main list
                        dayRatePassengerOptions = passengerOptions.filter(passengers =>
                            passengers <= 17
                        );
                    }
                } catch (dayRateError) {
                    console.error('Error loading day rate passenger options:', dayRateError);
                    // Fallback: filter from main list
                    dayRatePassengerOptions = passengerOptions.filter(passengers =>
                        passengers <= 17
                    );
                }

            } catch (error) {
                console.error('Error loading passenger options:', error);
                passengerOptions = [3, 6, 8, 17, 40, 50, 90];
                dayRatePassengerOptions = [3, 6, 8, 17]; // Default day rate options
            }
        }

        initPassengerSelects() {
            const tripPassengerSelect = document.getElementById('passengerCount');
            const dayRatePassengerSelect = document.getElementById('dayRatePassengerCount');

            // Regular trip passengers (all options)
            const passengerOptionsHTML = '<option value="">Sélectionner le nombre de passagers</option>' +
                passengerOptions.map(passengers => {
                    const vehicleType = this.getVehicleTypeByPassengers(passengers);
                    const label = this.getPassengerLabel(passengers, vehicleType);
                    return `<option value="${passengers}">${label}</option>`;
                }).join('');

            // Day rate passengers (only cost_by_day type - filtered)
            const dayRatePassengerOptionsHTML = '<option value="">Sélectionner le nombre de passagers</option>' +
                dayRatePassengerOptions.map(passengers => {
                    const vehicleType = this.getVehicleTypeByPassengers(passengers);
                    const label = this.getPassengerLabel(passengers, vehicleType);
                    return `<option value="${passengers}">${label}</option>`;
                }).join('');

            if (tripPassengerSelect) {
                tripPassengerSelect.innerHTML = passengerOptionsHTML;
                if (passengerOptions.length > 0) {
                    tripPassengerSelect.value = passengerOptions[0];
                }
            }

            if (dayRatePassengerSelect) {
                dayRatePassengerSelect.innerHTML = dayRatePassengerOptionsHTML;
                if (dayRatePassengerOptions.length > 0) {
                    dayRatePassengerSelect.value = dayRatePassengerOptions[0];
                }
            }

            this.setupPassengerSelectListeners();
        }

        getVehicleTypeByPassengers(passengers) {
            if (passengers <= 4) {
                return 'car';
            } else if (passengers <= 8) {
                return 'van';
            } else {
                return 'minibus';
            }
        }

        getPassengerLabel(passengers, vehicleType) {
            const vehicleLabels = {
                'car': 'Voiture',
                'van': 'Van',
                'minibus': 'Mini Bus'
            };
            return `${passengers} Passagers`;
        }

        setupPassengerSelectListeners() {
            const tripPassengerSelect = document.getElementById('passengerCount');
            const dayRatePassengerSelect = document.getElementById('dayRatePassengerCount');
            const vehicleSelect = document.getElementById('vehicleType');

            const setupListener = (element, handler) => {
                if (element && !eventListeners.has(element.id)) {
                    element.addEventListener('change', handler);
                    eventListeners.set(element.id, { element, handler });
                }
            };

            if (tripPassengerSelect) {
                setupListener(tripPassengerSelect, function() {
                    const passengers = parseInt(this.value);
                    if (passengers && vehicleSelect) {
                        const vehicleType = window.routePlanner.getVehicleTypeByPassengers(passengers);
                        vehicleSelect.value = vehicleType;
                    }
                });
            }

            if (dayRatePassengerSelect) {
                setupListener(dayRatePassengerSelect, function() {
                    window.routePlanner.updateDayRateSummary();
                });
            }
        }

        showAlert(message, type = 'info') {
            const alertContainer = document.getElementById('alertContainer');
            if (!alertContainer) return;

            const alert = document.createElement('div');
            alert.className = `alert ${type}`;

            const icons = {
                'info': 'fas fa-info-circle',
                'success': 'fas fa-check-circle',
                'error': 'fas fa-exclamation-circle',
                'warning': 'fas fa-exclamation-triangle'
            };

            alert.innerHTML = `
                <div class="alert-icon">
                    <i class="${icons[type] || icons.info}"></i>
                </div>
                <div class="alert-message">${message}</div>
            `;

            alertContainer.appendChild(alert);

            setTimeout(() => {
                alert.classList.add('show');
            }, 10);

            setTimeout(() => {
                alert.classList.remove('show');
                alert.classList.add('hide');

                setTimeout(() => {
                    if (alert.parentNode) {
                        alert.parentNode.removeChild(alert);
                    }
                }, 500);
            }, 2000);
        }

        showMessage(message, type) {
            this.hideMessages();
            this.showAlert(message, type);
        }

        hideMessages() {
            ['error', 'success'].forEach(type => {
                const element = document.getElementById(type);
                if (element) {
                    element.classList.remove('show');
                }
            });
        }

        setupEventListeners() {
            const useLocationBtn = document.getElementById('useCurrentLocation');
            const fromInput = document.getElementById('from');
            const toInput = document.getElementById('to');
            const calculateBtn = document.getElementById('calculateRoute');
            const addCityBtn = document.getElementById('addCityBtn');
            const confirmDayRate = document.getElementById('confirmDayRate');
            const dayRateDays = document.getElementById('dayRateDays');
            const dayRateStartDate = document.getElementById('dayRateStartDate');
            const saveAllBtn = document.getElementById('saveAllTrips');

            const setupListener = (id, handler, eventType = 'click') => {
                const element = document.getElementById(id);
                if (element && !eventListeners.has(id)) {
                    element.addEventListener(eventType, handler);
                    eventListeners.set(id, { element, handler });
                }
            };

            if (useLocationBtn) {
                setupListener('useCurrentLocation', () => this.useCurrentLocation());
            }
            if (calculateBtn) {
                setupListener('calculateRoute', () => this.addTrip());
            }
            if (saveAllBtn) {
                setupListener('saveAllTrips', () => this.saveAllTrips());
            }

            if (addCityBtn) {
                setupListener('addCityBtn', () => this.addCityToDayRate());
            }
            if (confirmDayRate) {
                setupListener('confirmDayRate', () => this.confirmDayRateBooking());
            }
            if (dayRateDays) {
                setupListener('dayRateDays', () => this.updateDayRateSummary(), 'change');
            }
            if (dayRateStartDate) {
                setupListener('dayRateStartDate', () => this.updateDayRateSummary(), 'change');
            }

            if (fromInput) {
                setupListener('fromInput', (e) => {
                    if (e.key === 'Enter') this.addTrip();
                }, 'keypress');
            }
            if (toInput) {
                setupListener('toInput', (e) => {
                    if (e.key === 'Enter') this.addTrip();
                }, 'keypress');
            }

            this.setupAutocomplete('from', 'fromSuggestions');
            this.setupAutocomplete('to', 'toSuggestions');
        }

        useCurrentLocation() {
            if (!this.userLocation) {
                this.showMessage('Localisation non disponible. Veuillez activer les services de localisation.', 'error');
                return;
            }

            const fromInput = document.getElementById('from');
            if (fromInput) {
                fromInput.value = 'Position actuelle';
                fromInput.dataset.lat = this.userLocation.lat;
                fromInput.dataset.lng = this.userLocation.lng;
            }

            this.showMessage('Position actuelle définie comme point de départ', 'success');
        }

/**
 * Efface COMPLÈTEMENT l'itinéraire et les marqueurs de la carte - VERSION RENFORCÉE
 */
clearRoute() {
    console.log('🗑️ NETTOYAGE COMPLET DE LA CARTE');

    // 1. Supprimer la couche d'itinéraire principale
    if (this.routeLayer && map) {
        try {
            map.removeLayer(this.routeLayer);
            console.log('✅ Couche d\'itinéraire principale supprimée');
        } catch (e) {
            console.log('❌ Erreur suppression routeLayer:', e);
        }
        this.routeLayer = null;
    }

    // 2. Supprimer l'itinéraire manuel
    if (this.manualRouteLayer && map) {
        try {
            map.removeLayer(this.manualRouteLayer);
            console.log('✅ Couche d\'itinéraire manuel supprimée');
        } catch (e) {
            console.log('❌ Erreur suppression manualRouteLayer:', e);
        }
        this.manualRouteLayer = null;
    }

    // 3. Supprimer TOUS les marqueurs sauf celui de la position utilisateur
    this.markers.forEach(marker => {
        if (map && marker && marker !== this.userLocationMarker) {
            try {
                map.removeLayer(marker);
                console.log('✅ Marqueur supprimé:', marker);
            } catch (e) {
                console.log('❌ Erreur suppression marqueur:', e);
            }
        }
    });

    // 4. Réinitialiser la liste des marqueurs
    this.markers = this.userLocationMarker ? [this.userLocationMarker] : [];

    // 5. Nettoyer les popups et forcer le redessin
    if (map) {
        try {
            map.closePopup();
            // Forcer un redessin complet de la carte
            map.invalidateSize(true);
            // Nettoyer également les couches temporaires
            map.eachLayer(layer => {
                if (layer instanceof L.Polyline ||
                    (layer instanceof L.Marker && layer !== this.userLocationMarker)) {
                    try {
                        map.removeLayer(layer);
                    } catch (e) {
                        // Ignorer les erreurs sur les layers déjà supprimés
                    }
                }
            });
        } catch (e) {
            console.log('❌ Erreur nettoyage carte:', e);
        }
    }

    console.log('✅ NETTOYAGE TERMINÉ - Carte prête pour nouvel itinéraire');
}

        /**
         * Rafraîchit uniquement les éléments liés à l'itinéraire sans toucher à l'état global de la carte
         */
        refreshRouteOnly() {
            console.log('🔁 Rafraîchissement du tracé uniquement');

            if (!map) {
                return;
            }

            const removeLayer = (layerProp) => {
                if (this[layerProp]) {
                    try {
                        map.removeLayer(this[layerProp]);
                    } catch (e) {
                        console.log(`❌ Erreur suppression ${layerProp}:`, e);
                    }
                    this[layerProp] = null;
                }
            };

            // Supprimer les différentes couches de trajets
            removeLayer('routeLayer');
            removeLayer('manualRouteLayer');

            // Supprimer les marqueurs temporaires (manuel ou autre)
            if (Array.isArray(this.tempMarkers) && this.tempMarkers.length) {
                this.tempMarkers.forEach(marker => {
                    try {
                        map.removeLayer(marker);
                    } catch (e) {
                        console.log('❌ Erreur suppression marqueur temporaire:', e);
                    }
                });
                this.tempMarkers = [];
            }

            ['startMarker', 'endMarker'].forEach(markerName => {
                if (this[markerName]) {
                    try {
                        map.removeLayer(this[markerName]);
                    } catch (e) {
                        console.log(`❌ Erreur suppression ${markerName}:`, e);
                    }
                    this[markerName] = null;
                }
            });

            // Ne conserver que le marqueur de localisation utilisateur
            if (Array.isArray(this.markers) && this.markers.length) {
                this.markers = this.markers.filter(marker => {
                    if (!marker) {
                        return false;
                    }
                    if (marker === this.userLocationMarker) {
                        return true;
                    }
                    try {
                        map.removeLayer(marker);
                    } catch (e) {
                        console.log('❌ Erreur suppression marqueur de trajet:', e);
                    }
                    return false;
                });
            }

            try {
                map.closePopup();
            } catch (e) {
                console.log('❌ Erreur fermeture popup:', e);
            }
        }

        async addTrip() {
            const fromInput = document.getElementById('from');
            const toInput = document.getElementById('to');
            const dateDebut = document.getElementById('dateDebut');
            const dateFin = document.getElementById('dateFin');
            const vehicleType = document.getElementById('vehicleType');
            const passengerSelect = document.getElementById('passengerCount');
            const loading = document.getElementById('loading');
            const btn = document.getElementById('calculateRoute');

            if (this.editingTripId) return this.showMessage("Vous êtes en mode modification.", "error");

            if (!fromInput || !toInput || !dateDebut || !dateFin || !vehicleType || !passengerSelect) {
                this.showMessage('Éléments du formulaire manquants', 'error');
                return;
            }

            if (!fromInput.value.trim() || !toInput.value.trim()) {
                this.showMessage('Veuillez saisir le point de départ et la destination.', 'error');
                return;
            }

            if (!dateDebut.value || !dateFin.value) {
                this.showMessage('Veuillez sélectionner les dates de début et fin.', 'error');
                return;
            }

            if (new Date(dateDebut.value) > new Date(dateFin.value)) {
                this.showMessage('La date de fin doit être postérieure à la date de début.', 'error');
                return;
            }

            if (!vehicleType.value) {
                this.showMessage('Veuillez choisir un type de véhicule.', 'error');
                return;
            }

            if (!passengerSelect.value) {
                this.showMessage('Veuillez sélectionner le nombre de passagers.', 'error');
                return;
            }

            // Prevent multiple submissions
            if (btn.disabled) {
                return;
            }

            if (loading) loading.classList.add('show');
            if (btn) {
                btn.disabled = true;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Calcul...';
            }

            try {
                let fromLat, fromLng, toLat, toLng;

                if (fromInput.dataset.lat && fromInput.dataset.lng) {
                    fromLat = parseFloat(fromInput.dataset.lat);
                    fromLng = parseFloat(fromInput.dataset.lng);
                } else {
                    const fromResults = await this.geocode(fromInput.value);
                    if (fromResults.length === 0) {
                        throw new Error('Impossible de trouver le point de départ.');
                    }
                    fromLat = parseFloat(fromResults[0].lat);
                    fromLng = parseFloat(fromResults[0].lon);
                }

                if (toInput.dataset.lat && toInput.dataset.lng) {
                    toLat = parseFloat(toInput.dataset.lat);
                    toLng = parseFloat(toInput.dataset.lng);
                } else {
                    const toResults = await this.geocode(toInput.value);
                    if (toResults.length === 0) {
                        throw new Error('Impossible de trouver la destination.');
                    }
                    toLat = parseFloat(toResults[0].lat);
                    toLng = parseFloat(toResults[0].lon);
                }

                const passengerCount = parseInt(passengerSelect.value);

                const url = `https://router.project-osrm.org/route/v1/driving/${fromLng},${fromLat};${toLng},${toLat}?overview=full&geometries=geojson`;
                const response = await fetch(url);
                const data = await response.json();

                if (!data.routes || data.routes.length === 0) {
                    throw new Error('Aucun itinéraire trouvé.');
                }

                const route = data.routes[0];
                const distance = (route.distance / 1000).toFixed(1);
                const duration = Math.round(route.duration / 60);

                const cost = await this.calculateCostByPassengers(distance, passengerCount);

                this.drawRouteOnMap(fromLat, fromLng, toLat, toLng, fromInput.value, toInput.value, distance, duration, cost);

                tripCounter++;
                const trip = {
                    id: tripCounter,
                    ref: `TRP-${String(tripCounter).padStart(3, '0')}`,
                    from: fromInput.value,
                    to: toInput.value,
                    dateDebut: dateDebut.value,
                    dateFin: dateFin.value,
                    vehicleType: vehicleType.value,
                    vehicleLabel: this.getVehicleLabel(vehicleType.value),
                    distance: distance,
                    duration: duration,
                    cost: cost,
                    status: 'pending',
                    coordinates: {
                        from: { lat: fromLat, lng: fromLng },
                        to: { lat: toLat, lng: toLng }
                    },
                    passengerCount: passengerCount,
                    type: 'regular',
                    fixedPrice: false
                };

                tripsList.push(trip);

                this.updateTripsTable();
                this.updateRecap();

                const tableContainer = document.getElementById('tripsTableContainer');
                const recapContainer = document.getElementById('tripRecap');
                if (tableContainer) tableContainer.style.display = 'block';
                if (recapContainer) recapContainer.style.display = 'block';

                fromInput.value = '';
                toInput.value = '';
                fromInput.dataset.lat = '';
                fromInput.dataset.lng = '';
                toInput.dataset.lat = '';
                toInput.dataset.lng = '';
                vehicleType.value = '';

                // Désactiver le mode manuel si actif
                if (this.manualRouteMode) {
                    this.cancelManualRoute();
                }

                this.showMessage('Trajet ajouté avec succès!', 'success');

            } catch (err) {
                this.showMessage(err.message, 'error');
            } finally {
                if (loading) loading.classList.remove('show');
                if (btn) {
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fas fa-plus"></i> AJOUTER';
                }
            }
        }

        getVehicleLabel(vehicleType) {
            const vehicleLabels = {
                'car': 'Voiture',
                'van': 'Van',
                'minibus': 'Mini Bus'
            };
            return vehicleLabels[vehicleType] || vehicleType;
        }

/**
 * Dessine un itinéraire sur la carte - VERSION COMPLÈTEMENT CORRIGÉE
 */
async drawRouteOnMap(fromLat, fromLng, toLat, toLng, fromName, toName, distance, duration, cost) {
    console.log('🎨 DÉBUT drawRouteOnMap - Nouvel itinéraire:', {
        de: `${fromName} (${fromLat}, ${fromLng})`,
        vers: `${toName} (${toLat}, ${toLng})`
    });

    // 1. S'assurer que la carte est prête
    if (!map || !mapInitialized) {
        console.log('🔄 Initialisation de la carte en cours...');
        this.initializeMapWithoutLocation();

        let attempts = 0;
        while (attempts < 10 && (!map || !mapInitialized)) {
            await new Promise(resolve => setTimeout(resolve, 500));
            attempts++;
        }

        if (!map || !mapInitialized) {
            console.error('❌ Carte non disponible après attente');
            this.showMessage('La carte n\'est pas disponible', 'error');
            return;
        }
    }

    try {
        // 2. NETTOYER UNIQUEMENT LE TRACÉ EXISTANT
        console.log('🧹 Rafraîchissement du tracé avant nouveau dessin...');
        this.refreshRouteOnly();

        // 3. CRÉER LES NOUVEAUX MARQUEURS
        console.log('📍 Création des nouveaux marqueurs...');

        const startIcon = L.divIcon({
            className: 'custom-marker route-marker-start',
            html: '<i class="fas fa-play" style="color: white; font-size: 12px;"></i>',
            iconSize: [30, 30],
            iconAnchor: [15, 15]
        });

        const endIcon = L.divIcon({
            className: 'custom-marker route-marker-end',
            html: '<i class="fas fa-flag-checkered" style="color: white; font-size: 12px;"></i>',
            iconSize: [30, 30],
            iconAnchor: [15, 15]
        });

        const startMarker = L.marker([fromLat, fromLng], {
            icon: startIcon,
            zIndexOffset: 1000
        }).addTo(map);

        const endMarker = L.marker([toLat, toLng], {
            icon: endIcon,
            zIndexOffset: 1000
        }).addTo(map);

        // Stocker les nouveaux marqueurs
        this.markers = [startMarker, endMarker];
        if (this.userLocationMarker) {
            this.markers.push(this.userLocationMarker);
        }

        // 4. CALCULER ET DESSINER LE NOUVEL ITINÉRAIRE
        console.log('🔄 Calcul itinéraire OSRM...');
        const routeUrl = `https://router.project-osrm.org/route/v1/driving/${fromLng},${fromLat};${toLng},${toLat}?overview=full&geometries=geojson`;

        const response = await fetch(routeUrl);
        const data = await response.json();

        if (!data.routes || data.routes.length === 0) {
            throw new Error('Aucun itinéraire routier trouvé entre ces villes.');
        }

        const route = data.routes[0];

        if (route.geometry && route.geometry.coordinates) {
            const routeCoordinates = route.geometry.coordinates.map(coord => [coord[1], coord[0]]);

            // 5. DESSINER LA NOUVELLE LIGNE
            this.routeLayer = L.polyline(routeCoordinates, {
                color: '#33A9DC',
                weight: 6,
                opacity: 0.9,
                lineJoin: 'round',
                lineCap: 'round'
            }).addTo(map);

            console.log('✅ Nouvelle ligne d\'itinéraire dessinée');

            // 6. ⭐⭐ CORRECTION : METTRE À JOUR LES POPUPS AVEC LES NOUVELLES VILLES ⭐⭐
            console.log('🔄 Mise à jour des popups avec nouvelles villes...');

            // Popup pour le DÉPART
            startMarker.bindPopup(`
                <div style="padding: 15px; min-width: 250px; text-align: center;">
                    <div style="font-size: 16px; font-weight: bold; color: #2c3e50; margin-bottom: 10px;">
                        🚗 Départ
                    </div>
                    <div style="margin-bottom: 8px;">
                        <strong>Ville:</strong> ${fromName}
                    </div>
                    <div style="margin-bottom: 8px;">
                        <strong>Distance:</strong> ${distance} km
                    </div>
                    <div style="margin-bottom: 8px;">
                        <strong>Durée:</strong> ${this.formatDuration(duration)}
                    </div>
                </div>
            `);

            // ⭐⭐ POPUP POUR L'ARRIVÉE - CORRIGÉ ⭐⭐
            endMarker.bindPopup(`
                <div style="padding: 15px; min-width: 250px; text-align: center;">
                    <div style="font-size: 16px; font-weight: bold; color: #2c3e50; margin-bottom: 10px;">
                        🏁 Arrivée
                    </div>
                    <div style="margin-bottom: 8px;">
                        <strong>Ville:</strong> ${toName}
                    </div>
                    <div style="margin-bottom: 8px;">
                        <strong>Coût:</strong> ${cost} MAD
                    </div>
                    <div style="margin-bottom: 8px;">
                        <strong>Distance:</strong> ${distance} km
                    </div>
                </div>
            `);

            // 7. ⭐⭐ AJOUTER UN POPUP SUR LA LIGNE D'ITINÉRAIRE ⭐⭐
            this.routeLayer.bindPopup(`
                <div style="padding: 15px; min-width: 280px; text-align: center;">
                    <div style="font-size: 18px; font-weight: bold; color: #2c3e50; margin-bottom: 15px;">
                        📍 Itinéraire
                    </div>
                    <div style="margin-bottom: 10px; font-size: 14px;">
                        <strong>De:</strong> ${fromName}
                    </div>
                    <div style="margin-bottom: 10px; font-size: 14px;">
                        <strong>À:</strong> ${toName}
                    </div>
                    <div style="margin-bottom: 8px;">
                        <strong>Distance:</strong> ${distance} km
                    </div>
                    <div style="margin-bottom: 8px;">
                        <strong>Durée:</strong> ${this.formatDuration(duration)}
                    </div>
                    <div style="margin-bottom: 8px;">
                        <strong>Coût estimé:</strong> ${cost} MAD
                    </div>
                </div>
            `);

            // 8. AJUSTER LA VUE POUR MONTRER LE NOUVEL ITINÉRAIRE
            const routeBounds = this.routeLayer.getBounds();
            if (routeBounds.isValid()) {
                console.log('🎯 Ajustement de la vue sur le nouvel itinéraire');
                map.fitBounds(routeBounds, {
                    padding: [50, 50],
                    maxZoom: 12,
                    animate: true,
                    duration: 1.5
                });
            }

            // 9. ⭐⭐ OUVRIRE LE POPUP DE L'ARRIVÉE POUR MONTRER LA NOUVELLE VILLE ⭐⭐
            setTimeout(() => {
                endMarker.openPopup();
                console.log('✅ Popup de l\'arrivée ouvert:', toName);
            }, 1000);

        } else {
            throw new Error('Géométrie d\'itinéraire non disponible');
        }

        console.log('🎉 NOUVEL ITINÉRAIRE AFFICHÉ AVEC SUCCÈS - VILLES MISES À JOUR');

    } catch (error) {
        console.error('❌ ERREUR CRITIQUE drawRouteOnMap:', error);

        // Méthode de secours - ligne directe
        console.log('🔄 Utilisation méthode de secours...');
        this.drawFallbackRoute(fromLat, fromLng, toLat, toLng);

        this.showMessage('Itinéraire affiché en ligne directe', 'info');
    }
}


/**
 * Méthode de secours - ligne directe
 */
drawFallbackRoute(fromLat, fromLng, toLat, toLng) {
    if (!map) return;

    try {
        const routeLine = L.polyline([
            [fromLat, fromLng],
            [toLat, toLng]
        ], {
            color: '#33A9DC',
            weight: 4,
            opacity: 0.7,
            dashArray: '10, 5'
        }).addTo(map);

        this.routeLayer = routeLine;

        const bounds = L.latLngBounds([
            [fromLat, fromLng],
            [toLat, toLng]
        ]);
        map.fitBounds(bounds, { padding: [20, 20] });

        console.log('🔄 Ligne directe dessinée (méthode de secours)');
    } catch (error) {
        console.error('❌ Erreur méthode de secours:', error);
    }
}


        /**
         * Réinitialise complètement la carte - NOUVELLE FONCTION
         */
        resetMap() {
            console.log('🔄 Réinitialisation complète de la carte');

            // Nettoyer toutes les couches
            this.refreshRouteOnly();
            this.clearManualMarkers();
            this.clearManualRoute();

            // Réinitialiser les variables
            this.markers = [];
            this.routeLayer = null;
            this.manualRouteLayer = null;

            // Recentrer la carte
            if (map && mapInitialized) {
                try {
                    map.setView(MAP_CONFIG.center, MAP_CONFIG.zoom);
                    map.invalidateSize(true);
                } catch (error) {
                    console.log('❌ Erreur recentrage carte:', error);
                }
            }
        }
async getRouteGeometry(fromLng, fromLat, toLng, toLat) {
    try {
        console.log('🔄 Récupération géométrie itinéraire:', { fromLng, fromLat, toLng, toLat });
        const url = `https://router.project-osrm.org/route/v1/driving/${fromLng},${fromLat};${toLng},${toLat}?overview=full&geometries=geojson`;

        const response = await fetch(url);
        if (!response.ok) {
            throw new Error(`Erreur HTTP: ${response.status}`);
        }

        const data = await response.json();
        console.log('📦 Données OSRM reçues:', data);

        if (data.routes && data.routes.length > 0 && data.routes[0].geometry) {
            const route = data.routes[0];
            const coordinates = route.geometry.coordinates.map(coord => [coord[1], coord[0]]);
            console.log('✅ Géométrie extraite:', coordinates.length, 'points');
            return coordinates;
        } else {
            console.warn('⚠️ Aucune géométrie trouvée dans la réponse OSRM');
            return null;
        }
    } catch (error) {
        console.error('❌ Erreur lors de la récupération de la géométrie:', error);
        return null;
    }
}
        drawFallbackRoute(fromLat, fromLng, toLat, toLng) {
            if (!map) return;

            try {
                const routeLine = L.polyline([[fromLat, fromLng], [toLat, toLng]], {
                    color: '#33A9DC',
                    weight: 4,
                    opacity: 0.7,
                    dashArray: '10, 5'
                }).addTo(map);

                this.routeLayer = routeLine;

                const bounds = L.latLngBounds([[fromLat, fromLng], [toLat, toLng]]);
                map.fitBounds(bounds, { padding: [20, 20] });
            } catch (error) {
                console.error('Erreur lors du dessin de l\'itinéraire de secours:', error);
            }
        }

        addRouteInfoToMap(fromName, toName, distance, duration, cost) {
            if (!map) return;

            const routeInfo = `
                <div style="padding: 10px; min-width: 200px;">
                    <h4 style="margin: 0 0 10px 0; color: #333;">Informations du Trajet</h4>
                    <div style="display: grid; gap: 5px; font-size: 12px;">
                        <div><strong>🚗 De:</strong> ${fromName}</div>
                        <div><strong>🏁 À:</strong> ${toName}</div>
                        <div><strong>📍 Distance:</strong> ${distance} km</div>
                        <div><strong>⏱️ Durée:</strong> ${this.formatDuration(duration)}</div>
                        <div><strong>💰 Coût estimé:</strong> ${cost} MAD</div>
                    </div>
                </div>
            `;

            if (this.routeLayer) {
                this.routeLayer.bindPopup(routeInfo);
            }
        }

        formatDuration(minutes) {
            if (!minutes) return '0 h';

            const hours = Math.floor(minutes / 60);
            const mins = minutes % 60;

            if (hours > 0) {
                return `${hours}h ${mins}min`;
            }
            return `${mins}min`;
        }

        updateRouteInfo(distance, duration, cost) {
            const distanceEl = document.getElementById('distance');
            const durationEl = document.getElementById('duration');
            const fuelCostEl = document.getElementById('fuelCost');
            const routeInfoEl = document.getElementById('routeInfo');
            const routeOptionsEl = document.getElementById('routeOptions');
            const modifyTargetEl = document.getElementById('modifyTarget');

            if (distanceEl) distanceEl.textContent = distance;
            if (durationEl) durationEl.textContent = this.formatDuration(duration);
            if (fuelCostEl) fuelCostEl.textContent = `${cost} MAD`;
            if (routeInfoEl) routeInfoEl.classList.remove('hidden');
            if (routeOptionsEl) routeOptionsEl.style.display = 'block';
            if (modifyTargetEl) modifyTargetEl.style.display = 'inline-block';
        }

        async geocode(query) {
            const cacheKey = `geocode_${query}`;

            // Vérifier le cache
            if (geocodingCache.has(cacheKey)) {
                return geocodingCache.get(cacheKey);
            }

            try {
                const response = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query + ', Morocco')}&limit=5&addressdetails=1`);
                const data = await response.json();
                const filteredData = data.filter(item =>
                    item.display_name.toLowerCase().includes('morocco') ||
                    item.display_name.toLowerCase().includes('maroc')
                );

                // Mettre en cache le résultat
                geocodingCache.set(cacheKey, filteredData);

                return filteredData;
            } catch (error) {
                return [];
            }
        }

        setupAutocomplete(inputId, suggestionsId) {
            const input = document.getElementById(inputId);
            const suggestionsDiv = document.getElementById(suggestionsId);

            if (!input || !suggestionsDiv) return;

            let timeoutId;

            const inputHandler = function() {
                clearTimeout(timeoutId);
                const query = this.value.trim();

                if (query.length < 2) {
                    suggestionsDiv.style.display = 'none';
                    return;
                }

                timeoutId = setTimeout(async () => {
                    try {
                        const response = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query + ', Morocco')}&limit=5&addressdetails=1`);
                        const data = await response.json();

                        if (data.length > 0) {
                            suggestionsDiv.innerHTML = data.map(result => {
                                const icon = this.getLocationIcon(result.type, result.class);
                                return `
                                    <div class="suggestion-item" data-lat="${result.lat}" data-lng="${result.lon}" data-name="${result.display_name}">
                                        <span>${icon}</span>
                                        <div>
                                            <strong>${result.display_name.split(',')[0]}</strong><br>
                                            <small>${result.display_name}</small>
                                        </div>
                                    </div>
                                `;
                            }).join('');
                            suggestionsDiv.style.display = 'block';
                        } else {
                            suggestionsDiv.style.display = 'none';
                        }
                    } catch (error) {
                        suggestionsDiv.style.display = 'none';
                    }
                }, 300);
            };

            // Remove existing listener if any
            if (eventListeners.has(inputId + '_input')) {
                input.removeEventListener('input', eventListeners.get(inputId + '_input').handler);
            }

            input.addEventListener('input', inputHandler);
            eventListeners.set(inputId + '_input', { element: input, handler: inputHandler });

            const clickHandler = (e) => {
                const item = e.target.closest('.suggestion-item');
                if (item) {
                    const text = item.dataset.name;
                    input.value = text;
                    input.dataset.lat = item.dataset.lat;
                    input.dataset.lng = item.dataset.lng;
                    suggestionsDiv.style.display = 'none';
                }
            };

            // Remove existing listener if any
            if (eventListeners.has(suggestionsId + '_click')) {
                suggestionsDiv.removeEventListener('click', eventListeners.get(suggestionsId + '_click').handler);
            }

            suggestionsDiv.addEventListener('click', clickHandler);
            eventListeners.set(suggestionsId + '_click', { element: suggestionsDiv, handler: clickHandler });

            const documentClickHandler = (e) => {
                if (!suggestionsDiv.contains(e.target) && e.target !== input) {
                    suggestionsDiv.style.display = 'none';
                }
            };

            // Remove existing listener if any
            if (eventListeners.has('document_click_' + inputId)) {
                document.removeEventListener('click', eventListeners.get('document_click_' + inputId).handler);
            }

            document.addEventListener('click', documentClickHandler);
            eventListeners.set('document_click_' + inputId, { element: document, handler: documentClickHandler });
        }

        getLocationIcon(type, classType) {
            const icons = {
                'city': '🏙️',
                'town': '🏘️',
                'village': '🏡',
                'hamlet': '🏠',
                'suburb': '🏘️',
                'quarter': '🏘️',
                'neighbourhood': '🏘️',
                'isolated_dwelling': '🏠',
                'farm': '🚜',
                'allotments': '🌱',
                'island': '🏝️'
            };

            return icons[type] || icons[classType] || '📍';
        }

        setupFormSwitcher() {
            const formTabs = document.querySelectorAll('.form-tab');

            formTabs.forEach(tab => {
                // Remove existing listener
                const existingListener = tab.getAttribute('data-listener-attached');
                if (!existingListener) {
                    tab.addEventListener('click', () => {
                        const formType = tab.dataset.form;

                        formTabs.forEach(t => t.classList.remove('active'));
                        tab.classList.add('active');

                        if (formType === 'trip') {
                            this.showTripForm();
                        } else {
                            this.showDayRateForm();
                        }

                        setTimeout(() => {
                            if (map && mapInitialized) {
                                map.invalidateSize(true);
                            }
                        }, 300);
                    });
                    tab.setAttribute('data-listener-attached', 'true');
                }
            });
        }

        showTripForm() {
            const tripForm = document.getElementById('tripForm');
            const dayRateForm = document.getElementById('dayRateForm');

            if (tripForm) {
                tripForm.classList.remove('hidden');
                tripForm.classList.add('active');
            }
            if (dayRateForm) {
                dayRateForm.classList.remove('active');
                dayRateForm.classList.add('hidden');
            }
            this.currentForm = 'trip';
        }

        showDayRateForm() {
            const tripForm = document.getElementById('tripForm');
            const dayRateForm = document.getElementById('dayRateForm');

            if (dayRateForm) {
                dayRateForm.classList.remove('hidden');
                dayRateForm.classList.add('active');
            }
            if (tripForm) {
                tripForm.classList.remove('active');
                tripForm.classList.add('hidden');
            }
            this.currentForm = 'day-rate';

            // Only initialize if we're not editing
            if (!this.editingTripId) {
                this.initDayRateForm();
            }
        }

        initDayRateForm() {
            const dayRateStartDate = document.getElementById('dayRateStartDate');

            if (dayRateStartDate) {
                const today = new Date();
                const todayFormatted = today.toISOString().slice(0, 16);
                dayRateStartDate.min = todayFormatted;
                dayRateStartDate.value = todayFormatted;
            }

            const citiesContainer = document.getElementById('citiesContainer');
            if (citiesContainer && citiesContainer.children.length === 0) {
                this.addCityToDayRate();
            }

            this.updateDayRateSummary();
        }

        addCityToDayRate() {
            const citiesContainer = document.getElementById('citiesContainer');
            if (!citiesContainer) return;

            const cityCount = citiesContainer.children.length;
            const cityItem = document.createElement('div');
            cityItem.className = 'city-item';
            cityItem.innerHTML = `
                <div class="city-header">
                    <span class="city-name">Étape ${cityCount + 1}</span>
                    <button type="button" class="remove-city">
                        <i class="fas fa-times"></i> Supprimer
                    </button>
                </div>
                <div class="city-details">
                    <div class="form-group" style="position: relative;">
                        <label><i class="fas fa-map-marker-alt"></i> Ville Marocaine</label>
                        <input type="text"
                            class="input-field city-name-input"
                            placeholder="Chercher une ville marocaine...">
                        <small class="city-help-text">
                            Commencez à taper pour voir les villes disponibles
                        </small>
                    </div>
                </div>
            `;

            citiesContainer.appendChild(cityItem);

            const removeBtn = cityItem.querySelector('.remove-city');
            const nameInput = cityItem.querySelector('.city-name-input');

            // Remove existing listeners
            removeBtn.onclick = null;
            nameInput.onchange = null;

            removeBtn.addEventListener('click', () => {
                cityItem.remove();
                this.updateDayRateSummary();
            });

            nameInput.addEventListener('change', () => this.updateDayRateSummary());

            this.setupCityAutocomplete(nameInput);
            this.updateDayRateSummary();
        }

        setupCityAutocomplete(input) {
            if (!input) return;

            let timeoutId;

            const inputHandler = function() {
                clearTimeout(timeoutId);
                const query = this.value.trim();

                const existingSuggestions = this.parentNode.querySelector('.suggestions');
                if (existingSuggestions) {
                    existingSuggestions.remove();
                }

                if (query.length < 1) {
                    return;
                }

                timeoutId = setTimeout(async () => {
                    try {
                        const response = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query + ', Morocco')}&limit=8&addressdetails=1`);
                        const data = await response.json();

                        if (data.length > 0) {
                            const suggestionsDiv = document.createElement('div');
                            suggestionsDiv.className = 'suggestions';
                            suggestionsDiv.style.position = 'absolute';
                            suggestionsDiv.style.zIndex = '1000';
                            suggestionsDiv.style.background = 'rgba(255, 255, 255, 0.95)';
                            suggestionsDiv.style.backdropFilter = 'blur(20px)';
                            suggestionsDiv.style.border = '1px solid rgba(255, 255, 255, 0.3)';
                            suggestionsDiv.style.borderRadius = '15px';
                            suggestionsDiv.style.maxHeight = '300px';
                            suggestionsDiv.style.overflowY = 'auto';
                            suggestionsDiv.style.width = '100%';
                            suggestionsDiv.style.marginTop = '5px';
                            suggestionsDiv.style.boxShadow = '0 20px 60px rgba(0, 0, 0, 0.15)';

                            suggestionsDiv.innerHTML = data.map(result => {
                                const icon = window.routePlanner.getLocationIcon(result.type, result.class);
                                return `
                                    <div class="suggestion-item"
                                        data-lat="${result.lat}"
                                        data-lng="${result.lon}"
                                        data-name="${result.display_name}"
                                        style="padding: 15px 20px; cursor: pointer; border-bottom: 1px solid rgba(0,0,0,0.1); display: flex; align-items: center; gap: 12px; transition: all 0.2s ease;">
                                        <span style="font-size: 1.2em;">${icon}</span>
                                        <div>
                                            <strong>${result.display_name.split(',')[0]}</strong><br>
                                            <small style="color: #666;">${result.display_name}</small>
                                        </div>
                                    </div>
                                `;
                            }).join('');

                            this.parentNode.appendChild(suggestionsDiv);

                            const clickHandler = (e) => {
                                const item = e.target.closest('.suggestion-item');
                                if (item) {
                                    const text = item.dataset.name;
                                    input.value = text;
                                    input.dataset.lat = item.dataset.lat;
                                    input.dataset.lng = item.dataset.lng;
                                    suggestionsDiv.remove();
                                    window.routePlanner.updateDayRateSummary();
                                }
                            };

                            suggestionsDiv.addEventListener('click', clickHandler);

                            const outsideClickHandler = function outsideClick(e) {
                                if (!suggestionsDiv.contains(e.target) && e.target !== input) {
                                    suggestionsDiv.remove();
                                    document.removeEventListener('click', outsideClickHandler);
                                }
                            };

                            document.addEventListener('click', outsideClickHandler);
                        }
                    } catch (error) {
                        console.error('Error fetching cities:', error);
                    }
                }, 200);
            };

            // Remove existing listener
            input.oninput = null;
            input.addEventListener('input', inputHandler);
        }

        async updateDayRateSummary() {
            const citiesContainer = document.getElementById('citiesContainer');
            const summaryCities = document.getElementById('summaryCities');
            const summaryDays = document.getElementById('summaryDays');
            const dayRateDays = document.getElementById('dayRateDays');
            const dayRatePassengerSelect = document.getElementById('dayRatePassengerCount');

            if (!citiesContainer || !summaryCities || !dayRatePassengerSelect) return;

            const passengerCount = parseInt(dayRatePassengerSelect.value) || 3;
            const totalDays = parseInt(dayRateDays.value) || 1;

            try {
                const response = await fetch(`/api/day-rate-cost?passengers=${passengerCount}&days=${totalDays}`);

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();

                let totalCost;
                let dailyRate;

                if (data.success && data.cost !== undefined) {
                    totalCost = data.cost;
                    dailyRate = data.cost_per_day || (data.cost / totalDays);
                } else {
                    // Fallback calculation using only day rate passenger options
                    const baseRates = {
                        3: 300, 6: 450, 8: 550, 17: 800
                    };
                    dailyRate = baseRates[passengerCount] || 700;
                    totalCost = dailyRate * totalDays;
                }

                const cityInputs = citiesContainer.querySelectorAll('.city-name-input');
                const validCities = Array.from(cityInputs).filter(input => input.value.trim() !== '').length;

                if (summaryCities) summaryCities.textContent = validCities;
                if (summaryDays) summaryDays.textContent = totalDays;

                // Update the summary display
                const dayRateSummary = document.getElementById('dayRateSummary');
                if (dayRateSummary) {
                    dayRateSummary.innerHTML = `
                        <div class="summary-item">
                            <span>Nombre de Villes:</span>
                            <span id="summaryCities">${validCities}</span>
                        </div>
                        <div class="summary-item">
                            <span>Jours Totaux:</span>
                            <span id="summaryDays">${totalDays}</span>
                        </div>

                    `;
                }

            } catch (error) {
                console.error('Error updating day rate summary:', error);
                // Fallback calculation using only day rate passenger options
                const passengerCount = parseInt(dayRatePassengerSelect.value) || 3;
                const totalDays = parseInt(dayRateDays.value) || 1;
                const baseRates = {
                    3: 300, 6: 450, 8: 550, 17: 800
                };
                const dailyRate = baseRates[passengerCount] || 700;
                const totalCost = dailyRate * totalDays;

                const cityInputs = citiesContainer.querySelectorAll('.city-name-input');
                const validCities = Array.from(cityInputs).filter(input => input.value.trim() !== '').length;

                if (summaryCities) summaryCities.textContent = validCities;
                if (summaryDays) summaryDays.textContent = totalDays;

                // Update the summary display
                const dayRateSummary = document.getElementById('dayRateSummary');
                if (dayRateSummary) {
                    dayRateSummary.innerHTML = `
                        <div class="summary-item">
                            <span>Nombre de Villes:</span>
                            <span id="summaryCities">${validCities}</span>
                        </div>
                        <div class="summary-item">
                            <span>Jours Totaux:</span>
                            <span id="summaryDays">${totalDays}</span>
                        </div>
                        <div class="summary-item">
                            <span>Tarif Journalier:</span>
                            <span>${dailyRate} MAD</span>
                        </div>
                        <div class="summary-item summary-total">
                            <span>Coût Total:</span>
                            <span>${totalCost} MAD</span>
                        </div>
                    `;
                }
            }
        }

        async calculateCostByPassengers(distance, passengers) {
            try {
                const response = await fetch(`/api/calculate-cost?distance=${distance}&passengers=${passengers}`);

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();

                if (data.success && data.cost !== undefined) {
                    return data.cost;
                } else {
                    // Fallback calculation
                    const costPerKm = 3.0;
                    return Math.max(Math.round(distance * costPerKm), 50);
                }
            } catch (error) {
                console.error('Error calculating cost:', error);
                // Fallback calculation
                const costPerKm = 3.0;
                return Math.max(Math.round(distance * costPerKm), 50);
            }
        }

        confirmDayRateBooking() {
            const startDate = document.getElementById('dayRateStartDate');
            const days = document.getElementById('dayRateDays');
            const citiesContainer = document.getElementById('citiesContainer');
            const dayRatePassengerSelect = document.getElementById('dayRatePassengerCount');

            if (!startDate || !days || !citiesContainer || !dayRatePassengerSelect) return;

            if (!startDate.value) {
                this.showMessage('Veuillez sélectionner une date de début.', 'error');
                return;
            }

            const cities = [];
            const cityItems = citiesContainer.getElementsByClassName('city-item');

            for (let item of cityItems) {
                const nameInput = item.querySelector('.city-name-input');

                if (nameInput && nameInput.value.trim()) {
                    cities.push({
                        name: nameInput.value.trim(),
                        lat: nameInput.dataset.lat || null,
                        lng: nameInput.dataset.lng || null
                    });
                }
            }

            if (cities.length === 0) {
                this.showMessage('Veuillez saisir au moins une ville.', 'error');
                return;
            }

            const passengerCount = parseInt(dayRatePassengerSelect.value) || 3;
            const totalDays = parseInt(days.value);

            // Calculate cost based on day rate passenger options only
            const baseRates = {
                3: 300, 6: 450, 8: 550, 17: 800
            };
            const dailyRate = baseRates[passengerCount] || 700;
            const totalCost = dailyRate * totalDays;

            const vehicleType = this.getVehicleTypeByPassengers(passengerCount);
            const vehicleLabel = this.getVehicleLabel(vehicleType);

            tripCounter++;
            const trip = {
                id: tripCounter,
                ref: `DAY-${String(tripCounter).padStart(3, '0')}`,
                from: 'Location par Journée',
                to: cities.map(city => city.name).join(' → '),
                dateDebut: startDate.value,
                dateFin: this.calculateEndDate(startDate.value, parseInt(days.value)),
                vehicleType: vehicleType,
                vehicleLabel: vehicleLabel,
                distance: 0,
                duration: 0,
                cost: totalCost,
                status: 'pending',
                type: 'day_rate',
                passengerCount: passengerCount,
                cities: cities,
                days: parseInt(days.value),
                dailyRate: dailyRate
            };

            tripsList.push(trip);

            this.updateTripsTable();
            this.updateRecap();

            this.showMessage(`Location par journée confirmée! ${days.value} jour(s) - ${totalCost} MAD`, 'success');

            const tableContainer = document.getElementById('tripsTableContainer');
            const recapContainer = document.getElementById('tripRecap');
            if (tableContainer) tableContainer.style.display = 'block';
            if (recapContainer) recapContainer.style.display = 'block';

            this.resetDayRateForm();

            const tripTab = document.querySelector('.form-tab[data-form="trip"]');
            if (tripTab) {
                tripTab.click();
            }
        }

        calculateEndDate(startDate, days) {
            const endDate = new Date(startDate);
            endDate.setDate(endDate.getDate() + days - 1);
            return endDate.toISOString().slice(0, 16);
        }

        resetDayRateForm() {
            const citiesContainer = document.getElementById('citiesContainer');
            const startDate = document.getElementById('dayRateStartDate');
            const days = document.getElementById('dayRateDays');

            if (citiesContainer) citiesContainer.innerHTML = '';
            if (startDate) {
                const today = new Date();
                const todayFormatted = today.toISOString().slice(0, 16);
                startDate.value = todayFormatted;
            }
            if (days) days.value = '1';

            this.addCityToDayRate();
            this.updateDayRateSummary();
        }
updateTripsTable() {
    const tableBody = document.getElementById('tripsTableBody');
    if (!tableBody) return;

    tableBody.innerHTML = tripsList.map(trip => `
        <tr>
            <td>${trip.ref}</td>
            <td>${trip.from} → ${trip.to}</td>
            <td>${trip.dateDebut} au ${trip.dateFin}</td>
            <td>${trip.vehicleLabel}</td>
            <td>${trip.distance} km</td>
            <td>${this.formatDuration(trip.duration)}</td>
            <td><span class="status-badge status-${trip.status}">${this.getStatusLabel(trip.status)}</span></td>
            <td>
                <div class="action-buttons">
                    <!-- NOUVELLE ICÔNE "VOIR SUR LA CARTE" -->
                    <button class="action-btn btn-view" onclick="window.routePlanner.viewTripOnMap(${trip.id})"
                            title="Voir cet itinéraire sur la carte">
                        <i class="fas fa-map-marked-alt"></i>
                    </button>

                    <button class="action-btn btn-edit" onclick="window.routePlanner.editTrip(${trip.id})"
                            title="Modifier ce trajet">
                        <i class="fas fa-edit"></i>
                    </button>

                    <button class="action-btn btn-delete" onclick="window.routePlanner.deleteTripFromList(${trip.id})"
                            title="Supprimer ce trajet">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </td>
        </tr>
    `).join('');
}

/**
 * Affiche un trajet spécifique sur la carte - VERSION AMÉLIORÉE
 */
viewTripOnMap(tripId) {
    const trip = tripsList.find(t => t.id === tripId);
    if (!trip) {
        this.showMessage('❌ Trajet non trouvé', 'error');
        return;
    }

    console.log('🗺️ Affichage du trajet sur la carte:', trip.ref);

    // S'assurer que la carte est prête
    if (!map || !mapInitialized) {
        console.log('🔄 Initialisation de la carte...');
        this.initializeMapWithoutLocation();

        // Attendre que la carte soit prête
        setTimeout(() => this.viewTripOnMap(tripId), 1000);
        return;
    }

    try {
        // Nettoyer complètement la carte
        this.refreshRouteOnly();

        // Attendre que le nettoyage soit effectif
        setTimeout(() => {
            // Afficher le trajet sur la carte
            if (trip.coordinates && trip.coordinates.from && trip.coordinates.to) {
                this.drawRouteOnMap(
                    trip.coordinates.from.lat,
                    trip.coordinates.from.lng,
                    trip.coordinates.to.lat,
                    trip.coordinates.to.lng,
                    trip.from,
                    trip.to,
                    trip.distance,
                    trip.duration,
                    trip.cost
                );

                this.showMessage(`📍 Affichage du trajet ${trip.ref} sur la carte`, 'success');
            } else {
                this.showMessage('❌ Données de coordonnées manquantes pour ce trajet', 'error');
            }
        }, 500);

    } catch (error) {
        console.error('❌ Erreur lors de l\'affichage du trajet:', error);
        this.showMessage('Erreur lors de l\'affichage du trajet sur la carte', 'error');
    }
}

        getStatusLabel(status) {
            const statusLabels = {
                'pending': "En Attente",
                'approved': "Approuvé",
                'rejected': "Rejeté",
                'paid': "Payé"
            };
            return statusLabels[status] || status;
        }

updateRecap() {
    if (tripsList.length === 0) {
        const recapEl = document.getElementById('tripRecap');
        if (recapEl) recapEl.style.display = 'none';
        return;
    }

    const totalDistance = tripsList.reduce((sum, trip) => sum + parseFloat(trip.distance || 0), 0);
    const totalDuration = tripsList.reduce((sum, trip) => sum + parseInt(trip.duration || 0), 0);
    const totalCost = tripsList.reduce((sum, trip) => sum + parseInt(trip.cost || 0), 0);

    const allDates = new Set();
    tripsList.forEach(trip => {
        const start = new Date(trip.dateDebut);
        const end = new Date(trip.dateFin);
        for (let date = new Date(start); date <= end; date.setDate(date.getDate() + 1)) {
            allDates.add(date.toISOString().split('T')[0]);
        }
    });
    const tripDays = allDates.size;

    const tripCountEl = document.getElementById('tripCount');
    const totalDistanceEl = document.getElementById('totalDistance');
    const totalDurationEl = document.getElementById('totalDuration');
    const totalCostEl = document.getElementById('totalCost');
    const tripDaysEl = document.getElementById('tripDays');

    if (tripCountEl) tripCountEl.textContent = `${tripsList.length} trajet${tripsList.length > 1 ? 's' : ''}`;
    if (totalDistanceEl) totalDistanceEl.textContent = totalDistance.toFixed(1);
    if (totalDurationEl) totalDurationEl.textContent = this.formatDuration(totalDuration);
    if (totalCostEl) totalCostEl.textContent = `${totalCost} MAD`;
    if (tripDaysEl) tripDaysEl.textContent = tripDays;

    // Ajouter un bouton "Voir tous sur la carte" si non présent
    this.addViewAllButton();
}

/**
 * Ajoute un bouton "Voir tous sur la carte" dans le récapitulatif
 */
addViewAllButton() {
    const recapContainer = document.getElementById('tripRecap');
    if (!recapContainer) return;

    // Vérifier si le bouton existe déjà
    let viewAllBtn = document.getElementById('viewAllTripsBtn');

    if (!viewAllBtn) {
        viewAllBtn = document.createElement('button');
        viewAllBtn.id = 'viewAllTripsBtn';
        viewAllBtn.className = 'btn btn-primary';
        viewAllBtn.innerHTML = '<i class="fas fa-map-marked-alt"></i> Voir tous sur la carte';
        viewAllBtn.onclick = () => this.viewAllTripsOnMap();

        // Ajouter le bouton au récapitulatif
        recapContainer.appendChild(viewAllBtn);
    }
}

/**
 * Affiche tous les trajets sur la carte
 */
viewAllTripsOnMap() {
    if (tripsList.length === 0) {
        this.showMessage('Aucun trajet à afficher', 'info');
        return;
    }

    console.log('🗺️ Affichage de tous les trajets sur la carte');

    // S'assurer que la carte est prête
    if (!map || !mapInitialized) {
        this.initializeMapWithoutLocation();
        setTimeout(() => this.viewAllTripsOnMap(), 1000);
        return;
    }

    try {
        // Nettoyer la carte
        this.refreshRouteOnly();

        // Afficher chaque trajet
        tripsList.forEach((trip, index) => {
            setTimeout(() => {
                if (trip.coordinates && trip.coordinates.from && trip.coordinates.to) {
                    this.drawRouteOnMap(
                        trip.coordinates.from.lat,
                        trip.coordinates.from.lng,
                        trip.coordinates.to.lat,
                        trip.coordinates.to.lng,
                        trip.from,
                        trip.to,
                        trip.distance,
                        trip.duration,
                        trip.cost
                    );
                }
            }, index * 300); // Délai entre chaque affichage
        });

        this.showMessage(`📍 ${tripsList.length} trajet(s) affiché(s) sur la carte`, 'success');

    } catch (error) {
        console.error('❌ Erreur affichage tous trajets:', error);
        this.showMessage('Erreur lors de l\'affichage des trajets', 'error');
    }
}

        sendMessage(tripId) {
            const trip = tripsList.find(t => t.id === tripId);
            if (trip) {
                alert(`Messagerie pour le trajet ${trip.ref}: ${trip.from} → ${trip.to}\n\nContactez votre administrateur pour plus de détails.`);
            }
        }

        payTrip(tripId) {
            const trip = tripsList.find(t => t.id === tripId);
            if (trip) {
                alert(`Paiement pour le trajet ${trip.ref}\nMontant: ${trip.cost} MAD\n\nRedirection vers le système de paiement...`);
                trip.status = 'paid';
                this.updateTripsTable();
            }
        }

        /**
         * Affiche le formulaire de modification d'un trajet - CORRIGÉ
         */
editTrip(id) {
    const trip = tripsList.find(t => t.id === id);
    if (!trip) return;

    this.editingTripId = id;

    console.log('✏️ Début de l\'édition du trajet:', trip.ref);

    // Charger le formulaire IMMÉDIATEMENT
    if (trip.type === 'day_rate') {
        this.showDayRateForm();
        this.loadDayRateForm(trip);
    } else {
        this.showTripForm();
        this.loadTripForm(trip);
    }

    // Afficher le trajet sur la carte APRÈS avoir chargé le formulaire
    setTimeout(() => {
        this.viewTripOnMap(id);
        console.log('✅ Trajet affiché sur la carte pour édition');
    }, 500);
}

        ensureMapReady() {
    return new Promise((resolve, reject) => {
        if (map && mapInitialized) {
            resolve();
            return;
        }

        console.log('🔄 Préparation de la carte pour édition...');
        this.initializeMapWithoutLocation();

        let attempts = 0;
        const maxAttempts = 10;

        const checkReady = setInterval(() => {
            attempts++;

            if (map && mapInitialized) {
                clearInterval(checkReady);

                // Forcer un redimensionnement final
                setTimeout(() => {
                    if (map) {
                        map.invalidateSize(true);
                    }
                    resolve();
                }, 200);

            } else if (attempts >= maxAttempts) {
                clearInterval(checkReady);
                reject(new Error('La carte n\'a pas pu être initialisée'));
            }
        }, 500);
    });
}
        switchToDayRateTab() {
            const dayRateTab = document.querySelector('.form-tab[data-form="day-rate"]');
            if (dayRateTab) {
                dayRateTab.click();
            }
        }

        switchToTripTab() {
            const tripTab = document.querySelector('.form-tab[data-form="trip"]');
            if (tripTab) {
                tripTab.click();
            }
        }


        loadTripForm(trip) {
            const fromInput = document.getElementById('from');
            const toInput = document.getElementById('to');
            const dateDebutInput = document.getElementById('dateDebut');
            const dateFinInput = document.getElementById('dateFin');
            const vehicleTypeInput = document.getElementById('vehicleType');
            const passengerSelect = document.getElementById('passengerCount');
            const calculateBtn = document.getElementById('calculateRoute');

            if (fromInput) fromInput.value = trip.from;
            if (toInput) toInput.value = trip.to;
            if (dateDebutInput) dateDebutInput.value = trip.dateDebut;
            if (dateFinInput) dateFinInput.value = trip.dateFin;
            if (vehicleTypeInput) vehicleTypeInput.value = trip.vehicleType;
            if (passengerSelect) passengerSelect.value = trip.passengerCount;

            if (trip.coordinates) {
                if (fromInput) {
                    fromInput.dataset.lat = trip.coordinates.from.lat;
                    fromInput.dataset.lng = trip.coordinates.from.lng;
                }
                if (toInput) {
                    toInput.dataset.lat = trip.coordinates.to.lat;
                    toInput.dataset.lng = trip.coordinates.to.lng;
                }
            }

            // Changer le texte du bouton en "Modifier"
            if (calculateBtn) {
                calculateBtn.innerHTML = '<i class="fas fa-edit"></i> MODIFIER';
                // Remove existing listener and add new one
                calculateBtn.onclick = null;
                calculateBtn.addEventListener('click', () => this.updateTrip());
            }

            // Ajouter un bouton Annuler
            this.addCancelButton();
        }

        loadDayRateForm(trip) {
            const startDate = document.getElementById('dayRateStartDate');
            const days = document.getElementById('dayRateDays');
            const passengerSelect = document.getElementById('dayRatePassengerCount');
            const confirmDayRate = document.getElementById('confirmDayRate');

            if (startDate) startDate.value = trip.dateDebut;
            if (days) days.value = trip.days;
            if (passengerSelect) passengerSelect.value = trip.passengerCount;

            // Remplir les villes
            this.loadDayRateCities(trip.cities);

            // Changer le texte du bouton en "Modifier"
            if (confirmDayRate) {
                confirmDayRate.innerHTML = '<i class="fas fa-edit"></i> MODIFIER';
                // Remove existing listener and add new one
                confirmDayRate.onclick = null;
                confirmDayRate.addEventListener('click', () => this.updateDayRateTrip());
            }

            // Ajouter un bouton Annuler
            this.addCancelButton();
        }

        loadDayRateCities(cities) {
            const citiesContainer = document.getElementById('citiesContainer');
            if (!citiesContainer) return;

            citiesContainer.innerHTML = '';

            cities.forEach((city, index) => {
                this.addCityToDayRate();
                const cityItems = citiesContainer.getElementsByClassName('city-item');
                const lastCityItem = cityItems[cityItems.length - 1];
                const nameInput = lastCityItem.querySelector('.city-name-input');

                if (nameInput) {
                    nameInput.value = city.name;
                    nameInput.dataset.lat = city.lat;
                    nameInput.dataset.lng = city.lng;
                }
            });
        }

        /**
         * Ajoute le bouton Annuler pendant l'édition - CORRIGÉ
         */
        addCancelButton() {
            this.removeCancelButton();

            const cancelBtn = document.createElement('button');
            cancelBtn.id = 'cancelEditBtn';
            cancelBtn.className = 'btn btn-warning';
            cancelBtn.innerHTML = '<i class="fas fa-times"></i> Annuler';
            cancelBtn.onclick = () => this.cancelEdit();

            // Ajouter à côté du bouton principal
            const calculateBtn = document.getElementById('calculateRoute');
            const confirmDayRate = document.getElementById('confirmDayRate');

            if (calculateBtn && calculateBtn.parentNode) {
                calculateBtn.parentNode.appendChild(cancelBtn);
            } else if (confirmDayRate && confirmDayRate.parentNode) {
                confirmDayRate.parentNode.appendChild(cancelBtn);
            }
        }

        /**
         * Supprime le bouton Annuler - CORRIGÉ
         */
        removeCancelButton() {
            const cancelBtn = document.getElementById('cancelEditBtn');
            if (cancelBtn) {
                cancelBtn.remove();
            }
        }

        /**
         * Réinitialise l'édition - CORRIGÉ
         */
        /**
         * Réinitialise l'édition - CORRIGÉ
         */
        cancelEdit(options = {}) {
            const { keepMap = false } = options;

            this.editingTripId = null;

            // Réinitialiser les boutons
            const calculateBtn = document.getElementById('calculateRoute');
            const confirmDayRate = document.getElementById('confirmDayRate');

            if (calculateBtn) {
                calculateBtn.innerHTML = '<i class="fas fa-plus"></i> AJOUTER';
                calculateBtn.onclick = () => this.addTrip();
            }

            if (confirmDayRate) {
                confirmDayRate.innerHTML = '<i class="fas fa-check"></i> CONFIRMER LA LOCATION';
                confirmDayRate.onclick = () => this.confirmDayRateBooking();
            }

            // Réinitialiser les formulaires
            this.resetForms();
            this.removeCancelButton();

            // Revenir au formulaire principal
            this.showTripForm();

            // Réinitialiser complètement la carte uniquement si demandé
            if (!keepMap) {
                this.resetMap();
                console.log('❌ Mode édition annulé - carte réinitialisée');
            } else {
                console.log('✅ Mode édition terminé - carte conservée');
            }
        }

        /**
         * Réinitialise complètement les formulaires - CORRIGÉ
         */
        resetForms() {
            // Formulaire trajet régulier
            const fromInput = document.getElementById('from');
            const toInput = document.getElementById('to');
            const dateDebutInput = document.getElementById('dateDebut');
            const dateFinInput = document.getElementById('dateFin');
            const vehicleTypeInput = document.getElementById('vehicleType');
            const passengerSelect = document.getElementById('passengerCount');

            if (fromInput) {
                fromInput.value = '';
                delete fromInput.dataset.lat;
                delete fromInput.dataset.lng;
            }
            if (toInput) {
                toInput.value = '';
                delete toInput.dataset.lat;
                delete toInput.dataset.lng;
            }
            if (dateDebutInput) dateDebutInput.value = '';
            if (dateFinInput) dateFinInput.value = '';
            if (vehicleTypeInput) vehicleTypeInput.value = '';
            if (passengerSelect && passengerOptions.length > 0) {
                passengerSelect.value = passengerOptions[0];
            }

            // Formulaire day rate
            this.resetDayRateForm();
        }
/**
 * Met à jour un trajet existant - VERSION RENFORCÉE
 */
async updateTrip() {
    if (!this.editingTripId) return;

    const index = tripsList.findIndex(t => t.id === this.editingTripId);
    if (index === -1) return;

    const trip = tripsList[index];

    // Récupérer les valeurs du formulaire
    const fromInput = document.getElementById('from');
    const toInput = document.getElementById('to');
    const dateDebut = document.getElementById('dateDebut');
    const dateFin = document.getElementById('dateFin');
    const vehicleType = document.getElementById('vehicleType');
    const passengerSelect = document.getElementById('passengerCount');
    const loading = document.getElementById('loading');
    const btn = document.getElementById('calculateRoute');

    // Validation
    if (!fromInput || !toInput || !fromInput.value.trim() || !toInput.value.trim()) {
        this.showMessage('Points de départ et arrivée requis', 'error');
        return;
    }

    if (loading) loading.classList.add('show');
    if (btn) {
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Modification...';
    }

    try {
        console.log('🔄 Début de la modification du trajet:', trip.ref);

        let fromLat, fromLng, toLat, toLng;
        let newFromName = fromInput.value.trim();
        let newToName = toInput.value.trim();

        // GÉOCODER LES NOUVELLES ADRESSES
        if (fromInput.dataset.lat && fromInput.dataset.lng) {
            fromLat = parseFloat(fromInput.dataset.lat);
            fromLng = parseFloat(fromInput.dataset.lng);
        } else {
            const fromResults = await this.geocode(newFromName);
            if (fromResults.length === 0) throw new Error('Point de départ introuvable');
            fromLat = parseFloat(fromResults[0].lat);
            fromLng = parseFloat(fromResults[0].lon);
        }

        if (toInput.dataset.lat && toInput.dataset.lng) {
            toLat = parseFloat(toInput.dataset.lat);
            toLng = parseFloat(toInput.dataset.lng);
        } else {
            const toResults = await this.geocode(newToName);
            if (toResults.length === 0) throw new Error('Destination introuvable');
            toLat = parseFloat(toResults[0].lat);
            toLng = parseFloat(toResults[0].lon);
        }

        const passengerCount = parseInt(passengerSelect.value);

        // ⭐⭐ RAFRAÎCHIR UNIQUEMENT LE TRACÉ EXISTANT ⭐⭐
        console.log('🧹 Rafraîchissement du tracé avant modification...');
        this.refreshRouteOnly();

        // ⭐⭐ CALCULER LE NOUVEL ITINÉRAIRE ⭐⭐
        const url = `https://router.project-osrm.org/route/v1/driving/${fromLng},${fromLat};${toLng},${toLat}?overview=full&geometries=geojson`;

        const response = await fetch(url);
        const data = await response.json();

        if (!data.routes || data.routes.length === 0) {
            throw new Error('Aucun itinéraire trouvé entre ces villes.');
        }

        const route = data.routes[0];
        const distance = (route.distance / 1000).toFixed(1);
        const duration = Math.round(route.duration / 60);
        const cost = await this.calculateCostByPassengers(distance, passengerCount);

        console.log('🔄 Ancien trajet:', `${trip.from} → ${trip.to}`);
        console.log('🔄 Nouveau trajet:', `${newFromName} → ${newToName}`);

        // ⭐⭐ DESSINER LE NOUVEL ITINÉRAIRE SUR LA CARTE ⭐⭐
        await this.drawRouteOnMap(fromLat, fromLng, toLat, toLng, newFromName, newToName, distance, duration, cost);

        // ⭐⭐ METTRE À JOUR COMPLÈTEMENT LE TRAJET ⭐⭐
        const oldFrom = trip.from;
        const oldTo = trip.to;

        trip.from = newFromName;
        trip.to = newToName;
        trip.dateDebut = dateDebut.value;
        trip.dateFin = dateFin.value;
        trip.vehicleType = vehicleType.value;
        trip.vehicleLabel = this.getVehicleLabel(vehicleType.value);
        trip.distance = distance;
        trip.duration = duration;
        trip.cost = cost;
        trip.passengerCount = passengerCount;
        trip.coordinates = {
            from: { lat: fromLat, lng: fromLng },
            to: { lat: toLat, lng: toLng }
        };

        // METTRE À JOUR L'INTERFACE
        this.updateTripsTable();
        this.updateRecap();

        this.showMessage(`✅ Trajet modifié! ${oldFrom} → ${oldTo} → ${newFromName} → ${newToName}`, 'success');

        // LAISSER VOIR LE RÉSULTAT
        setTimeout(() => {
            this.cancelEdit({ keepMap: true });
        }, 3000);

    } catch (err) {
        console.error('❌ Erreur lors de la modification:', err);
        this.showMessage('❌ ' + err.message, 'error');
        this.cancelEdit();
    } finally {
        if (loading) loading.classList.remove('show');
        if (btn) {
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-edit"></i> MODIFIER';
        }
    }
}

        /**
         * Met à jour un trajet de type day rate - CORRIGÉ
         */
        async updateDayRateTrip() {
            if (!this.editingTripId) return;

            const tripIndex = tripsList.findIndex(t => t.id === this.editingTripId);
            if (tripIndex === -1) return;

            const trip = tripsList[tripIndex];
            if (!trip || trip.type !== 'day_rate') return;

            const startDate = document.getElementById('dayRateStartDate');
            const days = document.getElementById('dayRateDays');
            const passengerSelect = document.getElementById('dayRatePassengerCount');
            const citiesContainer = document.getElementById('citiesContainer');

            if (!startDate || !days || !passengerSelect || !citiesContainer) {
                this.showMessage('Éléments du formulaire manquants', 'error');
                return;
            }

            // Récupérer les villes
            const cities = [];
            const cityItems = citiesContainer.getElementsByClassName('city-item');
            for (let item of cityItems) {
                const nameInput = item.querySelector('.city-name-input');
                if (nameInput && nameInput.value.trim()) {
                    cities.push({
                        name: nameInput.value.trim(),
                        lat: nameInput.dataset.lat || null,
                        lng: nameInput.dataset.lng || null
                    });
                }
            }

            if (cities.length === 0) {
                this.showMessage('Veuillez saisir au moins une ville.', 'error');
                return;
            }

            // Mettre à jour le trajet
            trip.dateDebut = startDate.value;
            trip.dateFin = this.calculateEndDate(startDate.value, parseInt(days.value));
            trip.passengerCount = parseInt(passengerSelect.value);
            trip.cities = cities;
            trip.days = parseInt(days.value);
            trip.to = cities.map(city => city.name).join(' → ');

            // Recalculer le coût
            const baseRates = {
                3: 300, 6: 450, 8: 550, 17: 800
            };
            trip.dailyRate = baseRates[trip.passengerCount] || 700;
            trip.cost = trip.dailyRate * trip.days;

            // Mettre à jour l'interface
            this.updateTripsTable();
            this.updateRecap();
            this.cancelEdit();

            this.showMessage('✅ Location par journée modifiée avec succès!', 'success');
        }

        deleteTripFromList(tripId, updateUI = true) {
            if (confirm('Êtes-vous sûr de vouloir supprimer ce trajet?')) {
                tripsList = tripsList.filter(t => t.id !== tripId);
                if (updateUI) {
                    this.updateTripsTable();
                    this.updateRecap();

                    if (tripsList.length === 0) {
                        const tableContainer = document.getElementById('tripsTableContainer');
                        const recapContainer = document.getElementById('tripRecap');
                        if (tableContainer) tableContainer.style.display = 'none';
                        if (recapContainer) recapContainer.style.display = 'none';
                    }
                }
            }
        }

        async saveAllTripsWithOptions(createNewPlanning, planningId, planningName = '') {
            if (tripsList.length === 0) {
                this.showMessage('Aucun trajet à sauvegarder.', 'error');
                return;
            }

            const btn = document.getElementById('saveAllTrips');
            if (!btn) return;

            // Prevent multiple submissions
            if (btn.disabled) {
                return;
            }

            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sauvegarde en cours...';

            try {
                const tokenMeta = document.querySelector('meta[name="csrf-token"]');
                if (!tokenMeta) {
                    throw new Error('CSRF token not found');
                }
                const token = tokenMeta.getAttribute('content');

                const tripsData = tripsList.map(trip => {
                    const tripData = {
                        start_location: trip.from || 'Non spécifié',
                        end_location: trip.to || 'Non spécifié',
                        date_debut: trip.dateDebut ? trip.dateDebut.split('T')[0] : new Date().toISOString().split('T')[0],
                        date_fin: trip.dateFin ? trip.dateFin.split('T')[0] : new Date().toISOString().split('T')[0],
                        vehicle_type: trip.vehicleType || 'car',
                        passengers: parseInt(trip.passengerCount) || 1,
                        cost: parseInt(trip.cost) || 0,
                        status: 'pending',
                        trip_type: trip.type === 'day_rate' ? 1 : 0
                    };

                    if (trip.type === 'regular' || trip.type === 'manual') {
                        tripData.distance = parseFloat(trip.distance) || 0;
                        tripData.duration = parseInt(trip.duration) || 0;
                    } else {
                        tripData.distance = 0;
                        tripData.duration = 0;
                        if (trip.cities && trip.cities.length > 0) {
                            tripData.villes = JSON.stringify(trip.cities.map(city => city.name));
                        } else {
                            tripData.villes = JSON.stringify([trip.from, trip.to]);
                        }
                    }

                    return tripData;
                });

                const requestData = {
                    trips: tripsData,
                    create_new_planning: createNewPlanning,
                    _token: token
                };

                if (createNewPlanning && planningName) {
                    requestData.planning_name = planningName;
                }

                if (!createNewPlanning && planningId) {
                    requestData.planning_id = planningId;
                }

                const response = await fetch('/trips/batch-save', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify(requestData)
                });

                const result = await response.json();

                if (!response.ok) {
                    if (result.errors) {
                        const errorMessages = Object.values(result.errors).flat().join(', ');
                        throw new Error(`Erreurs de validation: ${errorMessages}`);
                    }
                    throw new Error(result.message || `Erreur HTTP: ${response.status}`);
                }

                if (result.success) {
                    let message = '';
                    if (createNewPlanning) {
                        message = `${tripsData.length} trajet(s) sauvegardé(s) dans le planning "${planningName}"!`;
                    } else {
                        message = `${tripsData.length} trajet(s) ajouté(s) au planning existant!`;
                    }

                    this.showMessage(message, 'success');

                    // Clear the trips list and reset the interface
                    tripsList = [];
                    this.updateTripsTable();
                    this.updateRecap();

                    const tableContainer = document.getElementById('tripsTableContainer');
                    const recapContainer = document.getElementById('tripRecap');
                    if (tableContainer) tableContainer.style.display = 'none';
                    if (recapContainer) recapContainer.style.display = 'none';

                } else {
                    throw new Error(result.message || 'Erreur lors de la sauvegarde');
                }

            } catch (error) {
                this.showMessage('Erreur lors de la sauvegarde: ' + error.message, 'error');
            } finally {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-save"></i> Sauvegarder';
            }
        }

        saveAllTrips() {
            if (tripsList.length === 0) {
                this.showMessage('Aucun trajet à sauvegarder.', 'error');
                return;
            }

            if (!saveTripModal) {
                saveTripModal = new SaveTripModal();
            }
            saveTripModal.show();
        }

        initTripSystem() {
            const today = new Date();
            const todayFormatted = today.toISOString().slice(0, 16);
            const dateDebutInput = document.getElementById('dateDebut');
            const dateFinInput = document.getElementById('dateFin');

            if (dateDebutInput) {
                dateDebutInput.min = todayFormatted;
                dateDebutInput.value = todayFormatted;
            }
            if (dateFinInput) {
                dateFinInput.min = todayFormatted;
                dateFinInput.value = todayFormatted;
            }

            if (dateDebutInput && dateFinInput) {
                const changeHandler = function() {
                    dateFinInput.min = this.value;
                };

                // Remove existing listener if any
                if (eventListeners.has('dateDebutChange')) {
                    dateDebutInput.removeEventListener('change', eventListeners.get('dateDebutChange').handler);
                }

                dateDebutInput.addEventListener('change', changeHandler);
                eventListeners.set('dateDebutChange', { element: dateDebutInput, handler: changeHandler });
            }
        }
    }

    // Initialisation principale - CORRIGÉE
    document.addEventListener('DOMContentLoaded', function() {
        console.log('🚀 DOM chargé, initialisation du planificateur...');

        observeMapVisibility();
        setupMapResizeHandler();
        setupTabChangeListener();

        // Initialisations de secours
        const backupInits = [2000, 5000, 10000];
        backupInits.forEach((delay, index) => {
            setTimeout(() => {
                if (!mapInitialized) {
                    if (checkMapVisibility()) {
                        console.log('🔄 Initialisation de secours de la carte');
                        forceMapInit();
                    }
                }
            }, delay);
        });

        window.routePlanner = new MoroccoRoutePlanner();

        document.addEventListener('geolocationSuccess', function(e) {
            if (!mapInitialized) {
                setTimeout(forceMapInit, 800);
            }
        });

        document.addEventListener('mapInitialized', function(e) {
            console.log('✅ Carte initialisée avec succès');
            if (window.routePlanner) {
                window.routePlanner.setupMapClickHandler();
            }
        });

        saveTripModal = new SaveTripModal();
    });

    window.addEventListener('beforeunload', function() {
        if (map) {
            try {
                map.remove();
            } catch (e) {
                console.log('Erreur lors de la suppression de la carte:', e);
            }
            map = null;
        }
    });

    window.forceMapInit = forceMapInit;
    window.checkMapVisibility = checkMapVisibility;
    window.getMapState = () => ({
        mapInitialized,
        mapInitializationAttempted,
        map: map ? 'exists' : 'null'
    });
</script>
</body>
</html>
