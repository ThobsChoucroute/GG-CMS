<template>
    <section class="content-header">
        <h1>
            {{ page_name }}
            <small> {{ page_description }} </small>
        </h1>
        <!-- <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
        </ol> -->
    </section>
</template>

<script>
export default {
    props: [
        'page_name',
        'page_description',
    ]
}
</script>

<style>

</style>
