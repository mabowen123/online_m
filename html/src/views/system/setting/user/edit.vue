<template>
  <el-dialog
    :title="title"
    :visible.sync="visible"
    @open="open"
    @close="close"
  >
    <el-form
      ref="form"
      v-loading="loading"
      :element-loading-text="loadingMessage"
      :model="data"
      :rules="rules"
      label-width="80px"
    >

      <el-form-item label="ID">
        <el-input
          v-model="data.id"
          :disabled="true"
          placeholder="ID"
        />
      </el-form-item>
      <el-form-item
        label="用户名"
        prop="username"
      >
        <el-input
          v-model="data.username"
          placeholder="用户名"
        />
      </el-form-item>
      <el-form-item
        label="用户姓名"
        prop="name"
      >
        <el-input
          v-model="data.name"
          placeholder="用户姓名"
        />
      </el-form-item>
      <el-form-item
        label="密码"
        prop="password"
      >
        <el-input
          v-model="data.password"
          placeholder="密码"
          type="password"
        />
      </el-form-item>
      <el-form-item
        label="确认密码"
        prop="password_confirm"
      >
        <el-input
          v-model="data.password_confirm"
          placeholder="确认密码"
          type="password"
        />
      </el-form-item>
      <el-form-item>
        <el-button
          :disabled="loading"
          type="primary"
          @click="submit"
        >确定</el-button>
        <el-button
          :disabled="loading"
          @click="close"
        >取消</el-button>
      </el-form-item>

    </el-form>
  </el-dialog>
</template>

<script>
import { deepClone } from '@/utils'
import { fetchDetail, modtify } from '@/api/user'
const defaultData = {
  id: undefined,
  name: undefined,
  username: undefined,
  password: undefined,
  password_confirm: undefined
}

export default {
  name: 'UserEdit',
  props: {
    title: {
      type: String,
      default: ''
    },
    show: {
      type: Boolean,
      default: false
    }
  },
  data() {
    var validatePwdConfirm = (rule, value, callback) => {
      if (value === '') {
        callback(new Error('确认密码不能为空'))
      } else if (value !== this.data.password) {
        callback(new Error('两次输入密码不一致'))
      } else {
        callback()
      }
    }
    return {
      data: deepClone(defaultData),
      loading: false,
      loadingMessage: '正在加载',
      rules: {
        username: [
          {
            required: true, trigger: 'blur', message: '用户名不能为空'
          }
        ],
        name: [
          {
            required: true, trigger: 'blur', message: '名称不能为空'
          },
          {
            pattern: /^[A-Za-z0-9\u4e00-\u9fa5_-]{1,20}$/, message: '最多20位不包含特殊符号的字符串', trigger: 'blur'
          }
        ],
        password: [
          {
            pattern: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,32}$/, trigger: 'change', message: '8~32个字符(字母或数字)，至少1个大写字母，1个小写字母和1个数字'
          }
        ],
        password_confirm: [
          {
            validator: validatePwdConfirm, trigger: 'change'
          }
        ]
      }
    }
  },
  computed: {
    visible: {
      get() {
        return this.show
      },
      set(val) {
        this.$emit('update:show', val)
      }
    }
  },
  methods: {
    setId(id) {
      this.data.id = id
    },
    open() {
      if (this.data.id) {
        this.loading = true
        fetchDetail(this.data.id).then(res => {
          this.loading = false
          this.setData(res)
        }).catch(() => {
          this.loading = false
        })
      }
    },
    submit() {
      this.$refs.form.validate(valid => {
        if (valid) {
          this.loading = true
          modtify(this.data).then(() => {
            this.loading = false
            this.visible = false
            this.$emit('save:success')
          }).catch(() => {
            this.loading = false
          })
        }
      })
    },
    setData(data) {
      this.data = data
    },
    close() {
      this.visible = false
      this.setData(deepClone(defaultData))
    }
  }
}
</script>
