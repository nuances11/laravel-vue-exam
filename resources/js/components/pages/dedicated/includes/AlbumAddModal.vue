<template>
    <div class="text-md-end text-sm-start">
        <v-dialog v-model="dialog" width="500">
            <template v-slot:activator="{ on, attrs }">
                <v-btn
                    class="ma-2 btn-action"
                    v-bind="attrs"
                    v-on="on"
                    @click="getUserDetails(userId)"
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
                                :value="user.name"
                                label="User"
                                disabled
                            ></v-text-field>

                            <v-text-field
                                label="Title*"
                                v-model="album.title"
                                required
                            ></v-text-field>

                    </v-card-text>

                    <v-divider></v-divider>

                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn class="ma-2 btn-action" type="submit" text>
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
    props: ['userId'],
    data () {
      return {
        dialog: false,
        album: {},
        alertMessage: '',
        success: false,
        errors: [],
        user: {},
      }
    },
    created() {

    },
    methods: {
        getUserDetails(id) {
            this.axios
                .get(`/${this.apiUrl}users/${id}`)
                .then((response) => {
                    this.user = response.data;

            });
        },
        closeModal() {
            this.dialog = false;
        },
        addAlbum() {
            this.album.user_id = this.user.id;
            this.axios
                .post(`/${this.apiUrl}albums`, this.album)
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
