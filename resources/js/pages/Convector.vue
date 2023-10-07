<template>
  <v-app>
    <b-container>
      <b-row>
        <b-col xl='6' class='bg--light mx-auto'>
          <h1 class='text-center mb-4'>Конвектор Валют</h1>
          <!-- selecting bank -->
          <b-form-select
            v-model='selectedBankId'
            :options='banks'
            value-field='id'
            text-field='display_name'
          ></b-form-select>

          <b-row class='justify-content-between mt-3' no-gutters>
            <b-col cols='12' md='5'>
              <b-row no-gutters>
                <!-- place of currency selection -->
                <b-form-select
                  class='mb-2'
                  @change='clearInputs'
                  v-model='selected[0]'
                  :options='countries'
                ></b-form-select>

                <!-- place to enter a value -->
                <my-input @input='convert' v-model.number='inputed'></my-input>
              </b-row>
              <!-- rates currency -->
              <rates-currency
                :currencies='currencies'
                :selectedCurrency='selected[0]'
                :currenciesOfBank='bank.currencies'
              ></rates-currency>
            </b-col>

            <b-col cols='12' md='5'>
              <b-row no-gutters>
                <!-- place of currency selection -->
                <b-form-select
                  class='mb-2'
                  @change='clearInputs'
                  v-model='selected[1]'
                  :options='countries'
                ></b-form-select>
                <!-- place to display the result -->
                <b-form-input v-model='result' readonly></b-form-input>
              </b-row>
              <!-- rates currency -->
              <rates-currency
                :currencies='currencies'
                :selectedCurrency='selected[1]'
                :currenciesOfBank='bank.currencies'
              ></rates-currency>
            </b-col>
          </b-row>
        </b-col>
      </b-row>
    </b-container>
  </v-app>
</template>

<script>
import axios from 'axios'
import MyInput from '../components/ui/MyInput.vue'
import RatesCurrency from '../components/convector/RatesCurrency.vue'

export default {
  components: { MyInput, RatesCurrency },
  name: 'Convector',

  data() {
    return {
      selected: ['UAH', 'USD'],
      selectedBankId: 1,
      inputed: '',
      result: null,
      countries: ['UAH'],
      banks: [],
      bank: {},
      currencies: [],
    }
  },

  methods: {
    convert() {
      // Default currency values / UAH
      const defaultCurrency = {
        purchase: 1,
        sale: 1,
      }

      // First selected currency details
      const firstCurrency =
        this.bank.currencies[this.selected[0]] ?? defaultCurrency
      const firstCurrencyPurchase =
        firstCurrency.purchase * Number(this.inputed)

      // Second selected currency details
      const secondCurrency =
        this.bank.currencies[this.selected[1]] ?? defaultCurrency
      const secondCurrencySale = Number(secondCurrency.sale)

      // Result calculating
      const result = firstCurrencyPurchase / secondCurrencySale

      // // Rounding to ten thousandths
      this.result = result ? Math.floor(result * 1000) / 1000 : null
    },

    async requestDataForConvector(id = 1) {
      try {
        
        const { data } = await axios.get(
          'http://localhost/api/convector/banks',
          {
            params: {
              bank_id: id,
            },
          }
        )

        this.bank = data.bank
        this.banks = data.banks
        this.currencies = data.currencies

        Object.keys(data.bank.currencies).forEach((code) => {
          if (!this.countries.find((country) => country == code)) {
            this.countries.push(code)
          }
        })
      } catch (e) {
        console.log(e)
      }
    },
    clearInputs() {
      this.inputed = null
      this.result = null
    },
  },

  mounted() {
    this.requestDataForConvector(this.selectedBankId).then(() => {
      this.convert()
    })
  },

  watch: {
    selectedBankId() {
      this.requestDataForConvector(this.selectedBankId)
      this.inputed = null
      this.result = null
    },
  },
}
</script>

