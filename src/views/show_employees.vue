<template>
  <div class="container mt-4">
    <h2>จัดการข้อมูลพนักงาน</h2>

    <!-- 🔍 search -->
    <input v-model="search" class="form-control mb-3" placeholder="ค้นหา..." />

    <!-- ➕ add -->
    <div class="card p-3 mb-3">
        <h5>เพิ่มพนักงาน</h5>
      <div class="row">
        <div class="col">
          <input v-model="form.full_name" class="form-control" placeholder="ชื่อ-นามสกุล" />
        </div>
        <div class="col">
          <input v-model="form.department" class="form-control" placeholder="แผนก" />
        </div>
        <div class="col">
          <input v-model="form.salary" class="form-control" placeholder="เงินเดือน" />
        </div>
        <div class="col">
          <button class="btn btn-success" @click="addEmployee">เพิ่ม</button>
        </div>
      </div>
    </div>

    <!-- 📋 table -->
    <table class="table table-striped">
      <thead>
        <tr>
          <th>รหัส</th>
          <th>ชื่อ</th>
          <th>แผนก</th>
          <th>เงินเดือน</th>
          <th>สถานะ</th>
          <th>จัดการ</th>
        </tr>
      </thead>

      <tbody>
        <tr v-for="item in filteredEmployees" :key="item.emp_id">
          <td>{{ item.emp_id }}</td>
          <td>{{ item.full_name }}</td>
          <td>{{ item.department }}</td>
          <td>{{ item.salary }}</td>
          <td>
            <span v-if="item.active == 1" class="text-success">ทำงาน</span>
            <span v-else class="text-danger">ลาออก</span>
          </td>
          <td>
            <button class="btn btn-danger btn-sm" @click="deleteEmployee(item.emp_id)">
              ลบ
            </button>
          </td>
        </tr>

        <tr v-if="filteredEmployees.length === 0">
          <td colspan="6" class="text-center">ไม่มีข้อมูล</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'

const employees = ref([])
const search = ref('')

const form = ref({
  full_name: '',
  department: '',
  salary: ''
})

// 🔍 search
const filteredEmployees = computed(() =>
  employees.value.filter(e =>
    e.full_name?.includes(search.value) ||
    e.department?.includes(search.value)
  )
)

// 📥 load
const fetchEmployees = async () => {
  const res = await fetch('http://localhost/project-vue-68712375/php.api/show_employees.php')
  const data = await res.json()
  employees.value = data
}

// ➕ add
const addEmployee = async () => {
  console.log('Add button clicked!', form.value)
  try {
    const res = await fetch('http://localhost/project-vue-68712375/php.api/add_employee.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(form.value)
    })

    const result = await res.json()
    console.log('API response:', result)

    if (result.success) {
      alert('เพิ่มสำเร็จ')
      form.value = { full_name: '', department: '', salary: '' }
      fetchEmployees()
    } else {
      alert('เพิ่มไม่สำเร็จ: ' + (result.error || 'Unknown error'))
    }
  } catch (err) {
    console.error('Error adding employee:', err)
    alert('เกิดข้อผิดพลาด: ' + err.message)
  }
}

// ❌ delete
const deleteEmployee = async (id) => {
  if (!confirm('คุณแน่ใจจะลบ?')) return

  try {
    const res = await fetch('http://localhost/project-vue-68712375/php.api/delete_employee.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ emp_id: id })
    })

    const result = await res.json()

    if (result.success) {
      alert('ลบสำเร็จ')
      fetchEmployees()
    } else {
      alert('ลบไม่สำเร็จ: ' + (result.error || 'Unknown error'))
    }
  } catch (err) {
    console.error('Error deleting employee:', err)
    alert('เกิดข้อผิดพลาด: ' + err.message)
  }
}

onMounted(fetchEmployees)
</script>