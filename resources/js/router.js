import Users from './components/pages/User.vue';
import Photos from './components/pages/Photo.vue';
import Albums from './components/pages/Album.vue';
import UserPage from './components/pages/dedicated/User.vue';
import AlbumPage from './components/pages/dedicated/Album.vue';

export const routes = [
    {
        name: 'users',
        path: '/users',
        component: Users
    },
    {
        name: 'photos',
        path: '/photos',
        component: Photos
    },
    {
        name: 'albums',
        path: '/albums',
        component: Albums
    },
    {
        path: '/user/:id',
        name: 'user',
        component: UserPage
    },
    {
        path: '/album/:id',
        name: 'album',
        component: AlbumPage
    }
];
