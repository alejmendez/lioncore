<template>
  <div class="vs-con-loading__container tableContainerCrud">
    <!-- Table -->
    <vs-table
      ref="table"
      search
      :sst="true"
      :data="tableData"
      :max-items="itemsPerPage"
      @search="search"
      @sort="sort"
    >
      <div slot="header" class="flex flex-wrap-reverse items-center flex-grow justify-between">
        <div class="flex flex-wrap-reverse items-center data-list-btn-container">
          <!-- ADD NEW -->
          <div
            class="btn-add-new p-3 mb-4 mr-4 rounded-lg cursor-pointer flex items-center justify-center text-lg font-medium text-base text-primary border border-solid border-primary"
            @click="addNew"
          >
            <feather-icon icon="PlusIcon" svgClasses="h-4 w-4" />
            <span class="ml-2 text-base text-primary">Add new {{ entityName }}</span>
          </div>
        </div>
      </div>

      <template slot="thead">
        <vs-th
          v-for="th in thead"
          :key="th.key"
          :sort-key="th.key"
          >
          {{ th.name }}
        </vs-th>
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
                @click.stop="deleteRecord(tr.id)"
              />
            </vs-td>
          </vs-tr>
        </tbody>
      </template>
    </vs-table>
    <div>
      <vs-row class="mt-5">
        <vs-col vs-type="flex" vs-w="6">
          <!-- ITEMS PER PAGE -->
          Showing
          {{ currentPage * itemsPerPage - (itemsPerPage - 1) }}
          to
          <vs-dropdown>
            <a class="a-icon" href="#">
              {{ itemsPerPage }}
              <vs-icon class="" icon="expand_more"></vs-icon>
            </a>
            <div style="margin-left: 5px; height: 18px;">
              <vs-dropdown-menu>
                <vs-dropdown-item :key="item.id" v-for="item in optionsListCalc" @click="changeItemsPerPage(item)">
                  {{ item.option }}
                </vs-dropdown-item>
              </vs-dropdown-menu>
            </div>
          </vs-dropdown>
          of
          {{ queriedItems }}
          entries
        </vs-col>
        <vs-col vs-type="flex" vs-justify="center" vs-align="center" vs-w="6">
          <vs-pagination :total="numberOfPages" v-model="page"></vs-pagination>
        </vs-col>
      </vs-row>
    </div>
  </div>
</template>

<script>
import { datatables } from '@/utils'

export default {
  props: {
    entityName: String,
    listColumns: Array,
    thead: Array,
    page: {
      type: Number,
      default: 1
    },
    optionsList: {
      type: Array,
      default: () => [10, 25, 50]
    },
    itemsPerPage: {
      type: Number,
      default: 10
    },

    management: String,

    getDataAction: String,
    newRoute: String
  },
  data () {
    return {
      timer: null,
      isMounted: false
    }
  },
  computed: {
    datatable () {
      return datatables(this.listColumns)
    },
    tableData () {
      return this.$store.state[this.management].data
    },
    totalItems () {
      return this.$store.state[this.management].recordsTotal
    },
    numberOfPages () {
      return Math.ceil(this.$store.state[this.management].recordsTotal / this.itemsPerPage)
    },
    currentPage () {
      return this.isMounted ? this.$refs.table.currentx : 0
    },
    queriedItems () {
      return this.$refs.table ? this.$refs.table.queriedResults.length : this.totalItems
    },
    optionsListCalc () {
      return this.optionsList.map(ele => {
        return {id: ele, option: ele}
      })
    }
  },
  watch: {
    page (val) {
      this.changePage(val)
    }
  },
  methods: {
    addNew () {
      this.$emit('add-new')
      this.$router.push(this.newRoute).catch(() => {})
    },
    loading () {
      this.$emit('loading')
      this.$vs.loading({
        container: '.tableContainerCrud',
        scale: 0.6
      })
    },
    loaded () {
      this.$emit('loaded')
      this.$vs.loading.close('.tableContainerCrud > .con-vs-loading')
    },
    search (searching) {
      if (this.timer) {
        clearTimeout(this.timer)
        this.timer = null
      }

      this.timer = setTimeout(() => {
        this.$emit('search')
        this.datatable.draw++
        this.datatable.search.value = searching
        this.getData()
      }, 400)
    },
    changePage (page) {
      this.$emit('change-page')
      this.datatable.draw++
      this.datatable.start = (page - 1) * this.itemsPerPage
      this.getData()
    },
    sort (key, active) {
      this.datatable.draw++
      this.$emit('sort')

      if (active !== null) {
        this.datatable.order[0].column = this.listColumns.indexOf(key)
        this.datatable.order[0].dir = active
      } else {
        this.datatable.order[0].column = 0
        this.datatable.order[0].dir = 'asc'
      }

      this.getData()
    },
    changeItemsPerPage (cant) {
      this.datatable.length = cant
      this.itemsPerPage = cant
      this.getData()
    },
    editRecord (id) {
      this.$emit('edit-record', id)
    },
    deleteRecord (id) {
      this.$emit('delete-record', id)
    },
    showDeleteSuccess () {
      this.getData()
      this.$vs.notify({
        color: 'success',
        title: 'Record Deleted',
        text: `The selected ${ this.entityName } was successfully deleted.`
      })
    },
    getData () {
      this.$emit('get-data')
      try {
        this.loading()
        this.$store.dispatch(this.getDataAction, this.datatable)
          .then(() => this.loaded())
          .catch(() => this.loaded())
      } catch (err) {
        this.loaded()
      }
    }
  },
  mounted () {
    this.isMounted = TextTrackCueList
  },
  created () {
    setTimeout(() => {
      this.getData()
    }, 300)
  }
}
</script>
