<?php
if ($_SESSION['user']) {
    logout();
    exit();
}
