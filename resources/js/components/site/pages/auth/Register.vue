<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4 text-center mx-auto">
                <h1>Inscription</h1>
                <form @submit.prevent="register()">

                    <!-- Email -->
                    <div class="form-group">
                        <div class="input-group input-group-lg">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                            </div>
                            <input type="email" name="email" class="form-control" :class=" { 'is-invalid' : error } " v-model="user.email" placeholder="Email" required>
                            <div class="invalid-feedback" v-show="error">
                                Mauvais identifiants
                            </div>
                        </div>
                    </div>

                    <!-- Name -->
                    <div class="form-group">
                        <div class="input-group input-group-lg">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-signature"></i></span>
                            </div>
                            <input type="text" name="name" class="form-control" :class=" { 'is-invalid' : error } " v-model="user.name" placeholder="Nom + prénom" required>
                            <div class="invalid-feedback" v-show="error">
                                Mauvais identifiants
                            </div>
                        </div>
                    </div>

                    <!-- Birth Date -->
                    <div class="form-group">
                        <div class="input-group input-group-lg">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-birthday-cake" title="Birth Date"></i></span>
                            </div>
                            <input type="date" name="birth_date" class="form-control" :class=" { 'is-invalid' : error } " v-model="user.birth_date" required>
                            <div class="invalid-feedback" v-show="error">
                                Mauvais identifiants
                            </div>
                        </div>
                    </div>

                    <!-- Pseudo -->
                    <div class="form-group">
                        <div class="input-group input-group-lg">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-headset"></i></span>
                            </div>
                            <input type="text" name="pseudo" class="form-control" :class=" { 'is-invalid' : error } " v-model="user.pseudo" placeholder="Pseudo" required>
                            <div class="invalid-feedback" v-show="error">
                                Mauvais identifiants
                            </div>
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <div class="input-group input-group-lg">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-unlock"></i></span>
                            </div>

                            <input type="password" name="password" class="form-control" :class=" { 'is-invalid' : error } " v-model="user.password" placeholder="Mot de passe" required>
                            <input type="password" name="password_confirmation" class="form-control" :class=" { 'is-invalid' : error } " v-model="user.password_confirmation" placeholder="Confirmation mot de passe" required>
                            <div class="invalid-feedback" v-show="error">
                                Mauvais identifiants
                            </div>
                        </div>
                    </div>

                    <div class="form-group text-left">
                        <input type="checkbox" name="rulesCheck" :class=" { 'is-invalid' : error }" required>
                        <label for="rulesCheck">
                            J'ai lu et accepte le 
                            <router-link class="text-weight-bold" :to="{name: 'rules'}" target="_blank">règlement</router-link>
                        </label>
                        <div class="invalid-feedback" v-show="error">
                           Vous devez lire le réglèment avant de vous inscrire
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-success text-center" :disabled="loading">
                            M'inscrire
                            <b-spinner small variant="dark" label="Loading" v-show="loading"></b-spinner>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            error: false,
            loading: false,

            user: {
                email: '',
                name: '',
                pseudo: '',
                birth_date: '',
                password: '',
                password_confirmation: '',
            }
        };
    },

    methods: {
        register() {
            this.loading = true
            this.error = false

            axios.post('/api/register', this.user)
            .then(response => {
                this.loading = false
                auth.login(response.data.token)
                window.location.href = '/'
            })
            .catch(response => {
                this.loading = false
                this.error = true
            });
        }
    }
}
</script>