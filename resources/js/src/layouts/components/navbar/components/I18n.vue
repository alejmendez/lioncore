<template>
  <vs-dropdown vs-custom-content vs-trigger-click class="cursor-pointer">
    <span class="cursor-pointer flex items-center i18n-locale">
      <img class="h-4 w-5" :src="`/images/flags/${$i18n.locale}.png`" :alt="$i18n.locale" />
      <span class="hidden sm:block ml-2">{{ currentLocaleData.lang }}</span>
    </span>
    <vs-dropdown-menu class="w-48 i18n-dropdown vx-navbar-dropdown">
      <vs-dropdown-item
        v-for="(languaje, index) in languajes"
        :key="index"
        @click="updateLocale(languaje.flag)"
      >
        <img class="h-4 w-5 mr-1" :src="`/images/flags/${languaje.flag}.png`" :alt="languaje.flag" />
        &nbsp;{{ languaje.lang }}
      </vs-dropdown-item>
    </vs-dropdown-menu>
  </vs-dropdown>
</template>

<script>
export default {
  data () {
    return {
      languajes: [
        { flag: 'es', lang: 'Español'    },
        { flag: 'en', lang: 'English'    }
        // { flag: 'pt', lang: 'Portuguese' },
        // { flag: 'fr', lang: 'French'     },
        // { flag: 'de', lang: 'German'     },
      ]
    }
  },
  computed: {
    i18n_locale_img () {
      const locale = this.$i18n.locale
      return require(`@assets/images/flags/${locale}.png`)
    },
    currentLocaleData () {
      const locale = this.$i18n.locale
      return this.languajes.filter(languaje => languaje.flag === locale)[0]
    }
  },
  methods: {
    updateLocale (locale) {
      this.$i18n.locale = locale
    }
  }
}
</script>
