<template>
  <Modal
      :show="show"
      @showing="showing"
      @close-via-escape="close"
      data-testid="confirm-action-modal"
      maxWidth="screen-md"
      tabindex="-1"
      role="dialog"
  >
    <div
        class="bg-gray-100 dark:bg-gray-700 rounded-lg shadow-lg overflow-hidden p-8"
    >
      <ModalHeader v-text="__('yandexMapPicker.title')"/>
      <ModalContent>
        <p class="mb-3" v-if="!apiKey">
          {{ __('yandexMapPicker.api_key_not_found') }}
        </p>
        <div v-else :id="id" class="yandex-map-wrap"/>
      </ModalContent>
      <ModalFooter class="flex-col">
        <template v-if="apiKey">
          <div class="flex justify-between mb-3">
            <input class="md:w-[20rem] form-control form-input form-input-bordered"
                   type="text"
                   readonly
                   :placeholder="__('yandexMapPicker.latitude')"
                   :value="latitude"
            />
            <input class="md:w-[20rem] form-control form-input form-input-bordered"
                   type="text"
                   readonly
                   :placeholder="__('yandexMapPicker.longitude')"
                   :value="longitude"
            />
          </div>
          <default-button
              type="button"
              @click="saveCoordinates"
              class="mb-3"
          >
            {{ __('yandexMapPicker.save') }}
          </default-button>
        </template>
        <link-button
            type="button"
            @click="close"
        >
          {{ __('yandexMapPicker.cancel') }}
        </link-button>
      </ModalFooter>
    </div>
  </Modal>
</template>

<script>

import ModalHeader from "../../../vendor/laravel/nova/resources/js/components/Modals/ModalHeader";

export default {
  components: {ModalHeader},
  props: {
    id: {
      type: String,
      required: true
    },
    show: {
      type: Boolean,
      required: true
    },
    apiKey: {
      type: String,
    },
    value: {
      type: String,
    },
    zoom: {
      type: Number,
      default: 9
    }
  },

  data() {
    return {
      ready: false,
      valueTemporary: this.value || null,
    }
  },

  computed: {
    latitude() {
      return this.valueTemporary
          ? this.valueTemporary.split(',')[0]
          : null
    },
    longitude() {
      return this.valueTemporary
          ? this.valueTemporary.split(',')[1]
          : null
    },
    centerCoords() {
      const defaultCoords = [55.753994, 37.622093];
      try {
        return this.value.split(',') || defaultCoords;
      } catch (e) {
        return defaultCoords;
      }
    }
  },

  mounted() {
    ymaps.ready(this.initMap);
  },

  methods: {
    initMap() {
      this.ready = true
      this.showing()
    },

    showing() {
      if (!this.show || !this.ready || !this.apiKey) {
        return
      }

      let myPlacemark;

      const myMap = new ymaps.Map(this.id, {
        center: this.centerCoords,
        zoom: this.zoom
      }, {
        searchControlProvider: 'yandex#search'
      });

      // Создание метки.
      const createPlacemark = (coords) => {
        console.log(coords)
        if (myPlacemark) {
          myPlacemark.geometry.setCoordinates(coords);
        } else {
          myPlacemark = new ymaps.Placemark(coords, {}, {
            preset: 'islands#violetDotIconWithCaption',
            draggable: true
          });

          myMap.geoObjects.add(myPlacemark);
        }

        myPlacemark.events.add('dragend', () => {
          this.valueTemporary = myPlacemark.geometry.getCoordinates().toString();
        })
      }

      try {
        if (this.value) {
          createPlacemark(this.value.split(','))
        }
      } catch (e) {
      }

      const clickListener = (e) => {
        const coords = e.get('coords');
        createPlacemark(coords);

        this.valueTemporary = coords.toString()
      }

      // Слушаем клик на карте.
      myMap.events.add('click', clickListener);
    },

    close() {
      this.$emit('close');
    },

    saveCoordinates() {
      this.$emit('setValue', this.valueTemporary)
      this.close();
    },
  }
}
</script>
