<template>
    <div class="navbar navbar-expand-lg navbar-light bg-light mb-4">
        <router-link :to="{name: 'home'}" class="navbar-brand">
            <img src="../../../../../public/img/GGLAN.png" alt="GG-LAN" style="width: 130px;">
        </router-link>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarDropdown" aria-controls="navbarDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarDropdown">
            <ul class="navbar-nav">
                <li class="nav-item" v-for="(nav, key) in navs" :key="key" :class="{ 'active':nav.name.includes($route.name.split('.')[0]) }">
                    <router-link :to="{name: nav.name}" class="nav-link">
                        <b>{{ nav.title }}</b>
                    </router-link>
                </li>
            </ul>
            
            <ul class="navbar-nav ml-auto">
                <li class="list-inline-item">
                    <a href="https://www.instagram.com/gglanbrest" target="_blank">
                        <img src="../../../../../public/img/instagram.png" alt="Instagram" style="height: 35px;">
                    </a>
                </li>
                <li class="list-inline-item">
                    <a href="https://twitter.com/GGLanBrest" target="_blank">
                        <img src="../../../../../public/img/twitter.png" alt="Twitter" style="height: 35px;">
                    </a>
                </li>

                <li class="list-inline-item">
                    <a href="https://www.facebook.com/GGLANBREST/" target="_blank">
                        <img src="../../../../../public/img/facebook.png" alt="Facebook" style="height: 35px;">
                    </a>
                </li>

                <li class="list-inline-item">
                    <a href="https://discord.gg/mApqnDW" target="_blank">
                        <img src="../../../../../public/img/discord.png" alt="Discord" style="height: 35px;">
                    </a>
                </li>
                <li class="nav-item" v-if="user">
                     <a id="navbarDropdown" class="nav-link dropdown-toggle " href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <b> {{ user.pseudo }} </b> <span class="caret"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <router-link :to="{name: 'player.show', params: {id: user.id}}" class="dropdown-item font-weight-bold">
                            <i class="fas fa-cog"></i>
                            Profil
                        </router-link>
                        
                        <a href="/admin" class="dropdown-item font-weight-bold" v-if="isAdmin">
                            <i class="fas fa-user-shield"></i>
                            Admin
                        </a>
                        
                        <div class="dropdown-divider"></div>

                        <a href="#" class="dropdown-item text-danger font-weight-bold" @click="logout()">
                            <i class="fas fa-sign-out-alt"></i>
                            Déconnexion
                        </a>
                    </div>
                </li>

                <li class="nav-item" v-show="!user">
                    <router-link :to="{name: 'login'}" class="nav-link">
                        Connexion
                    </router-link>                
                </li>
                <li v-show="!user">
                    <router-link :to="{name: 'register'}" class="btn btn-danger">
                        <i class="fas fa-sign-in-alt"></i>
                        Inscription
                    </router-link>
                </li>
                <li class="nav-item">
                
                </li>
                <li class="nav-item">
                
                </li>
            </ul>

        </div>
    </div>
</template>
<script>
export default {
        data() {
            return {
                loading: false,
                authenticated: auth.check(),
                user: null,
                navs: [
                    {name: 'players', title:'Joueurs',},
                    {name: 'teams', title:'Equipes',},
                    {name: 'tournaments', title: "Inscription aux tournois"},
                    {name: 'rules', title:'Règlement',},
                ]
            }
        },

        methods: {
            getUser() {
                axios.get('/api/user')
                .then(response => {
                    this.user = response.data
                })
            },

            logout() {
                this.loading = true
                axios.get('/api/logout')
                .then(response => {
                    this.loading = false
                    this.$router.push( {name: 'home'} )
                })
                .catch(() => {
                    this.loading = false
                })

                auth.logout()

                this.user = null
            }
        },

        mounted() {
            if (this.authenticated) {
                this.user = this.getUser()
            }
        },

        computed: {
            isAdmin() {
                if (this.authenticated) {
                    if (this.user && this.user.admin) {
                        return true
                    }
                    return false
                }
            }
        }
    }
</script>

<style>

</style>
