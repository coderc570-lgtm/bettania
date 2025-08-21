<template>
    <div :class="customClass">
        <label :for="name" class="block mb-2 text-sm font-medium text-gray-900">{{ label }}</label>
        <quill-editor
            v-model="internalValue"
            :options="editorOptions"
            @input="onInput"
            :placeholder="placeholder"
            class="quill-editor"
            :style="{ height: editorHeight }"
        />
    </div>
</template>

<script lang="ts">
import { defineComponent, ref, watch, PropType } from 'vue';
import { QuillEditor } from '@vueup/vue-quill';
import 'quill/dist/quill.snow.css';

export default defineComponent({
    name: 'BaseQuillTextEditor',
    components: {
        QuillEditor,
    },
    props: {
        modelValue: {
            type: String as PropType<string>,
            required: true,
        },
        editorOptions: {
            type: Object as PropType<Record<string, any>>, // Define specific Quill options as needed
            default: () => ({
                theme: 'snow',
            }),
        },
        name: {
            type: String,
            required: true,
        },
        label: {
            type: String,
            required: true,
        },
        placeholder: {
            type: String,
            default: 'Type something...',
        },
        customClass: {
            type: String,
            default: '',
        },
        editorHeight: {
            type: String,
            default: '200px',
        },
    },
    setup(props, { emit }) {
        const internalValue = ref(props.modelValue);
        watch(
            () => props.modelValue,
            (newValue) => {
                internalValue.value = newValue;
            }
        );

        const onInput = (content: string) => {
            console.log('Quill Content:', content);
            internalValue.value = content;
            emit('update:modelValue', content);
        };

        return {
            internalValue,
            onInput,
        };
    },
});
</script>