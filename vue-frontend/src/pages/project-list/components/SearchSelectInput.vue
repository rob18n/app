<template>
    <div class="form-group position-relative">
        <input type="text" class="form-control mb-1 dropdown-toggle" v-model="searchTerm"
            placeholder="Sprachen durchsuchen" @click="showDropdown = true" @blur="hideDropdown" />
        <ul v-show="showDropdown && filteredOptions.length" class="dropdown-menu w-100" style="display: block">
            <li v-for="language in filteredOptions" :key="language.shortkey" @mousedown.prevent="select(language)"
                class="dropdown-item" :aria-disabled="language.shortkey === selectedOption">
                {{ language.shortkey }}
            </li>
            <li v-if="filteredOptions.length === 0" class="dropdown-item disabled">No results found</li>
        </ul>
    </div>
</template>

<script setup>
import { ref, computed, defineEmits } from 'vue'
import { useLanguageStore } from '@/stores/languageStore'

const props = defineProps(['selectedLanguages'])
const languageStore = useLanguageStore()
const { languages } = languageStore
const searchTerm = ref('')
const selectedOption = ref('')
const showDropdown = ref(false)
const emit = defineEmits(['addLanguage'])

const select = function (language) {
    if (language.shortkey !== selectedOption.value) {
        selectedOption.value = language.shortkey
        searchTerm.value = ''
        emit('addLanguage', language)
        showDropdown.value = false
    }
}

const filteredOptions = computed(() => {
    return languageStore.languages.filter(language => {
        const isSelected = props.selectedLanguages.some(selectedLang => selectedLang.shortkey === language.shortkey)
        return !isSelected && language.shortkey.toLowerCase().includes(searchTerm.value.toLowerCase())
    })
})


const hideDropdown = () => {
    setTimeout(() => {
        showDropdown.value = false
    }, 150)
}
</script>
