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
                <table class="w-full" id="authors-table">
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
                <input type="text" name="key" id="key" placeholder="Author name" >
                <button type="submit" onclick="search_authors()" class="inline-block dark:bg-[#eeeeec] dark:border-[#eeeeec] dark:text-[#1C1C1A] dark:hover:bg-white dark:hover:border-white hover:bg-black hover:border-black px-5 py-1.5 bg-[#1b1b18] rounded-sm border border-black text-white text-sm leading-normal">Search</button>
                <table class="w-full">
                    <tbody  id="search-result">
                    </tbody>
                </table>
                <script>
                    function search_authors() {
                        const key = document.querySelector("#key").value;
                        const bookId = "{{ $book->id}}";

                        const xhttp = new XMLHttpRequest();
                        xhttp.onload = function() {
                            const authors = JSON.parse(xhttp.responseText);
                            const tbody = document.getElementById("search-result");
                            tbody.innerHTML = "";
                            for (author of authors) {
                                const td1 = document.createElement("td");
                                td1.innerHTML = `<a href="/author/${author.id}">${author.name}</a>`;
                                const td2 = document.createElement("td");
                                td2.innerHTML = `<button onclick="add_author({{$book->id}},${author.id},'${author.name}')" class="bg-blue-500 w-16 text-white rounded p-1 hover:bg-blue-800 px-2 transition">add</button>`;
                                const tr = document.createElement("tr");
                                tr.id = "author"+author.id;
                                tr.classList.add("flex", "items-center", "justify-between", "w-full", "gap-3");
                                tr.appendChild(td1);
                                tr.appendChild(td2);
                                tbody.appendChild(tr);                                
                            }
                        }
                        xhttp.open("GET", "{{ route("authors.search") }}?"+`book_id=${bookId}&key=${key}`);
                        xhttp.send();                       
                    }

                    function add_author(bookId, authorId, authorName) {
                        const xhttp = new XMLHttpRequest();
                        xhttp.onload = function() {
                          if(xhttp.responseText === "OK")
                          {
                                let tr = document.getElementById("author"+authorId);
                                const tbody = document.getElementById("search-result");
                                tbody.removeChild(tr);


                                let td1 = document.createElement("td");
                                td1.innerHTML = `<a href="/author/${authorId}">${authorName}</a>`;
                                let td2 = document.createElement("td");
                                td2.innerHTML = `<a href="/book/${bookId}/remove_author/${authorId}"><button class="bg-red-500  w-16 text-white rounded p-1 hover:bg-red-800 px-2">remove</button></a>`;

                                tr = document.createElement("tr");
                                tr.classList.add("text-blue-500","line-clamp-1","flex", "items-center", "justify-between", "w-full", "gap-3");
                                tr.appendChild(td1);
                                tr.appendChild(td2);

                                const authorsTable = document.getElementById("authors-table");
                                authorsTable.appendChild(tr);
                          }
                        }
                        xhttp.open("GET", `/book/${bookId}/add_author/${authorId}`);
                        xhttp.send();                       
                    }

                </script>
@endsection