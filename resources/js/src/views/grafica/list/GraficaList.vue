<template>
  <div id="page-grafica-list">
    <grafica-filters></grafica-filters>
    <grafica-data-table></grafica-data-table>
  </div>
</template>

<script>
import GraficaFilters from './GraficaFilters.vue'
import GraficaDataTable from './GraficaDataTable.vue'

// Store Module
import moduleGraficaManagement from '@/store/grafica/moduleGraficaManagement.js'

export default {
  components: {
    GraficaFilters,
    GraficaDataTable
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
    if (!moduleGraficaManagement.isRegistered) {
      this.$store.registerModule('graficaManagement', moduleGraficaManagement)
      moduleGraficaManagement.isRegistered = true
    }
  }
}

</script>
