import mock from '@/fake-db/mock.js'

const data = {
  user: [
    {
      'id': 1,
      'category': 'student',
      'img': '@assets/images/portrait/small/avatar-s-1.jpg',
      'name': 'Maria Alexandra López'
    },
    {
      'id': 2,
      'category': 'teacher',
      'img': '@assets/images/portrait/small/avatar-s-2.jpg',
      'name': 'Fabiola Maria Colmenares Lara'
    },
    {
      'id': 3,
      'category': 'admin',
      'img': '@assets/images/portrait/small/avatar-s-3.jpg',
      'name': 'Linda Alejandra Blade Ranger'

    },
    {
      'id': 4,
      'category': 'attorney',
      'img': '@assets/images/portrait/small/avatar-s-4.jpg',
      'name': 'Kira Amuey Vargas Lara'

    },
    {
      'id': 5,
      'category': 'attorney',
      'img': '@assets/images/portrait/small/avatar-s-1.jpg',
      'name': 'Julio José Alavrez Pérez'

    },
    {
      'id': 6,
      'category': 'attorney',
      'img': '@assets/images/portrait/small/avatar-s-5.jpg',
      'name': 'Alvaro José Espinoza Rodríguez'
    },
    {
      'id': 7,
      'category': 'attorney',
      'img': '@assets/images/portrait/small/avatar-s-6.jpg',
      'name': 'Altagracia Simone Ramírez Cova'
    },
    {
      'id': 8,
      'category': 'attorney',
      'img': '@assets/images/portrait/small/avatar-s-7.jpg',
      'name': 'Juan José Bolívar Aponte'
    },
    {
      'id': 9,
      'category': 'admin',
      'img': '@assets/images/portrait/small/avatar-s-8.jpg',
      'name': 'Francisco de Miranda Vargas Donmar'
    },
    {
      'id': 10,
      'category': 'admin',
      'img': '@assets/images/portrait/small/avatar-s-9.jpg',
      'name': 'Rodolfo Antonio Palacios Beltran'
    },
    {
      'id': 11,
      'category': 'student',
      'img': '@assets/images/portrait/small/avatar-s-1.jpg',
      'name': 'Maria Alexandra López'
    },
    {
      'id': 12,
      'category': 'teacher',
      'img': '@assets/images/portrait/small/avatar-s-2.jpg',
      'name': 'Fabiola Maria Colmenares Lara'
    },
    {
      'id': 13,
      'category': 'admin',
      'img': '@assets/images/portrait/small/avatar-s-3.jpg',
      'name': 'Linda Alejandra Blade Ranger'

    },
    {
      'id': 14,
      'category': 'attorney',
      'img': '@assets/images/portrait/small/avatar-s-4.jpg',
      'name': 'Kira Amuey Vargas Lara'

    },
    {
      'id': 15,
      'category': 'attorney',
      'img': '@assets/images/portrait/small/avatar-s-1.jpg',
      'name': 'Julio José Alavrez Pérez'

    },
    {
      'id': 16,
      'category': 'attorney',
      'img': '@assets/images/portrait/small/avatar-s-5.jpg',
      'name': 'Alvaro José Espinoza Rodríguez'
    },
    {
      'id': 17,
      'category': 'attorney',
      'img': '@assets/images/portrait/small/avatar-s-6.jpg',
      'name': 'Altagracia Simone Ramírez Cova'
    },
    {
      'id': 18,
      'category': 'attorney',
      'img': '@assets/images/portrait/small/avatar-s-7.jpg',
      'name': 'Juan José Bolívar Aponte'
    },
    {
      'id': 19,
      'category': 'admin',
      'img': '@assets/images/portrait/small/avatar-s-8.jpg',
      'name': 'Francisco de Miranda Vargas Donmar'
    },
    {
      'id': 20,
      'category': 'admin',
      'img': '@assets/images/portrait/small/avatar-s-9.jpg',
      'name': 'Rodolfo Antonio Palacios Beltran'
    },
    {
      'id': 21,
      'category': 'student',
      'img': '@assets/images/portrait/small/avatar-s-1.jpg',
      'name': 'Maria Alexandra López'
    },
    {
      'id': 22,
      'category': 'teacher',
      'img': '@assets/images/portrait/small/avatar-s-2.jpg',
      'name': 'Fabiola Maria Colmenares Lara'
    },
    {
      'id': 23,
      'category': 'admin',
      'img': '@assets/images/portrait/small/avatar-s-3.jpg',
      'name': 'Linda Alejandra Blade Ranger'

    },
    {
      'id': 24,
      'category': 'attorney',
      'img': '@assets/images/portrait/small/avatar-s-4.jpg',
      'name': 'Kira Amuey Vargas Lara'

    },
    {
      'id': 25,
      'category': 'attorney',
      'img': '@assets/images/portrait/small/avatar-s-1.jpg',
      'name': 'Julio José Alavrez Pérez'

    },
    {
      'id': 26,
      'category': 'attorney',
      'img': '@assets/images/portrait/small/avatar-s-5.jpg',
      'name': 'Alvaro José Espinoza Rodríguez'
    },
    {
      'id': 27,
      'category': 'attorney',
      'img': '@assets/images/portrait/small/avatar-s-6.jpg',
      'name': 'Altagracia Simone Ramírez Cova'
    },
    {
      'id': 28,
      'category': 'attorney',
      'img': '@assets/images/portrait/small/avatar-s-7.jpg',
      'name': 'Juan José Bolívar Aponte'
    },
    {
      'id': 29,
      'category': 'admin',
      'img': '@assets/images/portrait/small/avatar-s-8.jpg',
      'name': 'Francisco de Miranda Vargas Donmar'
    },
    {
      'id': 30,
      'category': 'admin',
      'img': '@assets/images/portrait/small/avatar-s-9.jpg',
      'name': 'Rodolfo Antonio Palacios Beltran'
    },
  ]
}


mock.onGet('/pages/profile/user/').reply(() => {
  return [200, JSON.parse(JSON.stringify(data.user)).reverse()]
})

// POST : Add new Item
mock.onPost('/pages/profile/user/').reply((request) => {

  // Get event from post data
  const item = JSON.parse(request.data).item

  const length = data.user.length
  let lastIndex = 0
  if (length) {
    lastIndex = data.user[length - 1].id
  }
  item.id = lastIndex + 1

  data.user.push(item)

  return [201, { id: item.id }]
})

// Update Product
mock.onPost(/\/pages\/profile\/user\/\d+/).reply((request) => {

  const itemId = request.url.substring(request.url.lastIndexOf('/') + 1)

  const item = data.user.find((item) => item.id == itemId)
  Object.assign(item, JSON.parse(request.data).item)

  return [200, item]
})

// DELETE: Remove Item
mock.onDelete(/\/pages\/profile\/user\/\d+/).reply((request) => {

  const itemId = request.url.substring(request.url.lastIndexOf('/') + 1)

  const itemIndex = data.user.findIndex((p) => p.id == itemId)
  data.user.splice(itemIndex, 1)
  return [200]
})
