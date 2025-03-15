jQuery(document).ready(function($) {
    $(".dtoc-meta-tabs").each(function() {
        const $tabContainer = $(this); // Scope each .dtoc-meta-tabs container
        $tabContainer.find(".dtoc-meta-tab-titles a").first().addClass("active");
        $tabContainer.find(".dtoc-meta-tab-content").hide().first().show(); // Show the first tab content by default
        
        $tabContainer.find('.dtoc-meta-tab-titles a').click(function(e) {
            e.preventDefault();
            const target = $(this).attr('href');
            
            $tabContainer.find('.dtoc-meta-tab-content').hide(); // Hide all tab contents in this container
            $tabContainer.find('.dtoc-meta-tab-titles a').removeClass('active'); // Remove active class from all tabs in this container
            
            $(target).show(); // Show the selected tab content
            $(this).addClass('active'); // Add active class to the selected tab
        });
    });
});

