$(document).ready(function(){
    function handleSidebarButtonClick(event) {
        var href = event.target.getAttribute('href');
    
        var isBlankTarget = event.target.getAttribute('target') === '_blank';
    
        if (isBlankTarget) {
            return;
        }
    
        event.preventDefault();
    
        var targetElementId = href.substring(href.lastIndexOf("/") + 1);
        var targetElement = document.getElementById(targetElementId);
        targetElement.scrollIntoView({ behavior: 'smooth' });
    }
    
    var sidebarButtons = document.querySelectorAll("#logo-sidebar a");
    
    sidebarButtons.forEach(function(button) {
        button.addEventListener('click', handleSidebarButtonClick);
    });
})
