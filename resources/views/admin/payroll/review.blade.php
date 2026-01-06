@extends('layouts.app')
@section('title','Review Payroll')

@section('content')
<div class="container">
    <h4>Payroll Review: {{ $company->name }} - {{ $month->format('M Y') }}</h4>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Driver</th>
                <th>Gross Salary</th>
                <th>Deductions</th>
                <th>Net Salary</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payroll->details as $detail)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $detail->driver->names }}</td>
                <td>{{ number_format($detail->gross_salary,2) }}</td>
                <td>{{ number_format($detail->tax_deduction + $detail->rssb_deduction + $detail->penalty_amount,2) }}</td>
                <td>{{ number_format($detail->net_salary,2) }}</td>
                <td>
                    <a href="{{ route('admin.payroll.download.driver',$detail) }}" class="btn btn-sm btn-primary">Download Payslip</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @if($payroll->status != 'approved')
    <form method="POST" action="{{ route('admin.payroll.approve',$payroll) }}">
        @csrf
        <button class="btn btn-success">Approve Payroll</button>
    </form>
    @endif
</div>
@endsection
