<script setup>
import {onMounted, computed, reactive} from "vue";

const props = defineProps({
    loans: { type: Array, required: false },
})

const state = reactive({
    redditUser: '',
    showUserCheck: false,
});


onMounted(() => {
    console.log('loans', props.loans);
})
const totalInCirculation = computed(() => {
    let amount = 0;
    props.loans.map((loan) => {
        amount += Number(loan.loan.loan_amount);
    })
    return amount;
})
import AppLayout from '@/Layouts/AppLayout.vue';
import CreateLoanForm from '@/Pages/Dashboard/Partials/CreateLoanForm.vue';
import UpdateLoans from '@/Pages/Dashboard/Partials/UpdateLoans.vue';
import TextInput from "../Components/TextInput.vue";
import SecondaryButton from "../Components/SecondaryButton.vue";
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <create-loan-form></create-loan-form>

                    <div class="px-5">
                        <SecondaryButton
                            class="mb-3"
                            @click="state.showUserCheck = !state.showUserCheck"
                        >
                            Check User
                        </SecondaryButton>
                        <div
                            v-if="state.showUserCheck"
                        >
                            <TextInput
                                placeholder="Username"
                                id="redditUser"
                                v-model="state.redditUser"
                                type="text"
                                class="mb-3"
                            />
                            <div>
                                <a :href="`https://redditloans.com/loans.html?username=${state.redditUser}`" target="_blank">
                                    Loan History
                                </a>
                            </div>
                            <div>
                                <a :href="`https://universalscammerlist.com/search.php?username=${state.redditUser}`" target="_blank">
                                    USL
                                </a>
                            </div>
                            <div>
                                <a :href="`https://reddit-user-analyser.netlify.app/#${state.redditUser}`" target="_blank">
                                    Reddit User Analysis
                                </a>
                            </div>
                            <div>
                                <a href="https://www.freecarrierlookup.com/" target="_blank">Phone Check</a>
                            </div>
                        </div>
                    </div>
                    <h3 class="px-5 mb-5 text-2xl">
                        Loans
                    </h3>
                    <update-loans :loans="loans"></update-loans>
                    Info
                    <div>
                        Current in circulation: ${{ totalInCirculation }}
                    </div>
                    <div>
                        Total loans in progress: {{ props.loans.length }}
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
