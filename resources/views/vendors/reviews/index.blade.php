@extends('layouts.vendor')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="text-2xl font-semibold mb-6">Product Reviews</h2>

                @if($reviews->count())
                    <div class="space-y-4">
                        @foreach($reviews as $review)
                            <div class="border rounded-lg p-4">
                                <div class="flex justify-between">
                                    <div class="font-medium">{{ $review->user->name ?? 'Guest' }}</div>
                                    <div class="text-sm text-gray-500">{{ $review->created_at->format('Y-m-d H:i') }}</div>
                                </div>
                                <div class="text-sm text-gray-600">Product: {{ $review->product->name ?? '-' }}</div>
                                <div class="mt-2">Rating: {{ $review->rating }}/5</div>
                                @if($review->comment)
                                    <div class="mt-2 text-gray-700">{{ $review->comment }}</div>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6">
                        {{ $reviews->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <p class="text-gray-600">No reviews found</p>
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection
