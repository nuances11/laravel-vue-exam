import Users from './components/pages/User.vue';
import Photos from './components/pages/Photo.vue';
import Albums from './components/pages/Album.vue';

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
    }
];
