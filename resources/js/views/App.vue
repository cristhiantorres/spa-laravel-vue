<template>
  <div>
    <Navbar />
    <div class="container mt-2">
      <h1>Vue router Demo App</h1>
      <router-view></router-view>
    </div>
  </div>
</template>

<script>
import Navbar from '../components/Navbar'
export default {
  components: {
    Navbar
  }
}
</script>

