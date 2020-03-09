<?php

/**
 * @file
 * Contains \DrupalProject\composer\ScriptHandler.
 */

namespace DrupalProject\composer;

use Composer\Script\Event;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

class ScriptHandler
{

  public static function prepareForPantheon()
  {
    // Get rid of any .git directories that Composer may have added.
    // n.b. Ideally, there are none of these, as removing them may
    // impair Composer's ability to update them later. However, leaving
    // them in place prevents us from pushing to Pantheon.
    $dirsToDelete = [];
    $finder = new Finder();
    foreach (
      $finder
        ->directories()
        ->in(getcwd())
        ->ignoreDotFiles(false)
        ->ignoreVCS(false)
        ->depth('> 0')
        ->name('.git')
      as $dir) {
      $dirsToDelete[] = $dir;
    }
    $fs = new Filesystem();
    $fs->remove($dirsToDelete);

    // Fix up .gitignore: remove everything above the "::: cut :::" line
    $gitignoreFile = getcwd() . '/.gitignore';
    $gitignoreContents = file_get_contents($gitignoreFile);
    $gitignoreContents = preg_replace('/.*::: cut :::*/s', '', $gitignoreContents);
    file_put_contents($gitignoreFile, $gitignoreContents);

    // Fix up .gitignore: remove everything above the "::: cut :::" line
    $gitignoreFile = getcwd() . '/web/wp-content/themes/THEME_NAME/.gitignore';
    $gitignoreContents = file_get_contents($gitignoreFile);
    $gitignoreContents = preg_replace('/.*::: cut :::*/s', '', $gitignoreContents);
    file_put_contents($gitignoreFile, $gitignoreContents);
  }

  protected static function copyDirectory($source, $dest) {
    if (PHP_OS === 'Windows')
    {
      exec(sprintf("Xcopy /E /I %s %s", escapeshellarg($source), escapeshellarg($dest)));
    }
    else
    {
      exec(sprintf("cp -rf %s %s", escapeshellarg($source), escapeshellarg($dest)));
    }
  }

  public static function setupTheme(Event $event) {
    $io = $event->getIO();

    $theme_name = $io->ask('Provide new theme name: ');
    $theme_machine_name = preg_replace('/_+/', '_', preg_replace(
      '/[^a-z0-9_]+/',
      '_',
      strtolower($theme_name)
    ));

    $web = getcwd() . '/web';
    $theme_dir = "{$web}/wp-content/themes/{$theme_machine_name}";
    $io->write('Creating new theme');

    self::copyDirectory("{$web}/wp-content/themes/jp-base", $theme_dir);
    $files = [
      '.circleci/config.yml',
      '.lando.base.yml',
      'composer.json',
    ];

    foreach ($files as $filename) {
      $file = file_get_contents($filename);
      file_put_contents($filename, preg_replace("/THEME_NAME/", $theme_machine_name, $file));
    }
    $filename = 'scripts/composer/ScriptHandler.php';
    $file = file_get_contents($filename);

    // Funny syntax is necessary since we don't want to replace this line itself.
    file_put_contents($filename, str_replace("/THEME_NAME/" . ".gitignore", "/{$theme_machine_name}/.gitignore", $file));
    exec("cd {$theme_dir} && npm install");
  }

  public static function setupSite(Event $event) {
    self::setupTheme($event);
    $io = $event->getIO();
    $site = $io->ask('Provide new site name (for example: ifa-d8): ');
    exec('git remote remove origin');
    exec('terminus build:project:create --pantheon-site="'. $site . '" --team="Taoti Creative" --org="Taoti" --admin-email="taotiadmin@taoti.com" --admin-password="Taoti1996" --ci=circleci --git=github ./ '. $site . ' --preserve-local-repository');
    file_put_contents('.lando.yml', "
name: {$site}
config:
  site: {$site}
#  id: PANTHEONSITEID
    ");
  }

  public static function enableGitHooks(Event $event) {
    if (!ScriptHandler::commandExists('sh')) {
      echo "sh MUST be in your path for these git hooks to work.";
      exit(1);
    }
    $args = $event->getArguments();
    copy('scripts/githooks/post-commit', '.git/hooks/post-commit');
    $pre = 'scripts/githooks/pre-commit';
    $msg = "Git hooks set up for this project to run automatic standards fixes. ";
    if ($args[0] === 'lando') {
      $pre .= '-lando';
      $msg .= "Running via Lando.";
    }
    else {
      $msg .= "Running in your local environment. See documentation if necessary to confirm requirements.";
    }
    copy ($pre, '.git/hooks/pre-commit');
    echo $msg;
  }

  public static function commandExists($command) {
    $test = (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') ? "where" : "which";
    return is_executable(trim(shell_exec("$test $command")));

  }
}
