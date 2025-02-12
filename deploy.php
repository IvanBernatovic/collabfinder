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
    ->set('composer_options', '--verbose --prefer-dist --no-progress --no-interaction --no-dev --optimize-autoloader');

// Tasks
desc('Install npm packages in CI mode');
task('npm:ci', function () {
    run('export NVM_DIR="$([ -z "${XDG_CONFIG_HOME-}" ] && printf %s "${HOME}/.nvm" || printf %s "${XDG_CONFIG_HOME}/nvm")"
[ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh"');
    run('nvm use 14');
    if (has('previous_release')) {
        if (test('[ -d {{previous_release}}/node_modules ]')) {
            run('cp -R {{previous_release}}/node_modules {{release_path}}');
        }
    }
    run("cd {{release_path}} && npm ci");
});

task('supervisor:restart', function () {
    run('supervisorctl restart "collabfinder-worker:*"');
});


// Hooks
after('deploy:failed', 'deploy:unlock');
after('deploy:vendors', 'npm:ci');
after('deploy:publish', 'supervisor:restart');
