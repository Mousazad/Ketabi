@extends('layouts.base')

@section('onvan')
Books
@endsection

@section('content')
                <h1 class="mb-1 font-medium">Edit Book:</h1>
                @auth
                @if(auth()->user()->role == 'admin')
                    <form action="/book/{{$book->id}}/update" method="post" class="flex gap-2 flex-col">
                        @csrf
                        <label >Title:</label>
                        <input type="text" name="title" placeholder="Title" value="{{ $book->title }}">
                        <label>Publication Year:</label>
                        <input type="text" name="publication_year" placeholder="Publication Year"  value="{{ $book->publication_year }}">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                @foreach ($errors->all() as $error)
                                    <li dir='rtl' style="color:red">{{ $error }}</li>
                                @endforeach
                                </ul>
                            </div>
                        @endif
                        <button type="submit" class="inline-block dark:bg-[#eeeeec] dark:border-[#eeeeec] dark:text-[#1C1C1A] dark:hover:bg-white dark:hover:border-white hover:bg-black hover:border-black px-5 py-1.5 bg-[#1b1b18] rounded-sm border border-black text-white text-sm leading-normal">Save</button>
                    </form>
                    <h2>List of Authors:</h2>
                <table class="w-full">
                @foreach ($book->authors as $author)
                    <tr class="flex items-center justify-between w-full gap-3">
                        <td class="text-blue-500 line-clamp-1">
                            <a href="/author/{{$author->id}}">{{$author->name}}</a>
                        </td>
                        <td>
                            <a href="/book/{{$book->id}}/remove_author/{{$author->id}}"><button class="bg-red-500  w-16 text-white rounded p-1 hover:bg-red-800 px-2">remove</button></a>
                        </td>
                    </tr>
                @endforeach
                </table>
                @endif
                @endauth
                <h2 class="mb-1 font-medium">Add Book authors:</h2>
                <table class="w-full">
                @foreach ($noAuthor as $item)
                    <tr class="flex items-center justify-between w-full gap-3">
                        <td class="text-blue-500 line-clamp-1">
                            <a href="/author/{{$item->id}}">{{$item->name}}</a>
                        </td>
                        <td>
                            <a href="/book/{{$book->id}}/add_author/{{$item->id}}"><button class="bg-blue-500 w-16 text-white rounded p-1 hover:bg-blue-800 px-2 transition">add</button></a>
                        </td>
                    </tr>
                @endforeach
                </table>
@endsection