{{-- edit.blade.php --}}

<div class="container">
    <h2>Edit Ticket</h2>

    <form action="{{ route('event-tickets.update', $eventTicket) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Same form fields as create.blade.php, just pre-filled -->
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label>Event</label>
                    <select name="event_id" class="form-control" required>
                        <option value="">-- Select Event --</option>
                        @foreach($events as $id => $name)
                            <option value="{{ $id }}" {{ $eventTicket->event_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" value="{{ $eventTicket->name }}" required>
                </div>

                <div class="mb-3">
                    <label>Price</label>
                    <input type="number" step="0.01" name="price" class="form-control" value="{{ $eventTicket->price }}" required>
                </div>

                <div class="mb-3">
                    <label>Total Seats</label>
                    <input type="number" name="total_seats" class="form-control" value="{{ $eventTicket->total_seats }}" required>
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label>Description</label>
                    <textarea name="description" class="form-control" rows="3">{{ $eventTicket->description }}</textarea>
                </div>

                <div class="mb-3">
                    <label>Sale Start</label>
                    <input type="datetime-local" name="sale_start" class="form-control" value="{{ $eventTicket->sale_start?->format('Y-m-d\TH:i') }}">
                </div>

                <div class="mb-3">
                    <label>Sale End</label>
                    <input type="datetime-local" name="sale_end" class="form-control" value="{{ $eventTicket->sale_end?->format('Y-m-d\TH:i') }}">
                </div>

                <div class="mb-3">
                    <label>
                        <input type="checkbox" name="is_active" value="1" {{ $eventTicket->is_active ? 'checked' : '' }}>
                        Active
                    </label>
                </div>

                <div class="mb-3">
                    <label>Sort Order</label>
                    <input type="number" name="sort_order" class="form-control" value="{{ $eventTicket->sort_order }}">
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-success">Update Ticket</button>
        <a href="{{ route('event-tickets.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
