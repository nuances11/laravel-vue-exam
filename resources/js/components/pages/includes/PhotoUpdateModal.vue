<template>
    <v-dialog v-model="dialog" width="500">
        <template v-slot:activator="{ on, attrs }">
            <button class="btn btn-action" @click="getPhoto(photoId)" v-bind="attrs" v-on="on">
                <i class="bi bi-pencil-square"></i>
            </button>
        </template>

        <v-card>
            <form @submit.prevent="updatePhoto" class="pb-2 mb-3">
                <v-card-title class="text-h5 grey lighten-2">
                    Update Photo
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
                        Update Photo
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
    props: ['photoId'],
    data () {
      return {
        dialog: false,
        alertMessage: '',
        success: false,
        errors: [],
        albums: [],
        photo: {}
      }
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
        getPhoto(id) {
            this.errors = [];
            this.isEditing = true;
            this.axios
                .get(`${this.apiUrl}photos/${id}`)
                .then((response) => {
                    this.photo = response.data;
                    this.getAllAlbums()
            });
        },
        updatePhoto() {
            this.axios
                .put(`${this.apiUrl}photos/${this.photo.id}`, this.photo)
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
