<template>
    <select v-model="id" class="form-control">
        <option value="">- Selecciona una categoría</option>
        <option v-for="category in categories" :value="category.id">
            {{ category.name }}
        </option>
    </select>
</template>

<script>
export default {
    template: "#select_category_tpl",
    props: ['categories', 'id']
}
</script>