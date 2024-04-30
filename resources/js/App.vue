<template>
  <div>
    <router-view></router-view>
  </div>
</template>

<style>
@import url('https://fonts.googleapis.com/css?family=Montserrat:400,800');

* {
  --primary: #1e91cf;
  --secondary: #8e1ecf;
  box-sizing: border-box;
}

body {
	background: #f6f5f7;
	display: flex;
	justify-content: center;
	align-items: center;
	flex-direction: column;
	font-family: 'Montserrat', sans-serif;
	height: 100vh;
	margin: -20px 0 50px;
}
</style>
