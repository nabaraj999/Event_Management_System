{{-- create.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Create New Ticket</h2>

    <form action="{{ route('event-tickets.store') }}" method="POST">
        @csrf

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label>Event</label>
                    <select name="event_id" class="form-control @error('event_id') is-invalid @enderror" required>
                        <option value="">-- Select Event --</option>
                        @foreach($events as $id => $name)
                            <option value="{{ $id }}" {{ old('event_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                    @error('event_id') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label>Price</label>
                    <input type="number" step="0.01" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}" required>
                    @error('price') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label>Total Seats</label>
                    <input type="number" name="total_seats" class="form-control @error('total_seats') is-invalid @enderror" value="{{ old('total_seats') }}" required>
                    @error('total_seats') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label>Description</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                </div>

                <div class="mb-3">
                    <label>Sale Start</label>
                    <input type="datetime-local" name="sale_start" class="form-control" value="{{ old('sale_start') }}">
                </div>

                <div class="mb-3">
                    <label>Sale End</label>
                    <input type="datetime-local" name="sale_end" class="form-control" value="{{ old('sale_end') }}">
                    @error('sale_end') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label>
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                        Active
                    </label>
                </div>

                <div class="mb-3">
                    <label>Sort Order</label>
                    <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', 0) }}">
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-success">Create Ticket</button>
        <a href="{{ route('event-tickets.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
