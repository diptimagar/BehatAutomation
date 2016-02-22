@ECHO OFF
SET BIN_TARGET=%~dp0/../vendor/brianium/paratest/bin/paratest
php "%BIN_TARGET%" %*
