<template>
    <header class="main-header">
        <router-link :to="{name: 'index'}" class="logo">
            <span class="logo-mini">
                <b> {{ app_name_mini }} </b>
            </span>
            <span class="logo-lg">
                <b> {{ app_name }} </b>    
            </span>
        </router-link>
        <nav class="navbar navbar-static-top">
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>

            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- Messages -->
                    <!-- <li class="dropdown messages-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-envelope-o"></i>
                            <span class="label label-success">4</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">You have 4 messages</li>
                            <li>
                                <ul class="menu">
                                    <li>
                                        <a href="#">
                                        <div class="pull-left">
                                            <img :src="user.avatar" class="img-circle" alt="User Image">
                                        </div>
                                        <h4>
                                            Support Team
                                            <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                        </h4>
                                        <p>Why not buy a new awesome theme?</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="footer"><a href="#">See All Messages</a></li>
                        </ul>
                    </li> -->

                    <!-- Notifications -->
                    <!-- <li class="dropdown notifications-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-bell-o"></i>
                            <span class="label label-warning">10</span>
                        </a>

                        <ul class="dropdown-menu">
                            <li class="header">You have 10 notifications</li>
                            <li>
                                <ul class="menu">
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-users text-aqua"></i> 5 new members joined today
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="footer"><a href="#">View all</a></li>
                        </ul>
                    </li> -->

                    <!-- User account -->
                    <li class="dropdown user user-menu">
                        <!-- User button avatar -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img :src="user.avatar" class="user-image" alt="User Image">
                            <span class="hidden-xs" v-if="user"> {{ user.pseudo }} </span>
                        </a>

                        <!-- User avatar -->
                        <ul class="dropdown-menu">
                            <li class="user-header">
                                <img :src="user.avatar" class="img-circle" alt="User Image">
                                <p v-if="user"> {{ user.pseudo }} </p>
                            </li>

                            <!-- Menu Footer -->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <router-link :to="{ name: 'player.show', params: {id: user.id} }" class="btn btn-default btn-flat" v-if="user"> Profile </router-link>
                                </div>
                            </li>
                        </ul>

                    </li>
                    
                    <!-- Go back to site -->
                    <li>
                        <a href="/"> <i class="fas fa-sign-out-alt"></i> </a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
</template>

<script>
export default {
    props: [
        'app_name',
        'app_name_mini',
    ],

    data() {
        return {
            authenticated: auth.check(),
            user: null
        }
    },

    methods: {
        getUser() {
            axios.get('/api/user')
            .then(response => {
                this.user = response.data
            })
        },
    },

    mounted() {
        if (this.authenticated) {
            this.user = this.getUser()
        }
    }
}
</script>

<style>

</style>
