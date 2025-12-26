@extends('backend.master')
@section('title', 'Contact Section Management')

@section('content')
    <div class="container py-4">
        <!-- PAGE HEADER -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold">Contact Section Management</h4>
        </div>

        <div class="row">
            <!-- LEFT COLUMN -->
            <div class="col-lg-4">
                <!-- SECTION TITLE -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-info text-white">
                        <h6 class="mb-0">Section Title & Subtitle</h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('contact-sections.update', $section->id) }}">
                            @csrf @method('PUT')
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Title</label>
                                <input name="title" value="{{ $section->title }}" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Subtitle</label>
                                <input name="subtitle" value="{{ $section->subtitle }}" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Description</label>
                                <textarea name="description" class="form-control">{{ $section->description }}</textarea>
                            </div>
                            <button class="btn btn-info w-100">Save Section</button>
                        </form>
                    </div>
                </div>

                <!-- CONTACT CARD -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-info text-white">
                        <h6 class="mb-0">Contact Card Details</h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('contact-cards.update', $card->id) }}">
                            @csrf @method('PUT')
                            <div class="mb-2"><label class="fw-semibold">Title</label>
                                <input name="title" value="{{ $card->title }}" class="form-control">
                            </div>
                            <div class="mb-2"><label class="fw-semibold">Phone</label>
                                <input name="phone" value="{{ $card->phone }}" class="form-control">
                            </div>
                            <div class="mb-2"><label class="fw-semibold">Email</label>
                                <input name="email" value="{{ $card->email }}" class="form-control">
                            </div>
                            <div class="mb-2"><label class="fw-semibold">Address</label>
                                <input name="address" value="{{ $card->address }}" class="form-control">
                            </div>
                            <div class="mb-2"><label class="fw-semibold">Hours</label>
                                <input name="hours" value="{{ $card->hours }}" class="form-control">
                            </div>
                            <div class="mb-2"><label class="fw-semibold">Pill Text</label>
                                <input name="pill_text" value="{{ $card->pill_text }}" class="form-control">
                            </div>
                            <div class="mb-3"><label class="fw-semibold">Disclaimer</label>
                                <textarea name="disclaimer" class="form-control">{{ $card->disclaimer }}</textarea>
                            </div>
                            <button class="btn btn-info w-100">Update Card</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- RIGHT COLUMN -->
            <div class="col-lg-8">
                <!-- CONTACT FIELDS -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-info text-white">
                        <h6 class="mb-0">Contact Form Fields</h6>
                    </div>
                    <div class="card-body p-3">
                        <form method="POST" action="{{ route('contact-fields.store') }}" id="multiFieldsForm">
                            @csrf

                            <!-- Table: Field Listing -->
                            <div class="table-responsive mb-3">
                                <table class="table table-bordered align-middle mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>Order</th>
                                            <th>Key</th>
                                            <th>Label</th>
                                            <th>Placeholder</th>
                                            <th>Type</th>
                                            <th>Required</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="fields-table-body">
                                        @foreach($fields as $field)
                                            <tr>
                                                <td>{{ $field->order }}</td>
                                                <td>{{ $field->key }}</td>
                                                <td>{{ $field->label }}</td>
                                                <td>{{ $field->placeholder }}</td>
                                                <td>{{ $field->type }}</td>
                                                <td class="text-center">{{ $field->required ? 'Yes' : 'No' }}</td>
                                                <td>

                                                    {{-- <form method="POST"
                                                        action="{{ route('contact-fields.destroy', $field->id) }}">
                                                        @csrf @method('DELETE')
                                                        <button class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Delete?')">Delete</button>
                                                    </form> --}}
                                                    <button type="button" class="btn btn-sm btn-danger" onclick="deleteContactField({{ $field->id }})">
                                                        Delete
                                                    </button>

                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Single Button Text Input (outside table) -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Button Text (for any Button type field)</label>
                                <input type="text" class="form-control" name="button_text"
                                    placeholder="Enter button text here">
                                <small class="text-muted">This text will be applied to all fields of type 'button'.</small>
                            </div>

                            <!-- Add Multiple Fields -->
                            <div id="multi-fields-wrapper">
                                <div class="row g-2 mb-2 single-field-row align-items-center" data-row="add-0">
                                    <div class="col"><input name="fields[0][key]" class="form-control"
                                            placeholder="Key (static)" required></div>
                                    <div class="col"><input name="fields[0][label]" class="form-control" placeholder="Label"
                                            required></div>
                                    <div class="col"><input name="fields[0][placeholder]" class="form-control"
                                            placeholder="Placeholder"></div>
                                    <div class="col">
                                        <select name="fields[0][type]" class="form-select type-select" data-row="add-0"
                                            required>
                                            <option value="text">text</option>
                                            <option value="email">email</option>
                                            <option value="number">number</option>
                                            <option value="select">select</option>
                                            <option value="textarea">textarea</option>
                                            <option value="button">button</option>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <input name="fields[0][button_text]" class="form-control button-extra"
                                            data-row="add-0" placeholder="Button Text" style="display:none">
                                    </div>
                                    <div class="col text-center">
                                        <input type="checkbox" name="fields[0][required]" value="1" checked>
                                    </div>
                                    <div class="col"><input name="fields[0][order]" type="number" value="1"
                                            class="form-control"></div>
                                    <div class="col-auto">
                                        <button type="button"
                                            class="btn btn-danger btn-sm remove-field-btn">&times;</button>
                                    </div>
                                </div>
                            </div>


                            <button type="button" id="addFieldBtn" class="btn btn-outline-primary btn-sm mt-2">+ Add
                                Field</button>
                            <button type="submit" class="btn btn-success btn-sm mt-2">Save All</button>
                        </form>
                    </div>
                </div>

                <!-- AREA OPTIONS -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-info text-white">
                        <h6 class="mb-0">Area Dropdown Options</h6>
                    </div>
                    <div class="card-body p-3">
                        <form method="POST" action="{{ route('contact-areas.store') }}">
                            @csrf
                            <div class="row g-2 align-items-center">
                                <div class="col"><input name="value" class="form-control" placeholder="New Area" required>
                                </div>
                                <div class="col"><input name="order" type="number" value="1" class="form-control"></div>
                                <div class="col-auto"><button class="btn btn-success btn-sm">Add Area</button></div>
                            </div>
                        </form>
                        <div class="table-responsive mt-3">
                            <table class="table table-bordered mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Order</th>
                                        <th>Value</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($areas as $area)
                                        <tr>
                                            <td>{{ $area->order }}</td>
                                            <td>{{ $area->value }}</td>
                                            <td class="text-center">
                                                <form method="POST" action="{{ route('contact-areas.destroy', $area->id) }}">
                                                    @csrf @method('DELETE')
                                                    <button class="btn btn-sm btn-danger">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://unpkg.com/feather-icons"></script>
    <script>
        feather.replace();

        let fieldIndex = 1;

        document.getElementById('addFieldBtn').onclick = function () {
    let wrapper = document.getElementById('multi-fields-wrapper');
    let idx = fieldIndex;
    let rowHtml = `
    <div class="row g-2 mb-2 single-field-row align-items-center" data-row="add-${idx}">
        <div class="col"><input name="fields[${idx}][key]" class="form-control" placeholder="Key (static)" required></div>
        <div class="col"><input name="fields[${idx}][label]" class="form-control" placeholder="Label" required></div>
        <div class="col"><input name="fields[${idx}][placeholder]" class="form-control" placeholder="Placeholder"></div>
        <div class="col">
            <select name="fields[${idx}][type]" class="form-select type-select" data-row="add-${idx}" required>
                <option value="text">text</option>
                <option value="email">email</option>
                <option value="number">number</option>
                <option value="select">select</option>
                <option value="textarea">textarea</option>
                <option value="button">button</option>
            </select>
        </div>
        <div class="col">
            <input name="fields[${idx}][button_text]" class="form-control button-extra" data-row="add-${idx}" placeholder="Button Text" style="display:none">
        </div>
        <div class="col text-center">
            <input type="checkbox" name="fields[${idx}][required]" value="1" checked>
        </div>
        <div class="col"><input name="fields[${idx}][order]" type="number" value="1" class="form-control"></div>
        <div class="col-auto">
            <button type="button" class="btn btn-danger btn-sm remove-field-btn">&times;</button>
        </div>
    </div>`;
    wrapper.insertAdjacentHTML('beforeend', rowHtml);
    fieldIndex++;
};

// Show/hide button_text field per type select
document.addEventListener('change', function (e) {
    if (e.target.classList.contains('type-select')) {
        let type = e.target.value;
        let row = e.target.getAttribute('data-row');
        document.querySelectorAll(`.button-extra[data-row="${row}"]`).forEach(el => {
            el.style.display = (type === 'button') ? '' : 'none';
        });
        document.querySelectorAll(`.button-extra-edit[data-row="${row}"]`).forEach(el => {
            el.style.display = (type === 'button') ? '' : 'none';
        });
    }
});
   function deleteContactField(id) {
    if (!confirm('Delete this field?')) return;

    let url = "{{ route('contact-fields.destroy', ['id' => ':id']) }}";
    url = url.replace(':id', id);
    console.log(url);
    $.ajax({
        url: url,
        // type: 'DELETE',
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        success: function(response) {
            // Success: Reload the page or remove the deleted row dynamically
            console.log('Field deleted successfully');
            location.reload();
        },
        error: function(xhr) {
            let msg = 'Delete failed!';
            if(xhr.responseJSON && xhr.responseJSON.message) {
                msg = xhr.responseJSON.message;
            }
            alert(msg);
        }
    });
}

</script>
@endpush