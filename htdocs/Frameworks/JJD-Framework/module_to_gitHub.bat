
rem recupe du dossier parent qui est lenom du module
@echo off
echo "%~0"
echo "%~f0"
echo "%~dp0"
for %%a in ("%~dp0\.") do set "module=%%~nxa"
echo Nom du Dossier Parent est : "%module%" 


rem appel du batch generique
J:\Xoops\modules-JJD\copie_module_to_ghitHub.bat %module% %~dp0  
