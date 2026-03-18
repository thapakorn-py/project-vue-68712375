<template>
  <div class="container mt-4">
    <h2 class="mb-3">Product List</h2>

    <table class="table table-striped align-middle">
      <thead>
        <tr>
          <th>ID</th>
          <th>Title</th>
          <th>Description</th>
          <th>Category</th>
          <th>Price</th>
          <th>Image</th>
        </tr>
      </thead>

      <tbody>
        <tr v-for="item in products" :key="item.id">
          <td>{{ item.id }}</td>
          <td>{{ item.title }}</td>
          <td>{{ item.description }}</td>
          <td>{{ item.category }}</td>
          <td>${{ item.price }}</td>
          <td class="text-center">
            <img
              :src="item.thumbnail"
              class="product-img"
              alt="Product Image"
							:style="{ objectFit: 'contain', width: '100%', height: '200px' }"
							/>	
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'

const products = ref([])
const loading = ref(true)
const error = ref(null)

onMounted(async () => {
  try {
    const res = await fetch('https://dummyjson.com/products')
    const data = await res.json()
    products.value = data.products
  } catch (err) {
    error.value = 'โหลดข้อมูลไม่สำเร็จ'
  } finally {
    loading.value = false
  }
})
</script>
