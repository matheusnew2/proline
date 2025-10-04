<script setup>
import http from '@/services/http.js';
import {reactive,ref} from 'vue';
import { ArrowPathIcon } from '@heroicons/vue/24/solid'
const batches = reactive({batches:[]});
const jobs = reactive({jobs:[]});
const actualBatch = ref('');
getBatches();
setInterval(async () => {
     getBatches();
   }, 3000);
function getBatches(){

    http.get('/uploads')
    .then(response => {
        batches.batches = response.data;
        if(actualBatch.value){
            getJobs(actualBatch.value);
        }
    })
    .catch(error => {
        batches.batches = [];
    });

}
function getJobs(batch_id){
    actualBatch.value = batch_id;
    http.get(`/uploads/${batch_id}`)
        .then(response => {
            jobs.jobs = response.data;
        })
        .catch(error => {
            
        });
}
function reprocessBatch(batch_id){
     http.post(`/uploads/${batch_id}/reprocess`)
        .then(response => {
   
        })
        .catch(error => {
            batches.batches = [];
        });
}
function reprocessJob(job_id){
     http.post(`/uploads/job/${job_id}/reprocess`)
        .then(response => {
   
        })
        .catch(error => {
            batches.batches = [];
        });
}
</script>
<template>
    <div>
    <div class="w-3/4 m-auto flex flex-col gap-4">
        <label class="text-white text-4xl">Lista de uploads</label>
        <div v-for="batches in batches.batches" >
            <div  class="bg-gray-500 p-4 rounded-lg" v-on:click="getJobs(batches.id)">
                <div class="text-white text-xl font-bold  flex justify-between">
                    <div class="flex flex-col justify-between" >
                        <label>Upload Nº {{ batches.name }} 
                            <button  class="rounded p-1 text-sm"  :class="{ 
                                'bg-amber-300' : batches.status == 'pending' || batches.status == 'processing',
                                'bg-red-500' : batches.status == 'failed',
                                'bg-green-500' : batches.status == 'success', 
                                }">{{ batches.status }} </button>
                            {{ batches.progress }}%
                        </label>
                    </div>
                    <template v-if="batches.status == 'failed'">
                        <ArrowPathIcon v-on:click="reprocessBatch(batches.id)" class="w-[30px] hover:text-gray-300 hover:cursor-pointer" />
                    </template>
                </div>
                <template v-if="jobs.jobs[batches.id]">
                    <template v-if="jobs.jobs[batches.id].failed_jobs.length > 0">
                        <div v-for="failed_job in jobs.jobs[batches.id].failed_jobs" class="bg-red-300 rounded p-4 flex flex-col m-2">
                            <div class="flex justify-end" v-if="!failed_job.retry">
                                <ArrowPathIcon v-on:click="reprocessJob(failed_job.id)" class="w-[15px] hover:text-gray-300 hover:cursor-pointer" />
                            </div>
                            <div class="flex justify-between w-full">
                                <label class="">{{failed_job.name}} {{ failed_job.retry ? '(Retry)' : ''}}</label>
                                <i class="text-xs">{{ failed_job.date }}</i>
                            </div>
                            <label class="text-sm ml-5">{{failed_job.exception}}</label>
                            
                        </div>
                    </template>
                    <div v-if="jobs.jobs[batches.id].quantidades" class="flex flex-col gap-2 mt-5">
                        <div v-for="(quantidade,table) in jobs.jobs[batches.id].quantidades" :class="{'bg-green-300':quantidade == jobs.jobs[batches.id].arquivo[table],'bg-gray-100' : quantidade == 0, 'bg-amber-300':quantidade != jobs.jobs[batches.id].arquivo[table],}" class=" rounded p-2 flex justify-between">
                            <label>{{ table }}</label>
                            <label>Registros inseridos: {{quantidade}} / {{ jobs.jobs[batches.id].arquivo[table] }}</label>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
    </div>
</template>