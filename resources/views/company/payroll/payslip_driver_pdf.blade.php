<div style="
    max-width: 700px;
    margin: auto;
    font-family: 'Segoe UI', Tahoma, sans-serif;
    color: #333;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    overflow: hidden;
">

    <!-- ================= HEADER ================= -->
    <div style="
        background: linear-gradient(135deg, #0d6efd, #6610f2);
        color: #fff;
        padding: 20px;
        text-align: center;
    ">
        <h2 style="margin: 0;">Payslip</h2>
        <p style="margin: 5px 0 0; font-size: 14px;">
            {{ $detail->payroll->month->format('F Y') }}
        </p>
    </div>

    <!-- ================= EMPLOYEE INFO ================= -->
    <div style="padding: 20px; background: #f9fafb;">
        <table width="100%" cellpadding="5">
            <tr>
                <td><strong>Driver Name:</strong></td>
                <td>{{ $detail->driver->names }}</td>
            </tr>
            <tr>
                <td><strong>Company:</strong></td>
                <td>{{ $detail->payroll->company->name }}</td>
            </tr>
            <tr>
                <td><strong>Payslip Date:</strong></td>
                <td>{{ now()->format('d M Y') }}</td>
            </tr>
        </table>
    </div>

    <!-- ================= EARNINGS ================= -->
    <div style="padding: 20px;">
        <h4 style="margin-bottom: 10px; color: #0d6efd;">Earnings</h4>

        <table width="100%" cellspacing="0" cellpadding="8" style="border-collapse: collapse;">
            <tr style="background:#eef2ff;">
                <td>Base Salary</td>
                <td align="right">{{ number_format($detail->base_amount, 2) }}</td>
            </tr>
            <tr>
                <td>Trips Earnings</td>
                <td align="right">{{ number_format($detail->trips_earning, 2) }}</td>
            </tr>
            <tr style="background:#eef2ff;">
                <td>Overtime</td>
                <td align="right">{{ number_format($detail->overtime_amount, 2) }}</td>
            </tr>
            <tr>
                <td>Bonus</td>
                <td align="right">{{ number_format($detail->bonus_amount, 2) }}</td>
            </tr>
            <tr style="font-weight: bold; border-top: 2px solid #ccc;">
                <td>Gross Salary</td>
                <td align="right">{{ number_format($detail->gross_salary, 2) }}</td>
            </tr>
        </table>
    </div>

    <!-- ================= DEDUCTIONS ================= -->
    <div style="padding: 20px; background:#f9fafb;">
        <h4 style="margin-bottom: 10px; color: #dc3545;">Deductions</h4>

        <table width="100%" cellspacing="0" cellpadding="8" style="border-collapse: collapse;">
            <tr>
                <td>Tax</td>
                <td align="right">{{ number_format($detail->tax_deduction, 2) }}</td>
            </tr>
            <tr style="background:#fff;">
                <td>RSSB</td>
                <td align="right">{{ number_format($detail->rssb_deduction, 2) }}</td>
            </tr>
            <tr>
                <td>Penalties</td>
                <td align="right">{{ number_format($detail->penalty_amount, 2) }}</td>
            </tr>
            <tr style="background:#fff;">
                <td>Incident Deductions</td>
                <td align="right">{{ number_format($detail->incident_deduction, 2) }}</td>
            </tr>
        </table>
    </div>

    <!-- ================= NET PAY ================= -->
    <div style="
        padding: 20px;
        background: #0d6efd;
        color: #fff;
        text-align: center;
    ">
        <h3 style="margin: 0;">Net Salary</h3>
        <h1 style="margin: 5px 0 0;">
            {{ number_format($detail->net_salary, 2) }}
        </h1>
    </div>

    <!-- ================= FOOTER ================= -->
    <div style="
        padding: 12px;
        text-align: center;
        font-size: 12px;
        color: #6b7280;
    ">
        This is a system-generated payslip. No signature required.
    </div>

</div>