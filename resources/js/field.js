import IndexField from './components/IndexField'
import DetailField from './components/DetailField'
import FormField from './components/FormField'

Nova.booting((app, store) => {
  app.component('index-yandex-map-picker', IndexField)
  app.component('detail-yandex-map-picker', DetailField)
  app.component('form-yandex-map-picker', FormField)
})
