<?php
if (!isset($error)) {
	if (!isset($menu)) {
		$menu = 'templates/home/header.php';
	}
	include $menu;
}
?>
<?php
/*if ($_SESSION['nivel_user'] >= 0) {
	if (isset($sidebar)) {
		include $sidebar;
	}
}*/
?>
<?php echo $contenido ?>

<?php
if (!isset($error)) {
	if (!isset($pie)) {
		$pie = 'templates/home/footer.php';
	}
	include $pie;
}
?>