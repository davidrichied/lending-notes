<script setup>
import { ref, reactive, computed } from 'vue';
import { useForm } from '@inertiajs/inertia-vue3';
import ActionMessage from '@/Components/ActionMessage.vue';
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import Checkbox from '@/Components/Checkbox.vue';
import SelectInput from "@/Components/SelectInput.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import { useVuelidate } from '@vuelidate/core'
import { required, email } from '@vuelidate/validators'
import {Inertia} from "@inertiajs/inertia";
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';
import TextAreaInput from "../../../Components/TextAreaInput.vue";
const textInputOptions = ref({
    format: 'yyyy-MM-dd'
})

const props = defineProps({
    formState: { type: Object, required: false },
    vuelidate: {type: Object, required: false },
    formAction: {type: Function, required: false}
})

const state = reactive({
    loading: false,
    existing_user: false,
});


const addPayment = () => {
    props.formState.payments.push({
        amount: '',
        repay_at: '',
        repaid_at: '',
    })
}

const removePayment = (idx) => {
    const id = props.formState.payments[idx].id;
    if (id) {
        Inertia.post(route('payments.destroy', id), {}, {
            preserveScroll: true,
        });
    }
    props.formState.payments.splice(idx,1);
}
</script>

<template>
    <FormSection @submitted="props.formAction">
        <template #form>
            <!-- Loan Amount -->
            <div class="col-span-6 sm:col-span-2">
                <TextInput
                    placeholder="Loan Amount"
                    id="loan_amount"
                    v-model="props.formState.loan.loan_amount"
                    type="text"
                    class="mt-1 block w-full"
                />
<!--                <div class="input-errors" v-for="error of props.vuelidate.loan.loan_amount.$errors" :key="error.$uid">-->
<!--                    <InputError :message="error.$message" class="mt-2" />-->
<!--                </div>-->
            </div>
            <!-- Repayment -->
            <div class="col-span-6 sm:col-span-2">
                <TextInput
                    placeholder="Repayment"
                    id="repayment_amount"
                    v-model="props.formState.loan.repayment_amount"
                    type="text"
                    class="mt-1 block w-full"
                />
<!--                <div class="input-errors" v-for="error of props.vuelidate.loan.repayment_amount.$errors" :key="error.$uid">-->
<!--                    <InputError :message="error.$message" class="mt-2" />-->
<!--                </div>-->
            </div>
            <!-- Req Post -->
            <div class="col-span-6 sm:col-span-2">
                <TextInput
                    placeholder="Req Post"
                    id="req_post"
                    v-model="props.formState.loan.req_post"
                    type="text"
                    class="mt-1 block w-full"
                />
<!--                <div class="input-errors" v-for="error of props.vuelidate.loan.req_post.$errors" :key="error.$uid">-->
<!--                    <InputError :message="error.$message" class="mt-2" />-->
<!--                </div>-->
            </div>
            <!-- Status -->
            <div class="col-span-6 sm:col-span-3">
                <SelectInput
                    placeholder="Status"
                    id="status"
                    v-model="props.formState.loan.status"
                    :options="{ possible: 'Possible', in_progress: 'In Progress', complete: 'Complete' }"
                    class="mt-1 block w-full"
                />
                <!--                <div class="input-errors" v-for="error of props.vuelidate.loan.status.$errors" :key="error.$uid">-->
                <!--                    <InputError :message="error.$message" class="mt-2" />-->
                <!--                </div>-->
            </div>
            <!-- Is Unpaid -->
            <div class="col-span-6 sm:col-span-3">
                <InputLabel for="is_unpaid" value="Is Unpaid" />
                <div class="w-5">
                    <Checkbox
                        id="is_unpaid"
                        name="is_unpaid"
                        v-model="props.formState.is_unpaid"
                        class="mt-1 block w-full"
                    />
                </div>
            </div>
            <!-- Payments -->
            <div class="col-span-6">
                <div
                    class="grid grid-cols-6 gap-6 relative"
                    v-for="(payment, idx) in props.formState.payments"
                >
                    <div class="col-span-6 sm:col-span-2">
                        <TextInput
                            placeholder="Amount"
                            :id="`payment-amount-${idx}`"
                            v-model="payment.amount"
                            type="text"
                            class="mt-1 block w-full"
                        />
                    </div>
                    <div class="col-span-6 sm:col-span-2">
                        <TextInput
                            placeholder="Repay At"
                            :id="`repay-at-${idx}`"
                            v-model="payment.repay_at"
                            type="text"
                            class="mt-1 block w-full"
                        />
                    </div>
                    <div class="col-span-6 sm:col-span-2">
                        <TextInput
                            placeholder="Repaid At"
                            :id="`repaid-at-${idx}`"
                            v-model="payment.repaid_at"
                            type="text"
                            class="mt-1 block w-full"
                        />
                    </div>
                    <div class="absolute right-0">
                        <Dropdown align="right" width="48">
                            <template #trigger>
                                <span class="inline-flex rounded-md">
                                    <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition">
                                        <svg
                                            class="ml-2 -mr-0.5 h-4 w-4"
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
                                    >
                                        Remove
                                    </div>
                                </div>
                            </template>
                        </Dropdown>

                    </div>
                </div>
                <div
                    class="col-span-6 gap-6"
                >
                    <SecondaryButton
                        class="mt-3"
                        @click="addPayment"
                    >
                        Add Payment
                    </SecondaryButton>
                </div>
            </div>

            <!-- Notes -->
            <div class="col-span-6 sm:col-span-3">
                <div>
                    <textarea
                        id="notes"
                        name="notes"
                        v-model="props.formState.borrower.notes"
                        class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                    >
                    </textarea>
                </div>
            </div>

            <!-- Borrower -->
            <div class="col-span-6">
                <InputLabel for="existing_user" value="Existing User?" />
                <div class="w-5">
                    <Checkbox
                        id="existing_user"
                        v-model="state.existing_user"
                        class="mt-1 block w-full"
                    />
                </div>
            </div>

            <div v-if="state.existing_user">

            </div>
            <div v-else class="grid grid-cols-6 col-span-6 gap-6">
                <!-- First Name -->
                <div class="col-span-6 sm:col-span-3">
                    <TextInput
                        placeholder="First Name"
                        id="first_name"
                        v-model="props.formState.borrower.first_name"
                        type="text"
                        class="mt-1 block w-full"
                    />
<!--                    <div class="input-errors" v-for="error of props.vuelidate.borrower.first_name.$errors" :key="error.$uid">-->
<!--                        <InputError :message="error.$message" class="mt-2" />-->
<!--                    </div>-->
                </div>
                <!-- Last Name -->
                <div class="col-span-6 sm:col-span-3">
                    <TextInput
                        placeholder="Last Name"
                        id="last_name"
                        v-model="props.formState.borrower.last_name"
                        type="text"
                        class="mt-1 block w-full"
                    />
<!--                    <div class="input-errors" v-for="error of props.vuelidate.borrower.last_name.$errors" :key="error.$uid">-->
<!--                        <InputError :message="error.$message" class="mt-2" />-->
<!--                    </div>-->
                </div>
                <!-- Email -->
                <div class="col-span-6 sm:col-span-3">
                    <TextInput
                        placeholder="Email"
                        id="email"
                        v-model="props.formState.borrower.email"
                        type="text"
                        class="mt-1 block w-full"
                    />
<!--                    <div class="input-errors" v-for="error of props.vuelidate.borrower.email.$errors" :key="error.$uid">-->
<!--                        <InputError :message="error.$message" class="mt-2" />-->
<!--                    </div>-->
                </div>

                <!-- Phone -->
                <div class="col-span-6 sm:col-span-3">
                    <TextInput
                        placeholder="Phone"
                        id="phone"
                        v-model="props.formState.borrower.phone"
                        type="text"
                        class="mt-1 block w-full"
                    />
<!--                    <div class="input-errors" v-for="error of props.vuelidate.borrower.phone.$errors" :key="error.$uid">-->
<!--                        <InputError :message="error.$message" class="mt-2" />-->
<!--                    </div>-->
                </div>

                <!-- City -->
                <div class="col-span-6 sm:col-span-2">
                    <TextInput
                        placeholder="City"
                        id="city"
                        v-model="props.formState.borrower.city"
                        type="text"
                        class="mt-1 block w-full"
                    />
<!--                    <div class="input-errors" v-for="error of props.vuelidate.borrower.city.$errors" :key="error.$uid">-->
<!--                        <InputError :message="error.$message" class="mt-2" />-->
<!--                    </div>-->
                </div>

                <!-- State -->
                <div class="col-span-6 sm:col-span-2">
                    <TextInput
                        placeholder="State"
                        id="state"
                        v-model="props.formState.borrower.state"
                        type="text"
                        class="mt-1 block w-full"
                    />
<!--                    <div class="input-errors" v-for="error of props.vuelidate.borrower.state.$errors" :key="error.$uid">-->
<!--                        <InputError :message="error.$message" class="mt-2" />-->
<!--                    </div>-->
                </div>

                <!-- Zip -->
                <div class="col-span-6 sm:col-span-2">
                    <TextInput
                        placeholder="Zip"
                        id="zip"
                        v-model="props.formState.borrower.zip"
                        type="text"
                        class="mt-1 block w-full"
                    />
<!--                    <div class="input-errors" v-for="error of props.vuelidate.borrower.zip.$errors" :key="error.$uid">-->
<!--                        <InputError :message="error.$message" class="mt-2" />-->
<!--                    </div>-->
                </div>

                <!-- PayPal Email -->
                <div class="col-span-6 sm:col-span-2">
                    <TextInput
                        placeholder="PayPal Email"
                        id="paypal_email"
                        v-model="props.formState.borrower.paypal_email"
                        type="text"
                        class="mt-1 block w-full"
                    />
<!--                    <div class="input-errors" v-for="error of props.vuelidate.borrower.paypal_email.$errors" :key="error.$uid">-->
<!--                        <InputError :message="error.$message" class="mt-2" />-->
<!--                    </div>-->
                </div>

                <!-- Reddit -->
                <div class="col-span-6 sm:col-span-2">
                    <TextInput
                        placeholder="Reddit"
                        id="reddit"
                        v-model="props.formState.borrower.reddit"
                        type="text"
                        class="mt-1 block w-full"
                    />
<!--                    <div class="input-errors" v-for="error of props.vuelidate.borrower.reddit.$errors" :key="error.$uid">-->
<!--                        <InputError :message="error.$message" class="mt-2" />-->
<!--                    </div>-->
                </div>

                <!-- Facebook -->
                <div class="col-span-6 sm:col-span-2">
                    <TextInput
                        placeholder="Facebook"
                        id="facebook"
                        v-model="props.formState.borrower.facebook"
                        type="text"
                        class="mt-1 block w-full"
                    />
<!--                    <div class="input-errors" v-for="error of props.vuelidate.borrower.facebook.$errors" :key="error.$uid">-->
<!--                        <InputError :message="error.$message" class="mt-2" />-->
<!--                    </div>-->
                </div>

            </div>

        </template>

        <template #actions>
            <PrimaryButton :class="{ 'opacity-25': state.loading }" :disabled="state.loading">
                Create
            </PrimaryButton>
        </template>
    </FormSection>
</template>
