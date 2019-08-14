<template>
  <div class="users">
    
    <div v-if="! users" class="spinner-border" role="status">
      <span class="sr-only">Loading...</span>
    </div>

    <div class="error" v-if="error">
      {{ error }}
      <p>
        <button @click.prevent="fetchData">
          Try again
        </button>
      </p>
    </div>
    <table v-if="users" class="table table-sm table-bordered">
      
      <thead class="thead-dark">
        <th>Name</th>
        <th>Email</th>
        <th></th>
      </thead>

      <tbody>
        <tr v-for="{ id, name, email } in users" :key="id">
          <td>{{ name }}</td>
          <td>{{ email }}</td>
          <td>
            <router-link :to="{ name: 'users.edit', params: { id } }">Edit</router-link>
          </td>
        </tr>
      </tbody>
    </table>

    <div class="pagination">
      <button :disabled="!prevPage" class="btn btn-primary" @click.prevent="goToPrev">Previous</button>
      <span class="m-2">{{ paginationCount }}</span>
      <button :disabled="!nextPage" class="btn btn-primary" @click.prevent="goToNext">Next</button>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

const getUsers = (page, callback) => {
  const params = { page };

  axios
    .get('/api/users', { params })
    .then(response => {
      callback(null, response.data);
    })
    .catch(error => {
      callback(error, error.response.data);
    });
}

export default {
  data() {
    return {
      loading: false,
      users: null,
      meta: null,
      links: {
        first: null,
        last: null,
        next: null,
        prev: null,
      },
      error: null,
    };
  },

  beforeRouteEnter(to, from, next) {
    
    const params = {
      page: to.query.page
    };

    getUsers(to.query.page, (err, data) => {
      next(vm => vm.setData(err, data));
    });

  },

  beforeRouteUpdate(to, from, next) {
    
    this.users = this.links = this.meta = null;
    
    getUsers(to.query.page, (err, data) => {
      this.setData(err, data);
      next();
    });

  },
  
  computed: {
    nextPage() {
      if (! this.meta || this.meta.current_page === this.meta.last_page) {
        return;
      }
      
      return this.meta.current_page + 1;
    },

    prevPage() {
      if (! this.meta || this.meta.current_page === 1) {
        return;
      }
      return this.meta.current_page - 1;
    },

    paginationCount() {
      if (! this.meta) {
        return;
      }

      const { current_page, last_page } = this.meta;
      
      return `${current_page} of ${last_page}`;
    }
  },

  methods: {
    
    goToNext() {
      
      this.$router.push({
        query: {
          page: this.nextPage,
        },
      });

    },

    goToPrev() {

      this.$router.push({
        name: 'users.index',
        query: {
          page: this.prevPage,
        }
      });

    },

    setData(err, { data: users, links, meta }) {
      if (err) {
        this.error = err.toString();
      } else {
        this.users = users;
        this.links = links;
        this.meta = meta;
      }
    }
  }


}
</script>

