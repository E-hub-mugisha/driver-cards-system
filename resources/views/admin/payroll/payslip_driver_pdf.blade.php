<h3 style="text-align:center;">Payslip</h3>
<p><strong>Driver:</strong> {{ $detail->driver->names }}</p>
<p><strong>Company:</strong> {{ $detail->payroll->company->name }}</p>
<p><strong>Month:</strong> {{ $detail->payroll->month->format('M Y') }}</p>

<table width="100%" border="1" cellspacing="0" cellpadding="5">
    <thead>
        <tr>
            <th>Description</th>
            <th>Amount</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Base Salary</td>
            <td>{{ number_format($detail->base_amount,2) }}</td>
        </tr>
        <tr>
            <td>Gross Salary</td>
            <td>{{ number_format($detail->gross_salary,2) }}</td>
        </tr>
        <tr>
            <td>Tax Deduction</td>
            <td>{{ number_format($detail->tax_deduction,2) }}</td>
        </tr>
        <tr>
            <td>RSSB Deduction</td>
            <td>{{ number_format($detail->rssb_deduction,2) }}</td>
        </tr>
        <tr>
            <td>Penalties</td>
            <td>{{ number_format($detail->penalty_amount,2) }}</td>
        </tr>
        <tr>
            <td><strong>Net Salary</strong></td>
            <td><strong>{{ number_format($detail->net_salary,2) }}</strong></td>
        </tr>
    </tbody>
</table>
