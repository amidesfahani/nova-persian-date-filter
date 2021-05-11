<template>
    <div>
        <h3 class="text-sm uppercase tracking-wide text-80 bg-30 p-3">{{ filter.name }}</h3>
        <div class="p-2">
            <date-picker
				:id="filter.name + '-filter-date'"
				:type="type"
				:color="color"
				:placeholder="placeholder"
				inputClass="block w-full form-control-sm date-ltr"
				:initial-value="persianDate"
				v-model="value"
				@change="handleChange"
				:range="range"
				clearable
				locale="fa,en"
				:min="minDate"
				:max="maxDate"
				:format="format"
				:display-format="displayFormat"
            ></date-picker>
        </div>
    </div>
</template>

<script>
import VuePersianDatetimePicker from 'vue-persian-datetime-picker'
import jMoment from "moment-jalaali"
export default {
	props: {
		resourceName: {
			type: String,
			required: true,
		},
		filterKey: {
			type: String,
			required: true,
		},
	},
	data() {
		return {
			value: null
		}
	},
	methods: {
		handleChange() {
			var value = this.value.map(value => {
				return jMoment(value, this.format).format('YYYY-MM-DD')
            })

			this.$store.commit(`${this.resourceName}/updateFilterState`, {
				filterClass: this.filterKey,
				value,
			})
			this.$emit('change')
		}
	},
	computed: {
		format() {
			return this.filter.format || 'YYYY-MM-DD HH:mm'
		},

		displayFormat() {
			return this.filter.display_format || "jYYYY/jM/jD"
		},

		persianDate() {
			if (!this.filter.currentValue) {
				return '';
			} else {
				return jMoment(this.filter.currentValue).format(this.format)
			}
		},

		range() {
			return (this.filter.mode === 'range') ? 'range' : 'single'
		},

		type() {
			return this.filter.type || `date`
		},

		placeholder() {
			return this.filter.placeholder || this.__('Choose date')
		},

		value() {
			if (typeof this.filter.currentValue === 'object' && this.filter.currentValue.length >= 2){
				return [this.startDate, this.endDate]
			}
			return this.filter.currentValue || null
		},

		filter() {
			return this.$store.getters[`${this.resourceName}/getFilter`](
				this.filterKey
			)
		},

		options() {
			return this.$store.getters[`${this.resourceName}/getOptionsForFilter`](
				this.filterKey
			)
		},
	},

	mounted() {
    	this.options.forEach((option) => {
			Object.assign(this.filter, {[option.name]: option.value})
    	})
	},

	components: {
		datePicker: VuePersianDatetimePicker
	}
}
</script>

<style>
</style>