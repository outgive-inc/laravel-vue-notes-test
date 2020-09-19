<template>
  <card :title="$t('home')">
    {{ $t('you_are_logged_in') }}

    <div class="notes-nav"><a href="/notes"><fa icon="pencil-alt"/> My Notes</a></div>
  </card>
</template>

<script>
export default {
  middleware: 'auth',

  metaInfo () {
    return { title: this.$t('home') }
  }
}
</script>
<style lang="scss">
  .notes-nav {
    padding-top: 15px;
    font-size: 29px;

    a {
      color: #000;
    }
  }
</style>
