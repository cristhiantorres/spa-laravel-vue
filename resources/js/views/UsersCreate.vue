<template>
  <div>
    
    <div v-if="message" class="alert">{{ message }}</div>
    
    <form @submit.prevent="onSubmit($event)" v-else>
      
      <div class="form-group">
        <label for="user_name">Name</label>
        <input id="user_name" class="form-control" v-model="user.name"/>
      </div>

      <div class="form-group">
        <label for="user_email">Email</label>
        <input id="user_email" class="form-control" type="email" v-model="user.email"/>
      </div>

      <div class="form-group">
        <label for="user_password">Password</label>
        <input id="user_password" class="form-control" type="password" v-model="user.password"/>
      </div>

      <div class="form-group">
        <button type="submit" class="btn btn-primary" :disabled="saving">
          {{ saving ? 'Creating...' : 'Create' }}
        </button>
      </div>

    </form>
  </div>
</template>

<script>
import api from '../api/users';

export default {
  data() {
    return {
      loaded: false,
      message: null,
      saving: false,
      user: {
        name: "",
        email: "",
        password: "",
      }
    };
  },

  methods: {
    onSubmit($event) {
      this.saving = true;

      api.create(this.user)
        .then((response) => {
          this.$router.push({ name: 'users.edit', params: { id: response.data.data.id } });
        })
        .catch(error => {
          this.message = error.response.data.message || 'There was an issue creating the user.';          
        })
        .then(_ => this.saving = false);
    }
  }
};
</script>