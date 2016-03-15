# How to install CodeSniffer

## Install PHP
1. Download [PHP](http://windows.php.net/qa/)

> The VC9 builds require to have the Visual Studio 2008 SP1 x86 or x64 installed
> The VC11 builds require to have the Visual Studio 2012 x86 or x64 installed
> The VC14 builds require to have the Visual Studio 2015 x86 or x64 installed

2. Rename php.ini-development => php.ini
3. Try exec `php -v`.

## Install PEAR
1. Download [go-pear.phar](http://pear.php.net/go-pear.phar)
2. Copy go-pear.phar to php folder
3. Exec ```php go-pear.phar```
4. Check pear paths by ```pear config-show```.
5. If some paths are wrong repair it by pear ```config set KEY VALUE```

## Install PHP CodeSniffer
1. Exec ``` pear install PHP_CodeSniffer ```

## PHP Storm  PHP CodeSniffer
1. Open PHP Storm settings (Ctrl+Alt+S).
2. Languages & Deployment -> PHP -> Code Sniffer
3. Configuration - local. Click ```...```
4. Set phpcs path. For example: ```C:\php\phpcs.bat```
5. Editor -> Inspections (NOT intentions) -> PHP -> PHP Code Sniffer validation
6. Check it
7. Choose coding standart

## Add git hooks
1. Copy hooks in .git/hooks
2. Open .git/hooks/config
3. Change path to CodeSniffer PHPCS_BIN