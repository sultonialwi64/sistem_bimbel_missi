<?php
$file = __DIR__ . '/app/Http/Controllers/Admin/SubjectController.php';
$content = file_get_contents($file);
$patched = str_replace("'in:SD,SMP,SMA'", "'in:PAUD,SD,SMP,SMA'", $content);
file_put_contents($file, $patched);
echo "Done - replaced " . substr_count($content, "in:SD,SMP,SMA") . " occurrence(s)\n";
