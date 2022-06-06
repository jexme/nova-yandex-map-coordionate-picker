<template>
  <DefaultField :field="field" :errors="errors" :show-help-text="showHelpText">
    <template #field>
      <input
          :id="field.attribute"
          type="text"
          class="w-full form-control form-input form-input-bordered"
          :class="errorClasses"
          :placeholder="field.name"
          v-model="value"
      />

      <YandexMapModal
          :id="`${field.attribute}-map`"
          :show="showMap"
          :api-key="field.apiKey"
          :value="field.value"
          :zoom="field.zoom"
          @setValue="setValue"
          @close="closeModal"
      />

      <button type="button" class="btn-open" @click="showMap = !showMap">{{
          __('yandexMapPicker.button_open_map')
        }}
      </button>
    </template>
  </DefaultField>
</template>

<script>
import {FormField, HandlesValidationErrors} from 'laravel-nova'
import DefaultButton from "../../../vendor/laravel/nova/resources/js/components/Buttons/DefaultButton";
import RoundInput from "../../../vendor/laravel/nova/resources/js/components/Inputs/RoundInput";
import TextField from "../../../vendor/laravel/nova/resources/js/fields/Filter/TextField";
import HelpText from "../../../vendor/laravel/nova/resources/js/components/HelpText";
import YandexMapModal from "./YandexMapModal";

export default {
  components: {YandexMapModal, HelpText, TextField, RoundInput, DefaultButton},

  mixins: [FormField, HandlesValidationErrors],

  props: ['resourceName', 'resourceId', 'field'],

  data() {
    return {
      init: false,
      showMap: false,
      errorText: null
    }
  },

  methods: {

    setValue(value) {
      this.value = value;
    },

    closeModal() {
      this.showMap = false
    },

    /*
     * Set the initial, internal value for the field.
     */
    setInitialValue() {
      this.value = this.field.value || ''
    },

    /**
     * Fill the given FormData object with the field's internal value.
     */
    fill(formData) {
      formData.append(this.field.attribute, this.value || '')
    },
  },
}
</script>
