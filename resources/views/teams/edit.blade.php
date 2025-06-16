@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white shadow-sm rounded-lg overflow-hidden">
        <div class="p-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Edit Team</h2>

            <form action="{{ route('teams.update', $team) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Team Name</label>
                    <input type="text" name="name" id="name" value="{{ $team->name }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                    <textarea name="description" id="description" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ $team->description }}</textarea>
                </div>

                <div class="mb-6">
                    <label for="team_leader_id" class="block text-gray-700 text-sm font-bold mb-2">Team Leader</label>
                    <select name="team_leader_id" id="team_leader_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        <option value="">Select Team Leader</option>
                        @foreach($leaders as $leader)
                        <option value="{{ $leader->id }}" {{ $team->team_leader_id == $leader->id ? 'selected' : '' }}>
                            {{ $leader->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center justify-between">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Update Team
                    </button>
                    <a href="{{ route('teams.show', $team) }}" class="text-gray-600 hover:text-gray-800">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
