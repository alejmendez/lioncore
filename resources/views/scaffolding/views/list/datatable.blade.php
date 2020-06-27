<template>
  <table-crud
    entityName="{{ $nameModel }}"
    newRoute="/{{ $nameModel }}/new"
    getDataAction="{{ $nameModel }}Management/list"
    management="{{ $nameModel }}Management"
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
        title: 'Confirm Delete',
        text: 'Are you sure you want to delete the {{ $nameModel }}?',
        accept: () => this.delete(id),
        acceptText: 'Delete'
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
