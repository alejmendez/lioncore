<template>
  <div id="page-alumno-list">
    <alumno-filters></alumno-filters>
    <alumno-data-table></alumno-data-table>
  </div>
</template>

<script>
import AlumnoFilters from './AlumnoFilters.vue'
import AlumnoDataTable from './AlumnoDataTable.vue'

// Store Module
import moduleAlumnoManagement from '@/store/alumno/moduleAlumnoManagement.js'

export default {
  components: {
    AlumnoFilters,
    AlumnoDataTable
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
    if (!moduleAlumnoManagement.isRegistered) {
      this.$store.registerModule('alumnoManagement', moduleAlumnoManagement)
      moduleAlumnoManagement.isRegistered = true
    }
  }
}

</script>
