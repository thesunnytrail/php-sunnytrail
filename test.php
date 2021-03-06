<?php
require_once 'class.SunnyTrail.php';

$api_key = 'KEY'; // Settings tab

$sunny = new SunnyTrail($api_key);


$new_event_data = array(
	'action' => array('name' => 'signup', 'created' => time()),
	'plan' => array('name' => 'Basic', 'price' => 29, 'recurring' => 31),
	'name' => 'User1',
	'email' => 'johndoe@gmail.com',
	'id' => 12345
);

$event = $sunny->addEvent($new_event_data);


if ($event)
{
	echo 'All done, event added!';
}
else
{
	echo 'Something went wrong, event not added...';
}
