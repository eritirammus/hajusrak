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

    button {
        color: deepgray;
        font-family: 'Nunito', sans-serif;
        background: gray;
        font-size: 30px;
        text-decoration: none;
        border-color: deepgray;
    }
</style>


<div id="body" class="flex text-3xl">
    <div>
        @if (empty($cart))

            <p>the cart is empty</p>
        @else
            @foreach ($cart as $product)
                <div
                    class="mx-4 my-4 p-4 rounded-lg bg-gray-50 text-black shadow-lg hover:shadow-inner grid grid-cols-2">
                    <div>
                        <p>{{$product['name']}}</p>
                        <img class="h-24" src="{{$product['image']}}" alt="">
                    </div>

                    <div class="  ">
                        <p>{{$product['description']}}</p>

                        <p>{{$product['price']*$product['quantity']}} €</p>
                        <form action="{{route('updatecart')}}" method="post">
                            @csrf
                            <input type="hidden" value="{{$product['id']}}" name="id">
                            <input type="number" value="{{$product['quantity']}}" name="quantity">
                            <button type="submit">Update cart</button>
                        </form>
                        <form action="{{route('deleteitem')}}" method="post">
                            @csrf
                            <input type="hidden" value="{{$product['id']}}" name="id">
                            <button type="submit">delete</button>
                        </form>
                    </div>

                </div>
            @endforeach
        @endif
    </div>
    <div>
        <div class="w-96 h-36 flex-col border-2">
            <input id="card-holder-name" type="text" placeholder="Cardholder name">

            <!-- Stripe Elements Placeholder -->
            <div class="p-2" id="card-element"></div>

            <button class=" bg-blue-400 h-12 px-4 text-white text-xl rounded " id="card-button">
                Process Payment
            </button>
        </div>
    </div>
</div>
<script src="https://js.stripe.com/v3/"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script>


    const stripe = Stripe('pk_test_51KH6hGLzawazuwmcDdNYHNw1EcAztsFxkpvRp1uOpmoSbdvsma4PbV8jaarX32KvM6zviLCnjWgFqkMvlJq5wRlb00jyONllwb');

    const elements = stripe.elements();
    const cardElement = elements.create('card');

    cardElement.mount('#card-element');

    const cardHolderName = document.getElementById('card-holder-name');
    const cardButton = document.getElementById('card-button');

    cardButton.addEventListener('click', async (e) => {
        const {paymentMethod, error} = await stripe.createPaymentMethod(
            'card', cardElement, {
                billing_details: {name: cardHolderName.value}
            }
        );

        if (error) {
            // Display "error.message" to the user...
        } else {
            axios.post('/subscribe', {
                payment_method: paymentMethod.id,
            }).then((data) => {
                handleSubmit(data.data.paymentIntent)
                //  stripe.confirmCardPayment(data.data.paymentIntent.client_secret,
                //  {
                //      payment_method: {
                //          card: cardElement
                //   }
                //   })
            });


        }

    });

    async function handleSubmit(paymentIntent) {
        await stripe.confirmCardPayment(
            paymentIntent.client_secret,
            {
                payment_method: {
                    card: cardElement
                }
            }
        ).then(res => {
            if (res.paymentIntent.status === 'succeeded')
                axios.post('/success')
                    .then(window.location.replace('/'));
        })

//   if (error.type === "card_error" || error.type === "validation_error") {
//     showMessage(error.message);
//   } else {
//     showMessage("An unexpected error occured.");
//   }
    }
</script>
