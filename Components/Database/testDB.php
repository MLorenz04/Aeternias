<?php 
echo extension_loaded("mongodb") ? "loaded\n" : "not loaded\n";
$m = new MongoClient();