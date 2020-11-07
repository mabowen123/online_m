<template>
  <el-button
    :loading="loading"
    class="filter-item"
    type="primary"
    icon="el-icon-search"
    @click="handleClick"
  >搜索</el-button>
</template>

<script>

export default {
  name: 'FilterSearchButton',
  props: {
    loading: {
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
