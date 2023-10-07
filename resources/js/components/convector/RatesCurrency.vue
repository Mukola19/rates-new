<template >
  <div class='rates'>
    <p>
      {{ currencyName }}
    </p>
    <p>
      Купiвля:
      {{ purchase }}
    </p>
    <p>Продаж: {{ sale }}</p>
  </div>
</template>
<script>
export default {
  props: {
    currencies: Array,
    currenciesOfBank: Array,
    selectedCurrency: String,
  },

  computed: {
    purchase() {
      return this.currenciesOfBank?.[this.selectedCurrency]?.purchase ?? '1'
    },
    sale() {
      return this.currenciesOfBank?.[this.selectedCurrency]?.sale ?? '1'
    },

    currencyName() {
      return (
        this.currencies.find(
          (currency) => currency.code === this.selectedCurrency
        )?.name || 'Українська гривня'
      )
    },
  },
}
</script>
<style lang='scss'>
.rates {
  padding: 10px
}
</style>