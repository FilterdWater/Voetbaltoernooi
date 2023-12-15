<?php
function htmlHead($pageName)
{
  echo '<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title> Voetbaltoernooi | ' .
    $pageName .
    ' </title>
    <link rel="stylesheet" href="./style/output.css" />
  </head>';
}
//button
function htmlHeader()
{
  $buttons = '<a class="hidden rounded-md bg-zinc-200 px-5 py-2 text-sm font-medium text-orange-400 transition hover:text-orange-400/75 md:block" href="register.php"> Register </a> <a class="block rounded-md bg-orange-400 px-5 py-2 text-sm font-medium text-white transition hover:bg-orange-500" href="login.php"> Login </a>';
  if (isset($_SESSION['logged_in'])) {
    $buttons = '<form action="" method="post"><button class="md:block hidden rounded-md bg-red-500 px-5 py-2 text-sm font-medium text-white transition" name="logout" type="submit"> Logout </button></form>';
  }
  logout();
  echo '
	<header class="bg-orange-50 p-2 shadow-md">
	<div class="xs:px-4 flex h-16 items-center justify-between gap-8 px-2 sm:px-6 lg:px-8">
		<a class="block text-teal-600" href="index.php">
			<span class="sr-only">Home</span>
			<img src="./images/svg/knvb.svg" alt="knvb-logo" class="h-auto w-14" />
		</a>
		<nav class="hidden md:block">
			<ul class="flex items-center gap-6 text-sm">
			<li><a href="index.php" class="hover:cursor-pointer">home</a></li>
			<li><a href="teams.php" class="hover:cursor-pointer">teams</a></li>
			<li><a href="match.php" class="hover:cursor-pointer">matches</a></li>
			</ul>
		</nav>
		<div class="flex items-center gap-4 sm:flex">
		' .
    $buttons .
    '
			<button id="toggleMenu" class="block rounded bg-zinc-200 p-2 text-gray-600 transition hover:text-gray-600/75 md:hidden">
			<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
				<path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path>
			</svg>
			</button>
		</div>
	</div>
	</header>
	<aside id="sideMenu" class="z-50 hidden">
	<div class="fixed bottom-0 left-0 grid min-h-full min-w-full grid-flow-col">
		<div class="col-span-3 block bg-orange-50 shadow-md">
			<nav class="flex flex-col justify-center">
			<div class="flex justify-between">
				<a class="block text-teal-600" href="/">
					<span class="sr-only">Home</span>
					<img src="./images/svg/knvb.svg" alt="knvb-logo" class="m-2 h-14 w-auto" />
				</a>
				<svg id="hamCloseBtn" class="m-4 h-10 w-auto cursor-pointer text-gray-400 hover:text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M6 18L18 6M6 6l12 12"></path>
				</svg>
			</div>

			<ul class="mx-auto flex flex-col items-center gap-6 text-sm">
				<li><a href="index.php" class="hover:cursor-pointer">home</a></li>
				<li><a href="teams.php" class="hover:cursor-pointer">teams</a></li>
				<li><a href="match.php" class="hover:cursor-pointer">matches</a></li>
				<li><a class="block rounded-md bg-red-500 px-5 py-2 text-sm font-medium text-white transition" href="#"> Logout </a></li>
			</ul>
			</nav>
		</div>
		<div id="backDrop" class="bg-black/25"></div>
	</div>
	</aside>';
}

function htmlfooter()
{
  echo '';
}

?>
