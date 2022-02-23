<template>
    <div class="text-md-end text-sm-start">
        <v-dialog v-model="dialog" width="500">
            <template v-slot:activator="{ on, attrs }">
                <v-btn
                    class="ma-2 btn-action"
                    v-bind="attrs"
                    v-on="on"
                >
                    Add Album
                </v-btn>
            </template>

            <v-card>
                <form @submit.prevent="addAlbum" class="pb-2 mb-3">
                    <v-card-title class="text-h5 grey lighten-2">
                        Add Album
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
                        <v-btn color="secondary" type="submit" text>
                            Add Album
                        </v-btn>
                        <v-btn color="primary" text @click="closeModal(), clearForm()">
                            Cancel
                        </v-btn>
                    </v-card-actions>
                </form>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
  export default {
    data () {
      return {
        dialog: false,
        album: {},
        alertMessage: '',
        success: false,
        errors: [],
        users: []
      }
    },
    created() {
        this.getAllUsers()
    },
    methods: {
        getAllUsers() {
            this.axios
                .get(`${this.apiUrl}users`)
                .then(response => {
                    this.users = response.data;
            });
        },
        closeModal() {
            this.dialog = false;
        },
        addAlbum() {
            this.axios
                .post(`${this.apiUrl}albums`, this.album)
                .then((response) => {
                    this.success = response.data.success;
                    this.alertMessage = response.data.message;
                    this.$emit('onSubmitSuccess');
                    this.album = {};
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
            this.album = {};
        }
    }

  }
</script>
