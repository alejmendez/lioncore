<template>
  <vx-card ref="filterCard" title="Filters" class="{{ $nameModel }}-list-filters mb-8" actionButtons @refresh="resetColFilters" @remove="resetColFilters">
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
      return this.$store.state.{{ $nameModel }}Management.{{ $nameModel }}s
    },
    totalItems () {
      return this.$store.state.{{ $nameModel }}Management.recordsTotal
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
    this.$store.dispatch('{{ $nameModel }}Management/getFiltersValues').catch(err => { console.error(err) })
  }
}

</script>

<style lang="scss" scoped>
.{{ $nameModel }}-list-filters {
  .vs__actions {
    position: absolute;
    right: 0;
    top: 50%;
    transform: translateY(-58%);
  }
}
</style>
