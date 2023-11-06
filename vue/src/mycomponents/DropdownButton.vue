<script setup>
import { ref } from 'vue'
import { computed } from 'vue'
import { RouterLink } from 'vue-router'
import { getButtonColor } from '@/colors.js'
import BaseIcon from '@/components/BaseIcon.vue'

const props = defineProps({
  label: {
    type: [String, Number],
    default: null
  },
  icon: {
    type: String,
    default: null
  },
  iconSize: {
    type: [String, Number],
    default: null
  },
  href: {
    type: String,
    default: null
  },
  target: {
    type: String,
    default: null
  },
  to: {
    type: [String, Object],
    default: null
  },
  type: {
    type: String,
    default: null
  },
  color: {
    type: String,
    default: 'white'
  },
  as: {
    type: String,
    default: null
  },
  small: Boolean,
  outline: Boolean,
  active: Boolean,
  disabled: Boolean,
  roundedFull: Boolean
})

const is = computed(() => {
  if (props.as) {
    return props.as
  }

  if (props.to) {
    return RouterLink
  }

  if (props.href) {
    return 'a'
  }

  return 'button'
})

const computedType = computed(() => {
  if (is.value === 'button') {
    return props.type ?? 'button'
  }

  return null
})

const labelClass = computed(() => (props.small && props.icon ? 'px-1' : 'px-2'))

const componentClass = computed(() => {
  const base = [
    'inline-flex',
    'justify-center',
    'items-center',
    'whitespace-nowrap',
    'focus:outline-none',
    'transition-colors',
    'focus:ring',
    'duration-150',
    'border',
    props.disabled ? 'cursor-not-allowed' : 'cursor-pointer',
    props.roundedFull ? 'rounded-full' : 'rounded',
    getButtonColor(props.color, props.outline, !props.disabled, props.active)
  ]

  if (!props.label && props.icon) {
    base.push('p-1')
  } else if (props.small) {
    base.push('text-sm', props.roundedFull ? 'px-3 py-1' : 'p-1')
  } else {
    base.push('py-2', props.roundedFull ? 'px-6' : 'px-3')
  }

  if (props.disabled) {
    base.push(props.outline ? 'opacity-50' : 'opacity-70')
  }

  return base
})


const isDropdownOpen = ref(false);

const toggleDropdown = () => {
  isDropdownOpen.value = !isDropdownOpen.value;
};

const closeDropdown = () => {
  isDropdownOpen.value = false;
};
</script>

<template>
  <component
      :is="is"
      :class="`${componentClass} relative inline-block text-left`"
      :href="href"
      :type="computedType"
      :to="to"
      :target="target"
      :disabled="disabled"
    >
    <!-- <div class=""> -->
      <button @click="toggleDropdown" class="bg-blue-500 text-white px-4 py-2 rounded-md">
        Dropdown
      </button>
      <div v-if="isDropdownOpen" @click="closeDropdown" class="fixed inset-0 z-10"></div>
      <div v-if="isDropdownOpen" class="absolute right-0 mt-2 py-2 w-48 bg-white border border-gray-300 rounded-md shadow-lg">
        <!-- Dropdown items go here -->
        <slot />
      </div>
    <!-- </div> -->
  </component>
</template>
<!-- <DropdownButton >
        <span  class="block px-4 py-2 text-gray-800 hover:bg-blue-100" @click="isModalActive = true" >Change Password</span>
      </DropdownButton> -->

