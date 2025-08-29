<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <title>Deal Cards</title>

  <!-- Tailwind CDN (with line-clamp + forms plugins for your markup) -->
  <script src="https://cdn.tailwindcss.com?plugins=forms,line-clamp"></script>

  <style>
    /* Smooth reveal on scroll */
    .reveal { opacity: 0; transform: translateY(14px) scale(.98); transition: opacity .45s ease, transform .45s ease; }
    .reveal.show { opacity: 1; transform: translateY(0) scale(1); }

    /* Gentle floating effect */
    @keyframes floaty {
      0%   { transform: translateY(0); }
      50%  { transform: translateY(-8px); }
      100% { transform: translateY(0); }
    }
    .float-card { animation: floaty 7s ease-in-out infinite; }

    /* Modal fade */
    #offerModal { transition: opacity .3s ease; }
  </style>
</head>
<body class="bg-gradient-to-b from-pink-400 to-blue-400 min-h-screen font-sans relative overflow-x-hidden">

  <!-- Navbar -->
  <nav class="sticky top-0 z-50 bg-white/10 backdrop-blur-lg border-b border-white/20 py-4">
    <div class="max-w-7xl mx-auto flex justify-between items-center px-6">
      <a href="#" class="text-white text-2xl font-bold">DealCards</a>
      <div class="flex gap-4">
        <a href="#" id="home-nav" class="text-white px-4 py-2 rounded-full hover:bg-white hover:text-gray-800 transition">Home</a>
        <a href="{{ url('/')}}" id="deals-nav" class="text-white px-4 py-2 rounded-full bg-white/20 hover:bg-white hover:text-gray-800 transition">Offers</a>
        <a href="{{ url('specialOffers') }}" class="text-white px-4 py-2 rounded-full hover:bg-white hover:text-gray-800 transition">Special Offers</a>
        <a href="#" class="text-white px-4 py-2 rounded-full hover:bg-white hover:text-gray-800 transition">About</a>
      </div>
    </div>
  </nav>

  <!-- Hero -->
  <div class="text-center my-16">
    <h1 class="text-white text-5xl md:text-6xl font-extrabold mb-4">🚀 Amazing Offers</h1>
    <p class="text-white/90 text-lg md:text-xl">Check out the latest deals and earn rewards!</p>
  </div>

  <!-- Cards Grid -->
  <div id="cards-grid" class="max-w-7xl mx-auto px-6 grid md:grid-cols-2 lg:grid-cols-3 gap-8">
    @foreach ($campaigns as $campaign)
      <div class="card float-card reveal bg-white rounded-2xl shadow-lg overflow-hidden
            transition-transform duration-300 hover:-translate-y-1 hover:shadow-2xl flex flex-col">
        <!-- Header -->
        <div class="relative h-20 bg-gradient-to-r from-purple-500 to-indigo-600">
            <div class="absolute top-3 right-3 bg-white/90 px-3 py-1 rounded-full text-sm font-bold text-gray-800 animate-hatFloat">
            ⭐ {{ $campaign['badge'] ?? 'New' }}
            </div>
        </div>

        <!-- Body (flex-grow so it pushes button down) -->
        <div class="p-6 flex-1 flex flex-col">
            <h3 class="text-gray-900 text-xl font-extrabold mb-2">{{ $campaign['title'] }}</h3>

            @if(!empty(strip_tags(html_entity_decode($campaign['description']))))
            <p class="text-gray-600 mb-4 line-clamp-2">
                {{ strip_tags(html_entity_decode($campaign['description'])) }}
            </p>
            @else
            <p class="text-gray-400 italic mb-4">No description available.</p>
            @endif
        </div>

        <!-- Price -->
        <div class="bg-gradient-to-r from-purple-500 to-indigo-600 text-center p-4 text-white font-bold text-2xl">
            ₹{{ number_format($campaign['payout']) }}
            <div class="text-sm font-medium">Earn Upto</div>
        </div>

        <!-- Fixed Bottom Button -->
        <div class="p-6 mt-auto">
            <button
            class="w-full py-3 rounded-xl bg-gradient-to-r from-purple-500 to-indigo-600 text-white
                    font-semibold hover:scale-105 transition"
            data-id="{{ $campaign['id'] }}"
            data-title="{{ $campaign['title'] }}"
            data-description="{{ $campaign['description'] }}"
            data-payout="{{ $campaign['payout'] }}"
            data-tracking="{{ $campaign['tracking_link'] }}"
            onclick="showOfferModal(this)">
            Get Offer 👉
            </button>
        </div>
        </div>
    @endforeach
  </div>

  <!-- Modal -->
  <div id="offerModal"
       class="fixed inset-0 hidden opacity-0 flex items-center justify-center z-50 bg-black/70 backdrop-blur-sm">
    <div id="offerModalPanel"
         class="bg-white rounded-2xl w-11/12 max-w-md overflow-hidden shadow-2xl transform transition-all duration-300 scale-95 opacity-0">
      <div class="relative h-28 bg-gradient-to-r from-purple-500 to-indigo-600">
        <h3 id="modalOfferTitle" class="absolute bottom-4 left-6 text-white text-xl font-bold"></h3>
        <button class="absolute top-4 right-4 text-white text-2xl font-bold" onclick="closeModal()">&times;</button>
      </div>

      <div id="modalForm" class="p-6">
        <p id="modalOfferDescription" class="text-gray-600 mb-4"></p>

        <div class="text-center mb-6">
          <div id="modalOfferPrice" class="text-2xl font-bold text-gray-900"></div>
          <div class="text-sm font-medium text-gray-500">Earn Upto</div>
        </div>

        <div class="mb-4">
          <label for="upiId" class="block text-gray-700 font-semibold mb-2">Enter Your UPI ID</label>
          <input type="text" id="upiId" class="w-full border border-gray-300 rounded-lg px-4 py-3" placeholder="yourname@upi">
        </div>

        <div class="flex gap-4">
          <button class="flex-1 py-3 rounded-lg bg-gray-200 text-gray-800 font-semibold" onclick="closeModal()">Cancel</button>
          <button id="submitOfferBtn" class="flex-1 py-3 rounded-lg bg-gradient-to-r from-purple-500 to-indigo-600 text-white font-semibold" onclick="completeOffer(this)">Complete Offer</button>
        </div>
      </div>

      <div id="modalSuccess" class="p-6 text-center hidden">
        <div class="text-4xl text-green-500 mb-4">✓</div>
        <h3 class="text-xl font-bold mb-2">Offer Submitted!</h3>
        <p class="text-gray-600 mb-4">Thank you for participating.</p>
        <button id="continueBtn" class="py-3 px-6 rounded-lg bg-gradient-to-r from-purple-500 to-indigo-600 text-white font-semibold" onclick="redirectToOffer()">Continue to Offer</button>
      </div>
    </div>
  </div>

  <script>
    // ---------- State ----------
    let currentCampaignId = null;
    let currentTrackingLink = null;

    // ---------- Modal helpers ----------
    function decodeHtml(html) {
      const txt = document.createElement("textarea");
      txt.innerHTML = html;
      return txt.value;
    }

    function showOfferModal(button) {
      const campaignId   = button.dataset.id;
      const title        = button.dataset.title;
      const payout       = button.dataset.payout;
      const trackingLink = button.dataset.tracking;
      let description    = decodeHtml(button.dataset.description);

      currentCampaignId   = campaignId;
      currentTrackingLink = trackingLink;

      document.getElementById('modalOfferTitle').textContent = title;
      document.getElementById('modalOfferDescription').innerHTML = description;
      document.getElementById('modalOfferPrice').textContent = '₹' + parseInt(payout).toLocaleString('en-IN');
      document.getElementById('upiId').value = '';

      // reset views
      document.getElementById('modalForm').classList.remove('hidden');
      document.getElementById('modalSuccess').classList.add('hidden');

      // animate open
      const overlay = document.getElementById('offerModal');
      const panel   = document.getElementById('offerModalPanel');
      overlay.classList.remove('hidden');

      // Next frame -> fade in
      requestAnimationFrame(() => {
        overlay.classList.remove('opacity-0');
        panel.classList.remove('opacity-0', 'scale-95');
        panel.classList.add('opacity-100', 'scale-100');
      });
    }

    function closeModal() {
      const overlay = document.getElementById('offerModal');
      const panel   = document.getElementById('offerModalPanel');

      // fade out
      overlay.classList.add('opacity-0');
      panel.classList.add('opacity-0', 'scale-95');
      panel.classList.remove('opacity-100', 'scale-100');

      setTimeout(() => overlay.classList.add('hidden'), 300);
    }

    // Close when clicking the dark backdrop
    document.getElementById('offerModal').addEventListener('click', (e) => {
      if (e.target.id === 'offerModal') closeModal();
    });

    // ---------- Submit ----------
    function completeOffer(btn) {
      const upiId = document.getElementById('upiId').value.trim();
      if (!upiId) return alert('Please enter your UPI ID');
      if (!upiId.includes('@')) return alert('Please enter a valid UPI ID (e.g., yourname@upi)');

      const original = btn.textContent;
      btn.textContent = 'Processing...';
      btn.disabled = true;

      const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';

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
      .then(r => r.ok ? r.json() : Promise.reject(r))
      .then(data => {
        if (data?.success) {
          document.getElementById('modalForm').classList.add('hidden');
          document.getElementById('modalSuccess').classList.remove('hidden');

          // If backend gives a specific redirect_url, use it on click
          const cont = document.getElementById('continueBtn');
          cont.onclick = function () {
            if (data.redirect_url) window.open(data.redirect_url, '_blank');
            else redirectToOffer();
          };
        } else {
          alert(data?.message || 'Something went wrong');
          btn.textContent = original;
          btn.disabled = false;
        }
      })
      .catch(() => {
        alert('An error occurred. Please try again.');
        btn.textContent = original;
        btn.disabled = false;
      });
    }

    function redirectToOffer() {
      if (currentTrackingLink && currentTrackingLink !== '#') {
        window.open(currentTrackingLink, '_blank');
      }
      closeModal();
    }

    // ---------- Reveal on scroll ----------
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) entry.target.classList.add('show');
      });
    }, { threshold: 0.15, rootMargin: '0px 0px -80px 0px' });

    document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

    // (Optional) light tab click effect — needs #cards-grid (now present)
    const cardsGrid = document.getElementById('cards-grid');
    function pulseGrid() {
      cardsGrid.style.transform = 'scale(0.98)';
      cardsGrid.style.opacity = '0.9';
      setTimeout(() => {
        cardsGrid.style.transform = 'scale(1)';
        cardsGrid.style.opacity = '1';
      }, 180);
    }
    document.getElementById('home-nav').addEventListener('click', e => { e.preventDefault(); pulseGrid(); });
    document.getElementById('deals-nav').addEventListener('click', e => { e.preventDefault(); pulseGrid(); });
  </script>
</body>
</html>
