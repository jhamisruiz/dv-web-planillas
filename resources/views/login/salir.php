<?php

	session_destroy();

	echo '<script>window.location.replace("' . URL_HOST_WEB . '");</script>';
?>