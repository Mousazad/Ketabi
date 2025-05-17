@extends('layouts.base')

@section('onvan')
{{ $book->title }}
@endsection

@section('content')
                <h1 class="mb-1 font-medium">Information about {{ $book->title }}</h1>
                @if($book->cover_file != null)<img src={{ $book->cover_file }} alt= "Book Cover" width="400">@endif
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
                            Add By : {{ $book->addBy->name }}
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
                @auth
                @if(auth()->user()->role == 'admin')
                <div class="flex w-full gap-5 pb-2">
                    <a href="/book/{{$book->id}}/edit"><button class="border-2 rounded p-1 hover:shadow-md px-2">edit book</button></a>
                    <a href="/book/{{$book->id}}/delete"><button onclick="return confirm('Are you sure you want to delete this item?');" class="border-2 border-red-500 text-red-500 rounded p-1 hover:shadow-md px-2">delete book</button></a>
                </div>
                @endif
                @endauth
                <h2>List of Authors:</h2>
                <table class="w-full">
                @foreach ($book->authors as $author)
                    <tr class="flex items-center justify-between w-full gap-3">
                        <td class="line-clamp-1">
                            <a class="text-blue-500" href="/author/{{$author->id}}">{{$author->name}}</a>
                        </td>
                    </tr>
                @endforeach
                </table>

@endsection