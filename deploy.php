<?php
namespace Deployer;

require 'recipe/laravel.php';

// Project name
set('application', 'StarMentalityProgram');

// Project repository
set('repository', 'git@github.com:nyander/The-STAR-Programme.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', false); 

// Shared files/dirs between deploys 
add('shared_files', ['.env']);
add('shared_dirs', ['storage']);

// Writable dirs by web server 
add('writable_dirs', ['storage', 'bootstrap/cache']);
set('allow_anonymous_stats', false);

// Hosts

host('78.141.204.28') // Your Vultr server's IPv4 address
    ->user('starmentality')// Use the 'root' user
    ->set('deploy_path', '~/StarMentalityProgram'); // Set the deployment path on your server
    
// Tasks

task('build', function () {
    run('cd {{release_path}} && npm run build');
});

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');



// Migrate database before symlink new release.

before('deploy:symlink', 'artisan:migrate');

