@ECHO OFF
SET BIN_TARGET=%~dp0/../vendor/sauce/connect/bin/sauce_connect
php "%BIN_TARGET%" %*
