@extends('layouts.app')
@section('title', 'Admin Dashboard')

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg p-4" style="border-radius: 12px;">
        <h3 class="mb-4">👋 Welcome, {{ auth()->user()->name }}</h3>
        <p class="text-muted">This is your admin dashboard.</p>

        <div class="table-responsive mt-4">
            <table class="table table-bordered table-striped" id="conversionsTable">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Publisher ID</th>
                        <th>User ID (p2)</th>
                        <th>Click ID</th>
                        <th>Payout</th>
                        <th>Campaign ID</th>
                        <th>UPI ID</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($conversions as $conv)
                        <tr>
                            <td>{{ $conv->id }}</td>
                            <td>{{ $conv->publisher_id }}</td>
                            <td>{{ $conv->user_id }}</td>
                            <td>{{ $conv->click_id }}</td>
                            <td>{{ $conv->payout }}</td>
                            <td>{{ $conv->campaign_id }}</td>
                            <td>{{ $conv->upi_id ?? '—' }}</td>
                            <td>{{ $conv->created_at }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">No conversions found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Logout -->
        <form method="POST" action="{{ route('admin.logout') }}" class="mt-3">
            @csrf
            <button type="submit" class="btn btn-danger">Logout</button>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        $('#conversionsTable').DataTable();
    });
</script>
@endsection
