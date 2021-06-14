<template>
  <div class="container">
    <div class="border border-info col-lg-12 mt-3 p-3">
       <ul>
      <li v-for="error in errors" :key="error">{{ error[0] }}</li>
    </ul>
      <form class="add-form" @submit.prevent="onSubmit">
        <div class="header">New Note</div>
        <div class="form-group">
          <input
            v-model="title"
            type="text"
            class="title form-control"
            required
          />
        </div>
        <div class="form-group">
          <textarea
            v-model="content"
            class="form-control"
            id="content"
            required
          >
          </textarea>
        </div>
        <div class="btn-grp">
          <a href="/notes">
            <button type="button" class="btn btn-secondary">
              <fa icon="times" /><span class="action-btn">{{
                $t("cancel")
              }}</span>
            </button>
          </a>
          <button
            type="button"
            class="btn btn-info"
            v-on:click="onSubmit">
            <fa icon="save" /><span class="action-btn">Save</span>
          </button>
          <span v-if="isShow" class="alert-success m-3 p-2">{{ success }}</span>
        </div>
        
      </form>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import { mapGetters } from "vuex";

export default {
  data() {
    return {
      title: "",
      content: "",
      errors: "",
      isLoading: false,
       success:'',
        isShow: false,
    };
  },
  methods: {
    onSubmit() {
      this.isLoading = true;
      this.postNotes();
    },
    async postNotes() {
      axios
        .post("/api/notes/add", this.$data)
        .then((response) => {
          if(response.data.error){
              this.errors = response.data.error;
              this.isLoading = false;
            
          }else{
            this.isShow = true,
            this.success = "Note created successfully!";
            setInterval(() => {
              this.success = "";
              this.isShow = false;
              this.name = "";
              this.isLoading = false;
              this.$emit("completed", response.data.data);
              this.$router.push({ name: "notes" }); 
            }, 4000);
          }
        })
        .catch((error) => {
          this.errors = error.response.data.errors;
          this.isLoading = false;
        });
    },
  },
};
</script>

