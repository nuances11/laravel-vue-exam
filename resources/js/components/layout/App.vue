<template>
    <div>
        <top-navigation></top-navigation>
        <side-bar></side-bar>
        <main class="mt-5 pt-3">
            <router-view></router-view>
        </main>
    </div>
</template>

<script>
import TopNavigation from './includes/TopNavigation.vue'
import SideBar from './includes/SideBar.vue'

    export default {
        components: {
            TopNavigation,
            SideBar
        }
    }
</script>
