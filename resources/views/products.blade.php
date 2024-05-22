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

<div>
    <a class='rounded px-2 py-1 bg-gray-800 text-white' href="{{route('products.add')}}">Add new product</a>
    @foreach ($products as $product)
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Name
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Description
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Price
                                </th>
                                <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">Edit</span>
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <div class="flex-shrink-0 h-10 w-10">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <img class="w-80" src="{{$product->image}}" alt="product image" >
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{$product->name}}
                                                </div>
                                            </div>
                                        </div>
                                </div>
                                <div class="flex items-center">
                                    <div class="ml-4">
                                    </div>
                                </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <p>{{$product->description}}</p>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                          <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                            <p>{{$product->price}} €</p>
                          </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{route('products.edit', $product->id)}}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                </td>
                                <td>
                                    <form action="{{route('products.delete')}}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{$product->id}}">
                                        <button class="text-red-400" type="submit">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


@endforeach
