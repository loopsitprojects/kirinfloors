<x-mail::message>
# New Contact Request

**Name:** {{ $data['name'] }}

**Email:** [{{ $data['email'] }}](mailto:{{ $data['email'] }})

**Phone:** {{ $data['phone'] ?? 'N/A' }}

**Message:**
<x-mail::panel>
{{ $data['message'] }}
</x-mail::panel>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>