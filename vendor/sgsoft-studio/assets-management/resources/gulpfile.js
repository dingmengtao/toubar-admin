const elixir = require('laravel-elixir');

elixir.config.sourcemaps = true;
elixir.inProduction = true;

/**
 * Edit the path as you want
 */
const publicPath = 'projects-root/develop/public/';

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for your application as well as publishing vendor resources.
 |
 */

elixir((mix) => {
    mix
        .sass('./core/assets-management/resources/assets/sass/style.scss', publicPath + 'admin/css')
        .sass('./core/assets-management/resources/assets/sass/admin-bar.scss', publicPath + 'admin/css')

        .rollup('./core/assets-management/resources/assets/js/webed-core.js', publicPath + 'admin/js')
        .rollup('./core/assets-management/resources/assets/js/script.js', publicPath + 'admin/js')

        .rollup('./core/assets-management/resources/assets/js/Components/DataTables/DataTable.js', publicPath + 'admin/modules/datatables/webed.datatable.js')
        .rollup('./core/assets-management/resources/assets/js/Components/DataTables/DataTableAjax.js', publicPath + 'admin/modules/datatables/webed.datatable.ajax.js')

        .copy('./projects-root/develop/public/admin/modules/auth', 'core/base/resources/public/admin/modules/auth')
        .copy('./projects-root/develop/public/admin/modules/datatables', 'core/base/resources/public/admin/modules/datatables')
        .copy('./projects-root/develop/public/admin/css', 'core/base/resources/public/admin/css')
        .copy('./projects-root/develop/public/admin/js', 'core/base/resources/public/admin/js')

        /*Custom fields*/
        .sass('./core/custom-fields/resources/assets/sass/admin/modules/custom-fields/edit-field-group.scss', publicPath + 'admin/modules/custom-fields')
        .rollup('./core/custom-fields/resources/assets/js/admin/modules/custom-fields/edit-field-group.js', publicPath + 'admin/modules/custom-fields')
        .rollup('./core/custom-fields/resources/assets/js/admin/modules/custom-fields/use-custom-fields.js', publicPath + 'admin/modules/custom-fields')
        .copy('./projects-root/develop/public/admin/modules/custom-fields', 'core/custom-fields/resources/public/admin/modules/custom-fields')
    ;
});
