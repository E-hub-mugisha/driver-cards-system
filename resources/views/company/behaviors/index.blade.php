@extends('layouts.app')
@section('title', 'Driver Behaviors')
@section('content')

<div class="container-fluid">
    <div class="nk-content-inner">
        <div class="nk-content-body">
            <div class="nk-block-head nk-block-head-sm">
                <div class="nk-block-between">
                    <div class="nk-block-head-content">
                        <h3 class="nk-block-title page-title">Driver Behaviors</h3>
                    </div>
                    <div class="nk-block-head-content">
                        <div class="toggle-wrap nk-block-tools-toggle"><a href="#"
                                class="btn btn-icon btn-trigger toggle-expand me-n1"
                                data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                            <div class="toggle-expand-content" data-content="pageMenu">
                                <ul class="nk-block-tools g-3">
                                    <li class="nk-block-tools-opt">
                                        <a href="#"
                                            data-bs-toggle="modal"
                                            data-bs-target="#addBehaviorModal"
                                            class="btn btn-icon btn-primary d-md-none">
                                            <em class="icon ni ni-plus"></em>
                                        </a>

                                        <a href="#"
                                            data-bs-toggle="modal"
                                            data-bs-target="#addBehaviorModal"
                                            class="btn btn-primary d-none d-md-inline-flex">
                                            <em class="icon ni ni-plus"></em>
                                            <span>Add Behavior</span>
                                        </a>

                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Something went wrong!</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <div class="nk-block nk-block-lg">
                    <div class="nk-block-head">
                        <div class="nk-block-head-content">
                            <div class="nk-block-des">
                                <p>Lists of behavior that are involved in drivers</p>
                            </div>
                        </div>
                    </div>
                    <div class="card rounded-5 shadow-sm">
                        <div class="card-body">

                            <div class="row">

                                <!-- LEFT: CATEGORY MENU -->
                                <div class="col-md-3">
                                    <ul class="nav link-list-menu round-5 shadow-sm" role="tablist">
                                        @foreach($categories as $index=>$category)
                                        <li class="p-4">
                                            <span class="badge bg-secondary">
                                                {{ $category->behaviorTypes->count() }}
                                            </span>
                                            <a class="nav-link {{ $index==0?'active':'' }}"
                                                data-bs-toggle="tab"
                                                href="#tabItem-{{ $category->id }}">

                                                {{ $category->name }}

                                            </a>

                                        </li>
                                        @endforeach
                                    </ul>
                                </div>

                                <!-- RIGHT: CONTENT -->
                                <div class="col-md-9">
                                    <div class="tab-content">

                                        @foreach($categories as $index=>$category)
                                        <div class="tab-pane fade {{ $index==0?'show active':'' }}"
                                            id="tabItem-{{ $category->id }}">

                                            <!-- SEARCH -->
                                            <div class="mb-2">
                                                <input type="text"
                                                    class="form-control form-control-sm"
                                                    placeholder="Search behavior..."
                                                    onkeyup="
                                        let rows=document.querySelectorAll('#table-{{ $category->id }} tbody tr');
                                        rows.forEach(r=>r.style.display=
                                            r.innerText.toLowerCase().includes(this.value.toLowerCase())
                                            ? '' : 'none'
                                        );
                                    ">
                                            </div>

                                            <table class="datatable-init nowrap nk-tb-list nk-tb-ulist"
                                                id="table-{{ $category->id }}">
                                                <thead>
                                                    <tr class="nk-tb-item nk-tb-head">
                                                        <th class="nk-tb-col">Name</th>
                                                        <th class="nk-tb-col">Type</th>
                                                        <th class="nk-tb-col">Severity</th>
                                                        <th class="nk-tb-col">Score</th>
                                                        <th class="nk-tb-col nk-tb-col-tools text-end"></th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    @forelse($category->behaviorTypes as $behavior)
                                                    <tr class="nk-tb-item">
                                                        <td class="nk-tb-col">{{ $behavior->name }}</td>

                                                        <td class="nk-tb-col">
                                                            <span class="badge bg-{{ $behavior->category=='positive'?'success':'danger' }}">
                                                                {{ ucfirst($behavior->category) }}
                                                            </span>
                                                        </td>

                                                        <td class="nk-tb-col">
                                                            <span class="badge
                                                @if($behavior->severity=='low') bg-info
                                                @elseif($behavior->severity=='medium') bg-warning
                                                @else bg-danger @endif">
                                                                {{ ucfirst($behavior->severity) }}
                                                            </span>
                                                        </td>

                                                        <td class="nk-tb-col">{{ $behavior->default_score }}</td>

                                                        <td class="nk-tb-col nk-tb-col-tools">
                                                            <ul class="nk-tb-actions gx-1">
                                                                <li>
                                                                    <div class="drodown"><a href="#"
                                                                            class="dropdown-toggle btn btn-icon btn-trigger"
                                                                            data-bs-toggle="dropdown"><em
                                                                                class="icon ni ni-more-h"></em></a>
                                                                        <div class="dropdown-menu dropdown-menu-end">
                                                                            <ul class="link-list-opt no-bdr">
                                                                                <li>
                                                                                    <a href="{{ route('admin.behaviors.drivers',$behavior) }}"
                                                                                        class="text-success">
                                                                                        Drivers ({{ $behavior->driverBehaviors->count() }})
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#" class="text-primary" data-bs-toggle="modal" data-bs-target="#editBehaviorModal-{{ $behavior->id }}">
                                                                                        Edit
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    @if($behavior->driverBehaviors->count() > 0)
                                                                                    <a href="#" class="text-info" disabled>
                                                                                        In Use
                                                                                    </a>
                                                                                    @else
                                                                                    <form method="POST"
                                                                                        action="{{ route('admin.behaviors.destroy',$behavior) }}"
                                                                                        class="d-inline">
                                                                                        @csrf
                                                                                        @method('DELETE')
                                                                                        <button class="text-danger btn">
                                                                                            Delete
                                                                                        </button>
                                                                                    </form>
                                                                                    @endif
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            </ul>
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
                </div>
            </div>
        </div>
    </div>
</div>

@foreach($categories as $index=>$category)
@forelse($category->behaviorTypes as $behavior)

<!-- EDIT MODAL -->
<div class="modal fade"
    id="editBehaviorModal-{{ $behavior->id }}">
    <div class="modal-dialog">
        <form method="POST"
            action="{{ route('admin.behaviors.update',$behavior) }}"
            class="modal-content">
            @csrf
            @method('PUT')

            <div class="modal-header">
                <h5>Edit Behavior</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <input name="name"
                    value="{{ $behavior->name }}"
                    class="form-control mb-2"
                    required>

                <select name="category" class="form-control mb-2">
                    <option value="negative" @selected($behavior->category=='negative')>
                        Negative
                    </option>
                    <option value="positive" @selected($behavior->category=='positive')>
                        Positive
                    </option>
                </select>

                <select name="severity" class="form-control mb-2">
                    <option value="low" @selected($behavior->severity=='low')>Low</option>
                    <option value="medium" @selected($behavior->severity=='medium')>Medium</option>
                    <option value="high" @selected($behavior->severity=='high')>High</option>
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
@empty
@endforelse
@endforeach
<!-- ADD MODAL -->
<div class="modal fade" id="addBehaviorModal">
    <div class="modal-dialog">
        <form method="POST"
            action="{{ route('admin.behaviors.store') }}"
            class="modal-content">
            @csrf

            <div class="modal-header">
                <h5>Add Behavior</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <select name="behavior_category_id"
                    class="form-control mb-2" required>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}">
                        {{ $category->name }}
                    </option>
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

                <input type="number"
                    name="default_score"
                    class="form-control">
            </div>

            <div class="modal-footer">
                <button class="btn btn-primary">Save</button>
            </div>

        </form>
    </div>
</div>

@endsection