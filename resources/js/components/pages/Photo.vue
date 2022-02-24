<template>
    <div>
        <div class="container-fluid page-header">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <h4>Photos</h4>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 mb-3">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-6 col-lg-9 col-md-9 col-sm-6">
                                    <form class="d-flex my-3 my-lg-0 search-bar" @submit.prevent="getAllPhotos">
                                        <div class="input-group">
                                            <input class="form-control" type="search" v-model="search" placeholder="Search"
                                                aria-label="Search" />
                                            <button class="btn btn-secondary" type="submit">
                                                <i class="bi bi-search"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-6 col-md-3 col-sm-6 my-1 text-end">
                                    <div data-app>
                                        <photo-add-modal @onSubmitSuccess="getAllPhotos()"></photo-add-modal>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <v-data-table
                                :headers="headers"
                                :items="photos"
                                :items-per-page="10"
                                loading
                                loading-text="Loading... Please wait"
                                class="elevation-2">
                                <template v-slot:body="{items, headers}">
                                    <tbody name="list" is="transition-group" v-if="items.length > 0">
                                        <tr v-for="item in items" :key="item.id" class="item-row">
                                        <td>{{item.id}}</td>
                                        <td>{{item.album.title}}</td>
                                        <td>{{item.title}}</td>
                                        <td>
                                            <img width="50px" :src="item.thumbnailUrl" :alt="item.title">
                                        </td>
                                        <td>
                                            <div data-app>
                                                <photo-update-modal @onSubmitSuccess="getAllPhotos()" :photoId="item.id"></photo-update-modal>
                                                 <photo-delete-modal @onSubmitSuccess="getAllPhotos()" :photoId="item.id"></photo-delete-modal>
                                            </div>
                                        </td>
                                        </tr>
                                    </tbody>
                                    <tbody v-else>
                                        <tr>
                                        <td :colspan="headers.length" style="text-align: center">No data available.</td>
                                        </tr>
                                    </tbody>
                                </template>
                                <!-- <template v-slot:item.thumbnailUrl="{ item }">
                                    <img width="50px" :src="item.thumbnailUrl" :alt="item.title">
                                </template>
                                <template v-slot:item.action="{ item }">
                                    <div data-app>
                                        <photo-update-modal @onSubmitSuccess="getAllPhotos()" :photoId="item.id"></photo-update-modal>
                                        <photo-delete-modal @onSubmitSuccess="getAllPhotos()" :photoId="item.id"></photo-delete-modal>
                                    </div>

                                </template> -->
                            </v-data-table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import PhotoAddModal from './includes/PhotoAddModal.vue';
    import PhotoUpdateModal from './includes/PhotoUpdateModal.vue';
    import PhotoDeleteModal from './includes/PhotoDeleteModal.vue';

    export default {
        components: {
            PhotoAddModal,
            PhotoUpdateModal,
            PhotoDeleteModal
        },
        data() {
            return {
                headers: [
                    {
                        text: 'ID',
                        align: 'middle',
                        value: 'id',
                    },
                    { text: 'ALBUM', value: 'album.title' },
                    { text: 'TITLE', value: 'title' },
                    { text: 'IMAGE', value: 'thumbnailUrl' },
                    { text: 'ACTIONS', value: 'action' }
                ],
                photos: [],
                albums: [],
                search: ''
            }
        },
        created() {
            this.getAllAlbums();
            this.getAllPhotos();
        },
        methods: {
            getAllPhotos() {
                this.axios
                    .get(`${this.apiUrl}photos`, { params: { keyword: this.search } })
                    .then(response => {
                        this.photos = response.data;
                });
            },
            getAllAlbums() {
                this.axios
                    .get(`${this.apiUrl}albums`)
                    .then(response => {
                        this.albums = response.data;
                });
            }
        }
    }
</script>
