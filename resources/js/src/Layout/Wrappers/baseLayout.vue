<template>
    <v-app id="benesApp">
    <div class="app-container app-theme-white">
        <transition name="fade" mode="out-in" appear>
            <Header :headerbg="headercolor"/>
        </transition>
        <transition name="fade" mode="out-in" appear>
            <Sidebar :sidebarbg="sidebarcolor"/>
        </transition>
        <div class="app-main__outer">
            <div class="app-main__inner">
                <slot></slot>
            </div>
            <transition name="fade" mode="out-in" appear>
                <Footer/>
            </transition>
        </div>
    </div>
    </v-app>
</template>

<script>
    import Header from "../Components/Header";
    import Sidebar from "../Components/Sidebar";
    import Footer from "../Components/Footer";

    export default {
        name: 'app',
        components: {
            Header,
            Sidebar,
            Footer,
        },
        methods: {
            toggleConfig(className) {
                const el = document.body;
                this.isConfigOpen = !this.isConfigOpen;

                if (this.isConfigOpen) {
                    el.classList.add(className);
                } else {
                    el.classList.remove(className);
                }
            },
        },

        data() {
            return {
                headercolor: null,
                sidebarcolor: null,
            }
        },
    }
</script>
