@extends('layouts.base')

@section('onvan')
{{ $author->name }}
@endsection

@section('content')
                <h1 class="mb-1 font-medium">Information about {{ $author->name }}</h1>
                <ul class="flex flex-col mb-4 lg:mb-6">
                    <li>
                        <p>
                            Name : {{ $author->name }}
                        </p>
                    </li>
                    <li>
                        <p>
                            Nationality : {{ $author->nationality }}
                        </p>
                    </li>
                    <li>
                        <p>
                            Created At : {{ $author->created_at }}
                        </p>
                    </li>
                    <li>
                        <p>
                            Updated At : {{ $author->updated_at }}
                        </p>
                    </li>
                </ul>

@endsection