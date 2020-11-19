<template>
  <vx-card
    ref="filterCard"
    class="grafica-list-filters mb-8"
    actionButtons
    :title="$t('common.filters')"
    @refresh="resetColFilters"
    @remove="resetColFilters"
  >
    <div class="vx-row">

    </div>
  </vx-card>
</template>

<script>
import vSelect from 'vue-select'

export default {
  components: {
    vSelect
  },
  data () {
    return {
      // Filter Options
    }
  },
  watch: {

  },
  computed: {
    getFiltersValues () {
      return this.$store.state.graficaManagement.graficas
    },
    totalItems () {
      return this.$store.state.graficaManagement.recordsTotal
    }
  },
  methods: {
    setColumnFilter (column, val) {
      console.log(column, val)
    },
    resetColFilters () {
      // Reset Filter Options
      this.$refs.filterCard.removeRefreshAnimation()
    }
  },
  mounted () {

  },
  created () {
    this.$store.dispatch('graficaManagement/getFiltersValues').catch(err => { console.error(err) })
  }
}

</script>

<style lang="scss" scoped>
.grafica-list-filters {
  .vs__actions {
    position: absolute;
    right: 0;
    top: 50%;
    transform: translateY(-58%);
  }
}
</style>
