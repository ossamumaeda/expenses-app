<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#expenseModal">
    Add Expense
</button>

<div class="modal fade mt-0" id="expenseModal" tabindex="-1" aria-labelledby="expenseModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="expenseModalLabel">Add New Expense</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('expenses.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Description</label>
                        <input type="text" class="form-control" id="name" name="name"
                            placeholder="Describe the expense" required>
                    </div>

                    <div class="mb-3">
                        <label for="cost" class="form-label">Cost</label>
                        <input type="number" step="0.01" class="form-control" id="cost" name="cost"
                            min="0" required>
                    </div>

                    <div class="mb-3">
                        <label for="expense_type_id" class="form-label">Expense Type</label>
                        <select class="form-select" id="expense_type_id" name="expense_type_id">
                            @foreach ($expenseTypes as $types)
                                <option value="{{ $types->id }}">{{ $types->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="payment_method_id" class="form-label">Payment Method</label>
                        <select class="form-select" id="payment_method_id" name="payment_method_id">
                            @foreach ($paymentMethods as $types)
                                <option value="{{ $types->id }}">{{ $types->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" class="form-control" id="date" name="date" required>
                    </div>

                    <div class="mb-3">
                        <label for="time" class="form-label">Time</label>
                        <input type="time" class="form-control" id="time" name="time" required>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
