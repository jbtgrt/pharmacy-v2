<script setup>
import { computed, ref, watchEffect } from 'vue'
import { useStore } from 'vuex'
import { useMainStore } from '@/stores/main'
import { mdiEye, mdiTrashCan, mdiAccountEdit, mdiMagnify   } from '@mdi/js'
import CardBoxModal from '@/components/CardBoxModal.vue'
import TableCheckboxCell from '@/components/TableCheckboxCell.vue'
import BaseLevel from '@/components/BaseLevel.vue'
import BaseButtons from '@/components/BaseButtons.vue'
import BaseButton from '@/components/BaseButton.vue'
import UserAvatar from '@/components/UserAvatar.vue'
import UserCard from '@/components/UserCard.vue'
import SelectedUserCard from '@/components/SelectedUserCard.vue'
import FormField from '@/components/FormField.vue'
import FormControl from '@/components/FormControl.vue'


defineProps({
  checkable: Boolean
})

const mainStore = useMainStore()
const store = useStore()

const isModalActive = ref(false)
const isModalEdit = ref(false)
const isModalDangerActive = ref(false)

const items = computed(() => store.state.userList);


const selectedRecord = ref({});

function showRecord(client) {
  
}


const selectOptions = [
  { id: 5, label: '5 per page' },
  { id: 15, label: '15 per page' },
  { id: 30, label: '30 per page' }
]

const roleOptions = [
  { id: '', label: 'All Roles' },
  { id: 'Admin', label: 'Admin' },
  { id: 'Staff', label: 'Staff' },
  { id: 'Patient', label: 'Patient' }
]



const perPage = ref(5)
const currentPage = ref(0)
const searchQuery = ref('');
const selectedRole = ref('');
const filteredItems = ref([]);
const pageList = ref([]);
const numPages = ref(7);

// const numPages = computed(() => Math.ceil(items.value.length / perPage.value));
const calculateNumPages = computed(() => Math.ceil(items.value.length / perPage.value));
numPages.value = calculateNumPages;
const currentPageHuman = computed(() => currentPage.value + 1)

const pagesList = computed(() => {
  const pagesList = []
  for (let i = 0; i < numPages.value; i++) {
    pagesList.push(i)
  }
  return pagesList
})


// Add a watcher to update the filtered items when searchQuery or selectedRole changes
watchEffect(() => {
  // Filter items based on searchQuery and selectedRole
  filteredItems.value = items.value.filter((user) => {
    return (
      (selectedRole.value === '' || user.role == selectedRole.value) &&
      (user.first_name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
       user.last_name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
       user.email.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
       user.address.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
       user.role.toLowerCase().includes(searchQuery.value.toLowerCase()))
    );
  });

  numPages.value = Math.ceil(filteredItems.value.length / perPage.value);

  // Reset currentPage to 0
  currentPage.value = 0;

  // Update pageList based on the new numPages
  pageList.value = [];
  for (let i = 0; i < numPages.value; i++) {
    pageList.value.push(i);
  }
});

// // Update the usersPaginated computed property to use filteredItems
const usersPaginated = computed(() => {
  return filteredItems.value.slice(perPage.value * currentPage.value, perPage.value * (currentPage.value + 1));
});

</script>

<template>
  <CardBoxModal v-if="selectedRecord.value != null" v-model="isModalActive" title="User Details" classValue="flex overflow-x-auto shadow-lg max-h-modal w-11/12 md:w-3/5 lg:w-4/5 xl:w-6/12 z-50">
    <SelectedUserCard :user="selectedRecord" class="mb-6" />
  </CardBoxModal>

  <section class="p-4">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
      <div class="xl:flex xl:flex-wrap lg:flex lg:flex-wrap " >
        <FormField class="md:w-6/12 lg:w-4/12  xl:w-2/6 xl:mr-2 lg:mr-2">
          <FormControl v-model="perPage" :options="selectOptions" />
        </FormField>
        <FormField class="md:w-6/12 lg:w-4/12 xl:w-2/6">
          <FormControl v-model="selectedRole" :options="roleOptions" />
        </FormField>
      </div>
      <div class="xl:flex xl:justify-end lg:flex lg:justify-end">
        <FormField class="md:w-6/12 lg:w-4/6 xl:w-4/6">
          <FormControl v-model="searchQuery" :icon="mdiMagnify" />
        </FormField>
      </div>
    </div>
  </section>
  
  <table>
    <thead>
      <tr>
        <th v-if="checkable" />
        <th />
        <th>Name</th>
        <th>Email</th>
        <th>Address</th>
        <th>Role</th>
        <th />
      </tr>
    </thead>
    <tbody>
      <tr v-for="users in usersPaginated" :key="users.id">
        <TableCheckboxCell v-if="checkable" @checked="checked($event, users)" />
        <td class="border-b-0 lg:w-6 before:hidden">
          <UserAvatar :avatar="users.image_url" :username="users.first_name" class="w-24 h-24 mx-auto lg:w-6 lg:h-6" />
        </td>
        <td data-label="Name">
          {{ users.first_name }} {{ users.last_name }}
        </td>
        <td data-label="Email">
          {{ users.email }}
        </td>
        <td data-label="Address">
          {{ users.address }}
        </td>
        <td data-label="Role">
          {{ users.role }}
        </td>
        <td class="before:hidden lg:w-1 whitespace-nowrap">
          <BaseButtons type="justify-start lg:justify-end" no-wrap>
            <BaseButton color="info" :icon="mdiEye" small @click="showRecord(isModalActive = true, selectedRecord.value = users)" />
            <BaseButton color="success" :icon="mdiAccountEdit" small :to="`/admin/edit-user/${users.id}`" />
          </BaseButtons>
        </td>
      </tr>
    </tbody>
  </table>
  <div class="p-3 lg:px-6 border-t border-gray-100 dark:border-slate-800">
    <BaseLevel>
      <BaseButtons>
        <BaseButton
          v-for="page in pagesList"
          :key="page"
          :active="page === currentPage"
          :label="page + 1"
          :color="page === currentPage ? 'lightDark' : 'whiteDark'"
          small
          @click="currentPage = page"
        />
      </BaseButtons>
      <small>Page {{ currentPageHuman }} of {{ numPages }}</small>
    </BaseLevel>
  </div>
</template>
