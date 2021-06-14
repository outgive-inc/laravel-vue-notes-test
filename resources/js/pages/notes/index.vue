<template>
  <div class="notes-container">
    <a class="add" href="/notes/add"><div class="btn btn-info"><fa icon="plus"/></div>
    </a>
    
    <h1>Notes</h1>
    <nav aria-label="Page navigation example">
        <ul class="pagination">
          <li v-bind:class="[{ disabled: !pagination.prev_page_url }]" class="page-item">
            <a class="page-link" @click="fetchNotes(pagination.prev_page_url)" >Previous</a>
          </li>

          <li class="page-item disabled">
            <a class="page-link text-dark" href="#">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a>
          </li>

          <li v-bind:class="[{ disabled: !pagination.next_page_url }]" class="page-item">
            <a class="page-link" @click="fetchNotes(pagination.next_page_url)" >Next</a>
          </li>
        </ul>
      </nav>
    <div class="row">
      <div class="note-card col-xs-12 col-md-3" v-for="(item) in results" :key="item.id">
        <a :href="'/notes/view/'+ item.id">
          <h3>{{item.title}}</h3>
          <p>{{item.content}}</p>
          
        </a>
        <div class="footer">
          <button type="button" class="btn btn-secondary rounded" v-on:click="onDelete(item.id)"><fa class="delete-icon" icon="trash"/></button>
          <a :href="'/notes/edit/'+ item.id">
            <button type="button" class="btn btn-success rounded"><fa class="edit-icon" icon="pencil-alt"/></button>
          </a>
          <span class="created">{{item.created_at}}</span>
        </div>
      </div>
    </div>
    
  </div>
</template>

<script>
import axios from 'axios'
import { mapGetters } from "vuex";

export default {
  data: function(){
    return {
      results: [],
      pagination: {}
    }
  },
  mounted() {
    axios.get("/api/notes")
    .then(response => {
        this.results = response.data.data;
       
        let pagination = {
        current_page: response.data.current_page,
        last_page: response.data.last_page,
        next_page_url: response.data.next_page_url,
        prev_page_url: response.data.prev_page_url,
        
      };
      this.pagination = pagination; 
    })
  },
  methods: {
    fetchNotes(page_url){
      page_url = page_url || "/api/notes";
      axios.get(page_url)
      .then(response => {
        this.results = response.data.data;
        let pagination = {
        current_page: response.data.current_page,
        last_page: response.data.last_page,
        next_page_url: response.data.next_page_url,
        prev_page_url: response.data.prev_page_url,
      };
      this.pagination = pagination; 
      })
    },
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
    background: #fff;
    border-radius: 10px;
    box-shadow: 0px 3px 15px rgba(0,0,0,0.2);
    color: #fff;
    font-family: Trebuchet MS;
    margin: 10px;
    padding: 20px;
    height: 180px;

    a {
      color: #111;
      text-decoration: none;
    }

  }
  
  .page-link:hover{
      cursor: pointer;
    }
}
</style>
