<template>
    <div class="album-page">
        <div class="container-fluid page-header">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="header-content d-flex flex-wrap justify-content-between">
                        <h4>{{  album.title }}</h4>
                        <v-btn
                            class="ma-2 btn-action"
                            @click="goBack()"
                        >
                            Back
                        </v-btn>
                    </div>

                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <!-- Profile Card -->
                <div class="col-xs-12 col-md-4 col-lg-3">
                    <div class="userProfileInfo">
                        <div class="image text-center">
                            <img src="https://via.placeholder.com/300" :alt="album.title" class="w-100 img-responsive">
                        </div>
                        <div class="box">
                            <div class="name text-center"><h2>{{ album.title }}</h2></div>
                            <div class="info">
                                <span>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Inventore quod libero molestiae, doloremque rerum excepturi corporis dolore, esse ipsam suscipit, iure ducimus accusamus modi quibusdam saepe. Reiciendis ipsum accusamus tempore.</span>
                                <hr>
                                <div data-app class="text-center mt-auto">
                                    <album-update-modal @onSubmitSuccess="getAlbumDetails(album.id)" :albumId="album.id"></album-update-modal>
                                    <album-delete-modal @onSubmitSuccess="goBack()" :albumId="album.id"></album-delete-modal>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Album Card -->
                <div class="col-xs-12 col-md-8 col-lg-9">
                    <div class="box">
                        <div class="box-header d-flex flex-wrap justify-content-between">
                            <h2 class="boxTitle">Album Photos</h2>
                            <div data-app>
                                <photo-add-modal :albumId="album.id" @onSubmitSuccess="getAlbumDetails(album.id)"></photo-add-modal>
                            </div>
                        </div>
                        <hr>
                        <div class="row image-list">
                            <div class="col-md-3 col-sm-6" v-for="photo in album.photos"  :key="photo.id">
                                <img :src="photo.thumbnailUrl" :alt="photo.title" class="img-thumbnail w-100">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import AlbumUpdateModal from '../includes/AlbumUpdateModal.vue';
    import AlbumDeleteModal from '../includes/AlbumDeleteModal.vue';
    import PhotoAddModal from './includes/PhotoAddModal.vue';
    export default {
        components: {
            AlbumDeleteModal,
            AlbumUpdateModal,
            PhotoAddModal
        },
        data(){
            return{
                id:this.$route.params.id,
                album: []
            }
        },
        created() {
            this.getAlbumDetails(this.id)
        },
        methods: {
            goBack() {
                this.$router.back();
            },
            getAlbumDetails(id) {
                this.axios
                    .get(`/${this.apiUrl}albums/${id}`)
                    .then((response) => {
                        this.album = response.data;
                });
            }
        }
    }
</script>
