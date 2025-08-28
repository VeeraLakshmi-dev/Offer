@extends('layouts.app')
@section('title', 'Create Campaign')
@section('content')
<div class="container mt-5">
    <div class="card p-4 shadow">
        <h2>Create Campaign</h2>

        <form action="{{ route('admin.campaigns.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Campaign Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" required></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Payout</label>
                <input type="number" name="payouts" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Link</label>
                <input type="text" name="url" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>
</div>
@endsection
