<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <title>Deal Cards</title>

  <!-- Tailwind -->
  <script src="https://cdn.tailwindcss.com?plugins=forms,line-clamp"></script>

  <!-- Bootstrap (for modal only) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    /* Reveal on scroll */
    .reveal { opacity: 0; transform: translateY(14px) scale(.98); transition: opacity .45s ease, transform .45s ease; }
    .reveal.show { opacity: 1; transform: translateY(0) scale(1); }

    /* Floating effect */
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
            <a href="{{ url('/')}}" id="deals-nav" class="text-white px-4 py-2 rounded-full hover:bg-white/20 hover:bg-white hover:text-gray-800 transition">Offers</a>
            <a href="{{ url('specialOffers') }}" class="text-white px-4 py-2 rounded-full bg-white/20 hover:bg-white hover:text-gray-800 transition">Special Offers</a>
            <a href="#" class="text-white px-4 py-2 rounded-full hover:bg-white hover:text-gray-800 transition">About</a>
        </div>
        </div>
    </nav>

    <!-- Hero -->
    <div class="text-center my-16">
        <h1 class="text-white text-5xl md:text-6xl font-extrabold mb-4">🎉 Special Offers</h1>
        <p class="text-white/90 text-lg md:text-xl">Check out the latest deals and earn rewards!</p>
    </div>

    <!-- Cards Grid -->
    <div id="cards-grid" class="max-w-7xl mx-auto px-6 grid md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach ($camps as $camp)
        <div class="card float-card reveal bg-white rounded-2xl shadow-lg overflow-hidden
                transition-transform duration-300 hover:-translate-y-1 hover:shadow-2xl flex flex-col">

            <!-- Card Header -->
            <div class="relative h-20 bg-gradient-to-r from-purple-500 to-indigo-600">
                <div class="absolute top-3 right-3 bg-white/90 px-3 py-1 rounded-full text-sm font-bold text-gray-800">
                ⭐ New
                </div>
            </div>

            <!-- Card Body -->
            <div class="p-6 flex-1 flex flex-col">
                <h3 class="text-gray-900 text-xl font-extrabold mb-2">{{ $camp['name'] }}</h3>
                <p class="text-gray-600 mb-4 line-clamp-2">{{ $camp['description'] }}</p>
            </div>

            <!-- Price -->
            <div class="bg-gradient-to-r from-purple-500 to-indigo-600 text-center p-4 text-white font-bold text-2xl">
                ₹{{ $camp['payouts'] }}
                <div class="text-sm font-medium">Earn Upto</div>
            </div>

            <!-- Button -->
            <div class="p-6 mt-auto">
                <button
                class="w-full py-3 rounded-xl bg-gradient-to-r from-purple-500 to-indigo-600 text-white
                        font-semibold hover:scale-105 transition"
                data-bs-toggle="modal"
                data-bs-target="#offerModal"
                data-id="{{ $camp->id }}"
                data-name="{{ $camp->name }}"
                data-desc="{{ $camp->description }}"
                data-url="{{ $camp->url ?? '' }}"
                data-payouts="{{ $camp->payouts }}"
                data-code="{{ $camp->code }}">
                Get Offer 👉
                </button>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Modal -->
    <div class="modal fade" id="offerModal" tabindex="-1" aria-labelledby="offerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form method="POST" action="{{ route('special-clicks.store') }}" target="_blank" class="w-full">
            @csrf
            <div class="modal-content rounded-2xl shadow-xl border-0">

                <!-- Header -->
                <div class="modal-header border-b-0">
                <h5 class="modal-title text-xl font-bold text-gray-800" id="modal_title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Body -->
                <div class="modal-body space-y-4">
                <!-- Hidden Inputs -->
                <input type="hidden" name="campaign_id" id="campaign_id">
                <input type="hidden" name="url" id="url">
                <input type="hidden" name="payouts" id="payouts">
                <input type="hidden" name="code" id="code">
                <!-- Description -->
                <div>
                    <p class="text-gray-700" id="modal_desc"></p>
                </div>

                <!-- UPI Input -->
                <div>
                    <label for="upiid" class="block text-sm font-medium text-gray-700 mb-1">UPI ID</label>
                    <input type="text" class="form-control rounded-lg border px-3 py-2 focus:ring-2 focus:ring-indigo-500 w-full" id="upiid" name="upiid" required placeholder="example@upi">
                </div>
                </div>

                <!-- Footer -->
                <div class="modal-footer border-t-0">
                <button type="submit" class="w-full py-3 rounded-xl bg-gradient-to-r from-purple-500 to-indigo-600 text-white font-semibold hover:scale-105 transition">
                     Complete Offer
                </button>
                </div>
            </div>
            </form>
        </div>
    </div>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
 <script>
  const offerModal = document.getElementById('offerModal');
  const modal = new bootstrap.Modal(offerModal);

  // Fill modal fields on open
  offerModal.addEventListener('show.bs.modal', event => {
      const button = event.relatedTarget;

      const campaign_id = button.getAttribute('data-id');
      const name = button.getAttribute('data-name');
      const desc = button.getAttribute('data-desc');
      const url = button.getAttribute('data-url');
      const payouts = button.getAttribute('data-payouts');
      const code = button.getAttribute('data-code');

      offerModal.querySelector('#campaign_id').value = campaign_id;
      offerModal.querySelector('#url').value = url;
      offerModal.querySelector('#payouts').value = payouts;
      offerModal.querySelector('#code').value = code;
      offerModal.querySelector('#modal_title').textContent = name;
      offerModal.querySelector('#upiid').value = '';
      offerModal.querySelector('#modal_desc').textContent = desc;
  });

  // On form submit -> close modal + reset inputs
  const offerForm = offerModal.querySelector("form");
  offerForm.addEventListener("submit", function () {
      setTimeout(() => {
          // Close modal
          modal.hide();

          // Reset form fields
          offerForm.reset();
      }, 500); // little delay to allow request
  });

  // Reveal effect
  const reveals = document.querySelectorAll(".reveal");
  const revealOnScroll = () => {
    const windowHeight = window.innerHeight;
    reveals.forEach(el => {
      const top = el.getBoundingClientRect().top;
      if(top < windowHeight - 60) el.classList.add("show");
    });
  };
  window.addEventListener("scroll", revealOnScroll);
  window.addEventListener("load", revealOnScroll);
</script>

</body>
</html>
