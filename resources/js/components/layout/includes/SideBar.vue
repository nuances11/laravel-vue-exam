<template>
    <!-- offcanvas -->
    <div class="offcanvas offcanvas-start sidebar-nav bg-dark-custom" tabindex="-1" id="sidebar">
        <div class="offcanvas-body p-0">
            <nav class="navbar-dark">
                <ul class="navbar-nav">
                    <li>
                        <div class="text-muted small fw-bold text-uppercase px-3">
                            Features
                        </div>
                    </li>
                    <li>
                        <router-link class="nav-link px-3" to="/users" >
                            <span class="me-2"><i class="bi bi-people-fill"></i></span>
                            <span>Users</span>
                        </router-link>
                        <router-link class="nav-link px-3" to="/albums" >
                            <span class="me-2"><i class="bi bi-journal-album"></i></span>
                            <span>Albums</span>
                        </router-link>
                        <router-link class="nav-link px-3" to="/photos" >
                            <span class="me-2"><i class="bi bi-card-image"></i></span>
                            <span>Photos</span>
                        </router-link>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
    <!-- offcanvas -->
</template>

<script>
    export default {

    }

</script>
