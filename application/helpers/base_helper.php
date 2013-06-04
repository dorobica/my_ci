<?php

function ddump($a) {
	echo '<pre style="padding: 10px; font-family: Menlo, Monaco, Consolas, "Courier New", monospace; font-size: 12px; color: #333; line-height: 18px; word-break: break-all; word-wrap: break-word; white-space: pre; white-space: pre-wrap; background-color: #ededed; border: 1px solid #333;">', var_dump($a), '</pre>';
}