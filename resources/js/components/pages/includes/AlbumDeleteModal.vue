<template>
    <v-dialog v-model="dialog" persistent max-width="290">
        <template v-slot:activator="{ on, attrs }">
            <button class="btn btn-action" v-bind="attrs" v-on="on">
                    <i class="bi bi-trash"></i>
            </button>
        </template>
        <v-card>
            <v-card-title class="text-h5">
                Are you sure?
            </v-card-title>
            <v-card-text>
                Data will be deleted permanently.
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="green darken-1" text @click="dialog = false">
                    Cancel
                </v-btn>
                <v-btn color="red darken-1" text @click="deleteAlbum(albumId)">
                    Agree
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
    export default {
        props: ['albumId'],
        data () {
            return {
                dialog: false,
                albums: [],
            }
        },
        methods: {
            deleteAlbum(id) {
                this.axios
                    .delete(`${this.apiUrl}albums/${id}`)
                    .then(response => {
                        this.getAllAlbums();
                        let i = this.albums.map(album => album.id).indexOf(id); // find index of your object
                        this.albums.splice(i, 1)
                        this.$emit('onSubmitSuccess');
                        this.dialog = false;
                    });

            },
            getAllAlbums() {
                this.axios
                    .get(`${this.apiUrl}albums`)
                    .then(response => {
                        this.albums = response.data;
                });
            },

        }
    }

</script>
