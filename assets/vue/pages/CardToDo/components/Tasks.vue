<template>
    <div class="flex flex-col items-center text-white">
        <div>
            {{task.name}}
        </div>

    </div>
</template>

<script>
export default {
    name: "Tasks",
    props: ['task']
}
</script>

<style scoped>

</style>