<?php

namespace Deployer;

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
