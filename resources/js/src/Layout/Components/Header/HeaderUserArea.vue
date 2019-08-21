<template>
    <div class="d-flex">
        <div class="header-btn-lg pr-0">
            <div class="widget-content p-0">
                <div class="widget-content-wrapper">
                    <div class="widget-content-left">
                        <b-dropdown toggle-class="p-0 mr-2" menu-class="dropdown-menu-lg" variant="link" no-caret right>
                            <span slot="button-content">
                                <div class="icon-wrapper icon-wrapper-alt rounded-circle">
                                    <img width="42" class="rounded-circle" src="@/assets/images/avatars/1.jpg" alt="">
                                </div>
                            </span>
                            <div class="dropdown-menu-header">
                                <div class="dropdown-menu-header-inner bg-info">
                                    <div class="menu-header-image opacity-2 dd-header-bg-6"></div>
                                    <div class="menu-header-content text-left">
                                        <div class="widget-content p-0">
                                            <div class="widget-content-wrapper">
                                                <div class="widget-content-left mr-3">
                                                    <img width="42" class="rounded-circle" src="@/assets/images/avatars/1.jpg" alt="">
                                                </div>
                                                <div class="widget-content-left">
                                                    <div class="widget-heading">Alina Mcloughlin</div>
                                                    <div class="widget-subheading opacity-8">A short profile description</div>
                                                </div>
                                                <div class="widget-content-right mr-2">
                                                    <button class="btn-pill btn-shadow btn-shine btn btn-focus">Logout</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="scroll-area-xs" style="height: 150px;">
                                <VuePerfectScrollbar class="scrollbar-container" v-once>
                                    <ul class="nav flex-column">
                                        <li class="nav-item"><a href="javascript:void(0);" class="nav-link">Recover Password</a></li>
                                        <li class="nav-item-header nav-item">My Account</li>
                                        <li class="nav-item"><a href="javascript:void(0);" class="nav-link">Settings
                                        </a></li>
                                    </ul>
                                </VuePerfectScrollbar>
                            </div>
                        </b-dropdown>
                    </div>
                    <div class="widget-content-left  ml-3 header-user-info">
                        <div class="widget-heading">Alina Mclourd</div>
                        <div class="widget-subheading">VP People Manager</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import VuePerfectScrollbar from 'vue-perfect-scrollbar'
    export default {
        components: {
            VuePerfectScrollbar
        },
        data: () => ({

        }),
    }
</script>
