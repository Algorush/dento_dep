if (location.pathname.indexOf('/dashboard/deals/create/') > -1) {
    import(
        /* webpackChunkName: "saveAsGlb" */
        /* webpackPrefetch: true */
        './modules/saveAsGlb'
    )
    .then(module => module.default())
}