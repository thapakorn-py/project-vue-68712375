<template>
  <div class ="container"></div>
  <nav class="navbar navbar-expand-lg " style="background-color: #00a6ac;" data-bs-theme="light">
    <div class="container">
        <a class="navbar-brand" href="/">Shop DD</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/Product_api">Product</a>
								</li>
								<li class="nav-item">
                    <a class="nav-link" href="/Product_list">Product list</a>
                </li>
				<li class="nav-item">
                    <a class="nav-link" href="/gold">Gold</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Customers
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/showcustomer">show customers</a></li>
                        <li><a class="dropdown-item" href="/showemployees">show employees</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="#">Logout</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        {{ currentUser ? currentUser.firstName + ' ' + currentUser.lastName : 'Account' }}
                    </a>
                    <ul class="dropdown-menu">
                        <li v-if="!currentUser"><router-link class="dropdown-item" to="/register">Register</router-link></li>
                        <li v-if="!currentUser"><router-link class="dropdown-item" to="/login">Login</router-link></li>
                        <li v-if="currentUser">
                            <hr class="dropdown-divider">
                        </li>
                        <li v-if="currentUser"><a class="dropdown-item" href="#" @click.prevent="logout">Logout</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/about">About</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/contact">Contact</a>
                </li>
                


            </ul>
            <form class="d-flex" role="search">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" />
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
        </div>
    </div>
</nav>



<!--เปิดหน้าเพจที่คลิกหน้าเมนู-->
  <router-view/>

</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()
const currentUser = ref(null)

onMounted(() => {
  const user = localStorage.getItem('user')
  if (user) {
    currentUser.value = JSON.parse(user)
  }
})

const logout = () => {
  localStorage.removeItem('user')
  localStorage.removeItem('token')
  currentUser.value = null
  alert('ออกจากระบบสำเร็จ')
  router.push('/')
}
</script>





<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  /*text-align: center;*/
  color: #2c3e50;
}

nav {
  padding: 30px;
}

nav a {
  font-weight: bold;
  color: #2c3e50;
}

nav a.router-link-exact-active {
  color: #42b983;
}
</style>
