<template>
  <form class="edit-form">
    <div class="form-group">
      <input type="text" class="title form-control" v-model="title" required/>
    </div>
    <div class="form-group">      
      <textarea  v-model="content" class="form-control" rows="10" id="content" required>
      </textarea>
    </div>
    <div class="btn-grp">
      <a href="/notes">
        <button type="button" class="btn btn-danger">
          <fa icon="times"/><span class="action-btn">{{$t('cancel')}}</span>
        </button>
      </a>
      <button type="button" class="btn btn-success">
        <fa icon="save"/><span class="action-btn"  v-on:click="onSubmit">Save</span>
      </button>
    </div>
  </form>
</template>


<script>
import axios from 'axios'
import { mapGetters } from "vuex";
import router from '~/router'

export default {
    data() {
        return {
          id: '',
          title: '',
          content: '',
          errors: '',
          isLoading: false
        }
    },
    created() {
        this.id = this.$route.params.id;
    },
    methods: {
        onSubmit() {
          this.isLoading = true
          this.postNotes()
        },
        async postNotes() {
            axios.post("/api/notes/update/"+this.id, this.$data)
                .then(response => {
                    this.name = ''
                    this.isLoading = false
                    this.$emit('completed', response.data.data)
                    this.$router.push({ name: 'notes' })
                })
                .catch(error => {
                    // handle authentication and validation errors here
                    this.errors = error.response.data.errors
                    this.isLoading = false
                })
        }
    },
    mounted() {
      axios.get("/api/notes/edit/"+this.id)
      .then(response => {
          this.title = response.data.title;
          this.content = response.data.content;
          this.id = response.data.id;
          console.log(this.results);
        
        })
    }
}
</script>
<style lang="scss">
  .edit-form {
    font-family: Trebuchet MS;
    margin: 10px;
    padding: 20px;

    .title {
      font-size: 25px;
      font-weight: 500;
      padding-bottom: 12px;
    }

    .content {
      font-size: 16px;
    }

    .btn-grp {
      float: right;

      .btn {
        margin-left: 10px;

        .action-btn {
          padding-left: 5px;
        }
      }
    }
  }
</style>
