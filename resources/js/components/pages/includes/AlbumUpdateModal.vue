<template>
    <v-dialog v-model="dialog" width="500">
        <template v-slot:activator="{ on, attrs }">
            <button class="btn btn-action" @click="getAlbum(albumId)" v-bind="attrs" v-on="on">
                <i class="bi bi-pencil-square"></i>
            </button>
        </template>

        <v-card>
            <form @submit.prevent="updateAlbum" class="pb-2 mb-3">
                <v-card-title class="text-h5 grey lighten-2">
                    Update Album
                </v-card-title>

                <v-card-text>

                    <div v-if="errors.length" class="alert alert-danger" role="alert">
                        <ul>
                            <li v-for="error in errors" :key="error.id">{{ error }}</li>
                        </ul>
                    </div>
                    <div class="alert alert-success" v-if="success" role="alert">
                        {{  alertMessage }}
                        </div>

                    <v-text-field
                        label="Title*"
                        v-model="album.title"
                        required
                    ></v-text-field>

                    <v-select
                        :items="users"
                        label="User*"
                        required
                        item-text="name"
                        item-value="id"
                        single-line
                        v-model="album.user_id"
                    ></v-select>

                </v-card-text>

                <v-divider></v-divider>

                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn class="ma-2 btn-action" type="submit" text>
                        Update Album
                    </v-btn>
                    <v-btn color="primary" text @click="closeModal(), clearForm()">
                        Cancel
                    </v-btn>
                </v-card-actions>
            </form>
        </v-card>
    </v-dialog>
</template>

<script>
  export default {
    props: ['albumId'],
    data () {
      return {
        dialog: false,
        alertMessage: '',
        success: false,
        errors: [],
        album: {},
        users: [],
      }
    },
    methods: {
        getAllUsers() {
            this.axios
                .get(`/${this.apiUrl}users`)
                .then(response => {
                    this.users = response.data;
            });
        },
        closeModal() {
            this.dialog = false;
        },
        getAlbum(id) {
            this.errors = [];
            this.isEditing = true;
            this.axios
                .get(`/${this.apiUrl}albums/${id}`)
                .then((response) => {
                    this.album = response.data;
                    this.getAllUsers();
            });
        },
        updateAlbum() {
            this.axios
                .put(`/${this.apiUrl}albums/${this.album.id}`, this.album)
                .then((response) => {
                    this.success = response.data.success;
                    this.alertMessage = response.data.message;
                    this.$emit('onSubmitSuccess');
                })
                .catch((error) => {
                    let err = JSON.parse(JSON.stringify(error.response.data.errors));
                    for (var prop in err) {
                        if ( err.hasOwnProperty(prop) ) {
                            this.errors.push(err[prop][0]);
                        }
                    }
                })
        },
        clearForm() {
            this.errors = [];
            this.success = false;
            this.user = {};
        }
    }

  }
</script>
