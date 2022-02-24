<template>
    <div class="user-page">
        <div class="container-fluid page-header">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="header-content d-flex flex-wrap justify-content-between">
                        <h4>{{  user.name }}</h4>
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
                            <img src="https://www.pngitem.com/pimgs/m/30-307416_profile-icon-png-image-free-download-searchpng-employee.png" :alt="user.name" class="img-responsive w-100">
                        </div>
                        <div class="box">
                            <div class="name text-center"><h2>{{  user.name }}</h2></div>
                            <div class="info">
                                <span><i class="bi bi-envelope mr-2"></i><a href="#" :title="user.name">{{  user.email }}</a></span>
                                <hr>
                                <div data-app class="text-center mt-auto">
                                    <user-update-modal @onSubmitSuccess="getUserDetails(user.id)" :userId="user.id"></user-update-modal>
                                    <user-delete-modal @onSubmitSuccess="goBack()" :userId="user.id"></user-delete-modal>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Album Card -->
                <div class="col-xs-12 col-md-8 col-lg-9">
                    <div class="box">
                        <h2 class="boxTitle">Album list</h2>
                        <hr>
                        <ul class="list-group list-group-flush album-list">
                            <li v-for="album in user.albums" :key="album.id" class="align-items-center d-flex flex-column flex-sm-row flex-wrap justify-content-between list-group-item">
                                <h6 class="mb-0"><strong>{{ album.title }}</strong></h6>
                                <div data-app class="text-right m-1">
                                    <button class="btn btn-action" @click="goToAlbum(user.id)">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <album-update-modal @onSubmitSuccess="getUserDetails(user.id)" :albumId="album.id"></album-update-modal>
                                    <album-delete-modal @onSubmitSuccess="getUserDetails(user.id)" :albumId="album.id"></album-delete-modal>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <div class="box">
                        <h2 class="boxTitle">All User Photo</h2>
                        <hr>
                        <div class="row image-list">
                            <div class="col-md-3 col-sm-6" v-for="photo in user.photos"  :key="photo.id">
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
    import UserUpdateModal from '../includes/UserUpdateModal.vue';
    import UserDeleteModal from '../includes/UserDeleteModal.vue';
    import AlbumUpdateModal from '../includes/AlbumUpdateModal.vue';
    import AlbumDeleteModal from '../includes/AlbumDeleteModal.vue';
    export default {
        components: {
            UserUpdateModal,
            UserDeleteModal,
            AlbumDeleteModal,
            AlbumUpdateModal
        },
        data(){
            return{
                id:this.$route.params.id,
                user: []
            }
        },
        created() {
            this.getUserDetails(this.id)
        },
        methods: {
            goBack() {
                this.$router.back();
            },
            goToAlbum(albumId) {
                this.$router.push({ path: `/album/${albumId}` })
            },
            getUserDetails(id) {
                this.axios
                    .get(`/${this.apiUrl}users/${id}`)
                    .then((response) => {
                        this.user = response.data;
                });
            }
        }
    }
</script>
