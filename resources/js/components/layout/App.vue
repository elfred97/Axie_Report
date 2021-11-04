<template>
  <div id="app">
    <!-- BEGIN #page-container -->
	  <div id="page-container" class="fade show">
        <!-- BEGIN #header -->
        <header-component></header-component>
        <!-- END #header -->
        
        <router-view></router-view>
        
        <footer-component></footer-component>
        
        <copyright-component></copyright-component>
		
    </div>
    <!-- END #page-container -->
  </div>
</template>
