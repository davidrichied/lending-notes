<script setup>
import {ref, onMounted, reactive, computed} from 'vue'
import { Inertia } from "@inertiajs/inertia";
import CreateLoanFormFields from "./CreateLoanFormFields.vue";
import SecondaryButton from "../../../Components/SecondaryButton.vue";
import Dropdown from "@/Components/Dropdown.vue";

const state = reactive({
    edit: false,
    showPayments: false,
    showBorrower: false,
    showLoan: false,
});

const formState = reactive(props.loan);

const props = defineProps({
    loan: { type: Object, required: false },
})

onMounted(() => {
    // do something on mounted
})

const totalRepaymentAmount = computed(() => Number(props.loan.loan.loan_amount) + Number(props.loan.loan.repayment_amount))

const updateLoan = () => {
    Inertia.post(route('loans.update'), formState, {
        preserveScroll: true,
    });
};

const saveAndClose = () => {
    updateLoan();
    state.edit = false;
}

const removePayment = (idx) => {
    const id = props.loan.payments[idx].id;
    if (id) {
        Inertia.post(route('payments.destroy', id), {}, {
            preserveScroll: true,
        });
    }
    props.loan.payments.splice(idx,1);
}

</script>
<template>
    <div>
        <div
            class="px-5 mb-10"
        >
            <div class="flex">
                <SecondaryButton
                    class="mr-3"
                    @click="() => state.edit = !state.edit"
                >
                    {{ state.edit === true ? 'Done' : 'Edit' }}
                </SecondaryButton>
                <SecondaryButton
                    @click="updateLoan"
                    v-if="state.edit === true"
                >
                    Save & Close
                </SecondaryButton>
            </div>
            <div v-if="state.edit">
                <CreateLoanFormFields
                    :form-state="formState"
                    :form-action="saveAndClose"
                >
                </CreateLoanFormFields>
            </div>
            <div v-else>
                <div>
                    <div
                        @click="state.showBorrower = !state.showBorrower"
                        class="cursor-pointer py-1 text-lg text-blue-700 hover:text-blue-900"
                    >
                        {{ props.loan.borrower.first_name }} {{ props.loan.borrower.last_name }}
                    </div>
                    <div
                        v-if="state.showBorrower"
                        class="border border-blue-500 px-3 pt-2 pb-1 mb-1 rounded"
                    >
                        <div>
                            {{ props.loan.borrower.phone }}
                        </div>
                        <div>
                            {{ props.loan.borrower.email }}
                        </div>
                        <div v-if="props.loan.borrower.paypal_email && (props.loan.borrower.email !== props.loan.borrower.paypal_email)">
                            PayPal Email: {{ props.loan.borrower.paypal_email }}
                        </div>
                        <div v-if="props.loan.borrower.facebook">
                            <a :href="props.loan.borrower.facebook" target="_blank">Facebook</a>
                        </div>
                        <div>
                            <a :href="`https://reddit.com/u/${props.loan.borrower.reddit}`" target="_blank">
                                Reddit ({{ props.loan.borrower.reddit }})
                            </a>
                        </div>
                        <div>
                            <a :href="`https://redditloans.com/loans.html?username=${props.loan.borrower.reddit}`" target="_blank">
                                Loan History
                            </a>
                        </div>
                        <div>
                            <a :href="`https://universalscammerlist.com/search.php?username=${props.loan.borrower.reddit}`" target="_blank">
                                USL
                            </a>
                        </div>
                        <div>
                            <a :href="`https://reddit-user-analyser.netlify.app/#${props.loan.borrower.reddit}`" target="_blank">
                                Reddit User Analysis
                            </a>
                        </div>
                        <div>
                            {{ props.loan.borrower.city }}, {{ props.loan.borrower.state }}
                        </div>
                        <div>
                            <div v-html="props.loan.borrower.notes"></div>
                        </div>
                    </div>
                </div>
                <div>
                    <div
                        @click="state.showPayments = !state.showPayments"
                        class="cursor-pointer"
                    >
                        Next Pmt: {{ props.loan.payments[0].repay_at }} (${{ props.loan.payments[0].amount }})
                    </div>
                    <div
                        v-if="state.showPayments"
                        class="border border-blue-500 px-3 pt-2 pb-1 mb-1 rounded"
                    >
                        <div
                            v-for="(payment, idx) in props.loan.payments"
                            class="flex mb-2"
                        >
                            <div>
                                ${{ payment.amount }} {{ payment.repay_at }} {{ payment.repaid_at }}
                            </div>
                            <Dropdown align="right" width="48">
                                <template #trigger>
                                <span class="inline-flex rounded-md">
                                    <button type="button" class="border border-gray-300 bg-gray-100 ml-2 inline-flex items-center px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition">
                                        <svg
                                            class="h-4 w-4"
                                            xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20"
                                            fill="currentColor"
                                        >
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </span>
                                </template>

                                <template #content>
                                    <div>
                                        <div
                                            @click="removePayment(idx)"
                                            class="cursor-pointer px-3"
                                        >
                                            Remove
                                        </div>
                                    </div>
                                </template>
                            </Dropdown>
                        </div>
                    </div>
                </div>
                <div>
                    <div
                        @click="state.showLoan = !state.showLoan"
                        class="cursor-pointer"
                    >
                        Loan for ${{ props.loan.loan.loan_amount }} (${{ totalRepaymentAmount }} total repayment)
                    </div>
                    <div v-if="state.showLoan">
                        <div>
                            <a :href="props.loan.loan.req_post" target="_blank">REQ Post</a>
                        </div>
                        <div>
                            <div>
                                $confirm /u/paircoder {{ Number(props.loan.loan.loan_amount) }}.00 USD
                            </div>
                            <div>[PAID] (/u/{{ props.loan.borrower.reddit }}) (${{ Number(props.loan.loan.loan_amount) }}) (On Time)</div>
                            <div>$paid /u/{{ props.loan.borrower.reddit }} ${{ Number(props.loan.loan.loan_amount) }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
