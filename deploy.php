<?php

namespace Deployer;

require 'recipe/laravel.php';

// Config

set('repository', 'https://github.com/IvanBernatovic/collabfinder.git');

add('shared_files', []);
add('shared_dirs', []);
add('writable_dirs', []);



// Hosts
host('app.collabfinder.net')
    ->set('dotenv', '{{current_path}}/.env')
    ->set('env', [
        'DEPLOYER_PATH' => getenv('DEPLOYER_PATH'),
    ])
    ->set('remote_user', 'ivan')
    ->set('deploy_path', getenv('DEPLOYER_PATH') ?: '')
    ->set('bin/php', '/usr/bin/php8.1')
    ->set('bin/composer', '/usr/bin/php8.1 /usr/local/bin/composer')
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
