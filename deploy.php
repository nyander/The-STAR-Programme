<?php
namespace Deployer;

require 'recipe/laravel.php';

// Project name
set('application', 'AthleteRise');

// Project repository
set('repository', 'git@github.com:nyander/The-STAR-Programme.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', false); 

// Shared files/dirs between deploys 
add('shared_files', ['.env']);
add('shared_dirs', ['public/storage', 'storage']);


// Writable dirs by web server 
add('writable_dirs', ['storage', 'bootstrap/cache']);


// Hosts

host('78.141.204.28')
    ->user('starmentality')
    ->set('deploy_path', '~/{{application}}');    
    
// Regular migration is set to run before symlink as previously mentioned
before('deploy:symlink', 'artisan:migrate');

// Define a task for fresh migration
task('artisan:migrate:fresh', function () {
    run('{{bin/php}} {{release_path}}/artisan migrate:fresh');
});

// Define a task for seeding
task('artisan:seed', function () {
    run('{{bin/php}} {{release_path}}/artisan db:seed');
});

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');



