<script setup>
import http from '@/services/http.js';

function sendFile(){
    event.preventDefault();
    http.post('/uploads', new FormData(document.querySelector('form')))
        .then(response => {
            console.log(response);
        })
        .catch(error => {
            alert(error.response.data.message);
        });
}

</script>
<template>
    <form v-on:submit="sendFile()" enctype="multipart/form-data" class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
        <input type="file" accept="application/json" name="file" id="file" class="sr-only" />
        <div class="col-span-full">
            <label for="photo" class="block   text-4xl text-white">Upload de JSON</label>
            <div class="mt-2 flex items-center gap-x-3">
                <label for="file" class="rounded-md bg-white/10 px-3 py-2 text-sm font-semibold text-white inset-ring inset-ring-white/5 hover:bg-white/20">Selecionar arquivo .json</label>
            </div>
        </div>
        <div class="mt-2 flex items-center gap-x-3">
            <button type="submit"  class="rounded-md bg-green-700 px-3 py-2 text-sm font-semibold text-white inset-ring inset-ring-white/5 hover:bg-white/20">Enviar</button>
        </div>
    </form>
</template>