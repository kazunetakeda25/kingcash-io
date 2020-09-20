@ECHO OFF
SET BIN_TARGET=%~dp0/../rgooding/protobuf-php/protoc-gen-php.php
php "%BIN_TARGET%" %*
