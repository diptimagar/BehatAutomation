@ECHO OFF
SET BIN_TARGET=%~dp0/../vendor/sauce/sausage/bin/sauce_config
php "%BIN_TARGET%" %*
