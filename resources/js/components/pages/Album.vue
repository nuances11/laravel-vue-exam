<template>
    <div>
        <div class="container-fluid page-header">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <h4>Albums</h4>
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
                                    <form class="d-flex my-3 my-lg-0 search-bar" @submit.prevent="getAllAlbums">
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
                                        <album-add-modal @onSubmitSuccess="getAllAlbums()"></album-add-modal>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <v-data-table
                                :headers="headers"
                                :items="albums"
                                :items-per-page="10"
                                loading
                                loading-text="Loading... Please wait"
                                class="elevation-2">
                                <template v-slot:body="{items, headers}">
                                    <tbody name="list" is="transition-group" v-if="items.length > 0">
                                        <tr v-for="item in items" :key="item.id" class="album-list item-row" @click="goToAlbum(item.id)">
                                        <td>{{item.id}}</td>
                                        <td>{{item.user.name}}</td>
                                        <td>{{item.title}}</td>
                                        <td>
                                            <div data-app>
                                                <album-update-modal @onSubmitSuccess="getAllAlbums()" :albumId="item.id"></album-update-modal>
                                                <album-delete-modal @onSubmitSuccess="getAllAlbums()" :albumId="item.id"></album-delete-modal>
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
                                <!-- <template v-slot:item.action="{ item }">
                                    <div data-app>
                                        <album-update-modal @onSubmitSuccess="getAllAlbums()" :albumId="item.id"></album-update-modal>
                                        <album-delete-modal @onSubmitSuccess="getAllAlbums()" :albumId="item.id"></album-delete-modal>
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
    import AlbumAddModal from './includes/AlbumAddModal.vue';
    import AlbumUpdateModal from './includes/AlbumUpdateModal.vue';
    import AlbumDeleteModal from './includes/AlbumDeleteModal.vue';

    export default {
        components: {
            AlbumAddModal,
            AlbumUpdateModal,
            AlbumDeleteModal
        },
        data() {
            return {
                headers: [
                    {
                        text: '#',
                        align: 'middle',
                        value: 'id',
                    },
                    { text: 'USER', value: 'user.name' },
                    { text: 'TITLE', value: 'title' },
                    { text: 'ACTIONS', value: 'action' }
                ],
                users: [],
                albums: [],
                search: ''
            }
        },
        created() {
            this.getAllAlbums();
            this.getAllUsers();
        },
        methods: {
            goToAlbum(id) {
                this.$router.push({ path: `/album/${id}` })
            },
            getAllUsers() {
                this.axios
                    .get(`${this.apiUrl}users`)
                    .then(response => {
                        this.users = response.data;
                });
            },
            getAllAlbums() {
                this.axios
                    .get(`${this.apiUrl}albums`, { params: { keyword: this.search } })
                    .then(response => {
                        this.albums = response.data;
                });
            }
        }
    }
</script>
