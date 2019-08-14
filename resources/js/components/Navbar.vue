<template>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a href="#" class="navbar-brand">SPA</a>
    <div class="navbar-collapse">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <router-link :to="{ name: 'home' }" class="nav-link">Home</router-link>
        </li>
        <li class="nav-item">
          <router-link :to="{ name: 'users.index' }" class="nav-link">Users</router-link>
        </li>
        <li class="nav-item">
          <router-link :to="{ name: 'users.create' }" class="nav-link">User create</router-link>
        </li>
      </ul>
    </div>
  </nav>
  
</template>

<script>
export default {}
</script>