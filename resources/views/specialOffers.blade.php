<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Special Offers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4 text-center">Special Offers</h2>
    <div class="row g-4">
        @forelse($camps as $camp)
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Campaign #{{ $camp->id }}</h5>
                        <p class="card-text">
                            <strong>{{ $camp->description }}</strong><br>
                            Payout: <strong>{{ $camp->payouts }}</strong><br>
                            Created At: {{ $camp->created_at->format('d M, Y') }}
                        </p>
                        <button class="btn btn-primary mt-auto"
                                data-bs-toggle="modal"
                                data-bs-target="#offerModal"
                                data-id="{{ $camp->id }}"
                                data-name="{{ $camp->description }}"
                                data-url="{{ $camp->url ?? '' }}"
                                data-payouts="{{ $camp->payouts }}"
                                data-code="{{ $camp->code }}">
                            Get Offer
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center">
                <p>No special offers available.</p>
            </div>
        @endforelse
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="offerModal" tabindex="-1" aria-labelledby="offerModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="{{ route('special-clicks.store') }}">
        @csrf
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="offerModalLabel">Get Offer</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <input type="hidden" name="campaign_id" id="campaign_id">
              <input type="hidden" name="url" id="url">
              <input type="hidden" name="payouts" id="payouts">
              <input type="hidden" name="code" id="code">

                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <h5><span id="modal_title"></span></h5>
                </div>
              <div class="mb-3">
                  <label for="upiid" class="form-label">UPI ID</label>
                  <input type="text" class="form-control" id="upiid" name="upiid" required>
              </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success">Complete</button>
          </div>
        </div>
    </form>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const offerModal = document.getElementById('offerModal');
    offerModal.addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget;

        // Get data from button
        const campaign_id = button.getAttribute('data-id');
        const name = button.getAttribute('data-name');
        const url = button.getAttribute('data-url');
        const payouts = button.getAttribute('data-payouts');
        const code = button.getAttribute('data-code');

        // Fill modal fields
        offerModal.querySelector('#campaign_id').value = campaign_id;
        offerModal.querySelector('#url').value = url;
        offerModal.querySelector('#payouts').value = payouts;
        offerModal.querySelector('#code').value = code;
        offerModal.querySelector('#modal_title').textContent = name;
        offerModal.querySelector('#upiid').value = ''; // empty for user input
    });
</script>

</body>
</html>
