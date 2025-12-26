@extends('backend.master')
@section('title', 'Contact Submissions')

@section('content')
<div class="container py-4">
    <div class="card">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0">User Submissions</h5>
        </div>
        <div class="card-body p-0">
            <table class="table table-bordered table-striped mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        @foreach($fields as $field)
                            <th>{{ $field->label }}</th>
                        @endforeach
                        <th>Submitted</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($submissions as $sub)
                        <tr>
                            <td>{{ $sub->id }}</td>
                            @foreach($fields as $field)
                                <td>{{ $sub->data[$field->key] ?? '' }}</td>
                            @endforeach
                            <td>{{ $sub->created_at->format('Y-m-d H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ $fields->count() + 2 }}" class="text-center">
                                No submissions found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
