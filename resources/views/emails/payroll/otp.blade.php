@component('mail::message')
# Payroll Deletion OTP

Your OTP for deleting the payroll is:

**{{ $otp }}**

This OTP is valid for this session only.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
