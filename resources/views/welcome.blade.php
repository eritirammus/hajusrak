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
        scale: 60%;
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


<div class="bg-gray-100 dark:bg-gray-900">
    @if (Route::has('login'))
        <div class="flex justify-center top-5 right-0 px-6 py-4 lg:block">
            @auth
                <a href="{{ url('/dashboard') }}"
                   class="text-sm text-gray-700 dark:text-gray-500 underline">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Register</a>
                @endif
            @endauth
        </div>
        <a href="{{route('cart')}}">View cart {{count($cart)}}</a>
    @endif
    <div class="flex flex-col lg:grid lg:grid-cols-4 bg-white">
        @foreach ($products as $product)
            <div class="mx-4 my-4 p-4 rounded-lg bg-gray-50 text-black shadow-lg hover:shadow-inner">
                <form method="POST" action="{{route('addcart')}}">
                    @csrf
                    <input type="hidden" name="id" value="{{$product->id}}">
                    <div class="h-56">
                        <img src="{{ $product->image }}" alt="image" class="object-fill h-full w-full">
                    </div>
                    <div class="flex justify-between py-3">
                        <p class="text-2xl font-bold">{{ $product->name }}</p>
                        <span class="rounded-lg bg-green-300 h-8 text-black p-1">{{ $product->price }} €</span>
                    </div>
                    <div class="">
                        <div class="text-black">{{ $product->description }}</div>
                    </div>
                    <div class="text-center">

                        <button type="submit"
                                class="hover:shadow-xl px-6 rounded-lg text-white cursor-pointer bg-blue-700 text-xl shadow h-12 font-bold py-2">
                            Add to cart
                        </button>
                    </div>

                </form>
            </div>
        @endforeach
    </div>

