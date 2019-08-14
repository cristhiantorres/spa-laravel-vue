<template>
  <div>
    
    <div v-if="message" class="alert">{{ message }}</div>
    
    <div v-if="! loaded" class="spinner-border" role="status">
      <span class="sr-only">Loading...</span>
    </div>

    <form @submit.prevent="onSubmit($event)" v-else>
      
      <div class="form-group">
        <label for="user_name">Name</label>
        <input id="user_name" class="form-control" v-model="user.name" />
      </div>

      <div class="form-group">
        <label for="user_email">Email</label>
        <input id="user_email" class="form-control" type="email" v-model="user.email" />
      </div>

      <div class="form-group">
        <button type="submit" class="btn btn-primary" :disabled="saving">Update</button>
        <button :disabled="saving" class="btn btn-danger" @click.prevent="onDelete($event)">Delete</button>
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
        id: null,
        name: "",
        email: "",
      }
    };
  },

  created() {    
    
    api.find(this.$route.params.id)
    .then((response) => {
      this.loaded = true;
      this.user = response.data.data;      
    })
    .catch((err) => {
       this.$router.push({ name: '404' });
    });;

  },

  methods: {
    onSubmit($event) {
      this.saving = true;

      api.update(this.user.id, { name: this.user.name, email: this.user.email })
        .then((response) => {
          this.message = "User updated";
          setTimeout(() => this.$router.push({ name: 'users.index' }), 2000);
        })
        .catch(error => {
          console.log(error);
          
        })
        .then(_ => this.saving = false);
    },

    onDelete($event) {

      this.saving = true;

      api.delete(this.user.id)
        .then((response) => {
          this.$router.push({ name: 'users.index' });
        });
    }
  }
};
</script>

<style lang="scss" scoped>
  $red: lighten(red, 30%);
  $darkRed: darken($red, 50%);

  .form-group label {
    display: block; 
  }

  .alert {
    background: $red;
    color: $darkRed;
    padding: 1rem;
    margin-bottom: 1rem;
    width: 50%;
    border: 1px solid $darkRed;
    border-radius: 5px;
  }
</style>