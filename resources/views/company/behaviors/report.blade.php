<h3>Driver Behavior Report - {{ $company->name }}</h3>
<p>Date: {{ now()->format('d M Y') }}</p>
<table width="100%" border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>#</th>
            <th>Driver</th>
            <th>Behaviors</th>
        </tr>
    </thead>
    <tbody>
        @foreach($drivers as $index => $driver)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $driver->names }}</td>
                <td>
                    @foreach($driver->behaviors as $behavior)
                        <strong>{{ $behavior->behaviorType->behaviorCategory->name ?? 'N/A' }}:</strong>
                        {{ $behavior->behaviorType->name ?? 'N/A' }} - {{ $behavior->description ?? 'N/A' }} <br>
                    @endforeach
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
