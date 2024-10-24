@extends('filament::resources.class-resource.pages.view-record')

@section('content')
    <div>
        <h2 class="text-lg font-bold">Users in this class:</h2>
        <ul>
            @forelse($record->users as $user)
                <li>{{ $user->name }} ({{ $user->email }})</li>
            @empty
                <li>No users found in this class.</li>
            @endforelse
        </ul>
    </div>
@endsection
