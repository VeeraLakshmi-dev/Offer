<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Deal Cards</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800,900" rel="stylesheet" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: radial-gradient(ellipse at top, #e66465 0%, #9198e5 100%);
            background-attachment: fixed;
            min-height: 100vh;
            padding: 0;
            position: relative;
            overflow-x: hidden;
        }

        /* Geometric background shapes */
        .bg-shapes {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 0;
        }

        .shape {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.05);
            animation: float-shapes 20s linear infinite;
        }

        .shape:nth-child(1) {
            width: 300px;
            height: 300px;
            top: 20%;
            left: -150px;
            animation-delay: 0s;
        }

        .shape:nth-child(2) {
            width: 200px;
            height: 200px;
            top: 60%;
            right: -100px;
            animation-delay: -5s;
        }

        .shape:nth-child(3) {
            width: 150px;
            height: 150px;
            top: 40%;
            left: 80%;
            animation-delay: -10s;
        }

        @keyframes float-shapes {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            33% { transform: translateY(-30px) rotate(120deg); }
            66% { transform: translateY(15px) rotate(240deg); }
        }

        /* Modern Navbar */
        .navbar {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            padding: 20px 0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 2rem;
            font-weight: 900;
            color: white;
            text-decoration: none;
            position: relative;
        }

        .logo::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, #ff6b6b, #4ecdc4, #45b7d1, #96ceb4);
            border-radius: 2px;
        }

        .nav-menu {
            display: flex;
            gap: 30px;
        }

        .nav-item {
            color: white;
            text-decoration: none;
            font-weight: 600;
            padding: 10px 20px;
            border-radius: 25px;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.1);
        }

        .nav-item:hover,
        .nav-item.active {
            background: white;
            color: #333;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        /* Main Container */
        .container {
            max-width: 1300px;
            margin: 0 auto;
            padding: 60px 20px;
            position: relative;
            z-index: 1;
        }

        .hero-section {
            text-align: center;
            margin-bottom: 80px;
        }

        .hero-title {
            font-size: 4rem;
            font-weight: 900;
            color: white;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            animation: bounceInDown 1s ease-out;
        }

        .hero-subtitle {
            font-size: 1.3rem;
            color: rgba(255, 255, 255, 0.9);
            font-weight: 400;
            animation: fadeInUp 1s ease-out 0.3s both;
        }

        @keyframes bounceInDown {
            0% {
                opacity: 0;
                transform: translate3d(0, -100px, 0);
            }
            60% {
                opacity: 1;
                transform: translate3d(0, 25px, 0);
            }
            75% {
                transform: translate3d(0, -10px, 0);
            }
            90% {
                transform: translate3d(0, 5px, 0);
            }
            100% {
                transform: none;
            }
        }

        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translate3d(0, 40px, 0);
            }
            100% {
                opacity: 1;
                transform: none;
            }
        }

        /* Cards Grid */
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(380px, 1fr));
            gap: 30px;
            perspective: 1000px;
        }

        /* Card Styles */
        .card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            position: relative;
            cursor: pointer;
            transform-style: preserve-3d;
            animation: cardFadeIn 0.8s ease-out both;
        }

        @keyframes cardFadeIn {
            0% {
                opacity: 0;
                transform: rotateY(-15deg) translateY(50px);
            }
            100% {
                opacity: 1;
                transform: rotateY(0) translateY(0);
            }
        }

        .card:nth-child(1) { animation-delay: 0.1s; }
        .card:nth-child(2) { animation-delay: 0.2s; }
        .card:nth-child(3) { animation-delay: 0.3s; }
        .card:nth-child(4) { animation-delay: 0.4s; }
        .card:nth-child(5) { animation-delay: 0.5s; }
        .card:nth-child(6) { animation-delay: 0.6s; }

        .card:hover {
            transform: translateY(-10px) rotateX(5deg);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
        }

        /* Card Header with gradient */
        .card-header {
            height: 80px;
            position: relative;
            overflow: hidden;
        }

        .card:nth-child(odd) .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .card:nth-child(even) .card-header {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }

        .card:nth-child(3n) .card-header {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }

        .card-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            animation: rotate 20s linear infinite;
        }

        @keyframes rotate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Badge */
        .card-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: rgba(255, 255, 255, 0.9);
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            color: #333;
            animation: wiggle 2s ease-in-out infinite;
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        @keyframes wiggle {
            0%, 50%, 100% { transform: rotate(0deg); }
            25% { transform: rotate(-5deg); }
            75% { transform: rotate(5deg); }
        }

        /* Card Content - IMPROVED */
        .card-content {
            padding: 35px 30px 10px 20px;
            min-height: 180px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .card-title {
            font-size: 1.75rem;
            font-weight: 800;
            color: #1a1a1a;
            margin-bottom: 18px;
            line-height: 1.3;
            letter-spacing: -0.025em;
            background: linear-gradient(135deg, #1a1a1a 0%, #333 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            min-height: 2.3em;
            display: flex;
            align-items: flex-start;
        }

        .card-description {
            font-size: 1.05rem;
            color: #555;
            line-height: 1.7;
            margin-bottom: 25px;
            font-weight: 400;
            text-align: left;
            min-height: 3.4em;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            opacity: 0.9;
        }

        /* Stats Row */
        .card-stats {
            display: flex;
            justify-content: space-between;
            margin-bottom: 25px;
            padding: 18px;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 12px;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .stat-item {
            text-align: center;
            flex: 1;
        }

        .stat-number {
            font-size: 1.4rem;
            font-weight: 800;
            color: #333;
            display: block;
            margin-bottom: 2px;
        }

        .stat-label {
            font-size: 0.85rem;
            color: #666;
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        /* Price Section */
        .price-container {
            background: linear-gradient(135deg, #667eea, #764ba2);
            margin: 0 -30px 30px -30px;
            padding: 28px 30px;
            text-align: center;
            position: relative;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2);
        }

        .price-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(255, 255, 255, 0.1), transparent);
            pointer-events: none;
        }

        .price-amount {
            font-size: 2.8rem;
            font-weight: 900;
            color: white;
            margin-bottom: 8px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
            letter-spacing: -0.025em;
        }

        .price-label {
            font-size: 1rem;
            color: rgba(255, 255, 255, 0.9);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Action Button */
        .action-btn {
            width: 100%;
            padding: 18px 24px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .action-btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: all 0.3s ease;
        }

        .action-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }

        .action-btn:hover::before {
            width: 300px;
            height: 300px;
        }

        .action-btn:active {
            transform: translateY(-1px);
        }

        /* Floating Elements */
        .floating-icon {
            position: absolute;
            font-size: 1.5rem;
            opacity: 0.7;
            animation: float 6s ease-in-out infinite;
        }

        .floating-icon:nth-child(1) {
            top: 20px;
            left: 20px;
            animation-delay: 0s;
        }

        .floating-icon:nth-child(2) {
            top: 50px;
            right: 40px;
            animation-delay: -2s;
        }

        .floating-icon:nth-child(3) {
            bottom: 30px;
            left: 30px;
            animation-delay: -4s;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-20px);
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .nav-container {
                padding: 0 15px;
            }

            .logo {
                font-size: 1.5rem;
            }

            .nav-menu {
                gap: 15px;
            }

            .hero-title {
                font-size: 2.5rem;
            }

            .hero-subtitle {
                font-size: 1.1rem;
            }

            .cards-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .card-content {
                padding: 25px 20px;
                min-height: 160px;
            }

            .card-title {
                font-size: 1.5rem;
                margin-bottom: 15px;
            }

            .card-description {
                font-size: 1rem;
                margin-bottom: 20px;
            }

            .price-container {
                margin: 0 -20px 25px -20px;
                padding: 25px 20px;
            }

            .price-amount {
                font-size: 2.2rem;
            }

            .card-stats {
                flex-direction: column;
                gap: 15px;
                padding: 15px;
            }

            .action-btn {
                padding: 16px 20px;
                font-size: 1rem;
            }
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 4px;
        }

        /* Loading spinner for buttons */
        .loading {
            display: inline-block;
            width: 16px;
            height: 16px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
            margin-right: 8px;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Modal Styles */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.7);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 2000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            backdrop-filter: blur(5px);
        }

        .modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .modal-container {
            background: white;
            border-radius: 20px;
            width: 90%;
            max-width: 500px;
            padding: 0;
            overflow: hidden;
            transform: translateY(50px);
            transition: all 0.3s ease;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
        }

        .modal-overlay.active .modal-container {
            transform: translateY(0);
        }

        .modal-header {
            height: 120px;
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, #667eea, #764ba2);
        }

        .modal-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            animation: rotate 20s linear infinite;
        }

        .modal-title {
            position: absolute;
            bottom: 20px;
            left: 30px;
            color: white;
            font-size: 1.8rem;
            font-weight: 800;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
            z-index: 1;
        }

        .modal-close {
            position: absolute;
            top: 20px;
            right: 20px;
            background: rgba(255, 255, 255, 0.9);
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            z-index: 1;
            transition: all 0.3s ease;
        }

        .modal-close:hover {
            transform: rotate(90deg);
            background: white;
        }

        .modal-content {
            padding: 30px;
        }

        .modal-description {
            color: #555;
            margin-bottom: 25px;
            line-height: 1.6;
        }

        .modal-price {
            text-align: center;
            margin-bottom: 30px;
        }

        .modal-price-amount {
            font-size: 2.5rem;
            font-weight: 900;
            color: #333;
            margin-bottom: 5px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .modal-price-label {
            font-size: 1rem;
            color: #666;
            font-weight: 600;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }

        .form-input {
            width: 100%;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-input:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.2);
            outline: none;
        }

        .modal-actions {
            display: flex;
            gap: 15px;
        }

        .modal-btn {
            flex: 1;
            padding: 15px;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
        }

        .modal-btn-primary {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
        }

        .modal-btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }

        .modal-btn-secondary {
            background: #f8f9fa;
            color: #333;
            border: 1px solid #ddd;
        }

        .modal-btn-secondary:hover {
            background: #e9ecef;
        }

        /* Success state */
        .modal-success {
            text-align: center;
            padding: 30px;
            display: none;
        }

        .modal-success-icon {
            font-size: 4rem;
            color: #4CAF50;
            margin-bottom: 20px;
            animation: bounceIn 0.6s ease-out;
        }

        .modal-success-title {
            font-size: 1.8rem;
            font-weight: 800;
            margin-bottom: 15px;
            color: #333;
        }

        .modal-success-message {
            color: #555;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        @keyframes bounceIn {
            0% {
                opacity: 0;
                transform: scale(0.3);
            }
            50% {
                opacity: 1;
                transform: scale(1.05);
            }
            70% {
                transform: scale(0.9);
            }
            100% {
                transform: scale(1);
            }
        }
    </style>
</head>
<body>
    <div class="bg-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>

    <nav class="navbar">
        <div class="nav-container">
            <a href="#" class="logo"></a>
            <div class="nav-menu">
                <a href="#" class="nav-item" id="home-nav">Home</a>
                <a href="#" class="nav-item active" id="deals-nav">Offers</a>
                <a href="{{url('specialOffers')}}" class="nav-item">Special Offers</a>
                <a href="#" class="nav-item">About</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="hero-section">
            <h1 class="hero-title">🚀 Amazing Offers</h1>
        </div>

        <div class="cards-grid" id="cards-grid">
            @foreach ($campaigns as $campaign)
            <div class="card">
                <div class="card-header">
                    <div class="card-badge">⭐ {{ $campaign['badge'] ?? 'New' }}</div>
                </div>
                <div class="card-content">
                    <h3 class="card-title">{{ $campaign['title'] }}</h3>
                    <p class="card-description">
                        {{ strip_tags(html_entity_decode($campaign['description'])) }}
                    </p>
                </div>

                <div class="price-container">
                    <div class="price-amount">₹{{ number_format($campaign['payout']) }}</div>
                    <div class="price-label">{{ $campaign['price_label'] ?? 'Earn Upto' }}</div>
                </div>

                <div style="padding: 0 30px 30px;">
                      <button class="action-btn"
                        data-id="{{ $campaign['id'] }}"
                        data-title="{{ $campaign['title'] }}"
                        data-description="{{ $campaign['description'] }}"
                        data-payout="{{ $campaign['payout'] }}"
                        data-tracking="{{ $campaign['tracking_link'] }}"
                        onclick="showOfferModal(this)">
                        <span class="loading" style="display: none;"></span>
                        <span>Get Offer</span>
                        <span class="icon">👉</span>
                    </button>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Modal Structure -->
    <div class="modal-overlay" id="offerModal">
        <div class="modal-container">
            <div class="modal-header">
                <h3 class="modal-title" id="modalOfferTitle"></h3>
                <div class="modal-close" onclick="closeModal()">
                    &times;
                </div>
            </div>

            <div class="modal-content" id="modalForm">
                <p class="modal-description" id="modalOfferDescription"></p>

                <div class="modal-price">
                    <div class="modal-price-amount" id="modalOfferPrice"></div>
                    <div class="modal-price-label">Earn Upto</div>
                </div>

                <div class="form-group">
                    <label for="upiId" class="form-label">Enter Your UPI ID</label>
                    <input type="text" id="upiId" class="form-input" placeholder="yourname@upi" required>
                </div>

                <div class="modal-actions">
                    <button class="modal-btn modal-btn-secondary" onclick="closeModal()">Cancel</button>
                    <button class="modal-btn modal-btn-primary" onclick="completeOffer()">Complete Offer</button>
                </div>
            </div>

            <div class="modal-success" id="modalSuccess">
                <div class="modal-success-icon">✓</div>
                <h3 class="modal-success-title">Offer Submitted!</h3>
                <p class="modal-success-message">Thank you for participating.</p>
                <button class="modal-btn modal-btn-primary" onclick="redirectToOffer()">Continue to Offer</button>
            </div>
        </div>
    </div>
    <script>
        // Modal functionality
        let currentCampaignId = null;
        let currentTrackingLink = null;
        let submitBtn = null;

        function showOfferModal(button) {
            const campaignId = button.dataset.id;
            const title = button.dataset.title;
            const payout = button.dataset.payout;
            const trackingLink = button.dataset.tracking;

            // Decode HTML entities back to real HTML
            let description = button.dataset.description;
            const txt = document.createElement("textarea");
            txt.innerHTML = description;
            description = txt.value;

            currentCampaignId = campaignId;
            currentTrackingLink = trackingLink;

            document.getElementById('modalOfferTitle').textContent = title;

            document.getElementById('modalOfferDescription').innerHTML = description;

            document.getElementById('modalOfferPrice').textContent =
                '₹' + parseInt(payout).toLocaleString('en-IN');

            document.getElementById('modalForm').style.display = 'block';
            document.getElementById('modalSuccess').style.display = 'none';
            document.getElementById('upiId').value = '';

            document.getElementById('offerModal').classList.add('active');
        }

        function closeModal() {
            resetSubmitButton();
            document.getElementById('offerModal').classList.remove('active');
        }
        function resetSubmitButton() {
            if (submitBtn) {
                submitBtn.innerHTML = 'Complete Offer';
                submitBtn.disabled = false;
            }
        }
        function completeOffer() {
            const upiId = document.getElementById('upiId').value.trim();

            if (!upiId) {
                alert('Please enter your UPI ID');
                return;
            }

            // Validate UPI ID format (simple validation)
            if (!upiId.includes('@')) {
                alert('Please enter a valid UPI ID (e.g., yourname@upi)');
                return;
            }

           submitBtn = document.querySelector('#modalForm .modal-btn-primary');
            const originalBtnText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<span class="loading"></span> Processing...';
            submitBtn.disabled = true;

            // Get CSRF token - fallback if meta tag doesn't exist
            let csrfToken = '';
            const csrfMeta = document.querySelector('meta[name="csrf-token"]');
            if (csrfMeta) {
                csrfToken = csrfMeta.content;
            }

            // Make the API call to save the offer click
            fetch('/offer-clicks', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    campaign_id: currentCampaignId,
                    upi_id: upiId,
                    tracking_link: currentTrackingLink
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
           .then(data => {
                if (data.success) {
                    // Show success message
                    document.getElementById('modalForm').style.display = 'none';
                    document.getElementById('modalSuccess').style.display = 'block';

                    // Update redirect button with backend generated URL
                    const redirectBtn = document.querySelector('#modalSuccess .modal-btn-primary');
                    redirectBtn.onclick = function() {
                        if (data.redirect_url) {
                            window.open(data.redirect_url, '_blank');
                        }
                        closeModal();
                    };
                } else {
                    alert('Error: ' + (data.message || 'Something went wrong'));
                    submitBtn.innerHTML = originalBtnText;
                    submitBtn.disabled = false;
                    resetSubmitButton();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
                submitBtn.innerHTML = originalBtnText;
                submitBtn.disabled = false;
                resetSubmitButton();
            });
        }
        function redirectToOffer() {
            if (currentTrackingLink && currentTrackingLink !== '#') {
                window.open(currentTrackingLink, '_blank');
            }
            closeModal();
        }
        // Close modal when clicking outside
        document.getElementById('offerModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        // Navigation functionality
        const homeNav = document.getElementById('home-nav');
        const dealsNav = document.getElementById('deals-nav');
        const cardsGrid = document.getElementById('cards-grid');

        function switchTab(activeTab, inactiveTab) {
            activeTab.classList.add('active');
            inactiveTab.classList.remove('active');

            // Add smooth transition effect
            cardsGrid.style.transform = 'scale(0.95)';
            cardsGrid.style.opacity = '0.7';

            setTimeout(() => {
                cardsGrid.style.transform = 'scale(1)';
                cardsGrid.style.opacity = '1';
            }, 200);
        }

        homeNav.addEventListener('click', (e) => {
            e.preventDefault();
            switchTab(homeNav, dealsNav);
        });

        dealsNav.addEventListener('click', (e) => {
            e.preventDefault();
            switchTab(dealsNav, homeNav);
        });

        // Add parallax effect on scroll
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const shapes = document.querySelectorAll('.shape');

            shapes.forEach((shape, index) => {
                const speed = 0.5 + (index * 0.2);
                shape.style.transform = `translateY(${scrolled * speed}px)`;
            });
        });

        // Intersection Observer for card animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -100px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0) rotateY(0)';
                }
            });
        }, observerOptions);

        // Observe all cards
        document.querySelectorAll('.card').forEach(card => {
            observer.observe(card);
        });

        // Add click effect to cards
        document.querySelectorAll('.card').forEach(card => {
            card.addEventListener('click', function(e) {
                // Don't trigger if clicking the button
                if (e.target.classList.contains('action-btn')) return;

                this.style.transform = 'translateY(-10px) rotateX(5deg) scale(1.02)';

                setTimeout(() => {
                    this.style.transform = 'translateY(-10px) rotateX(5deg)';
                }, 150);
            });
        });

        // Add random floating animations to cards
        function addRandomFloat() {
            const cards = document.querySelectorAll('.card');
            cards.forEach((card, index) => {
                setTimeout(() => {
                    card.style.animation += `, float 8s ease-in-out infinite`;
                    card.style.animationDelay = `${index * 0.5}s, ${Math.random() * 2}s`;
                }, index * 200);
            });
        }

        // Initialize floating animations after page load
        window.addEventListener('load', () => {
            setTimeout(addRandomFloat, 1000);
        });
    </script>
</body>
</html>
