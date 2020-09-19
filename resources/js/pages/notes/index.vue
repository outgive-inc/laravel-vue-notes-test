<template>
  <div class="notes-container">
    <h1>Notes</h1>
    <div class="row">
      <div class="note-card col-xs-12 col-md-5" v-for="(item) in results" :key="item.id">
        <a :href="'/notes/view/'+ item.id">
          <div class="title">{{item.title}}</div>
          <div class="content">
            {{item.content}}
          </div>
        </a>
        <div class="footer">
          <button type="button" class="btn btn-light footer-btn" v-on:click="onDelete(item.id)"><fa class="delete-icon" icon="trash"/></button>
          <a :href="'/notes/edit/'+ item.id">
            <button type="button" class="btn btn-light footer-btn"><fa class="edit-icon" icon="pencil-alt"/></button>
          </a>
          <span class="created">{{item.created_at}}</span>
        </div>
      </div>
    </div>
    <a class="add" href="/notes/add">
      <div class="add-btn">
      <fa icon="plus"/>
      </div>
    </a>
  </div>
</template>

<script>
import axios from 'axios'
import { mapGetters } from "vuex";

export default {
  data: function(){
    return {
      results: []
    }
  },
  mounted() {
    axios.get("/api/notes")
    .then(response => {
        this.results = response.data;
    })
  },
  methods: {
    onDelete(id) {
      this.isLoading = true
      if (confirm('Are you sure you want to delete this note?')) {
        this.deleteNotes(id)
      }
    },
    async deleteNotes(id) {
      axios.delete("/api/notes/delete/"+id)
        .then(response => {
            window.location.reload();
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
.notes-container {
  .note-card {
    background: #67AAF9;
    border-radius: 10px;
    box-shadow: 0px 3px 15px rgba(0,0,0,0.2);
    color: #fff;
    font-family: Trebuchet MS;
    margin: 10px;
    padding: 20px;
    height: 180px;

    a {
      color: #fff;
      text-decoration: none;
    }

    .title {
      font-size: 25px;
      font-weight: 500;
      padding-bottom: 12px;
    }

    .content {
      font-size: 16px;
    }

    .title, .content {
      overflow: hidden;
      white-space: nowrap;
      text-overflow: ellipsis;
    }

    .footer {
      padding-top: 30px;

      .footer-btn {
        border-radius: 50%;

        .delete-icon, .edit-icon {
          color: #999;
        }
      }

      .created {
        float: right;
        padding: 7px 8px;
      }
    }
  }

  .add {
    color: #000;

    .add-btn {
      background: #9BBDF9;
      border-radius: 50%;
      bottom: 5%;
      font-size: 20px;
      padding: 12px 20px;
      position: absolute;
      right: 5%;

      @media only screen and (min-width: 1200px) {
        font-size: 25px;
        padding: 20px 30px;
      }
    }
  }
}
</style>
