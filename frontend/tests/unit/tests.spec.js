import { createLocalVue, shallowMount } from '@vue/test-utils'
import LoginPage from '@/modules/auth/pages/LoginPage'
import RegisterPage from '@/modules/auth/pages/RegisterPage'
import TaskPage from '@/modules/task/pages/TaskPage'

import Vuetify from 'vuetify'

beforeAll(() => {
  jest.spyOn(console, 'log').mockImplementation(jest.fn());
  jest.spyOn(console, 'debug').mockImplementation(jest.fn());
  jest.spyOn(console, 'error').mockImplementation(jest.fn());
});

describe('LoginPage.vue', () => {
  const localVue = createLocalVue()
  let vuetify

  beforeEach(() => {
    vuetify = new Vuetify()
  })

  it('renders page', () => {
    const wrapper = shallowMount(LoginPage, {
      localVue,
      vuetify
    })

    expect(wrapper.isVueInstance()).toBeTruthy()
  })
})

describe('RegisterPage.vue', () => {
  const localVue = createLocalVue()
  let vuetify

  beforeEach(() => {
    vuetify = new Vuetify()
  })

  it('renders page', () => {
    const wrapper = shallowMount(RegisterPage, {
      localVue,
      vuetify
    })

    expect(wrapper.isVueInstance()).toBeTruthy()
  })
})

describe('TaskPage.vue', () => {
  const localVue = createLocalVue()
  let vuetify

  beforeEach(() => {
    vuetify = new Vuetify()
  })

  it('renders page', async () => {
    const wrapper = await shallowMount(TaskPage, {
      localVue,
      vuetify
    })

    await wrapper.setData({
      items: [
        {
          status: 'pending'
        }
      ]
    })

    expect(wrapper.isVueInstance()).toBeTruthy()
  })
})
