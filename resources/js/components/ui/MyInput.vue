<template >
  <b-form-input v-text="myValue" @keypress="isNumber($event)" @change="updateMyValue"></b-form-input>
</template>
<script>
export default {

  props: {
    myValue: String | Number,
  },
  methods: {
    isNumber(evt) {
      const keysAllowed = [
        "0",
        "1",
        "2",
        "3",
        "4",
        "5",
        "6",
        "7",
        "8",
        "9",
        ".",
      ];
      const keyPressed = evt.key;

      if (!keysAllowed.includes(keyPressed)) {
        evt.preventDefault();
      }
    },

    updateMyValue(e) {
        this.$emit('updateMyValue', e.target.value)
    },
  },
};
</script>
