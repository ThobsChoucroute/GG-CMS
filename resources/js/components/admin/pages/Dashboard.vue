<template>
    <div>
        <FlashMessage position="right bottom"></FlashMessage>
        <admin-content-header page_name="Tableau de bord" page_description=""></admin-content-header>

        <section class="content">
            <div class="row">
                <players-stat-box timer="120000"></players-stat-box>
                <teams-stat-box timer="120000"></teams-stat-box>
                <!-- <posts-stat-box timer="120000"></posts-stat-box> -->
                <new-players-stat-box timer="120000"></new-players-stat-box>
                <tournaments-average-filling-stat-box></tournaments-average-filling-stat-box>
                <!-- <tournaments-days-left-stat-box timer="120000"></tournaments-days-left-stat-box> -->
            </div>
            
            <div class="row">
                <teams-percentage-stat></teams-percentage-stat>
                <players-per-games-stat></players-per-games-stat>
                <tournaments-teams-percentage-stat></tournaments-teams-percentage-stat>
                <tournaments-days-left-stat></tournaments-days-left-stat>
            </div>
        </section>
    </div>
</template>

<script>
import AdminContentHeader from './../layouts/AdminContentHeader'

export default {
    components: {
        AdminContentHeader,
  },

  data() {
      return {
      }
  },

  methods: {

  },
}
</script>

<style>

</style>
