<template>
  <div class="new-note-container">
    <form class="add-form" @submit.prevent="onSubmit">
      <div class="header">New Note</div>
      <div class="form-group">
        <input v-model="title" type="text" class="title form-control" required/>
      </div>
      <div class="form-group">      
        <textarea v-model="content" class="form-control" rows="10" id="content" required>
        </textarea>
      </div>
      <div class="btn-grp">
        <a href="/notes">
          <button type="button" class="btn btn-danger">
            <fa icon="times"/><span class="action-btn">{{$t('cancel')}}</span>
          </button>
        </a>
        <button type="button" class="btn btn-success button is-primary" v-on:click="onSubmit">
          <fa icon="save"/><span class="action-btn">Save</span>
        </button>
      </div>
    </form>
  </div>
</template>

<script>
import axios from 'axios'
import { mapGetters } from "vuex";

export default {
    data() {
        return {
            title: '',
            content: '',
            errors: '',
            isLoading: false
        }
    },
    methods: {
        onSubmit() {
          console.log("this submits");
            this.isLoading = true
            this.postNotes()
        },
        async postNotes() {
            axios.post("/api/notes/add", this.$data)
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
    }
}
</script>
<style lang="scss">
  .new-note-container {
    font-family: Trebuchet MS;
    color: #000;

    .header {
      padding-bottom: 20px;
      font-size: 30px;

    }

    .add-form {
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
  }
</style>
