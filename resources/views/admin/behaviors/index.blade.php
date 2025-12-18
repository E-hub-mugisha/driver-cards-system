@extends('layouts.app')
@section('title', 'Driver Behaviors')
@section('content')

<div class="container">
    <div class="az-content-body pd-lg-l-40 d-flex flex-column">
        <div class="d-flex justify-content-between mb-3">
            <h2 class="az-content-title mb-0">Driver Behaviors</h2>
            <div class="d-flex gap-2">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBehaviorModal">
                    + Add Behavior
                </button>
            </div>
        </div>

        <div class="row">
            <!-- LEFT: CATEGORIES -->
            <div class="col-md-3">
                <div class="nav flex-column nav-pills">
                    @foreach($categories as $index => $category)
                    <button class="nav-link {{ $index === 0 ? 'active' : '' }}"
                        data-bs-toggle="pill"
                        data-bs-target="#cat-{{ $category->id }}">
                        {{ $category->name }}
                        <span class="badge bg-secondary float-end">
                            {{ $category->behaviorTypes->count() }}
                        </span>
                    </button>
                    @endforeach
                </div>
            </div>

            <!-- RIGHT: CONTENT -->
            <div class="col-md-9">
                <div class="tab-content">

                    @foreach($categories as $index => $category)
                    <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}"
                        id="cat-{{ $category->id }}">

                        <!-- SEARCH -->
                        <div class="p-2">
                            <input type="text"
                                class="form-control form-control-sm"
                                placeholder="Search behavior..."
                                onkeyup="
                             const rows = document.querySelectorAll('#table-{{ $category->id }} tbody tr');
                             rows.forEach(r => r.style.display =
                                 r.innerText.toLowerCase().includes(this.value.toLowerCase()) ? '' : 'none'
                             );
                           ">
                        </div>

                        <table class="table table-sm table-border mb-0" id="table-{{ $category->id }}" id="example2">
                            <thead class="table-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Severity</th>
                                    <th>Score</th>
                                    <th width="160">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($category->behaviorTypes as $behavior)
                                <tr>
                                    <td>{{ $behavior->name }}</td>

                                    <td>
                                        <span class="badge bg-{{ $behavior->category === 'positive' ? 'success' : 'danger' }}">
                                            {{ ucfirst($behavior->category) }}
                                        </span>
                                    </td>

                                    <td>
                                        <span class="badge
                                    @if($behavior->severity === 'low') bg-info
                                    @elseif($behavior->severity === 'medium') bg-warning
                                    @else bg-danger @endif">
                                            {{ ucfirst($behavior->severity) }}
                                        </span>
                                    </td>

                                    <td>{{ $behavior->default_score }}</td>

                                    <td>
                                        <a href="{{ route('admin.behaviors.drivers', $behavior) }}"
                                            class="btn btn-sm btn-info">
                                            Drivers ({{ $behavior->driverBehaviors->count() }})
                                        </a>


                                        <!-- EDIT -->
                                        <button class="btn btn-sm btn-warning"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editBehaviorModal-{{ $behavior->id }}">
                                            Edit
                                        </button>

                                        <!-- DELETE -->
                                        @if($behavior->driverBehaviors->count() > 0)
                                        <button class="btn btn-sm btn-secondary" disabled
                                            title="Behavior already used">
                                            In Use
                                        </button>
                                        @else
                                        <form method="POST"
                                            action="{{ route('admin.behaviors.destroy', $behavior) }}"
                                            class="d-inline">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-danger"
                                                onclick="return confirm('Delete this behavior?')">
                                                Delete
                                            </button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>


                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">
                                        No behaviors found
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</div>

@forelse($category->behaviorTypes as $behavior)

<!-- EDIT MODAL (NO JS) -->
<div class="modal fade" id="editBehaviorModal-{{ $behavior->id }}">
    <div class="modal-dialog">
        <form method="POST"
            action="{{ route('admin.behaviors.update', $behavior) }}"
            class="modal-content">
            @csrf @method('PUT')

            <div class="modal-header">
                <h5>Edit Behavior</h5>
            </div>

            <div class="modal-body">
                <input name="name"
                    value="{{ $behavior->name }}"
                    class="form-control mb-2" required>

                <select name="category" class="form-control mb-2">
                    <option value="negative" @selected($behavior->category==='negative')>Negative</option>
                    <option value="positive" @selected($behavior->category==='positive')>Positive</option>
                </select>

                <select name="severity" class="form-control mb-2">
                    <option value="low" @selected($behavior->severity==='low')>Low</option>
                    <option value="medium" @selected($behavior->severity==='medium')>Medium</option>
                    <option value="high" @selected($behavior->severity==='high')>High</option>
                </select>

                <input type="number"
                    name="default_score"
                    value="{{ $behavior->default_score }}"
                    class="form-control">
            </div>

            <div class="modal-footer">
                <button class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>
@endforeach

<!-- ADD MODAL -->
<div class="modal fade" id="addBehaviorModal">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('admin.behaviors.store') }}" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5>Add Behavior</h5>
            </div>

            <div class="modal-body">
                <select name="behavior_category_id" class="form-control mb-2" required>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>

                <input name="name" class="form-control mb-2" required>

                <select name="category" class="form-control mb-2">
                    <option value="negative">Negative</option>
                    <option value="positive">Positive</option>
                </select>

                <select name="severity" class="form-control mb-2">
                    <option value="low">Low</option>
                    <option value="medium">Medium</option>
                    <option value="high">High</option>
                </select>

                <input type="number" name="default_score" class="form-control">
            </div>

            <div class="modal-footer">
                <button class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
</div>

@endsection