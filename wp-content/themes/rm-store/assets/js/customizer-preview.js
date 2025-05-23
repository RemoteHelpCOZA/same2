(function($, api) {
    // Map elements to customizer setting IDs
    var mapping = {
        '.home-category-1': 'home_category_1',
        '.home-category-2': 'home_category_2',
        '.home-category-3': 'home_category_3',
        '.home-category-4': 'home_category_4'
    };
    $.each(mapping, function(selector, settingId) {
        $(document).on('click', selector, function(e) {
            e.preventDefault();
            api.panel('customize').expand(); // ensure customizer panels open
            api.control(settingId).focus(); // focus the control
        });
    });
})(jQuery, wp.customize);
