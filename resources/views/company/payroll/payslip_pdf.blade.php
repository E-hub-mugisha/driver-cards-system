<table width="100%" border="1" cellspacing="0" cellpadding="5">
    <thead>
        <tr>
            <th>Driver</th>
            <th>Gross</th>
            <th>Deductions</th>
            <th>Net</th>
        </tr>
    </thead>
    <tbody>
        @foreach($payroll->details as $detail)
        <tr>
            <td>{{ $detail->driver->names }}</td>
            <td>{{ number_format($detail->gross_salary,2) }}</td>
            <td>{{ number_format($detail->tax_deduction + $detail->rssb_deduction + $detail->penalty_amount,2) }}</td>
            <td>{{ number_format($detail->net_salary,2) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
<p><strong>Total Gross:</strong> {{ number_format($payroll->details->sum('gross_salary'),2) }}</p>
<p><strong>Total Deductions:</strong> {{ number_format($payroll->details->sum(function($detail) {
    return $detail->tax_deduction + $detail->rssb_deduction + $detail->penalty_amount;
}),2) }}</p>
<p><strong>Total Net:</strong> {{ number_format($payroll->details->sum('net_salary'),2) }}</p>
<p><em>This is a system generated payslip summary and does not require a signature.</em></p>