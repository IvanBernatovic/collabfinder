<?php

namespace Deployer;

require 'recipe/laravel.php';

// Config

set('repository', 'git@github.com:IvanBernatovic/collabfinder.git');

add('shared_files', []);
add('shared_dirs', []);
add('writable_dirs', []);


echo 'Deployer path: ' . getenv('DEPLOYER_PATH') . PHP_EOL;
echo 'NPM bin: ' . getenv('NPM_BIN') . PHP_EOL;

// Hosts
host('app.collabfinder.net')
    ->set('env', [
        'NPM_BIN' => getenv('NPM_BIN'),
        'DEPLOYER_PATH' => getenv('DEPLOYER_PATH'),
    ])
    ->set('remote_user', 'ivan')
    ->set('deploy_path', getenv('DEPLOYER_PATH') ?: '')
    ->set('bin/php', '/usr/bin/php7.4')
    ->set('bin/composer', '/usr/bin/php7.4 /usr/local/bin/composer')
    ->set('composer_options', '--verbose --prefer-dist --no-progress --no-interaction --no-dev --optimize-autoloader')
    ->set('bin/npm', getenv('NPM_BIN'));


// Tasks
desc('Install npm packages in CI mode');
task('npm:ci', function () {
    if (has('previous_release')) {
        if (test('[ -d {{previous_release}}/node_modules ]')) {
            run('cp -R {{previous_release}}/node_modules {{release_path}}');
        }
    }
    run("cd {{release_path}} && {{bin/npm}} ci");
});

task('supervisor:restart', function () {
    run('supervisorctl restart "collabfinder-worker:*"');
});


// Hooks
after('deploy:failed', 'deploy:unlock');
after('deploy:vendors', 'npm:ci');
after('deploy:publish', 'supervisor:restart');
