// document.addEventListener('contextmenu', function(e) {
//     e.preventDefault();
// }, false);


document.addEventListener('keydown', function(e) {
    
    if (e.keyCode == 123 || 
        (e.ctrlKey && e.shiftKey && (e.keyCode == 73 || e.keyCode == 74)) || 
        (e.ctrlKey && e.keyCode == 85)) {
        e.preventDefault();
    }
}, false);


document.addEventListener('keydown', function(e) {
    if (e.ctrlKey && e.shiftKey && e.keyCode == 67) {
        e.preventDefault();
    }
}, false);


document.addEventListener('keydown', function(e) {
    if (e.ctrlKey && e.keyCode == 83) {
        e.preventDefault();
    }
}, false);