<template>
  <div id="page-registro-list">
    <registro-filters></registro-filters>
    <registro-data-table></registro-data-table>
  </div>
</template>

<script>
import RegistroFilters from './RegistroFilters.vue'
import RegistroDataTable from './RegistroDataTable.vue'

// Store Module
import moduleRegistroManagement from '@/store/registro/moduleRegistroManagement.js'

export default {
  components: {
    RegistroFilters,
    RegistroDataTable
  },
  data () {
    return {
    }
  },
  methods: {

  },
  mounted () {

  },
  created () {
    if (!moduleRegistroManagement.isRegistered) {
      this.$store.registerModule('registroManagement', moduleRegistroManagement)
      moduleRegistroManagement.isRegistered = true
    }
  }
}

</script>
