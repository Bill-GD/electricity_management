<?php

if (isset($_REQUEST) && isset($_REQUEST['user_id'])) {
  echo "Deleting user with id: {$_REQUEST['user_id']}";
} else {
  echo "No id received";
}