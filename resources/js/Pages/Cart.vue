<template>
    <div>
      <!-- Product List -->
      <div v-for="product in products" :key="product.id">
        <h2>{{ product.name }}</h2>
        <button @click="addToCart(product)">Add to Cart</button>
      </div>
  
      <!-- Shopping Cart -->
      <div v-for="item in cart" :key="item.product.id">
        <h2>{{ item.product.name }}</h2>
        <p>Quantity: {{ item.quantity }}</p>
        <button @click="removeFromCart(item.product)">Remove</button>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        products: [], // Fetch your products from the server
        cart: []
      };
    },
    methods: {
      addToCart(product) {
        let cartItem = this.cart.find(item => item.product.id === product.id);
        if (cartItem) {
          cartItem.quantity++;
        } else {
          this.cart.push({ product: product, quantity: 1 });
        }
      },
      removeFromCart(product) {
        let index = this.cart.findIndex(item => item.product.id === product.id);
        if (index !== -1) {
          this.cart.splice(index, 1);
        }
      }
    }
  };
  </script>