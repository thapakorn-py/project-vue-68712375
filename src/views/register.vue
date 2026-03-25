<template>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card shadow-lg">
          <div class="card-body p-5">
            <h2 class="text-center mb-4">สมัครสมาชิก</h2>

            <div v-if="message" :class="messageType" class="alert">
              {{ message }}
            </div>

            <form @submit.prevent="register">
              <div class="mb-3">
                <label class="form-label">ชื่อ</label>
                <input v-model="form.firstName" type="text" class="form-control" required />
              </div>

              <div class="mb-3">
                <label class="form-label">นามสกุล</label>
                <input v-model="form.lastName" type="text" class="form-control" required />
              </div>

              <div class="mb-3">
                <label class="form-label">เบอร์โทร</label>
                <input v-model="form.phone" type="text" class="form-control" required />
              </div>

              <div class="mb-3">
                <label class="form-label">Email</label>
                <input v-model="form.email" type="email" class="form-control" required />
              </div>

              <div class="mb-3">
                <label class="form-label">Username</label>
                <input v-model="form.username" type="text" class="form-control" required />
              </div>

              <div class="mb-3">
                <label class="form-label">Password</label>
                <input v-model="form.password" type="password" class="form-control" required />
              </div>

              <div class="mb-3">
                <label class="form-label">ยืนยัน Password</label>
                <input v-model="form.confirmPassword" type="password" class="form-control" required />
              </div>

              <button type="submit" class="btn btn-primary w-100">สมัครสมาชิก</button>
            </form>

            <div class="mt-3 text-center">
              <p>มีบัญชีแล้ว? <router-link to="/login">เข้าสู่ระบบ</router-link></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()
const form = ref({
  firstName: '',
  lastName: '',
  phone: '',
  email: '',
  username: '',
  password: '',
  confirmPassword: ''
})

const message = ref('')
const messageType = ref('alert-info')

const register = async () => {
  if (form.value.password !== form.value.confirmPassword) {
    message.value = 'Password ไม่ตรงกัน!'
    messageType.value = 'alert-danger'
    return
  }

  try {
    const res = await fetch('http://localhost/project-vue-68712375/php.api/register.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(form.value)
    })

    const result = await res.json()

    if (result.success) {
      message.value = 'สมัครสมาชิกสำเร็จ! กำลังเปลี่ยนเส้นทาง...'
      messageType.value = 'alert-success'
      setTimeout(() => {
        router.push('/login')
      }, 1500)
    } else {
      message.value = 'สมัครสมาชิกไม่สำเร็จ: ' + (result.error || 'Unknown error')
      messageType.value = 'alert-danger'
    }
  } catch (err) {
    console.error('Registration error:', err)
    message.value = 'เกิดข้อผิดพลาด: ' + err.message
    messageType.value = 'alert-danger'
  }
}
</script>
