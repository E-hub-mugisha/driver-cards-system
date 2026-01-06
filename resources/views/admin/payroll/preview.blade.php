@extends('layouts.app')
@section('title','Preview Payroll')

@section('content')
<div class="container">
    <h4>Preview Payroll - {{ $company->name }} - {{ $month->format('M Y') }}</h4>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Driver</th>
                <th>Base Salary</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($drivers as $driver)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $driver->names }}</td>
                <td>{{ number_format($settings->salary_type=='fixed' ? $settings->base_salary : 0,2) }}</td>
                <td>-</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <form method="POST" action="{{ route('admin.payroll.process') }}">
        @csrf
        <input type="hidden" name="company_id" value="{{ $company->id }}">
        <input type="hidden" name="month" value="{{ $month->format('Y-m') }}">
        <button class="btn btn-success">Process Payroll</button>
    </form>
</div>
@endsection
