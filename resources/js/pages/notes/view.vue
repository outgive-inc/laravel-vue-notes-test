<template>
  <div class="view-container">
    <div class="notes">
      <div class="title">{{title}}</div>
      <div class="content">{{content}}</div>
    </div>
    <a class="action-btns" :href="'/notes/edit/'+id">
      <div class="edit-btn action">
        <fa icon="pencil-alt"/>
      </div>
    </a>
    <a class="action-btns" href="/notes">
      <div class="back-btn action">
        <fa icon="arrow-left"/>
      </div>
    </a>
  </div>
</template>
<script>
import axios from 'axios'
import { mapGetters } from "vuex";

import router from '~/router'

export default {
  data: function(){
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
  mounted() {
    axios.get("/api/notes/edit/"+this.id)
    .then(response => {
      this.title = response.data.title;
      this.content = response.data.content;
      this.id = response.data.id;
    })
  }
}
</script>
<style lang="scss">
  .view-container {
    font-family: Trebuchet MS;
    color: #000;

    .title {
      font-size: 25px;
      font-weight: 500;
      padding-bottom: 25px;
    }

    .content {
      font-size: 16px;
      color: #696969;
    }

    .action-btns {
      color: #000;

      .action {
        background: #9BBDF9;
        border-radius: 50%;
        bottom: 5%;
        font-size: 20px;
        padding: 12px 20px;
        position: absolute;
        right: 5%;

        &.edit-btn {
          right: 10%;
        }

        @media only screen and (min-width: 1200px) {
          font-size: 25px;
          padding: 20px 30px;
        }
      }
    }
  }
</style>
