@extends('layouts.base')

@section('onvan')
{{ $book->title }}
@endsection

@section('content')
                <h1 class="mb-1 font-medium">Information about {{ $book->title }}</h1>
                <ul class="flex flex-col mb-4 lg:mb-6">
                    <li>
                        <p>
                            Title : {{ $book->title }}
                        </p>
                    </li>
                    <li>
                        <p>
                            Publication Year : {{ $book->publication_year }}
                        </p>
                    </li>
                    <li>
                        <p>
                            Created At : {{ $book->created_at }}
                        </p>
                    </li>
                    <li>
                        <p>
                            Updated At : {{ $book->updated_at }}
                        </p>
                    </li>
                </ul>
                <h2>List of Authors:</h2>
                @foreach ($book->authors as $author)
                    <p>{{$author->name}}</p>
                @endforeach

@endsection