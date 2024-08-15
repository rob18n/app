import { defineStore } from 'pinia';
import { ref } from 'vue';

export const useModalStore = defineStore('modalStore', () => {
    const variableDeleteModalIsOpen = ref(false);
    const variableEditModalIsOpen = ref(false);

    return {
        variableDeleteModalIsOpen, variableEditModalIsOpen
    };
});
