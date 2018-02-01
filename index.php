<?php
/**
 * Simple file server
 * @usage   php -S <ip>:<port> index.php
 * @notice  cd root dir and run above code.
 * @notice  replace <ip> to your server ip, e.g. 10.11.12.13;
 * @notice  replace <port> to a port that is not occupied, e.g. 8000.
 * @notice  use -t to specify root dir if needed.
 * @author  chenkai
 * @url     https://github.com/chenkai2
 */
$dir = dirname(__FILE__);
$self = $_SERVER['PHP_SELF'];
if($self=='/index.php')
{
    $self='';
}
$path = "{$dir}{$self}";
//if file doesn't exists, 404
if(!file_exists($path))
{
    http_response_code(404);
    exit;
}
//if it is a file (not a dir), directly download it / .php would be executed.
if(is_file($path))
{
    return false;
}
//if it is a dir, list its entries.
echo "<p>content of:<br>{$self}/<br>is:</p>";
$dirs = [];
$files = [];

$d = dir($path);
while(false !== ($entry = $d->read()))
{
    if($entry == '.' || $entry == '..')
    {
        continue;
    }
    $fullPath="{$path}/{$entry}";
    if(is_file($fullPath))
    {
        $files[] = $entry;
    }
    elseif(is_dir($fullPath))
    {
        $dirs[] = $entry;
    }
}
$d->close();

sort($dirs);
sort($files);

echo "<ul>";
foreach($dirs as $entry)
{
    echo "<li><a href='{$self}/{$entry}'>{$entry}/</a></li>";
}

foreach($files as $entry)
{
    echo "<li><a href='{$self}/{$entry}'>{$entry}</a></li>";
}
echo "</ul>";
