<style>
    @import url('https://fonts.googleapis.com/css2?family=Nunito:wght@700&display=swap');

    body {
        font-family: 'Nunito', sans-serif;
        background: gray !important;
        padding: 50px;
        font-size: 30px;
    }
    p {
        font-size: 30px;
        font-family: 'Nunito', sans-serif;
        color: deepgray;
    }

    th {
        font-family: 'Nunito', sans-serif;
        font-size:30px;
        color: deepgray;
    }

    td {
        font-family: 'Nunito', sans-serif;
        font-size:30px;
        color: deepgray;
    }

    input {
        color: deepgray;
        font-size: 30px;
        font-family: 'Nunito', sans-serif;
        background: gray;
        text-decoration: none;
        border-color: deepgray;
    }

    a {
        text-decoration: none;

        color: hotgray;
    }

    img {
        scale: 30%;
    }

    button {
        color: deepgray;
        font-family: 'Nunito', sans-serif;
        background: gray;
        font-size: 30px;
        text-decoration: none;
        border-color: deepgray;
    }
</style>


<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add new product') }}
        </h2>
    </x-slot>
    <div>
        <form method="POST" action="{{route('products.store')}}" enctype="multipart/form-data">
            @csrf
            <x-label for="name" :value="__('Name')"/>
            <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" autofocus/>
            @error('name')
            <p class="text-xs text-red-500">{{$message}}</p>
            @enderror

            <x-label for="description" :value="__('Description')"/>
            <x-input id="description" class="block mt-1 w-full" type="text" name="description"
                     :value="old('description')" autofocus/>
            @error('description')
            <p class="text-xs text-red-500">{{$message}}</p>
            @enderror

            <x-label for="price" :value="__('Price')"/>
            <x-input id="price" class="block mt-1 w-full" type="text" name="price" :value="old('price')" autofocus/>
            @error('price')
            <p class="text-xs text-red-500">{{$message}}</p>
            @enderror

            <x-label for="image">Add image</x-label>
            <input name="image" id="image" type="file">

            <button type="submit">Submit</button>
        </form>
    </div>
</x-app-layout>

