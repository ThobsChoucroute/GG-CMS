<template>
    <div>
        <admin-content-header page_name="Game profile" ></admin-content-header>
        <FlashMessage position="right bottom"></FlashMessage>

        <section class="content">
                <button @click="goToGamesList()" class="btn btn-primary">
                    <i class="fas fa-arrow-left"></i>
                    Return to game list
                </button>
            <div class="row">
                <div class="col-md-3">
                    <!-- Pseudo & Avatar -->
                    <div class="box box-primary">
                        <loader :color="'#337ab7'" v-show="loading"></loader>
                        <div class="box-body box-profile" v-show="!loading">

                            <h3 class="profile-username text-center"> {{ game.name }} </h3>
                            <p class="text-muted text-center">{{ game.description }} </p>

                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a href="#profile" data-toggle="tab">Profile</a>
                            </li>
                            <li>
                                <a href="#ranks" data-toggle="tab">Ranks</a>
                            </li>
                            <li v-show="!loading">
                                <a href="#settings" data-toggle="tab">Settings</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="active tab-pane" id="profile">
                                <h3> Game informations </h3>
                                <loader :color="'#337ab7'" v-show="loading"></loader>

                                <form class="form-horizontal" v-show="!loading">
                                    <!-- Name -->
                                    <div class="form-group">
                                        <label for="name" class="col-sm-2 control-label">Name</label>

                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="name" v-model="game.name" disabled>
                                        </div>
                                    </div>

                                    <!-- Description -->
                                    <div class="form-group">
                                        <label for="description" class="col-sm-2 control-label">Description</label>

                                        <div class="col-sm-10">
                                            <textarea id="description" cols="30" rows="5" class="form-control" style="resize: none;" v-model="game.description" disabled></textarea>
                                        </div>
                                    </div>
                                </form>

                                <hr>
                                <h3> Game players </h3>
                                <loader :color="'#337ab7'" v-show="loading"></loader>

                                <table class="table table-striped table-hover" v-show="!loading">
                                    <thead>
                                        <tr>
                                            <th>Pseudo</th>
                                            <th>Rank</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(player, key) in players" :key="key">
                                            <td> {{ player.pseudo }} </td>
                                            <td> {{ player.rank }} </td>
                                            <td class="text-center">
                                                <router-link :to="{ name: 'player.show', params: {id: player.id} }" class="btn btn-primary">
                                                    <i class="fas fa-eye"></i>
                                                </router-link>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="tab-pane" id="ranks">
                                <div class="box-header">
                                    <h3 class="box-title">
                                        Game ranks
                                    </h3>
                                    <div class="box-tools pull-right">
                                        <router-link :to="{ name: 'rank.create'}" class="btn btn-success">
                                            <i class="fas fa-plus"></i>
                                            Add
                                        </router-link>
                                    </div>
                                </div>

                                <AdminDataTable :data="ranks" :columns="ranksColumns"  :actions="ranksActions" :index="false" :loading="loading"></AdminDataTable>
                                <!-- <loader :color="'#337ab7'" v-show="loading"></loader>
                                <table class="table table-striped table-hover" v-show="!loading">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Image</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(rank, key) in ranks" :key="key">
                                            <td> {{ rank.name }} </td>
                                            <td> 
                                                <img :src="rank.image" alt="No image..." class="img-responsive img-rounded" style="max-width: 150px;">
                                            </td>
                                            <td class="text-center">
                                                <router-link :to="{ name: 'rank.edit', params: {game: game.id, rank : rank.id}}" class="btn btn-success">
                                                    <i class="fas fa-edit"></i>
                                                </router-link>
                                                <button class="btn btn-danger" @click="deleteRank(key)">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table> -->
                            </div>

                            <div class="tab-pane" id="settings">
                                <form @submit.prevent="updateGame()" class="form-horizontal">
                                    <!-- Name -->
                                    <div class="form-group">
                                        <label for="name" class="col-sm-2 control-label">Name</label>

                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="name" placeholder="Name" v-model="game.name" required>
                                        </div>
                                    </div>

                                    <!-- Description -->
                                    <div class="form-group">
                                        <label for="description" class="col-sm-2 control-label">Description</label>

                                        <div class="col-sm-10">
                                            <textarea id="description" cols="30" rows="5" class="form-control" style="resize: none;" v-model="game.description" required></textarea>
                                        </div>
                                    </div>

                                    <!-- Places -->
                                    <div class="form-group">
                                        <label for="places" class="col-sm-2 control-label">Places</label>

                                        <div class="col-sm-10">
                                            <input type="number" min="1" step="1" class="form-control" id="places" placeholder="places" v-model="game.places" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <button type="submit" class="btn btn-success">
                                                <i class="fas fa-sync fa-spin" v-show="loading"></i>
                                                <i class="fas fa-check" v-show="!loading"></i>
                                                Update
                                            </button>

                                            <button type="button" class="btn btn-danger" @click="deleteGame()">
                                                <i class="fas fa-sync fa-spin" v-show="loading"></i>
                                                <i class="fas fa-trash-alt" v-show="!loading"></i>
                                                Delete
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
import AdminContentHeader from './../../layouts/AdminContentHeader'
import Loader from 'vue-spinner/src/ScaleLoader.vue'

export default {
    components: {
        AdminContentHeader,
        Loader
    },

    data() {
        return {
            loading: false,
            game: {},
            players: [],
            ranks: [],
            ranksColumns: [
                {name: 'name', th: 'Name'},
                {name: 'image', th: 'Image', render(row, cell, index) {
                    return '<img src="' + row.image + '" alt="No image..." class="img-responsive img-rounded" style="max-width: 150px;">'
                }},
            ],
            ranksActions: [
                {text: "", icon: "fas fa-edit", color: "success margin-right-2", action: (row, index) => {
                    this.$router.push({ name: 'rank.edit', params: {game: this.game.id, rank : row.id}})
                }},
                {text: "", icon: "fas fa-trash", color: "danger mr-2", action: (row, index) => {
                    this.deleteRank(index)
                }},
            ],
        }
    },

    methods: {
        // Go back to the previous page
        goToGamesList() {
            this.$router.push({name: 'games'});
        },

        // Get game
        getGame() {
            this.loading = true
            let id = this.$route.params.id

            axios.get('/api/games/' + id)
            .then(response => {
                this.loading = false
                this.game = response.data
            })
        },

        // Get game players
        getPlayers() {
            this.loading = true
            let id = this.$route.params.id

            axios.get('/api/games/' + id + '/players')
            .then(response => {
                this.loading = false
                this.players = response.data
            })
        },

        // Get game ranks
        getRanks() {
            this.loading = true
            let id = this.$route.params.id

            axios.get('/api/games/' + id + '/ranks')
            .then(response => {
                this.ranks = response.data
                this.loading = false
            })
        },

        // Update game
        updateGame() {
            this.loading = true;
            let id = this.$route.params.id

            axios.put('/api/games/' + id, this.game)
            .then(response => {
                this.loading = false;
                this.games = response.data
                this.flashMessage.success({
                    title: "Game updated !",
                    message: "The game has been successfully updated"
                })
            })
            .catch(e => {
                this.loading = false;
                this.flashMessage.error({
                    title: "You didn't change any fields !",
                    message: "You have to change a least one field to update the game"
                })
            })
        },

        // Delete game
        deleteGame() {
            if (confirm("Are you sure you want to delete this game ? It's definitive")) {
                let id = this.$route.params.id

                axios.delete('/api/games/' + id)
                .then(response => {
                    this.loading = false;
                    this.flashMessage.success({
                        title: "Game deleted !",
                        message: "The game has been successfully deleted"
                    })
                    this.goToGamesList();
                })
                .catch(e => {
                    this.loading = false
                    this.flashMessage.error({
                        title: "Something went wrong",
                        message: "Please try again"
                    })
                })              
            }
        },

        // Delete game rank
        deleteRank(key) {
            let rank = this.ranks[key]
            let id = this.$route.params.id
            if (confirm("Are you sure you want to delete this rank ? It's definitive")) {
                this.loading = true

                axios.delete('/api/games/' + id + '/ranks/' + rank.id)
                .then(response => {
                    this.flashMessage.success({
                        title: 'Rank deleted !',
                        message: 'The rank has been successfully deleted'
                    })
                    
                    this.ranks.splice(key, 1);
    
                    this.loading = false
                })
                .catch(e => {
                    this.flashMessage.error({
                        title: "Something went wrong",
                        message: "Please try again"
                    })
    
                    this.loading = false
                })
            }
        }
    },

    mounted() {
        this.getGame()
        this.getPlayers()
        this.getRanks()
    }
}
</script>

<style>

</style>
