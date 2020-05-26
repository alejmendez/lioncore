<template>
  <div class="vx-card p-6">
    <div class="flex flex-wrap items-center"></div>

    <!-- Table -->
    <vs-table
      ref="table"
      search
      striped
      hoverFlat
      :sst="true"
      :data="usersData"
      :max-items="itemsPerPage"
      @search="handleSearch"
      @sort="handleSort"
    >
      <div slot="header" class="flex flex-wrap-reverse items-center flex-grow justify-between">
        <div class="flex flex-wrap-reverse items-center data-list-btn-container">
          <!-- ADD NEW -->
          <div
            class="btn-add-new p-3 mb-4 mr-4 rounded-lg cursor-pointer flex items-center justify-center text-lg font-medium text-base text-primary border border-solid border-primary"
            @click="addNew"
          >
            <feather-icon icon="PlusIcon" svgClasses="h-4 w-4" />
            <span class="ml-2 text-base text-primary">Add New User</span>
          </div>
        </div>

        <!-- ITEMS PER PAGE -->
        <vs-dropdown vs-trigger-click class="cursor-pointer mb-4 mr-4 items-per-page-handler">
          <div
            class="p-4 border border-solid d-theme-border-grey-light rounded-full d-theme-dark-bg cursor-pointer flex items-center justify-between font-medium"
          >
            <span
              class="mr-2"
            >{{ currentPage * itemsPerPage - (itemsPerPage - 1) }} - {{ totalItems - currentPage * itemsPerPage > 0 ? currentPage * itemsPerPage : totalItems }} of {{ queriedItems }}</span>
            <feather-icon icon="ChevronDownIcon" svgClasses="h-4 w-4" />
          </div>
          <!-- <vs-button class="btn-drop" type="line" color="primary" icon-pack="feather" icon="icon-chevron-down"></vs-button> -->
          <vs-dropdown-menu>
            <vs-dropdown-item @click="itemsPerPage = 10">
              <span>10</span>
            </vs-dropdown-item>
            <vs-dropdown-item @click="itemsPerPage = 25">
              <span>25</span>
            </vs-dropdown-item>
            <vs-dropdown-item @click="itemsPerPage = 50">
              <span>50</span>
            </vs-dropdown-item>
          </vs-dropdown-menu>
        </vs-dropdown>
      </div>

      <template slot="thead">
        <vs-th sort-key="email">Email</vs-th>
        <vs-th sort-key="username">Username</vs-th>
        <vs-th sort-key="person.first_name">Name</vs-th>
        <vs-th>Action</vs-th>
      </template>

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
                @click.stop="editRecord(tr.id)"
              />
              <feather-icon
                icon="TrashIcon"
                svgClasses="w-5 h-5 hover:text-danger stroke-current"
                class="ml-2"
                @click.stop="confirmDeleteRecord(tr.id)"
              />
            </vs-td>
          </vs-tr>
        </tbody>
      </template>
    </vs-table>
    <vs-pagination :total="numberOfPages" v-model="page"></vs-pagination>
  </div>
</template>

<script>
import { datatables } from '@/utils'

export default {
  data () {
    const listColumns = ['email', 'username', 'person.first_name']

    return {
      timer: null,
      page: 1,
      itemsPerPage: 10,
      isMounted: false,
      listColumns,
      datatable: datatables(listColumns)
    }
  },
  computed: {
    usersData () {
      return this.$store.state.userManagement.users
    },
    totalItems () {
      return this.$store.state.userManagement.recordsTotal
    },
    numberOfPages () {
      return Math.ceil(this.$store.state.userManagement.recordsTotal / this.itemsPerPage)
    },
    currentPage () {
      if (this.isMounted) {
        return this.$refs.table.currentx
      }
      return 0
    },
    queriedItems () {
      return this.$refs.table ? this.$refs.table.queriedResults.length : this.totalItems
    }
  },
  watch: {
    page (val) {
      this.handleChangePage(val)
    }
  },
  methods: {
    addNew () {
      this.$router.push('/user/new').catch(() => {})
    },
    handleSearch (searching) {
      if (this.timer) {
        clearTimeout(this.timer)
        this.timer = null
      }

      this.timer = setTimeout(() => {
        this.datatable.draw++
        this.datatable.search.value = searching
        this.getData()
      }, 400)
    },
    handleChangePage (page) {
      this.datatable.draw++
      this.datatable.start = (page - 1) * this.itemsPerPage
      this.getData()
    },
    handleSort (key, active) {
      this.datatable.draw++
      console.log(key + ' - ' + active)
      console.log(this.listColumns)
      console.log(this.listColumns.indexOf(key))
      this.datatable.order[0].column = this.listColumns.indexOf(key)
      this.datatable.order[0].dir = active
      this.getData()
    },
    editRecord (id) {
      this.$router.push(`/user/${id}`).catch(() => {})
    },
    confirmDeleteRecord () {
      this.$vs.dialog({
        type: 'confirm',
        color: 'danger',
        title: 'Confirm Delete',
        text: `You are about to delete "${this.params.data.username}"`,
        accept: this.deleteRecord,
        acceptText: 'Delete'
      })
    },
    deleteRecord (id) {
      this.$store
        .dispatch('userManagement/removeRecord', id)
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
        title: 'User Deleted',
        text: 'The selected user was successfully deleted'
      })
    },
    getData () {
      this.$store.dispatch('userManagement/list', this.datatable).catch(err => {
        console.error(err)
      })
    }
  },
  mounted () {
    this.isMounted = true
  },
  created () {
    this.getData()
  }
}
</script>
