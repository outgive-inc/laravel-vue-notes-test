<template>
  <div class="container">
    <div class="border border-info col-lg-12 mt-3 p-3">
      <ul>
        <li v-for="error in errors" :key="error">{{ error[0] }}</li>
      </ul>
      <form class="edit-form">
        <div class="header">Update Note</div>
        <div class="form-group">
          <input
            type="text"
            class="title form-control"
            v-model="title"
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
          <button type="button" class="btn btn-info">
            <fa icon="save" /><span class="action-btn" v-on:click="onSubmit"
              >Save</span
            >
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
import router from "~/router";

export default {
  data() {
    return {
      id: "",
      title: "",
      content: "",
      errors: "",
      isLoading: false,
      success:'',
        isShow: false,
    };
  },
  created() {
    this.id = this.$route.params.id;
  },
  methods: {
    onSubmit() {
      this.isLoading = true;
      this.postNotes();
    },
    async postNotes() {
      axios.post("/api/notes/update/" + this.id, this.$data)
        .then((response) => {
          if (response.data.error) {
            this.errors = response.data.error;
            this.isLoading = false;
          } else {
            (this.isShow = true), (this.success = "Note created successfully!");
            setInterval(() => {
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
  mounted() {
    axios.get("/api/notes/edit/" + this.id).then((response) => {
      this.title = response.data.title;
      this.content = response.data.content;
      this.id = response.data.id;

    });
  },
};
</script>
