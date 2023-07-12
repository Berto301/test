<script setup>
import Navbar from "./Navbar.vue";
import Sidebar from "./Sidebar.vue";

defineProps({
  title: String,
  user: Object,
  notifications: Array,
});
</script>

<template>
  <div>
    <!-- Topbar Start -->
    <Navbar :user="user" :notifications="notifications" />
    <!-- end Topbar -->

    <!-- Start Content-->
    <div class="container-fluid">
      <!-- Begin page -->
      <div class="wrapper bg-[#f4f7f6]">
        <!-- ========== Left Sidebar Start ========== -->
         <Sidebar />
        <!-- Left Sidebar End -->

        <div class="w-[calc(100%-260px)] float-right relative mt-16 !bg-[#f4f7f6]">
          <div class="h-[88vh] p-4 flex flex-col space-y-4">
            <slot />
          </div>
          <!-- End Content -->

          <!-- Footer Start -->

          <!-- end Footer -->
        </div>
        <!-- content-page -->
      </div>
      <!-- end wrapper-->
    </div>
    <!-- END Container -->
  </div>
</template>
