const dataTableStructure = (listColumns) => {
  const columns = []
  let i = 0

  listColumns.forEach(column => {
    columns.push({
      data: i++,
      name: column,
      searchable: true,
      orderable: true,
      search: {
        value: '',
        regex: false
      }
    })
  })

  return {
    draw: 0,
    columns,
    order: [{
      column: 0,
      dir: 'asc'
    }],
    start: 0,
    length: 10,
    search: {
      value: '',
      regex: ''
    }
  }
}


export default dataTableStructure
