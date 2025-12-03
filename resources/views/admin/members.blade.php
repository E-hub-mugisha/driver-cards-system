@extends('layouts.app')
@section('title','Member list')
@section('content')

<div class="container">
    <div class="az-content-body pd-lg-l-40 d-flex flex-column">
        <h2 class="az-content-title">Members list</h2>
        <div class="breadcomb-report">
            <a href="{{ route('drivers.export') }}" data-toggle="tooltip" data-placement="left" title="Download Report" class="btn btn-primary btn-rounded btn-block">Download Report</a>
        </div>
        <div>
            <table id="example2" class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Company Name</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach( $members as $member)
                    <tr>
                        <td>{{ $member->id }}</td>
                        <td>{{ $member->name }}</td>
                        <td>{{ $member->status }}</td>
                        <td>
                            <!-- Action Dropdown -->
                            <div class="dropdown">
                                <button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="actionDropdown{{ $member->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                    Actions
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="actionDropdown{{ $member->id }}">
                                    <li>
                                        <a href="#" class="dropdown-item text-success" data-bs-toggle="modal" data-bs-target="#confirmModal" data-action="{{ route('member.active', $member->id) }}" data-message="Are you sure you want to set this member active?">Activate</a>
                                    </li>
                                    <li>
                                        <a href="#" class="dropdown-item text-warning" data-bs-toggle="modal" data-bs-target="#confirmModal" data-action="{{ route('member.inactive', $member->id) }}" data-message="Are you sure you want to set this member inactive?">Inactivate</a>
                                    </li>
                                    <li>
                                        <a href="#" class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#confirmModal" data-action="{{ route('member.delete', $member->id) }}" data-message="Are you sure you want to delete this member?">Delete</a>
                                    </li>
                                </ul>
                            </div>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    const confirmModal = document.getElementById('confirmModal');
    confirmModal.addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget;
        const action = button.getAttribute('data-action');
        const message = button.getAttribute('data-message');
        const method = button.textContent.trim().toLowerCase(); // optional: can set PUT/DELETE dynamically

        const form = document.getElementById('confirmForm');
        form.action = action;

        // Update method dynamically based on link text
        if(button.textContent.trim() === 'Activate' || button.textContent.trim() === 'Inactivate') {
            form.method = 'POST';
            form.innerHTML = '@csrf @method("PUT")' + form.innerHTML;
        } else if(button.textContent.trim() === 'Delete') {
            form.method = 'POST';
            form.innerHTML = '@csrf @method("DELETE")' + form.innerHTML;
        }

        document.getElementById('confirmMessage').textContent = message;
    });
</script>

@endsection