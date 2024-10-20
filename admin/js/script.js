const allSideMenu = document.querySelectorAll('#sidebar .side-menu.top li a');

allSideMenu.forEach(item=> {
	const li = item.parentElement;

	item.addEventListener('click', function () {
		allSideMenu.forEach(i=> {
			i.parentElement.classList.remove('active');
		})
		li.classList.add('active');
	})
});




// TOGGLE SIDEBAR
const menuBar = document.querySelector('#content nav .bx.bx-menu');
const sidebar = document.getElementById('sidebar');

menuBar.addEventListener('click', function () {
	sidebar.classList.toggle('hide');
})

if(window.innerWidth < 768) {
	sidebar.classList.add('hide');
}

const switchMode = document.getElementById('switch-mode');

switchMode.addEventListener('change', function () {
	if(this.checked) {
		document.body.classList.add('dark');
	} else {
		document.body.classList.remove('dark');
	}
})

document.addEventListener('DOMContentLoaded', function () {
    const menuItems = document.querySelectorAll('#sidebar .side-menu li a');
    const currentPath = window.location.pathname;

    menuItems.forEach(item => {
        const itemHref = item.getAttribute('href');
        
        // Check if the current page URL matches the href of the menu item
        if (currentPath.includes(itemHref)) {
            // Remove 'active' from all menu items
            menuItems.forEach(i => i.parentElement.classList.remove('active'));
            // Add 'active' to the current menu item
            item.parentElement.classList.add('active');
        }
    });
});
