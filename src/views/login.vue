<template>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-5">
        <div class="card shadow-lg">
          <div class="card-body p-5">
            <h2 class="text-center mb-4">เข้าสู่ระบบ</h2>

            <div v-if="message" :class="messageType" class="alert">
              {{ message }}
            </div>

            <form @submit.prevent="login">
              <div class="mb-3">
                <label class="form-label">Username</label>
                <input v-model="form.username" type="text" class="form-control" required />
              </div>

              <div class="mb-3">
                <label class="form-label">Password</label>
                <input v-model="form.password" type="password" class="form-control" required />
              </div>

              <button type="submit" class="btn btn-primary w-100">เข้าสู่ระบบ</button>
            </form>

            <div class="mt-3 text-center">
              <p>ยังไม่มีบัญชี? <router-link to="/register">สมัครสมาชิก</router-link></p>
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
  username: '',
  password: ''
})

const message = ref('')
const messageType = ref('alert-info')

const login = async () => {
  try {
    const res = await fetch('http://localhost/project-vue-68712375/php.api/login.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(form.value)
    })

    const result = await res.json()

    if (result.success) {
      message.value = 'เข้าสู่ระบบสำเร็จ!'
      messageType.value = 'alert-success'
      // Save user info to localStorage
      localStorage.setItem('user', JSON.stringify(result.user))
      localStorage.setItem('token', result.token || '')
      setTimeout(() => {
        router.push('/')
      }, 1000)
    } else {
      message.value = 'Username หรือ Password ไม่ถูกต้อง'
      messageType.value = 'alert-danger'
    }
  } catch (err) {
    console.error('Login error:', err)
    message.value = 'เกิดข้อผิดพลาด: ' + err.message
    messageType.value = 'alert-danger'
  }
}
</script>
