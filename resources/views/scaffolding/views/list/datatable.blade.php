<template>
  <table-crud
    newRoute="/{{ $nameModel }}/new"
    getDataAction="{{ $nameModel }}Management/list"
    management="{{ $nameModel }}Management"
    :entityName="$t('{{ $nameModel }}.title.view')"
    :thead="thead"
    :listColumns="listColumns"
    @edit-record="edit"
    @delete-record="confirmDelete"
  />
</template>

<script>
import table from '@/components/crud/table'

export default {
  data () {
    return {
      id: '',
      listColumns: [{!! $listColumns !!}],
      thead: [
{!! $thead !!}
      ]
    }
  },
  components: {
    'table-crud': table
  },
  methods: {
    edit (id) {
      this.$router.push(`/{{ $nameModel }}/${id}`).catch(() => {})
    },
    confirmDelete (id) {
      this.id = id
      this.$vs.dialog({
        type: 'confirm',
        color: 'danger',
        title: this.$t('confirm_delete'),
        text: this.$t('common.are_you_sure_you_want_to_delete', { entityName: this.$t('{{ $nameModel }}.title.view') }),
        accept: () => this.delete(id),
        acceptText: this.$t('delete')
      })
    },
    deleteRecord (id) {
      this.$store
        .dispatch('{{ $nameModel }}Management/delete', id)
        .then(() => {
          this.showDeleteSuccess()
        })
        .catch(err => {
          console.error(err)
        })
    }
  }
}
</script>
