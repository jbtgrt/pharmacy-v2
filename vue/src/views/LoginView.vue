<script setup>
import { ref, reactive } from 'vue'
import { useStore } from "vuex";
import { useRouter } from 'vue-router'
import { mdiAccount, mdiAsterisk, mdiLockOutline } from '@mdi/js'
import SectionFullScreen from '@/components/SectionFullScreen.vue'
import CardBox from '@/components/CardBox.vue'
import FormCheckRadio from '@/components/FormCheckRadio.vue'
import FormField from '@/components/FormField.vue'
import FormControl from '@/components/FormControl.vue'
import BaseButton from '@/components/BaseButton.vue'
import BaseButtons from '@/components/BaseButtons.vue'
import LayoutGuest from '@/layouts/LayoutGuest.vue'
import Alert from "../mycomponents/Alert.vue";
import TButtonLoading from "../mycomponents/core/TButtonLoading.vue";

const store = useStore()
const router = useRouter()


const user = ref({
  email: "",
  password: "",
  remember: false
});

let loading = ref(false);
let errorMsg = ref("");

function login(ev) {
  ev.preventDefault();

  loading.value = true;
  store
    .dispatch("login", user.value)
    .then((data) => {
      loading.value = false;
      const userRole = data.user[0].role.toLowerCase(); 
      store.commit('setRole', userRole)
      if(userRole!='supplier'){
        router.push(`/${userRole}/`);
      } else {
         router.push('/dashboard');
      }
    })
    .catch((err) => {
      loading.value = false;
      errorMsg.value = err.response.data.error;
    });
}
</script>

<template>
  <!-- <LayoutGuest> -->
    <SectionFullScreen v-slot="{ cardClass }" bg="greenLime">
      <CardBox :class="cardClass">
        <div class="flex min-h-full flex-1 flex-col justify-center px-6 py-12 lg:px-8">
          <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <img @click="router.push('/home')" class="mx-auto h-12 w-auto hover:cursor-pointer" src="@/assets/PharmIMS-pharmacy.png" alt="PharmIMS LOGO" />
            

            <h2 class="mt-5 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Sign in to your account</h2>
          </div>
          <div class="mt-5 sm:mx-auto sm:w-full sm:max-w-sm">
            <form class="space-y-6" @submit="login">
              <Alert v-if="errorMsg">
                {{ errorMsg }}
                <span
                  @click="errorMsg = ''"
                  class="w-8 h-8 flex items-center justify-center rounded-full transition-colors cursor-pointer hover:bg-[rgba(0,0,0,0.2)]"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M6 18L18 6M6 6l12 12"
                    />
                  </svg>
                </span>
              </Alert>
              <input type="hidden" name="remember" value="true" />
                <div class="rounded-md shadow-sm -space-y-px">
                  <div>
                    <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email address</label>
                    <div class="mt-2">
                      <input v-model="user.email" id="email" name="email" type="email" autocomplete="email" required="" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 mb-5" />
                    </div>
                  </div>
                  <div>
                    <!-- <div class="flex items-center justify-between">
                      <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
                      <div class="text-sm">
                        <a href="#" class="font-semibold text-indigo-600 hover:text-indigo-500">Forgot password?</a>
                      </div>
                    </div> -->
                    <div class="mt-2">
                      <input v-model="user.password" id="password" name="password" type="password" autocomplete="current-password" required="" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                    </div>
                  </div>
                </div>

                <div class="flex items-center justify-between hidden">
                  <div class="flex items-center">
                    <input
                      id="remember-me"
                      name="remember-me"
                      type="checkbox"
                      v-model="user.remember"
                      class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                    />
                    <label for="remember-me" class="ml-2 block text-sm text-gray-900">
                      Remember me
                    </label>
                  </div>
                </div>

              <div>
                <TButtonLoading :loading="loading" class="w-full relative justify-center">
                  <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                    
                  </span>
                  Sign in
                </TButtonLoading>
              </div>
            </form>

           <!--  <p class="mt-10 text-center text-sm text-gray-500">
              Forgot Password?
              {{ ' ' }}
              <a href="#" class="font-semibold leading-6 text-indigo-600 hover:text-indigo-500">Request New Password</a>
            </p> -->
          </div>
        </div>
      </CardBox>
    </SectionFullScreen>
  <!-- </LayoutGuest> -->
</template>
