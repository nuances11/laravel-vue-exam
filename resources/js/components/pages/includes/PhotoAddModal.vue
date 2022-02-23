<template>
    <div class="text-md-end text-sm-start">
        <v-dialog v-model="dialog" width="500">
            <template v-slot:activator="{ on, attrs }">
                <v-btn
                    class="ma-2 btn-action"
                    v-bind="attrs"
                    v-on="on"
                >
                    Add Photo
                </v-btn>
            </template>

            <v-card>
                <form @submit.prevent="addPhoto" class="pb-2 mb-3">
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
                        <v-select
                            :items="albums"
                            label="Album*"
                            required
                            item-text="title"
                            item-value="id"
                            single-line
                            v-model="photo.album_id"
                        ></v-select>

                        <v-text-field
                            label="Title*"
                            v-model="photo.title"
                            required
                        ></v-text-field>

                        <v-text-field
                            label="URL*"
                            v-model="photo.url"
                            required
                            type="url"
                        ></v-text-field>

                        <v-text-field
                            label="Thumbnail URL*"
                            v-model="photo.thumbnailUrl"
                            required
                            type="url"
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
    data () {
      return {
        dialog: false,
        photo: {},
        alertMessage: '',
        success: false,
        errors: [],
        albums: []
      }
    },
    created() {
        this.getAllAlbums()
    },
    methods: {
        getAllAlbums() {
            this.axios
                .get(`${this.apiUrl}albums`)
                .then(response => {
                    this.albums = response.data;
            });
        },
        closeModal() {
            this.dialog = false;
        },
        addPhoto() {
            this.axios
                .post(`${this.apiUrl}photos`, this.photo)
                .then((response) => {
                    this.success = response.data.success;
                    this.alertMessage = response.data.message;
                    this.$emit('onSubmitSuccess');
                    this.photo = {};
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
