@extends('layouts.base')

@section('onvan')
Books
@endsection

@section('content')
<h1 class="mb-1 font-medium">These is all our Books</h1>
                <p class="mb-2 text-[#706f6c] dark:text-[#A1A09A]">We find these batch of books interesting.</p>
                <ul class="flex flex-col mb-4 lg:mb-6">
                    @foreach ($books as $book)
                        <li
                            class="flex items-center gap-4 py-2 relative before:border-l before:border-[#e3e3e0] dark:before:border-[#3E3E3A] before:top-1/2 before:bottom-0 before:left-[0.4rem] before:absolute">
                            <span class="relative py-1 bg-white dark:bg-[#161615]">
                                <span
                                    class="flex items-center justify-center rounded-full bg-[#FDFDFC] dark:bg-[#161615] shadow-[0px_0px_1px_0px_rgba(0,0,0,0.03),0px_1px_2px_0px_rgba(0,0,0,0.06)] w-3.5 h-3.5 border dark:border-[#3E3E3A] border-[#e3e3e0]">
                                    <span class="rounded-full bg-[#dbdbd7] dark:bg-[#3E3E3A] w-1.5 h-1.5"></span>
                                </span>
                            </span>
                            <span>
                                <a href="/book/{{ $book->id }}"
                                    class="inline-flex items-center space-x-1 font-medium underline underline-offset-4 text-[#f53003] dark:text-[#FF4433] ml-1">
                                    <span>{{ $book->title }}</span>
                                </a>
                            </span>
                        </li>
                    @endforeach
                </ul>
                @auth
                @if(auth()->user()->role == 'admin')
                    <form action="/books/create" method="post" class="flex gap-2 flex-col" enctype="multipart/form-data">
                        @csrf
                        <input type="text" name="title" placeholder="Title">
                        <input type="text" name="publication_year" placeholder="Publication Year">
                        <input class="form-control" type="file" name="cover_file" placeholder="cover file">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                @foreach ($errors->all() as $error)
                                    <li dir='rtl' style="color:red">{{ $error }}</li>
                                @endforeach
                                </ul>
                            </div>
                        @endif
                        <button type="submit" class="inline-block dark:bg-[#eeeeec] dark:border-[#eeeeec] dark:text-[#1C1C1A] dark:hover:bg-white dark:hover:border-white hover:bg-black hover:border-black px-5 py-1.5 bg-[#1b1b18] rounded-sm border border-black text-white text-sm leading-normal">Add                        Book</button>
                    </form>
                @endif
                @endauth

@endsection