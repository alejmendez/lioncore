<template>
  <table-crud
    newRoute="/user/new"
    getDataAction="userManagement/list"
    management="userManagement"
    ref="table"
    :entityName="$t('users.title.view')"
    :thead="thead"
    :listColumns="listColumns"
  >
    <template slot-scope="{data}">
      <tbody>
        <vs-tr :data="tr" :key="indextr" v-for="(tr, indextr) in data">
          <vs-td>{{ tr.email }}</vs-td>
          <vs-td>{{ tr.username }}</vs-td>
          <vs-td>{{ tr.person.first_name }} {{ tr.person.last_name }}</vs-td>
          <vs-td class="whitespace-no-wrap">
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
      listColumns: ['email', 'username', 'person.first_name'],
      thead: [
        {
          name: this.$t('users.email'),
          key: 'email'
        },
        {
          name: this.$t('users.username'),
          key: 'username'
        },
        {
          name: this.$t('users.first_name'),
          key: 'person.first_name'
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
      this.$router.push(`/user/${id}`).catch(() => {})
    },
    confirmDelete (id) {
      this.id = id
      this.$vs.dialog({
        type: 'confirm',
        color: 'danger',
        title: this.$t('common.confirm_delete'),
        text: this.$t('common.are_you_sure_you_want_to_delete', { entityName: this.$t('users.title.view') }),
        accept: () => this.delete(id),
        acceptText: this.$t('common.delete')
      })
    },
    delete (id) {
      this.loading()
      this.$store
        .dispatch('userManagement/delete', id)
        .then(() => {
          this.showDeleteSuccess()
        })
        .catch(err => {
          console.error(err)
        })
    },
    showDeleteSuccess () {
      this.getData()
      this.$vs.notify({
        color: 'success',
        title: this.$t('common.record_deleted'),
        text: this.$t('common.the_selected_entityname_was_successfully_deleted', { entityName: this.$t('users.title.view') })
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
