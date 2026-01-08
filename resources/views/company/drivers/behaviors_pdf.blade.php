<h3>Driver Behavior Report - {{ $driver->names }}</h3>
<p>Company: {{ $company->name }}</p>
<p>Date: {{ now()->format('d M Y') }}</p>

<table width="100%" border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>#</th>
            <th>Behavior Category</th>
            <th>Behavior Type</th>
            <th>Description</th>
            <th>Reported By</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        @forelse($driver->behaviors as $index => $behavior)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $behavior->behaviorType->behaviorCategory->name ?? 'N/A' }}</td>
            <td>{{ $behavior->behaviorType->name ?? 'N/A' }}</td>
            <td>{{ $behavior->description ?? 'N/A' }}</td>
            <td>{{ optional($behavior->reporter)->name ?? 'System' }}</td>
            <td>{{ $behavior->created_at?->format('d M Y - h:i A') ?? 'N/A' }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="6" class="text-center">No behavior records found.</td>
        </tr>
        @endforelse
    </tbody>
</table>
