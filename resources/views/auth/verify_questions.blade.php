@extends('layouts.guest')
@section('title', 'Verify Security Questions')
@section('content')
<div class="bg-white rounded-lg shadow-md p-8">
    <h2 class="text-2xl font-bold mb-6 text-center">Answer Security Questions</h2>
    <form method="POST" action="{{ route('password.verify.questions') }}">
        @csrf
        @foreach($questions as $index => $question)
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Question {{ $loop->iteration }}: {{ $question->question }}</label>
            <input type="text" name="answer{{ $loop->iteration }}" class="w-full px-3 py-2 border rounded-lg" required>
        </div>
        @endforeach
        @error('answer1') <p class="text-red-500 text-xs mb-4">{{ $message }}</p> @enderror
        <button type="submit" class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition">Verify Answers</button>
    </form>
</div>
@endsection
