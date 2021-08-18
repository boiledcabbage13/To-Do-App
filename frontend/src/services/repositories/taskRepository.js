import axios from '../../plugins/axios';
const resource = '/api/tasks';

export default {
  get(payload) {
    return axios.get(`${resource}`, payload);
  },
  show(id) {
    return axios.get(`${resource}/${id}`);
  },
  create(payload) {
    return axios.post(`${resource}`,payload)
  },
  update(id, payload) {
    return axios.put(`${resource}/${id}`,payload)
  },
  delete(id) {
    return axios.delete(`${resource}/${id}`)
  },
  dummyData(limit = 5) {
    let items = [];

    for (let index = 0; index < limit; index++) {
      let id = index + 1;
      items.push({
        id,
        name: `product ${id}`,
        packaging: [
          {
            type: 'piece',
            price: 1.00 * id
          },
          {
            type: 'pack',
            price: 10.00 * id
          },
          {
            type: 'box',
            price: 100.00 * id
          }
        ]
      })
    }
    
    return items;
  }
}