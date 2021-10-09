const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')

    // scripts for components
    .js('resources/js/components/navstart.js' , 'public/js/components')
    .js('resources/js/components/jobseeker_nav.js', 'public/js/components')
    .js('resources/js/components/employer_nav.js', 'public/js/components')
    .js('resources/js/components/admin-nav.js', 'public/js/components')

    // guest
    .js('resources/js/pages/guest/job-search.js', 'public/js/pages/guest')
    .js('resources/js/pages/guest/job-search-marinduque.js', 'public/js/pages/guest')
    .js('resources/js/pages/guest/job-view-marinduque.js', 'public/js/pages/guest')
    .js('resources/js/pages/guest/employer-jobs.js', 'public/js/pages/guest')
    .js('resources/js/pages/guest/employers.js', 'public/js/pages/guest')
    .js('resources/js/pages/resume.js', 'public/js/pages')
    .js('resources/js/ajax-setup.js', 'public/js/pages')

    // scripts for pages
    .js('resources/js/pages/signup.js', 'public/js/pages')
    .js('resources/js/pages/signin.js', 'public/js/pages')
    .js('resources/js/pages/home.js', 'public/js/pages')
    .js('resources/js/pages/seeker_home.js', 'public/js/pages')
    .js('resources/js/pages/seeker_profile.js', 'public/js/pages')
    .js('resources/js/pages/seeker_jobmatch.js', 'public/js/pages')
    .js('resources/js/pages/employer_profile.js', 'public/js/pages')
    .js('resources/js/pages/email_verification.js', 'public/js/pages')
    .js('resources/js/pages/employer_signup.js', 'public/js/pages')
    .js('resources/js/animation.js', 'public/js')
    //scripts for seekers
    .js('resources/js/pages/seeker/upload_profile_picture.js', 'public/js/pages/seeker')
    .js('resources/js/pages/seeker/view-job.js', 'public/js/pages/seeker')
    .js('resources/js/pages/seeker/apply-job.js', 'public/js/pages/seeker')
    .js('resources/js/pages/seeker/job-suggestions-full.js', 'public/js/pages/seeker')
    .js('resources/js/pages/seeker/settings.js', 'public/js/pages/seeker')

    // scripts for emp
    .js('resources/js/pages/employer/post-job.js', 'public/js/pages/employer')
    .js('resources/js/pages/employer/upload-logo.js', 'public/js/pages/employer')
    .js('resources/js/pages/employer/job-list.js', 'public/js/pages/employer')
    .js('resources/js/pages/employer/edit-job.js', 'public/js/pages/employer')
    .js('resources/js/pages/employer/job.js', 'public/js/pages/employer')
    .js('resources/js/pages/employer/accept-application.js', 'public/js/pages/employer')

    // scripts for admin
    .js('resources/js/pages/admin/admin-home.js', 'public/js/pages/admin')
    .js('resources/js/pages/admin/employer-list.js', 'public/js/pages/admin')
    .js('resources/js/pages/admin/job-seeker-list.js', 'public/js/pages/admin')
    .js('resources/js/pages/admin/job-list.js', 'public/js/pages/admin')
    .js('resources/js/pages/admin/add-admin-account.js', 'public/js/pages/admin')
    

    //scripts for auth
    .js('resources/js/auth/password-reset.js', 'public/js/auth')


    

    // styleas
    // styles for guest users
    .sass('resources/css/app.scss', 'public/css', [])
    .postCss('resources/css/app_sample.css', 'public/css', [
        require('tailwindcss')
    ])
    .sass('resources/css/home.scss', 'public/css', [])
    .sass('resources/css/signup.scss', 'public/css', [])
    .sass('resources/css/signin.scss', 'public/css', [])
    .sass('resources/css/forgot-password.scss', 'public/css', [])
    .sass('resources/css/guest/job-search.scss', 'public/css/guest', [])
    .sass('resources/css/resume.scss', 'public/css', [])

    // styles for employers
    .sass('resources/css/employer_signup.scss', 'public/css', [])
    .sass('resources/css/employer_nav.scss','public/css', [] )
    .sass('resources/css/employer_home.scss','public/css', [] )
    .sass('resources/css/employer_profile.scss','public/css', [] )
    .sass('resources/css/employer/post-job.scss','public/css/employer', [] )
    .sass('resources/css/employer/upload-logo.scss','public/css/employer', [] )
    .sass('resources/css/employer/job-list.scss','public/css/employer', [] )
    .sass('resources/css/employer/edit-job.scss','public/css/employer', [] )
    .sass('resources/css/employer/job.scss','public/css/employer', [] )
    .sass('resources/css/employer/accept-application.scss','public/css/employer', [] )

    //styles for seekers
    .sass('resources/css/jobseeker_nav.scss','public/css', [] )
    .sass('resources/css/job_match_results.scss','public/css', [] )
    .sass('resources/css/seeker_jobmatch.scss', 'public/css', [])
    .sass('resources/css/seeker_home.scss','public/css', [] )
    .sass('resources/css/seeker_profile.scss', 'public/css')
    .sass('resources/css/seeker/upload_profile_picture.scss', 'public/css/seeker')
    .sass('resources/css/seeker/view-job.scss', 'public/css/seeker')
    .sass('resources/css/seeker/apply-job.scss', 'public/css/seeker')

    // styles for admin
    .sass('resources/css/admin/admin-home.scss', 'public/css/admin')

    .sass('resources/css/email_verification.scss', 'public/css');





