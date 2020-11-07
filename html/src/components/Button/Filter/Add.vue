<template>
  <el-button
    :disabled="disabled"
    class="filter-item"
    type="primary"
    icon="el-icon-plus"
    @click="handleClick"
  >添加</el-button>
</template>

<script>
export default {
  name: 'FilterAddButton',
  props: {
    disabled: {
      type: Boolean,
      default: false
    }
  },
  methods: {
    handleClick() {
      this.$emit('click')
    }
  }
}
</script>
