<template>
  <div class="navbar">
    <hamburger
      :is-active="sidebar.opened"
      class="hamburger-container"
      @toggleClick="toggleSideBar"
    />

    <breadcrumb class="breadcrumb-container" />
    <div class="left-menu">
      <el-button-group>
        <el-button
          v-for="group in groups"
          :key="group.name"
          :type="group.type"
          round
          @click="switchRoutes(group.name)"
        >
          {{ group.name }}
        </el-button>
      </el-button-group>
    </div>
    <div class="right-menu">
      <el-dropdown
        class="avatar-container"
        trigger="click"
      >
        <div class="avatar-wrapper">
          {{ name }}
          <i class="el-icon-caret-bottom" />
        </div>
        <el-dropdown-menu
          slot="dropdown"
          class="user-dropdown"
        >
          <el-dropdown-item
            divided
            @click.native="logout"
          >
            <span style="display:block;">退出</span>
          </el-dropdown-item>
        </el-dropdown-menu>
      </el-dropdown>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import { deepClone } from '@/utils'
import Breadcrumb from '@/components/Breadcrumb'
import Hamburger from '@/components/Hamburger'
import { routeGroups } from '@/router'
export default {
  components: {
    Breadcrumb,
    Hamburger
  },
  data() {
    return {
      currentRoute: deepClone(this.$store.getters.addRouters)
    }
  },
  computed: {
    ...mapGetters([
      'sidebar',
      'name'
    ]),
    groups: {
      get: function() {
        return routeGroups()
      }
    }
  },
  methods: {
    routeGroups,
    toggleSideBar() {
      this.$store.dispatch('app/toggleSideBar')
    },
    switchRoutes(groupName) {
      this.$store.commit('SET_ROUTERS', this.handleRouter(groupName))
    },
    handleRouter(groupName) { // 路由类别切换
      let items = []
      this.groups.map(item => {
        if (item.name === groupName) {
          items = item.routes
        }
      })
      const newitems = []
      items.forEach(a => {
        this.currentRoute.forEach(b => {
          if (a.path === b.path) {
            newitems.push(b)
          }
        })
      })

      return newitems
    },
    async logout() {
      await this.$store.dispatch('user/logout').then(() => {
        location.reload()
      })
      this.$router.push(`/login?redirect=${this.$route.fullPath}`)
    }
  }
}
</script>

<style lang="scss" scoped>
.navbar {
  height: 50px;
  overflow: hidden;
  position: relative;
  background: #fff;
  box-shadow: 0 1px 4px rgba(0, 21, 41, 0.08);

  .hamburger-container {
    line-height: 46px;
    height: 100%;
    float: left;
    cursor: pointer;
    transition: background 0.3s;
    -webkit-tap-highlight-color: transparent;

    &:hover {
      background: rgba(0, 0, 0, 0.025);
    }
  }

  .breadcrumb-container {
    float: left;
  }
  .left-menu {
    margin-left: 20px;
    align-items: center;
    float: left;
    height: 100%;
  }
  @media screen and (max-width: 723px) {
    .left-menu {
      >>> .el-button-group {
        .el-button {
          padding: 10px 10px;
        }
      }
    }
  }
  @media screen and (max-width: 638px) {
    .left-menu {
      >>> .el-button-group {
        margin-left: -5px;
        .el-button {
          padding: 10px 10px;
          border-radius: 0;
        }
      }
    }
    .right-menu {
      float: none !important;
      width: 80px;
      margin: 0 auto;
    }
  }
  .right-menu {
    float: right;
    height: 100%;
    line-height: 50px;

    &:focus {
      outline: none;
    }

    .right-menu-item {
      display: inline-block;
      padding: 0 8px;
      height: 100%;
      font-size: 18px;
      color: #5a5e66;
      vertical-align: text-bottom;

      &.hover-effect {
        cursor: pointer;
        transition: background 0.3s;

        &:hover {
          background: rgba(0, 0, 0, 0.025);
        }
      }
    }

    .avatar-container {
      margin-right: 30px;

      .avatar-wrapper {
        margin-top: 5px;
        position: relative;

        .user-avatar {
          cursor: pointer;
          width: 40px;
          height: 40px;
          border-radius: 10px;
        }

        .el-icon-caret-bottom {
          cursor: pointer;
          position: absolute;
          right: -20px;
          top: 25px;
          font-size: 12px;
        }
      }
    }
  }
}
</style>
