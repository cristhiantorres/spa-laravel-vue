<template>
  <div class="users">
    
    <div class="loading" v-if="loading">
      Loading...
    </div>

    <div class="error" v-if="error">
      {{ error }}
      <p>
        <button @click.prevent="fetchData">
          Try again
        </button>
      </p>
    </div>

    <ul v-if="users">
      <li v-for="{ id, name, email } in users" :key="id">
          <strong>Name: </strong> {{ name }}
          <strong>Email: </strong> {{ email }}
      </li>
    </ul>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      loading: false,
      users: null,
      error: null,
    };
  },

  created() {
    this.fetchData();
  },

  methods: {
    fetchData() {
      this.error = this.users = null;
      this.loading = true;

      axios
        .get('/api/users')
        .then(response => {
          this.loading = false;
          this.users = response.data.data;
        })
        .catch(error => {
          this.loading = false;
          this.error = error.response.data.message || error.message;
        });
    }
  }


}
</script>
