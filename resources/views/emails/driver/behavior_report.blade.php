@component('mail::message')
# Driver Behavior Report

Hello,

Please find attached the behavior report for driver: **{{ $driver->names }}**.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
