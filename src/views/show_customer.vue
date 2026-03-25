<template>
  <div class="container mt-4">
    <h2 class="mb-3">จัดการข้อมูลลูกค้า</h2>

    <!-- 🔍 ค้นหา -->
    <input
      v-model="search"
      type="text"
      class="form-control mb-3"
      placeholder="ค้นหาชื่อ / นามสกุล / username"
    />

    <!-- ➕ เพิ่มลูกค้า -->
    <div class="card mb-3 p-3">
      <h5>เพิ่มลูกค้า</h5>
      <div class="row">
        <div class="col">
          <input v-model="form.firstName" class="form-control" placeholder="ชื่อ" />
        </div>
        <div class="col">
          <input v-model="form.lastName" class="form-control" placeholder="นามสกุล" />
        </div>
        <div class="col">
          <input v-model="form.phone" class="form-control" placeholder="เบอร์โทร" />
        </div>
        <div class="col">
          <input v-model="form.username" class="form-control" placeholder="username" />
        </div>
        <div class="col">
          <button class="btn btn-success" @click="addCustomer">เพิ่ม</button>
        </div>
      </div>
    </div>

    <!-- loading -->
    <div v-if="loading">กำลังโหลด...</div>

    <!-- error -->
    <div v-else-if="error" class="text-danger">
      {{ error }}
    </div>

    <!-- 📋 ตาราง -->
    <table v-else class="table table-striped align-middle">
      <thead>
        <tr>
          <th>รหัสลูกค้า</th>
          <th>ชื่อ</th>
          <th>นามสกุล</th>
          <th>เบอร์โทร</th>
          <th>username</th>
          <th>จัดการ</th>
        </tr>
      </thead>

      <tbody>
        <tr v-for="item in filteredCustomers" :key="item.customer_id">
          <td>{{ item.customer_id }}</td>
          <td>{{ item.firstName }}</td>
          <td>{{ item.lastName }}</td>
          <td>{{ item.phone }}</td>
          <td>{{ item.username }}</td>
          <td>
            <button class="btn btn-danger btn-sm" @click="deleteCustomer(item.customer_id)">
              ลบ
            </button>
          </td>
        </tr>

        <tr v-if="filteredCustomers.length === 0">
          <td colspan="6" class="text-center">ไม่มีข้อมูล</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'

const customers = ref([])
const loading = ref(true)
const error = ref(null)
const search = ref('')

// ฟอร์มเพิ่มข้อมูล
const form = ref({
  firstName: '',
  lastName: '',
  phone: '',
  username: ''
})

// 🔍 filter ค้นหา
const filteredCustomers = computed(() => {
  return customers.value.filter(c =>
    c.firstName?.includes(search.value) ||
    c.lastName?.includes(search.value) ||
    c.username?.includes(search.value)
  )
})

// 📥 โหลดข้อมูล
const fetchCustomers = async () => {
  try {
    const res = await fetch('http://localhost/project-vue-68712375/php.api/show_customer.php')
    const data = await res.json()
    customers.value = data
  } catch (err) {
    error.value = 'โหลดข้อมูลไม่สำเร็จ'
  } finally {
    loading.value = false
  }
}

// ➕ เพิ่มลูกค้า
const addCustomer = async () => {
  try {
    const res = await fetch('http://localhost/project-vue-68712375/php.api/add_customer.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(form.value)
    })

    const result = await res.json()

    if (result.success) {
      alert('เพิ่มสำเร็จ')
      form.value = { firstName: '', lastName: '', phone: '', username: '' }
      fetchCustomers()
    } else {
      alert('เพิ่มไม่สำเร็จ')
    }
  } catch (err) {
    console.error(err)
  }
}

// ❌ ลบลูกค้า
const deleteCustomer = async (id) => {
  if (!confirm('คุณแน่ใจจะลบ?')) return

  try {
    const res = await fetch('http://localhost/project-vue-68712375/php.api/delete_customer.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ customer_id: id })
    })

    const result = await res.json()

    if (result.success) {
      alert('ลบสำเร็จ')
      fetchCustomers()
    } else {
      alert('ลบไม่สำเร็จ')
    }
  } catch (err) {
    console.error(err)
  }
}

onMounted(fetchCustomers)
</script>