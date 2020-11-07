<template>
  <div class="app-container">
    <div class="filter-container">
      <el-input-number
        v-model="filter.id"
        :min="1"
        placeholder="ID"
        class="filter-item"
        clearable
      />
      <el-input
        v-model="filter.name"
        placeholder="用户姓名"
        class="filter-item"
        style="width:200px"
        clearable
      />

      <el-input
        v-model="filter.username"
        style="width:200px"
        placeholder="用户名"
        class="filter-item"
        clearable
      />
      <filter-search-button
        :loading="data.loading"
        @click="handleFilter"
      />

      <filter-add-button
        :disabled="data.loading"
        @click="handleAdd"
      />
    </div>
    <el-table
      v-loading="data.loading"
      :element-loading-text="data.loadingMessage"
      :data="data.list"
      border
      highlight-current-row
      stripe
    >
      <el-table-column
        label="ID"
        width="80"
      >
        <template slot-scope="scope">
          <span>{{ scope.row.id }}</span>
        </template>
      </el-table-column>

      <el-table-column label="用户姓名">
        <template slot-scope="scope">
          <span>{{ scope.row.name }}</span>
        </template>
      </el-table-column>
      <el-table-column label="用户名">
        <template slot-scope="scope">
          <span>{{ scope.row.username }}</span>
        </template>
      </el-table-column>

      <el-table-column label="创建时间">
        <template slot-scope="scope">
          <span>{{ scope.row.created_at }}</span>
        </template>
      </el-table-column>

      <el-table-column label="修改时间">
        <template slot-scope="scope">
          <span>{{ scope.row.updated_at }}</span>
        </template>
      </el-table-column>
      <el-table-column label="状态">
        <template slot-scope="scope">
          <el-tag :type="_type(scope.row) ">
            {{ _typeText(scope.row) }}
          </el-tag>
        </template>
      </el-table-column>
      <el-table-column
        label="操作"
        align="center"
        width="180"
      >
        <template slot-scope="scope">
          <div v-if="!scope.row.deleted_at">
            <el-button
              size="mini"
              @click="hanldeEdit(scope.row.id)"
            >编辑</el-button>
            <el-button
              size="mini"
              type="danger"
              @click="hanldeDelete(scope.row.id)"
            >删除</el-button>
          </div>
          <el-button
            v-else
            size="mini"
            type="primary"
            @click="hanldeRecover(scope.row.id)"
          >恢复</el-button>
        </template>
      </el-table-column>
    </el-table>

    <pagination
      v-show="data.total>0"
      :total="data.total"
      :page.sync="filter.page"
      :limit.sync="filter.limit"
      @pagination="getList"
    />
    <edit
      ref="edit"
      :title="edit.title"
      :show="edit.show"
      @update:show="updateShow"
      @save:success="getList"
    />
  </div>
</template>

<script>
import Pagination from '@/components/Pagination'
import Edit from './edit'
import { confirm } from '@/utils/message'
import { fetchList, deleteModel, recover } from '@/api/user'
import { FilterSearchButton, FilterAddButton } from '@/components/Button'
export default {
  name: 'User',
  components: {
    Pagination,
    Edit,
    FilterSearchButton,
    FilterAddButton
  },
  data() {
    return {
      filter: {
        id: undefined,
        username: undefined,
        name: undefined
      },
      data: {
        loading: false,
        loadingMessage: '加载中...',
        total: 0,
        list: []
      },
      edit: {
        title: undefined,
        show: false
      }
    }
  },
  computed: {
    _type() {
      return (row) => {
        return row.deleted_at === null ? 'success' : 'danger'
      }
    },
    _typeText() {
      return (row) => {
        return row.deleted_at === null ? '正常' : '已删除'
      }
    }
  },
  created() {
    this.handleFilter()
  },
  methods: {
    handleFilter() {
      this.filter.page = 1
      this.getList()
    },
    hanldeDelete(id) {
      const _self = this
      confirm('确认删除吗?', '警告', 'warngin', function() {
        _self.data.loading = true
        _self.data.loadingMessage = '正在删除...'
        deleteModel(id).then(() => {
          _self.data.loading = false
          _self.handleFilter()
        }).catch(() => {
          _self.data.loading = false
        })
      })
    },
    hanldeRecover(id) {
      const _self = this
      confirm('确认恢复吗?', '提示', 'info', function() {
        _self.data.loading = true
        _self.data.loadingMessage = '正在删除...'
        recover(id).then(() => {
          _self.data.loading = false
          _self.handleFilter()
        }).catch(() => {
          _self.data.loading = false
        })
      })
    },
    getList() {
      this.data.loading = true
      fetchList(this.filter).then(res => {
        this.data.loading = false
        this.data.list = res.list
        this.data.total = res.total
      }).catch(() => {
        this.data.loading = false
      })
    },
    handleAdd() {
      this.showEdit()
    },
    hanldeEdit(id) {
      this.showEdit(id)
    },
    showEdit(id) {
      this.edit.show = true
      this.edit.title = id ? '编辑' : '添加'
      this.$refs.edit.setId(id)
    },
    updateShow(val) {
      this.edit.show = val
    }
  }
}
</script>
