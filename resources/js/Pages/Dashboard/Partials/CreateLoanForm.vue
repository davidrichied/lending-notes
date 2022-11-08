<template>
    <div>
        <div
            class="px-5 my-5"
        >
            <SecondaryButton
                @click="state.showForm = !state.showForm"
            >
                Create Loan
            </SecondaryButton>
        </div>

        <CreateLoanFormFields
            v-show="state.showForm"
            :form-state="formState"
            :form-action="createLoan"
            class="mb-5"
        ></CreateLoanFormFields>
    </div>
</template>
<script setup>
import { ref, reactive, computed } from 'vue';
import { useVuelidate } from '@vuelidate/core'
import { required, email } from '@vuelidate/validators'
import {Inertia} from "@inertiajs/inertia";
import '@vuepic/vue-datepicker/dist/main.css';
import CreateLoanFormFields from "./CreateLoanFormFields.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";

const state = reactive({
    showForm: false,
});
const formStateObject = {
    loan: {
        id: '',
        loan_amount: '',
        repayment_amount: '',
        status: 'possible',
        is_unpaid: false,
        req_post: '',
        req_post_title: '',
        sent_at: '',
        completed_at: '',
        notes: '',
        is_late: false,
        user_id: '',
        borrower_id: '',
    },
    borrower: {
        id: '',
        first_name: '',
        last_name: '',
        phone: '',
        email: '',
        city: '',
        state: '',
        zip: '',
        paypal_email: '',
        reddit: '',
        facebook: '',
        notes: '',
    },
    payments: [
        {
            id: '',
            amount: '',
            repay_at: '',
            repaid_at: '',
            is_unpaid: '',
            loan_id: '',
        }
    ],
};
const formStateDefaults = JSON.stringify(formStateObject);

const formState = reactive(formStateObject);

const rules = {
    loan: {
        loan_amount: { required: false },
        repayment_amount: { required: false },
        is_unpaid: { required: false },
        req_post: { required: false },
        req_post_title: { required: false },
        sent_at: { required: false },
        completed_at: { required: false },
        status: { required: false },
        notes: { required: false },
        is_late: { required: false },
    },
    borrower: {
        // id: '',
        first_name: { required: false },
        last_name: { required: false },
        phone: { required: false },
        email: { required: false },
        city: { required: false },
        state: { required: false },
        zip: { required: false },
        paypal_email: { required: false },
        reddit: { required: false },
        facebook: { required: false },
    },
}

// const vuelidate = useVuelidate(rules, formState)

const createLoan = () => {
    Inertia.post(route('loans.store'), formState);
    resetForm();
};

const resetForm = () => {
    const defaultForm = JSON.parse(formStateDefaults);
    formState.payments = defaultForm.payments;
    formState.borrower = defaultForm.borrower;
    formState.loan = defaultForm.loan;
}
</script>
