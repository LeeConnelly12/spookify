<script setup>
import { useForm } from '@inertiajs/vue3'
import TextInput from '@/Components/TextInput.vue'
import InputLabel from '@/Components/InputLabel.vue'
import InputError from '@/Components/InputError.vue'

const form = useForm({
  name: null,
  year: new Date().getFullYear(),
  file: null,
  image: null,
})

function submit() {
  form.post('/songs')
}
</script>

<template>
  <div>create song page</div>
  <form @submit.prevent="submit">
    <div>
      <InputLabel for="name" value="Name" />
      <TextInput
        id="name"
        type="text"
        class="block w-full mt-1"
        v-model="form.name"
        required
        autofocus
        autocomplete="username"
      />
      <InputError class="mt-2" :message="form.errors.name" />
    </div>
    <div class="mt-4">
      <InputLabel for="file" value="File" />
      <input
        type="file"
        id="file"
        @input="form.file = $event.target.files[0]"
      />
      <InputError class="mt-2" :message="form.errors.file" />
    </div>
    <div class="mt-4">
      <InputLabel for="image" value="Image" />
      <input
        type="file"
        id="image"
        @input="form.image = $event.target.files[0]"
      />
      <InputError class="mt-2" :message="form.errors.image" />
    </div>
    <button class="mt-4">Submit</button>
  </form>
</template>
