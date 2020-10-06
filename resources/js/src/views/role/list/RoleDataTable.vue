<template>
  <table-crud
    newRoute="/role/new"
    getDataAction="roleManagement/list"
    management="roleManagement"
    ref="table"
    :entityName="$t('role.title.view')"
    :thead="thead"
    :listColumns="listColumns"
  >
    <template slot-scope="{data}">
      <tbody>
        <vs-tr :data="tr" :key="indextr" v-for="(tr, indextr) in data">
          <vs-td style="width:100%">{{ tr.name }}</vs-td>
          <vs-td class="whitespace-no-wrap" style="width:90px">
            <feather-icon
              icon="EditIcon"
              svgClasses="w-5 h-5 hover:text-primary stroke-current"
              @click.stop="edit(tr.id)"
            />
            <feather-icon
              icon="TrashIcon"
              svgClasses="w-5 h-5 hover:text-danger stroke-current"
              class="ml-2"
              @click.stop="confirmDelete(tr.id)"
            />
          </vs-td>
        </vs-tr>
      </tbody>
    </template>
  </table-crud>
</template>

<script>
import table from '@/components/crud/table'

export default {
  data () {
    return {
      id: '',
      listColumns: ['name'],
      thead: [
        {
          name: this.$t('role.name'),
          key: 'name'
        }
      ]
    }
  },
  components: {
    'table-crud': table
  },
  methods: {
    getData () {
      this.$refs.table.getData()
    },
    loading () {
      this.$vs.loading()
    },
    loaded () {
      this.$vs.loading.close()
    },
    edit (id) {
      this.$router.push({ name: 'role-edit', params: { id } }).catch(() => {})
    },
    confirmDelete (id) {
      this.id = id
      this.$vs.dialog({
        type: 'confirm',
        color: 'danger',
        title: this.$t('common.confirm_delete'),
        text: this.$t('common.are_you_sure_you_want_to_delete', { entityName: this.$t('role.title.view') }),
        accept: () => this.delete(id),
        acceptText: this.$t('common.delete')
      })
    },
    delete (id) {
      this.loading()
      this.$store
        .dispatch('roleManagement/delete', id)
        .then(() => {
          this.showDeleteSuccess()
        })
        .catch(err => {
          this.showDeleteError()
          console.error(err)
        })
    },
    showDeleteSuccess () {
      this.getData()
      this.$vs.notify({
        color: 'success',
        title: this.$t('common.record_deleted'),
        text: this.$t('common.the_selected_entityname_was_successfully_deleted', { entityName: this.$t('role.title.view') })
      })
    },
    showDeleteError () {
      this.getData()
      this.$vs.notify({
        color: 'danger',
        title: this.$t('common.record_deleted'),
        text: this.$t('common.an_error_was_generated_while_trying_to_delete_the_record')
      })
    }
  }
}
</script>
